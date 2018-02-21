<form action="user.php?login">
	<fieldset>
		<legend>Login</legend>
		<ul id="error">
			<li class="password alert alert-warning">Incorrect login and/or password</li>
		</ul>
		<div class="form-group">
			<label for="login">Login</label>
			<input class="form-control" type="text" name="login" id="login">
		</div>
		<div class="form-group">
			<label for="password">Password</label>
			<input class="form-control" type="password" name="password" id="password">
		</div>
		<input class="btn btn-primary" type="submit" value="login">
	</fieldset>
</form>