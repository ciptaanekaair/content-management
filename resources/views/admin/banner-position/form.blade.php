<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
				<form method="POST" id="category_form" name="category_form" enctype="multipart/form-data">
			<div class="modal-body">
					<input type="hidden" name="category_id" id="category_id">
					<input type="hidden" name="_method" id="formMethod">
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label for="category_name">Nama Kategori</label>
								<input type="text" name="category_name" class="form-control" id="category_name">
								<div class="alert-message">
									<code id="category_nameError"></code>
								</div>
							</div>
							<div class="form-group">
								<label for="category_description">Deskripsi Kategori</label>
								<textarea name="category_description" rows="5" class="form-control" id="category_description"></textarea>
								<div class="alert-message">
									<code id="category_descriptionError"></code>
								</div>
							</div>
							<div class="form-group">
								<label for="category_image">Gambar Kategori</label>
								<input type="file" name="category_image" class="form-control" id="category_image">
								<div class="alert-message">
									<code id="category_imageError"></code>
								</div>
							</div>
							<a href="" target="_blank" id="category_image_link" class="btn btn-info" visible="false">
								<i class="fa fa-eye"></i> &nbsp Lihat Picture
							</a>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label for="keywords">Keywords Kategori</label>
								<input type="text" name="keywords" class="form-control" id="keywords">
								<div class="alert-message">
									<code id="keywordsError"></code>
								</div>
							</div>
							<div class="form-group">
								<label for="description_seo">Description Meta</label>
								<textarea name="description_seo" rows="5" class="form-control" id="description_seo"></textarea>
								<div class="alert-message">
									<code id="description_seoError"></code>
								</div>
							</div>
							<div class="form-group">
								<label for="status">Status</label>
								<select name="status" id="status" class="form-control">
									<option value="pilih" selected>Pilih Status Category</option>
									<option value="0">Draft</option>
									<option value="1">Active</option>
								</select>
								<div class="alert-message">
									<code id="statusError"></code>
								</div>
							</div>
						</div>
					</div>
					
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary" id="btnSave">Save</button>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title-delete"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form type="POST" id="category_delete_form">
			<div class="modal-body">
					{{ csrf_field() }}
					<input type="hidden" name="category_id_d" id="category_id_d">
					<input type="hidden" name="_method" id="formMethodD" value="DELETE">
				<p align="center">
					Anda akan menghapus data:<br>
					<code id="category_name_d"></code>.
					<br>
					<b>Apakah anda yakin? Anda tidak akan dapat mengembalikan data ini.</b>
				</p>
			</div>
			<div class="modal-footer">
				<button class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-danger" id="btnDelete"><i class="fa fa-trash"></i> &nbsp Delete</button>
			</form>
			</div>
		</div>
	</div>
</div>