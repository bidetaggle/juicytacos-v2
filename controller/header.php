<?php

use Lib\IO;
use Lib\Secure;
use Model\Header;

try
{
	include_once("view/header.view.php");
}
catch (Exception $e)
{
	IO::displayException($e);
}

?>

