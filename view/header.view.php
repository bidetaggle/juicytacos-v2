<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>no title</title>
    <link rel="stylesheet" type="text/css" href="<?php echo Lib\Configuration::$rootURL; ?>/view/css/base.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Lib\Configuration::$rootURL; ?>/view/css/interrupt.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Lib\Configuration::$rootURL; ?>/view/css/dropzone.css" />
    <script src="<?php echo Lib\Configuration::$rootURL; ?>/view/bower_components/jquery/dist/jquery.min.js"></script>
	<script src="<?php echo Lib\Configuration::$rootURL; ?>/view/js/form.js"></script>
    <link rel="icon" href="./img/favicon.ico" />
    <link rel="stylesheet" href="<?php echo Lib\Configuration::$rootURL; ?>/view/bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo Lib\Configuration::$rootURL; ?>/view/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Lib\Configuration::$rootURL; ?>/view/css/style.css" />
</head>

<body>
<?php if(Lib\Configuration::$debug == true): ?>
<pre>
Debug mode set to true in parameters.php:
<?php var_dump($_SESSION); ?>
<?php //var_dump($CtoV); ?>
</pre>
<?php endif; ?>
	<header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">login</a></li>
                    <li class="nav-item"><a class="nav-link" href="products.php">Browse our products :)</a></li>
                    <?php if(!is_null($_SESSION['id'])): ?>
                        <?php if(Lib\Secure::allowedUser(1)): ?>
                            <li class="nav-item"><a class="nav-link" href="user.php">Users list</a></li>
                        <?php endif; ?>
                        <?php if(Lib\Secure::allowedUser(2)): ?>
                            <li class="nav-item"><a class="nav-link" href="bill.php">View my bills</a></li>
                            <li class="nav-item"><a class="nav-link" href="products.php?new">Create a new product</a></li>
                        <?php endif; ?>
                        <li><a class="nav-link disconnect" href="user.php?logout">Disconnect (<?php echo $_SESSION['login']; ?>)</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
	</header>
    <div class="container">