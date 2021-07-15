<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form enctype="multipart/form-data">
					<div class="form-group">
						<label for="category_name">Nama Kategori</label>
						<input type="text" name="category_name" class="form-control" id="category_name">
						<div class="alert-message" id="category_nameError"></div>
					</div>
					<div class="form-group">
						<label for="category_description">Deskripsi Kategori</label>
						<textarea name="category_description" class="form-control" id="category_description"></textarea>
						<div class="alert-message" id="category_descriptionError"></div>
					</div>
					<div class="form-group">
						<label for="keywords">Keywords Kategori</label>
						<input type="text" name="keywords" class="form-control" id="keywords">
						<div class="alert-message" id="keywordsError"></div>
					</div>
					<div class="form-group">
						<label for="description_seo">Description Meta</label>
						<textarea name="description_seo" class="form-control" id="description_seo"></textarea>
						<div class="alert-message" id="description_seoError"></div>
					</div>
					<div class="form-group">
						<label for="category_image">Gambar Kategori</label>
						<input type="file" name="category_image" class="form-control" id="category_image">
						<div class="alert-message" id="category_imageError"></div>
					</div>
					<a href="" target="_blank" id="category_image_link">Image</a>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" id="btnSave">Save</button>
			</div>
		</div>
	</div>
</div>