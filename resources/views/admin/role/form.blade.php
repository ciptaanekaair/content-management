<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-title shipping-title"></div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="role_form" name="role_form" enctype="multipart/form-data">
				<div class="modal-body">
					<input type="hidden" name="role_id" id="role_id">
					<input type="hidden" name="_method" id="formAddMethod" value="PUT">
					<div class="row">
						<div class="col-12">
							<div class="form-group">
								<label for="nama_role">Nama Role</label>
								<input type="text" name="nama_role" class="form-control" id="nama_role">
								<div class="alert-message">
									<code id="nama_roleError"></code>
								</div>
							</div>
							<div class="form-group">
								<label for="status">Status</label>
								<select name="status" id="status" class="form-control">
									<option value="" selected>Pilih Status Role</option>
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
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="modal-level" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label for="levels">Attach dengan Level</label>
					<select name="levels" id="levels" class="form-control">
						<option value="" selected>Pilih Level</option>
						@foreach($levels as $item)
						<option value="{{ $item->id }}">{{ $item->nama_level }}</option>
						@endforeach
					</select>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-title" id="title-delete"></div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form name="form-delete" id="form-delete">
				<div class="modal-body">
					<div class="form-group">
						
					</div>
				</div>
				<div class="modal-footer">

				</div>
			</form>
		</div>
	</div>
</div>