<?php

namespace Lib;

use Exception;
use PDO;
use Lib\Configuration;
use Lib\Database;
use Lib\Secure;

class SQL
{
    private $tableName;
    private $data = array();
    private $where = array();
    private $whereNot = array();
    private $join = array();
    private $orderby = array();

    /**
	 * Table name on where you will work
	 * @param string $tableName;
 	 * @since 1.1
 	 * @return void
	 */
    public function __construct($tableName = NULL){
    	if($tableName !== NULL)
    		$this->tableName = $tableName;
    }

    //Pour reseter les datas une fois qu'une opération est terminée
    private function reset(){
    	$this->data = array();
    	$this->where = array();
    }

    private function makeWhereString($where = array()){
    	$w = "";

		if(!empty($where)){
			foreach ($where as $key => $value) {
				if($w == "")
					$w = "WHERE ".$key." = '".$value."'";
				else
					$w .= " AND " . $key . " = '" . $value."'";
			}
		}

		return $w;
    }

    public function set($index, $value){
		$this->data[$index] = $value;
	}

	public function setWhere($index, $value){
		$this->where[$index] = $value;
	}

	public function setWhereNot($index, $value){
		$this->whereNot[$index] = $value;
	}

	public function join($table, $column1, $column2){
		$join['table'] = $table;
		$join['column1'] = $column1;
		$join['column2'] = $column2;
		array_push($this->join, $join);
	}

	public function orderby($column, $order){
		$this->orderby['column'] = $column;
		$this->orderby['order'] = $order;
	}

	/**
	 * Debug function whose purpose is to prompt the final SQL request
	 * @param string $type = "insert" ; "insert" || "i" || "update" || "u"
 	 * @since 1.0
 	 * @return string $request;
	 */
	public function echo_request($type = "insert"){
		if($type == "insert" || $type == "i"){
			$stringData = array("index" => "", "values" => "");

			$separator = '';
			foreach ($this->data as $index => $value) {
				$stringData["index"] .= $separator . $index;
				$stringData["values"] .= $separator . '\''. $value . '\'';
				$separator = ',';
			}

			$request = 'INSERT INTO '.Configuration::$databaseTablePrefix.$this->tableName . '(' . $stringData["index"] . ') 
						VALUES (' . $stringData["values"] . ')';
		}

		elseif($type == "update" || $type == "u"){
			$stringData = '';

			$separator = '';
			foreach ($this->data as $index => $value) {
				if($value === NULL)
					$stringData .= $separator.$index.' = NULL';
				else
					$stringData .= $separator.$index.' = \''.$value.'\'';

				$separator = ', ';
			}

			$request = 'UPDATE '.Configuration::$databaseTablePrefix.$this->tableName.' 
						SET '. $stringData .'
						'.$this->makeWhereString($this->where);
		}

		else{
			$w0 = "";
			$w = "";

			if(!empty($this->join)){
				foreach ($this->join as $key => $value) {
					$w0 .= "JOIN ".Configuration::$databaseTablePrefix.$value['table']." 
							ON ".Configuration::$databaseTablePrefix.$this->tableName.".".$value['column1']." = ".Configuration::$databaseTablePrefix.$value['table'].".".$value['column2']." ";
				}
			}

			if(!empty($this->where)){
				foreach ($this->where as $key => $value) {
					if($w == "")
						$w = "WHERE ";
					else
						$w .= " AND ";

					if(Secure::isInt($value))
						$w .= $key . " = " . $value;
					else
						$w .= $key . " LIKE '$value'";
				}
			}
			if(!empty($this->whereNot)){
				foreach ($this->whereNot as $key => $value) {
					if($w == "")
						$w = "WHERE ";
					else
						$w .= " AND ";

					if(Secure::isInt($value))
						$w .= $key . " <> " . $value;
					else
						$w .= $key . " NOT LIKE '$value'";
				}
			}
			if(!empty($this->orderby)){
				$w .= "ORDER BY ".$this->orderby['column']." ".$this->orderby['order'];
			}

			$request = 'SELECT * 
						FROM '.Configuration::$databaseTablePrefix.$this->tableName.'
						'.$w0.$w;
		}

		//mise en forme
		$request = str_replace("\t", '', $request);

		$request = "\n-------------------\n" . $request . "\n-------------------\n";

		return $request;
	}

	//fonction pourrie
	public function update(){
		$stringData = '';

		$separator = '';
		foreach ($this->data as $index => $value) {
			if($value === NULL)
				$stringData .= $separator.$index.' = NULL';
			else
				$stringData .= $separator.$index.' = \''.$value.'\'';
			$separator = ', ';
		}

		$request = 'UPDATE '.Configuration::$databaseTablePrefix.$this->tableName.' 
					SET '. $stringData .'
					'.$this->makeWhereString($this->where);

		$bdd = Database::$dbh->prepare($request);
		$bdd->execute();

		$this->reset();
	}

	public function insert(){	
		$stringData = array("index" => "", "values" => "");

		$separator = '';
		foreach ($this->data as $index => $value) {
			$stringData["index"] .= $separator . $index;
			$stringData["values"] .= $separator . '\''. $value . '\'';
			$separator = ',';
		}

		$request = 'INSERT INTO '.Configuration::$databaseTablePrefix.$this->tableName . '(' . $stringData["index"] . ') 
					VALUES (' . $stringData["values"] . ')';

		$bdd = Database::$dbh->prepare($request);
		$bdd->execute();

		$this->reset();

		return Database::$dbh->lastInsertId();
	}

	public function delete(){
		$request = 'DELETE FROM '.Configuration::$databaseTablePrefix.$this->tableName.' 
					'.$this->makeWhereString($this->where);

		$bdd = Database::$dbh->prepare($request);
		$bdd->execute();

		$this->reset();
	}


	//////////// SELECT //////////////////

	public function selectAll(){
		$w0 = "";
		$w = "";

		if(!empty($this->join)){
			foreach ($this->join as $key => $value) {
				$w0 .= "JOIN ".Configuration::$databaseTablePrefix.$value['table']." 
						ON ".Configuration::$databaseTablePrefix.$this->tableName.".".$value['column1']." = ".Configuration::$databaseTablePrefix.$value['table'].".".$value['column2']." ";
			}
		}

		if(!empty($this->where)){
			foreach ($this->where as $key => $value) {
				if($w == "")
					$w = "WHERE ";
				else
					$w .= " AND ";

				if(Secure::isInt($value))
					$w .= $key . " = " . $value;
				else
					$w .= $key . " LIKE '$value'";
			}
		}
		if(!empty($this->whereNot)){
			foreach ($this->whereNot as $key => $value) {
				if($w == "")
					$w = "WHERE ";
				else
					$w .= " AND ";

				if(Secure::isInt($value))
					$w .= $key . " <> " . $value;
				else
					$w .= $key . " NOT LIKE '$value'";
			}
		}
		if(!empty($this->orderby)){
			$w .= "ORDER BY ".$this->orderby['column']." ".$this->orderby['order'];
		}

		$bdd = Database::$dbh->prepare('SELECT * 
										FROM '.Configuration::$databaseTablePrefix.$this->tableName.'
										'.$w0.$w
										);
		$bdd->execute();
		return $bdd->fetchAll();
	}

	public function select(){
		$return = $this->selectAll();

		return (!empty($return)) ? $return[0] : false;
	}

	/**
	 * Make a custom SQL request
	 * WARNING ! The request is not secured AT ALL
	 * You have to secure data BEFORE using SQL::query()
	 * @param string $query
 	 * @since 1.1
 	 * @return array <- query return;
	 */
	public function query($query){
		$bdd = Database::$dbh->prepare($query);
		$bdd->execute();
		return $bdd->fetchAll();
	}

	// public function getById($id){
	// 	$bdd = Database::$dbh->prepare('SELECT * 
	// 									FROM '.Configuration::$databaseTablePrefix.$this->tableName.'
	// 									ORDER BY id
	// 									');
	// 	$bdd->execute(array(Secure::forceInt($id)));
	// 	return $bdd->fetch();
	// }
}
?>