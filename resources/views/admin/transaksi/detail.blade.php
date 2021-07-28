@extends('layouts.dashboard-layout')

@section('header')
	<h1>Transaction: {{ $transaction->transaction_code }}</h1>
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
				<div class="form-group">
					<label for="status">Status Transaksi</label>
					<select name="status" id="status" class="form-control">
						<option value="">Pilih Status</option>
						<option value="0" {{ $transaction->status == 0 ? 'selected' : '' }}>Pending (Belum di bayar)</option>
						<option value="1" {{ $transaction->status == 1 ? 'selected' : '' }}>Complete</option>
						<option value="2" {{ $transaction->status == 2 ? 'selected' : '' }}>Ferivy Payment</option>
						<option value="3" {{ $transaction->status == 3 ? 'selected' : '' }}>Pengemasan</option>
						<option value="4" {{ $transaction->status == 4 ? 'selected' : '' }}>Pengiriman</option>
						<option value="5" {{ $transaction->status == 5 ? 'selected' : '' }}>Diterima</option>
						<option value="6" {{ $transaction->status == 6 ? 'selected' : '' }}>Canceled</option>
					</select>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection