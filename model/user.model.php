<?php

namespace Model;

use Lib\Database;
use Lib\SQL;
use Lib\Configuration;
use Lib\Secure;

class User extends AbstractModel{
	public function login($data){
        $SQL = new SQL('users');
        $SQL->setWhere('login', Secure::text($data['login']));
        $SQL->setWhere('password', hash('sha256', $data['password'] . Configuration::$salt));
        $response = $SQL->select();

        if($response){
            $_SESSION["login"] = $response["login"];
            $_SESSION["id"] = $response["id"];
            $this->errors['password'] = true;
        }
        else
        	$this->errors['password'] = false;

		return $this->errors;
	}

	public function logout(){
		session_destroy();
	}

	public function create($data){
		$this->errors["login"] = Secure::isValidName($data["login"]);
		$this->errors["exists"] = !Secure::isInDatabase('users', 'login', $data['login']);
        $this->errors["password"] = Secure::isValidName($data["password"], 8, 25);
        $this->errors["status"] = Secure::isInt($data["status"]);

        //return false si des erreurs ont été trouvées
    	foreach ($this->errors as $err){
    		if(!$err)
    			return $this->errors;
        }

        $SQL = new SQL('users');
        $SQL->set('login', Secure::text($data["login"]));
        $SQL->set('password', hash('sha256', $data['password'] . Configuration::$salt));
        $SQL->set('status', Secure::forceInt($data["status"]));
        $SQL->insert();
	}

	//We could enhance it to check if there is a SQL error but by default this function return true
	public function delete($data){
		$SQL = new SQL('users');
		$SQL->setWhere('id', Secure::forceInt($data['id']));
		$SQL->delete();

		return true;
	}

	//get the list of users
	public function list(){
        $SQL = new SQL('users');
        $SQL->setWhereNot('id', Secure::forceInt($_SESSION['id']));
        //$SQL->echo_request("select");
        return $SQL->selectAll();
	}
}

?>