<?php

use Lib\IO;
use Lib\Configuration;
use Lib\Secure;
use Model\User;

try
{
	$User = new User;
	if(isset($_GET['login'])){
		$result = $User->login($_POST);
		$result["Location"] = "index.php";
		echo json_encode($result);
	}

	elseif(isset($_GET['logout'])){
		$User->logout();
		header('Location: '.Configuration::$rootURL);
	}

	elseif(isset($_GET['new']) && Secure::allowedUser(1)){
		include_once("header.php");
		include_once(Configuration::$rootPath . "/view/user.new.php");
		include_once("footer.php");
	}

	elseif(isset($_GET['create']) && Secure::allowedUser(1)){
		$result = $User->create($_POST);
		$result["Location"] = "user.php";
		echo json_encode($result);
	}

	elseif (isset($_GET['delete']) && Secure::allowedUser(1)) {
		echo $User->delete($_POST) ? 'true' : 'false';
	}

	elseif(Secure::allowedUser(1)){
		$CtoV = $User->list();

		include_once("header.php");
		include_once(Configuration::$rootPath . "/view/user.view.php");
		include_once("footer.php");
	}
}
catch (Exception $e)
{
	IO::displayException($e);
}

?>
