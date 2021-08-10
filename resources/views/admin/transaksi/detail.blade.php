@extends('layouts.dashboard-layout')

@section('header')
	<h1>Transaction: {{ $transaction->transaction_code }}</h1> - [ <div id="statusTransaksi">{{ $transaction->status_transaksi }}</div> ]
@endsection

@section('content')
<div class="row mb-3">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<table class="table">
					<tbody>
						<tr>
							<td width="100">Nama</td>
							<td width="50">:</td>
							<td><b>{{ $transaction->user->name }}</b></td>
							<td width="100">Phone</td>
							<td width="50">:</td>
							<td><b>{{ $transaction->user->userDetail->handphone }}</b></td>
						</tr>
						<tr>
							<td width="100">Email</td>
							<td width="50">:</td>
							<td><b>{{ $transaction->user->email }}</b></td>
							<td width="100">Alamat</td>
							<td width="50">:</td>
							<td><b>{{ $transaction->user->userDetail->alamat }}</b></td>
						</tr>
					</tbody>
				</table>
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<tr align="center">
								<th>Nama Barang</th>
								<th width="100">Qty</th>
								<th width="250">Harga Satuan</th>
								<th width="250">Harga Total</th>
							</tr>
						</thead>
						<tbody>
							@forelse($transaction->transactionDetail as $tdetail)
							<tr align="center">
								<td>
									{{ $tdetail->products->product_name }}<br>
									<small>Product Code: {{ $tdetail->products->product_code }}</small>
								</td>
								<td>
									{{ $tdetail->qty }}
								</td>
								<td>
									Rp. {{ number_format($tdetail->products->product_price) }}
								</td>
								<td>
									Rp. {{ number_format($tdetail->total_price) }}
								</td>
							</tr>
							@empty
							<tr>
								<td colspan="4">Belum ada data pembelian product.</td>
							</tr>
							@endforelse
							<tr align="center">
								<td colspan="3">Total Price</td>
								<td>Rp. {{ number_format($transaction->total_price) }}</td>
							</tr>
							<tr align="center">
								<td colspan="3">Discount</td>
								<td>Rp. {{ number_format($transaction->discount) }}</td>
							</tr>
							<tr align="center">
								<td colspan="3">PPN 10%</td>
								<td>Rp. {{ number_format($transaction->pajak_ppn) }}</td>
							</tr>
							<tr align="center">
								<td colspan="3">Sub Total</td>
								<td>Rp. {{ number_format($transaction->sub_total_price) }}</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div>
					<table class="table table-stripped table-hover">
						<thead>
							<tr align="center">
								<th colspan="6">
									Bukti Pembayaran
								</th>
							</tr>
							<tr>
								<th width="20">id</th>
								<th>Tanggal</th>
								<th>Deskripsi</th>
								<th>Bukti</th>
								<th>Status</th>
								<th></th>
							</tr>
						</thead>
						<tbody id="paymentTable">
						</tbody>
					</table>
				</div>
				<form method="POST" id="form_status" name="form_status">
					@csrf
					@method('PUT')
					<div class="form-group">
						<input type="hidden" name="transaction_id" id="transaction_id" value="{{ $transaction->id }}">
						<label for="status">Status Transaksi</label>
						<select name="status" id="status" class="form-control">
							<option value="">Pilih Status</option>
							<option value="0" {{ $transaction->status == 0 ? 'selected' : '' }}>Pending (Belum di bayar)</option>
							<option value="1" {{ $transaction->status == 1 ? 'selected' : '' }}>Complete</option>
							<option value="2" {{ $transaction->status == 2 ? 'selected' : '' }}>Ferivy Payment</option>
							<option value="6" {{ $transaction->status == 7 ? 'selected' : '' }}>Pembayaran Terverifikasi</option>
							<option value="3" {{ $transaction->status == 3 ? 'selected' : '' }}>Pengemasan</option>
							<option value="4" {{ $transaction->status == 4 ? 'selected' : '' }}>Pengiriman</option>
							<option value="5" {{ $transaction->status == 5 ? 'selected' : '' }}>Diterima</option>
							<option value="6" {{ $transaction->status == 6 ? 'selected' : '' }}>Canceled</option>
						</select>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection

@section('formodal')
	@include('admin.modal-loading')
@endsection

@section('jq-script')

<script type="text/javascript">
$(function() {
	fetch_payment_data({{ $transaction->id }});

	$('#status').on('change', function() {
		var id = $('#transaction_id').val();

		$.ajax({
			url: '{{ url("transactions") }}/'+id,
			type: 'POST',
			data: $('#form_status').serialize(),
			beforeSend: function(){
				// Show image container
				$("#modal-loading").modal('show');
			},
			success: function(data) {
				$('#status [value='+data.status+']').attr('selected', 'selected');
				Swal.fire('Success!', data.message, 'success');
			},
			error: function(response) {
				Swal.fire('Error!', response.responseJSON.errors.message, 'error');
			},
			complete: function(data) {
				// Hide image container
				$("#modal-loading").modal('hide');
			}
		});
	});
});

function fetch_payment_data(id) {
	$.ajax({
		url: '{{ url("data-payment/transaction") }}/'+id,
		type: 'GET',
		beforeSend: function() {
			$("#modal-loading").modal('show');
		},
		success: function(data) {
			checkStatus();
			$('#paymentTable').html(data);
		},
		complete: function() {
			$("#modal-loading").modal('hide');
		}
	});
}

function checkStatus() {
	$.ajax({
		url: '{{ url("data/transactions/status/".$transaction->id) }}',
		type: 'GET',
		success: function(data) {
			$('#status [value="'+data.status+'"]').attr('selected', 'selected');
			$('#statusTransaksi').text(data.status_transaksi);
		}
	});
}

function verify(key) {
	$.ajax({
		url: '{{ url("transaction/verify") }}/'+key,
		type: 'GET',
		beforeSend: function() {
			$("#modal-loading").modal('show');
		},
		success: function(data) {
			Swal.fire('Success!', data.message, 'success');
			fetch_payment_data({{ $transaction->id }});
			// $('#paymentTable').html(data);
		},
		error: function(e) {
			Swal.fire('Error!', e.responseJSON.errors.message, 'error');
		},
		complete: function() {
			$("#modal-loading").modal('hide');
		},
	});
}

function unverify(key) {
	$.ajax({
		url: '{{ url("transaction/unverify") }}/'+key,
		type: 'GET',
		beforeSend: function() {
			$("#modal-loading").modal('show');
		},
		success: function(data) {
			Swal.fire('Success!', data.message, 'success');
			fetch_payment_data({{ $transaction->id }});
			// $('#paymentTable').html(data);
		},
		error: function(e) {
			Swal.fire('Error!', e.responseJSON.errors.message, 'error');
		},
		complete: function() {
			$("#modal-loading").modal('hide');
		},
	});
}

function terminate(key) {
	$.ajax({
		url: '{{ url("transaction/terminate") }}/'+key,
		type: 'GET',
		beforeSend: function() {
			$("#modal-loading").modal('show');
		},
		success: function(data) {
			Swal.fire('Success!', data.message, 'success');
			fetch_payment_data({{ $transaction->id }});
			// $('#paymentTable').html(data);
		},
		error: function(e) {
			Swal.fire('Error!', e.responseJSON.errors.message, 'error');
		},
		complete: function() {
			$("#modal-loading").modal('hide');
		},
	});
}
</script>

@endsection