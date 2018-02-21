<?php

use Lib\IO;
use Lib\Configuration;
use Lib\Secure;
use Model\Products;

try
{
	$Products = new Products;

	if(isset($_GET['create']) && Secure::allowedUser(2)){
		$result = $Products->create($_POST);
		$result['Location'] = 'products.php';
		echo json_encode($result);
	}

	elseif(isset($_GET['new']) && Secure::allowedUser(2)){
		include_once("header.php");
		include_once(Configuration::$rootPath . "/view/products.new.php");
		include_once("footer.php");
	}

	elseif(isset($_GET['owner'])){
		$Products->setData(['owner' => $_GET['owner']]);
		$CtoV = $Products->list();

		include_once("header.php");
		include_once(Configuration::$rootPath . "/view/products.view.php");
		include_once("footer.php");
	}

	elseif (isset($_GET['id'])) {
		$Products->setData(['id_product' => $_GET['id']]);
		$CtoV = $Products->list();
		if(!empty($CtoV))
			$CtoV = $CtoV[0];
		else
			header('Location: '.Configuration::$rootURL.'/error.php');

		include_once("header.php");
		include_once(Configuration::$rootPath . "/view/products.id.php");
		include_once("footer.php");
	}
	
	else{
		$CtoV = $Products->list();

		include_once("header.php");
		include_once(Configuration::$rootPath . "/view/products.view.php");
		include_once("footer.php");
	}
}
catch (Exception $e)
{
	IO::displayException($e);
}

?>
