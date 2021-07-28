<div class="modal fade" id="modal-new" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form name="user_form" id="user_form" enctype="multipart/form-data">
				<div class="modal-body">
					<input type="hidden" name="user_id" id="user_id">
					<input type="hidden" name="_method" id="formUserMethod">
					<div class="row">
						<div class="col-lg-6 col-md-12">
							<div class="form-group">
								<label for="name">Nama Lengkap</label>
								<input type="text" name="name" class="form-control" id="name">
								<div class="alert-message">
									<code id="nameError"></code>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-12">
							<div class="form-group">
								<label for="email">Email</label>
								<input name="email" class="form-control" id="email" readonly>
								<div class="alert-message">
									<code id="emailError"></code>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-12">
							<div class="form-group">
								<label for="password">Password</label>
								<input type="password" name="password" class="form-control" id="password">
								<div class="alert-message">
									<code id="passwordError"></code>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-12">
							<div class="form-group">
								<label for="password_confirmation">Confirm Password</label>
								<input type="password" name="password_confirmation" class="form-control" id="password_confirmation">
								<div class="alert-message">
									<code id="password_confirmationError"></code>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-12">
							<div class="form-group">
								<label for="profile_photo_path">Gambar Kategori</label>
								<input type="file" name="profile_photo_path" class="form-control" id="profile_photo_path">
								<div class="alert-message">
									<code id="profile_photo_pathError"></code>
								</div>
							</div>
							<a href="" target="_blank" id="profile_photo_url" visible="false">
								<i class="fas fa-eye"></i> &nbsp Lihat Picture
							</a>
						</div>
						<div class="col-lg-6 col-md-12">
							<div class="form-group">
								<label for="level_id">Level User</label>
								<select name="level_id" id="level_id" class="form-control">
									<option value="levelid">Pilih Status</option>
									@foreach($levels as $item)
									<option value="{{ $item->id }}">{{ $item->nama_level }}</option>
									@endforeach
								</select>
								<div class="alert-message">
									<code id="level_idError"></code>
								</div>
							</div>
							<div class="form-group">
								<label for="status">Status User</label>
								<select name="status" id="status" class="form-control">
									<option value="status">Pilih Status</option>
									<option value="0">Non Aktif</option>
									<option value="1">Aktif</option>
									<option value="99">Banned</option>
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
					<button type="submit" class="btn btn-primary" id="btnUserSave">Save</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-title shipping-title"></div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="detail_form" name="detail_form" enctype="multipart/form-data">
				<div class="modal-body">
					<input type="hidden" name="detail_id" id="detail_id">
					<input type="hidden" name="user_id_detail" id="user_id_detail">
					<input type="hidden" name="_method" id="formShippingMethod" value="PUT">
					<div class="row">
						<div class="col-12">
							<div class="form-group">
								<label for="telepon">Telepon</label>
								<input type="text" name="telepon" class="form-control" id="telepon">
								<div class="alert-message">
									<code id="teleponError"></code>
								</div>
							</div>
							<div class="form-group">
								<label for="handphone">Handphone</label>
								<input type="text" name="handphone" class="form-control" id="handphone">
								<div class="alert-message">
									<code id="handphoneError"></code>
								</div>
							</div>
							<div class="form-group">
								<label for="alamat">Alamat</label>
								<textarea name="alamat" rows="4" class="col-12" id="alamat"></textarea>
								<div class="alert-message">
									<code id="alamatError"></code>
								</div>
							</div>
							<div class="form-group">
								<label for="provinsi_id">Provinsi</label>
								<select name="provinsi_id" id="provinsi_id" class="form-control">
									@foreach($provinsis as $item)
									<option value="{{ $item->id }}">{{ $item->provinsi_name }}</option>
									@endforeach
								</select>
								<div class="alert-message">
									<code id="provinsi_idError"></code>
								</div>
							</div>
							<div class="form-group">
								<label for="kode_pos">Kode POS</label>
								<input type="text" name="kode_pos" class="form-control" id="kode_pos">
								<div class="alert-message">
									<code id="kode_posError"></code>
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
			<form type="POST" id="user_delete_form">
			<div class="modal-body">
				<input type="hidden" name="userid_delete" id="userid_delete">
				<input type="hidden" name="_method" id="formMethodD" value="DELETE">
				<p align="center">
					Anda akan menghapus data:<br>
					<code id="user_name_d"></code>.
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