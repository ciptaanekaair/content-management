<div class="modal fade" id="modal-shipping" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="shipping-form-title"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="POST" id="shipping_form" name="shipping_form">
				@csrf
				<div class="modal-body">
					<input type="hidden" name="_method" id="formMethod">
					<input type="hidden" name="shipping_id" id="shipping_id">
	                <input type="hidden" name="transaction_id" id="transaction_id">
					<div class="row">
	                    <div class="col-lg-12">
	                        <div class="form-group">
	                            <label for="transaction_id">Nomor Transaksi</label>
	                            <input type="text" name="transaction_code" id="transaction_code" class="form-control" readonly>
	                        </div>
	                        <div class="form-group">
	                            <label for="tanggal_kirim">Tanggal Pengiriman</label>
	                            <input type="date" name="tanggal_kirim" id="tanggal_kirim" class="form-control">
	                        </div>
	                        <div class="form-group">
	                            <label for="tanggal_sampai">Tanggal Sampai</label>
	                            <input type="date" name="tanggal_sampai" id="tanggal_sampai" class="form-control">
	                        </div>
							<div class="form-group">
								<label for="user_id">Kurir</label>
								<select name="user_id" id="user_id" class="form-control">
									<option selected>Pilih Kurir</option>
									@foreach($kurirs as $kurir)
									<option value="{{ $kurir->id }}">{{ $kurir->name }}</option>
									@endforeach
								</select>
								<div class="alert-message">
									<code id="statusError"></code>
								</div>
							</div>
							<div class="form-group">
								<label for="keterangan">Detail Pengiriman</label>
								<textarea name="keterangan" rows="6" class="form-control" id="keterangan"></textarea>
								<div class="alert-message">
									<code id="category_descriptionError"></code>
								</div>
							</div>
							<div class="form-group">
								<label for="status">Status</label>
								<select name="status" id="status" class="form-control">
									<option value="pilih">Pilih Status Pengiriman</option>
									<option value="0" selected>On Progress</option>
									<option value="1">Terkirim</option>
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