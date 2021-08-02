<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="POST" id="position_form" name="category_form" enctype="multipart/form-data">
				<div class="modal-body">
					<input type="hidden" name="position_id" id="position_id">
					<input type="hidden" name="_method" id="formMethod">
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								<label for="position_name">Nama Posisi</label>
								<input type="text" name="position_name" class="form-control" id="position_name">
								<div class="alert-message">
									<code id="position_nameError"></code>
								</div>
							</div>
							<div class="form-group">
								<label for="position_description">Deskripsi Posisi</label>
								<textarea name="position_description" rows="6" class="col-md-12" id="position_description"></textarea>
								<div class="alert-message">
									<code id="position_descriptionError"></code>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary" id="btnSave">Save</button>
				</div>
			</form>
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
			<form type="POST" id="position_delete_form">
			<div class="modal-body">
					{{ csrf_field() }}
					<input type="hidden" name="position_id_d" id="position_id_d">
					<input type="hidden" name="_method" id="formMethodD" value="DELETE">
				<p align="center">
					Anda akan menghapus data:<br>
					<code id="position_name_d"></code>.
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