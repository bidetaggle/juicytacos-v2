<?php
header( 'content-type: text/html; charset=utf-8' );

use Lib\Configuration;
use Lib\Database;
use Lib\Cron;

////////////////////////////////////////////////
//				main includes 				  //
////////////////////////////////////////////////

include_once("libraries/configuration.lib.php");
include_once("libraries/io.lib.php");
include_once("libraries/database.lib.php");
include_once("libraries/sql.lib.php");
include_once("libraries/log.lib.php");
include_once("libraries/secure.lib.php");
include_once("libraries/mail.lib.php");
include_once("libraries/cron.lib.php");

include_once("sql/abstract.sql.php");
include_once("sql/cron.sql.php");

include_once("model/abstract.model.php");
include_once("model/error.model.php");
include_once("model/user.model.php");
include_once("model/products.model.php");
include_once("model/bill.model.php");

////////////////////////////////////////////////
//				specific includes 			  //
////////////////////////////////////////////////

//Initialisation
Configuration::initialize();
Database::connect();

//Ouverture de session
session_set_cookie_params(3600);
session_start();

if(empty($_SESSION)){
	$_SESSION["login"] = NULL;
	$_SESSION["id"] = NULL;
}

// crons
/*
$cron = new Cron;
$cron->set(60, "tmp_clean");
$cron->start();
*/

//gestionnaire d'URL rewriting
if(empty($_GET['file'])){
	//echo 'empty';
	include_once('controller/index.php');
}
elseif(file_exists(Configuration::$rootPath . "/controller/".$_GET['file'].".php"))
{
	//echo 'file exist';
	include_once("controller/".$_GET['file'].".php");
}
else{
	//echo $_GET['file'];
	//echo 'noooooooooooooo';
	header('Location: '.Configuration::$rootURL.'/error.php?error=404');
}

?>
