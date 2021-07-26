<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title title-form"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form type="POST" id="form-data" enctype="multipart/form-data">
			<input type="hidden" name="kota_id" class="form-control" id="kota_id">
			<div class="modal-body">
				<div class="form-group">
					<label for="provinsi_id">Provinsi</label>
					<select name="provinsi_id" class="form-control" id="provinsi_id">
						<option>Pilih Provinsi</option>
						@foreach($provinsis as $index => $item)
						<option value="{{ $item->id }}">{{ $item->provinsi_name }} - {{ $item->provinsi_code }}</option>
						@endforeach
					</select>
					<div class="alert-message">
						<code id="provinsi_idError"></code>
					</div>
				</div>
				<div class="form-group">
					<label for="nama_kota">Nama Kota</label>
					<input type="text" name="nama_kota" class="form-control" id="nama_kota">
					<div class="alert-message">
						<code id="nama_kotaError"></code>
					</div>
				</div>
				<div class="form-group">
					<label for="status">Status</label>
					<select name="status" class="form-control" id="status">
						<option>Pilih Status</option>
						<option value="0">Draft</option>
						<option value="1">Publish</option>
					</select>
					<div class="alert-message">
						<code id="statusError"></code>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary" id="btnImport"><i class="fa fa-trash"></i> &nbsp Import</button>
			</form>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal-import" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title title-import"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form type="POST" id="form-import" enctype="multipart/form-data">
			<div class="modal-body">
				<div class="form-group">
					<label for="file_upload">File Import</label>
					<input type="file" name="file_upload" class="form-control" id="file_upload">
					<div class="alert-message">
						<code id="file_uploadError"></code>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-danger" id="btnImport"><i class="fa fa-trash"></i> &nbsp Import</button>
			</form>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title title-delete"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form type="POST" id="form-import" enctype="multipart/form-data">
			<div class="modal-body">
				<div class="form-group">
					<label for="file_upload">File Import</label>
					<input type="file" name="file_upload" class="form-control" id="file_upload">
					<div class="alert-message">
						<code id="file_uploadError"></code>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-danger" id="btnImport"><i class="fa fa-trash"></i> &nbsp Import</button>
			</form>
			</div>
		</div>
	</div>
</div>