<?php

use Lib\IO;
use Lib\Configuration;
use Lib\Secure;
use Model\Bill;

try
{
	$Bill = new Bill;

	if(isset($_GET['create']) && Secure::allowedUser(3)){
		$result = $Bill->create($_POST);
		$result["Location"] = "bill.php?success";
		echo json_encode($result);
	}

	elseif (isset($_GET['delete']) && Secure::allowedUser(2)) {
		echo $Bill->delete($_POST) ? 'true' : 'false';
	}

	elseif (isset($_GET['success'])) {
		include_once("header.php");
		include_once(Configuration::$rootPath . "/view/bill.success.php");
		include_once("footer.php");
	}

	elseif(Secure::allowedUser(2)){
		$CtoV = $Bill->list();

		include_once("header.php");
		include_once(Configuration::$rootPath . "/view/bill.view.php");
		include_once("footer.php");
	}
}
catch (Exception $e)
{
	IO::displayException($e);
}

?>
