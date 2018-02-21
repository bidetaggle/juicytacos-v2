<?php

use Lib\Secure;
use Model\Error;

try
{
	$_GET['error'] = (isset($_GET['error'])) ? $_GET['error'] : 404;
	
	$err = new Error(Secure::forceInt($_GET['error']));

	$error = array("libelle" 	=> $err->get(),
					"id" 		=> Secure::forceInt($_GET['error'])
					);

   	include_once("header.php");
   	include_once("view/error.view.php");
   	include_once("footer.php");
}
catch (Exception $e)
{
   IO::displayException($e);
}
?>
