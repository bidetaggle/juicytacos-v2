<?php

namespace Model;

use Lib\Database;
use Lib\SQL;
use Lib\Configuration;
use Lib\Secure;

class Bill extends AbstractModel{
	public function create($data){
		$this->errors["not_exists"] = Secure::isInDatabase('products', 'id_product', $data['id_product']);

        //return false si des erreurs ont été trouvées
    	foreach ($this->errors as $err){
    		if(!$err)
    			return $this->errors;
        }

        $SQL = new SQL('bills');
        $SQL->set('id_product', Secure::forceInt($data["id_product"]));
        $SQL->set('id_customer', Secure::forceInt($_SESSION['id']));
        $SQL->insert();
	}

	//We could enhance it to check if there is a SQL error but by default this function return true
	public function delete($data){
		$SQL = new SQL('bills');
		$SQL->setWhere('id_bill', Secure::forceInt($data['id_bill']));
		$SQL->delete();

		return true;
	}

	public function list(){
        $SQL = new SQL('bills');
        $SQL->join('products', 'products.id_product', 'bills.id_product');
        $SQL->join('users', 'bills.id_customer', 'users.id');
        $SQL->setWhere('owner', Secure::forceInt($_SESSION['id']));
        //echo $SQL->echo_request("select");
        return $SQL->selectAll();
	}
}

?>