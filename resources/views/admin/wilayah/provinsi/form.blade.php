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
			<input type="hidden" name="provinsi_id" class="form-control" id="provinsi_id">
			<div class="modal-body">
				<div class="form-group">
					<label for="provinsi_code">Kode Provinsi</label>
					<input type="text" name="provinsi_code" class="form-control" id="provinsi_code" placeholder="Kode Provinsi. Ex: AC untuk Aceh">
					<div class="alert-message">
						<code id="provinsi_codeError"></code>
					</div>
				</div>
				<div class="form-group">
					<label for="provinsi_name">Nama Provinsi</label>
					<input type="text" name="provinsi_name" class="form-control" id="provinsi_name" placeholder="Nama Provinsi. Ex: Aceh">
					<div class="alert-message">
						<code id="provinsi_nameError"></code>
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
				<button type="submit" class="btn btn-primary" id="btnImport"><i class="fa fa-save"></i> &nbsp Simpan</button>
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
            <form type="POST" id="formDataDelete">
	            <div class="modal-body">
                    {{ csrf_field() }}
                    <input type="hidden" name="_method" id="formMethodD" value="DELETE">
                    <input type="hidden" name="provinsi_id_d" id="provinsi_id_d">
	                <p align="center">
	                    Anda akan menghapus data:<br>
	                    <code id="provinsi_name_d"></code>.
	                    <br>
	                    <b>Apakah anda yakin? Anda tidak akan dapat mengembalikan data ini.</b>
	                </p>
	            </div>
	            <div class="modal-footer">
	                <button class="btn btn-secondary" data-dismiss="modal">Close</button>
	                <button type="submit" class="btn btn-danger" id="btnDelete"><i class="fa fa-trash"></i> &nbsp Delete</button>
	            </div>
            </form>
        </div>
    </div>
</div>