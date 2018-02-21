<form action="products.php?create">
	<legend>New product</legend>
	<ul id="error">
		<li class="title">You must provide a title between 3 and 30 characters lenght</li>
		<li class="description">The description is too long</li>
		<li class="price">The price is not valid</li>
	</ul>
	<label for="title">Title</label>
	<input class="form-control" type="text" name="title" id="title">
	<label for="description">Description</label>
	<textarea class="form-control" name="description" id="description"></textarea>
	<label for="price">Price</label>
	<input class="form-control" type="text" name="price" id="price">

	<input type="submit">
</form>