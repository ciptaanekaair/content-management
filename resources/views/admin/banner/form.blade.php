<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="POST" id="banner_form" name="banner_form" enctype="multipart/form-data">
				<div class="modal-body">
					<input type="hidden" name="banner_id" id="banner_id">
					<input type="hidden" name="_method" id="formMethod">
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								<label for="banner_position_id">Posisi Banner</label>
								<select name="banner_position_id" id="banner_position_id" class="form-control">
									<option>Pilih Posisi Penempatan Banner</option>
									@foreach($positions as $item)
									<option value="{{ $item->id }}">{{ $item->position_name }}</option>
									@endforeach
								</select>
								<div class="alert-message">
									<code id="banner_position_idError"></code>
								</div>
							</div>
							<div class="form-group">
								<label for="banner_name">Nama Banner</label>
								<input type="text" name="banner_name" class="form-control" id="banner_name">
								<div class="alert-message">
									<code id="banner_nameError"></code>
								</div>
							</div>
							<div class="form-group">
								<label for="banner_image">Banner Image</label>
								<input type="file" name="banner_image" id="banner_image" class="form-control">
								<div class="alert-message">
									<code id="banner_imageError"></code>
								</div>
							</div>
							<div id="lihat-image">
								
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
			<form type="POST" id="banner_delete_form">
			<div class="modal-body">
					{{ csrf_field() }}
					<input type="hidden" name="banner_id_d" id="banner_id_d">
					<input type="hidden" name="_method" id="formMethodD" value="DELETE">
				<p align="center">
					Anda akan menghapus data:<br>
					<code id="banner_name_d"></code>.
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