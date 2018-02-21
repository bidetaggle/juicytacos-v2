<table class="table table-striped table-dark">
	<thead>
		<tr>
			<th>Name</th>
			<th>Description</th>
			<th>Price</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($CtoV as $product): ?>
			<tr>
				<td><a href="?id=<?php echo $product['id_product']; ?>"><?php echo $product['title']; ?></a></td>
				<td><?php echo $product['description']; ?></td>
				<td>$<?php echo $product['price']; ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>