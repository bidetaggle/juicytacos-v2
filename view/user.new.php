<form action="user.php?create">
	<ul id="error">
		<li class="login alert alert-warning">You must provide a title between 3 and 30 characters lenght</li>
		<li class="exists alert alert-warning">An user with this name already exists</li>
		<li class="password alert alert-warning">The password is too short</li>
		<li class="status alert alert-warning">The status doesn't exists</li>
	</ul>
	<div class="form-group">
		<label for="login">login</label>
		<input class="form-control" type="text" name="login" id="login">
		<label for="password">password</label>
		<input class="form-control" type="password" name="password" id="password">
	</div>
	<select class="form-control" name="status">
		<option value="1">Administrator</option>
		<option value="2">Seller</option>
		<option value="3">Customer</option>
	</select>
	<input class="btn btn-primary" type="submit">
</form>