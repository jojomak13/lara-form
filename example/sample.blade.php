<form id="frm" class="card m-5">
	<div class="card-body">
		<h3 class="text-center card-title text-primary">Create Todo</h3>
		<hr>
		<div class="form-group">
			<label for="description">Description</label>
			<input type="description" name="description" id="description" class="form-control">
			<div class="invalid-feedback"></div>
		</div>
		<hr>
		<button type="submit" class="btn btn-primary btn-block">Create</button>	
	</div>
</form>

<script>
document.getElementById('frm').addEventListener('submit', (e) => {
	e.preventDefault();
	// Start Form Library
	new Form({
		el: '#frm',
		inputs: ['description'] 
	}).post('/todos', function(msg){ // success response
		alert(msg)
		window.location.reload();	
	})
	// End Form Library	
})
</script>