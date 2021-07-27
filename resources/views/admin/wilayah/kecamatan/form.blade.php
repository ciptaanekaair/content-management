<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title title-form"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form type="POST" id="form-data">
            <input type="hidden" name="_method" id="formAddMethod">
            <input type="hidden" name="kecamatan_id" class="form-control" id="kecamatan_id">
            <div class="modal-body">
                <div class="form-group">
                    <label for="kota_id">Kota</label>
                    <select name="kota_id" class="form-control" id="kota_id">
                        <option>Pilih Kota</option>
                        @foreach($kotas as $index => $item)
                        <option value="{{ $item->id }}">{{ $item->nama_kota }}</option>
                        @endforeach
                    </select>
                    <div class="alert-message">
                        <code id="kota_idError"></code>
                    </div>
                </div>
                <div class="form-group">
                    <label for="nama_kecamatan">Nama Kecamatan</label>
                    <input type="text" name="nama_kecamatan" class="form-control" id="nama_kecamatan">
                    <div class="alert-message">
                        <code id="nama_kecamatanError"></code>
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
                <button type="submit" class="btn btn-primary" id="btnImport"><i class="fa fa-save"></i> &nbsp Import</button>
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
            <form type="POST" id="formDataDelete">
            <div class="modal-body">
                    {{ csrf_field() }}
                    <input type="hidden" name="_method" id="formMethodD" value="DELETE">
                    <input type="hidden" name="kecamatan_id_d" id="kecamatan_id_d">
                <p align="center">
                    Anda akan menghapus data:<br>
                    <code id="kecamatan_name_d"></code>.
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