<h1><?php echo $CtoV['title']; ?></h1>
<h3>Description : </h3>
<p><?php echo $CtoV['description']; ?></p>
<span class="badge badge-warning">$<?php echo $CtoV['price']; ?></span>
<?php if(Lib\Secure::allowedUser(3)): ?>
	<ul id="error">
		<li class="not_exists">This product doesn't exists</li>
	</ul>
	<form action="bill.php?create">
		<input type="hidden" name="id_product" value="<?php echo $CtoV['id_product'] ?>">
		<input class="btn btn-success" type="submit" value="purchase">
	</form>
<?php endif; ?>