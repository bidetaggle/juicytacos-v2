<?php

namespace Model;

use Lib\Database;
use Lib\SQL;
use Lib\Configuration;
use Lib\Secure;

class Products extends AbstractModel {
	public function create($data){
		$this->errors["title"] = Secure::isValidName($data["title"]);
        $this->errors["description"] = Secure::isValidName($data["description"], 0, 250);
        $this->errors["price"] = Secure::isValidPrice($data["price"]);

        //return false si des erreurs ont été trouvées
    	foreach ($this->errors as $err){
    		if(!$err)
    			return $this->errors;
        }

        $SQL = new SQL('products');
        $SQL->set('title', Secure::text($data["title"]));
        $SQL->set('description', Secure::text($data["description"]));
        $SQL->set('price', Secure::text($data["price"]));
        $SQL->set('owner', Secure::forceInt($_SESSION['id']));
        $SQL->insert();
	}

	public function list($filter = NULL){
		$SQL = new SQL('products');
        $SQL->join('users', 'products.owner', 'users.id');

        if(!is_null($this->data))
            foreach ($this->data as $key => $value)
                $SQL->setWhere($key, $value);

        //echo $SQL->echo_request("s");
        return $SQL->selectAll();
	}
}

?>