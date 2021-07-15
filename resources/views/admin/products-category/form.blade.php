<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label for="category_name">Nama Kategori</label>
					<input type="text" name="category_name" class="form-control" id="category_name">
					<div class="alert-message" id="category_nameError"></div>
				</div>
				<div class="form-group">
					<label for="category_description">Nama Kategori</label>
					<textarea name="category_description" class="form-control" id="category_description"></textarea>
					<div class="alert-message" id="category_descriptionError"></div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Save changes</button>
			</div>
		</div>
	</div>
</div>