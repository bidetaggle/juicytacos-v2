<a class="badge badge-primary" href="user.php?new">Create a new user</a>
<table class="table table-striped table-dark">
	<thead>
		<tr>
			<th>Login</th>
			<th>Status</th>
			<th>Delete</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($CtoV as $user): ?>
		<form action="user.php?delete">
			<tr>
					<td><?php echo $user['login']; ?></td>
					<td><?php echo $user['status']; ?></td>
					<td>
						<input type="hidden" name="id" value="<?php echo $user['id']; ?>">
						<input class="btn btn-danger" type="submit" name="delete" value="delete">
					</td>
			</tr>
		</form>
	<?php endforeach; ?>
	</tbody>
</table>