
<table class="table table-striped table-dark">
	<thead>
		<tr>
			<th>Product</th>
			<th>Customer name</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($CtoV as $bill): ?>
			<tr>
				<form action="bill.php?delete">
					<td><?php echo $bill['title']; ?></td>
					<td><?php echo $bill['login']; ?></td>
					<td>
						<input type="hidden" name="id_bill" value="<?php echo $bill['id_bill']; ?>">
						<input class="btn btn-danger" type="submit" value="delete">
					</td>
				</form>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>