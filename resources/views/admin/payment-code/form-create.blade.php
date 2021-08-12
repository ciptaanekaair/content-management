@extends('layouts.dashboard-layout')

@section('header')
  <h1>Create Payment Method</h1>
@endsection

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
        	@if(request()->routeIs('payment-methodes.create'))
        	<div class="card-title" id="card-title">
        		Form Metode Pembayaran
        	</div>
        	@else
        	<div class="card-title" id="card-title">
        		Edit : {{ $pMethod->nama_pembayaran }}
        	</div>
        	@endif
        </div>
        <div class="card-body">
        <form name="form-payment" id="form-payment">
        @csrf
        <input type="hidden" name="_method" id="formMethod" value="{{ $pMethod->id == '' ? 'POST' : 'PUT' }}">
        <input type="hidden" name="payment_code_id" id="payment_code_id" value="{{ old('payment_code_id', $pMethod->id) }}">
        <div class="row">
				<div class="col-lg-6">
					<div class="form-group">
						<label for="kode_pembayaran">Kode Pembayaran</label>
						<input type="text" name="kode_pembayaran" class="form-control" id="kode_pembayaran" value="{{ old('kode_pembayaran', $pMethod->kode_pembayaran) }}" placeholder="Kode Pembayaran">
						<div class="alert-message">
							<code id="kode_pembayaranError"></code>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label for="nama_pembayaran">Nama Pembayaran</label>
						<input type="text" name="nama_pembayaran" class="form-control" id="nama_pembayaran" value="{{ old('nama_pembayaran', $pMethod->nama_pembayaran) }}" placeholder="Nama Pembayaran">
						<div class="alert-message">
							<code id="nama_pembayaranError"></code>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label for="nama_bank">Nama Bank</label>
						<input type="text" name="nama_bank" class="form-control" id="nama_bank" value="{{ old('nama_bank', $pMethod->nama_bank) }}" placeholder="Nama Bank">
						<div class="alert-message">
							<code id="nama_bankError"></code>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label for="cabang">Cabang</label>
						<input type="text" name="cabang" class="form-control" id="cabang" value="{{ old('cabang', $pMethod->cabang) }}" placeholder="Cabang">
						<div class="alert-message">
							<code id="cabangError"></code>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label for="nomor_rekening">Nomor Rekening</label>
						<input type="text" name="nomor_rekening" class="form-control" id="nomor_rekening" value="{{ old('nomor_rekening', $pMethod->nomor_rekening) }}" placeholder="Nomor Rekening">
						<div class="alert-message">
							<code id="nomor_rekeningError"></code>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label for="atas_nama_rekening">Atas Nama</label>
						<input type="text" name="atas_nama_rekening" class="form-control" id="atas_nama_rekening" value="{{ old('atas_nama_rekening', $pMethod->atas_nama_rekening) }}" placeholder="Atas Nama Rekening">
						<div class="alert-message">
							<code id="atas_nama_rekeningError"></code>
						</div>
					</div>
				</div>
				<div class="col-lg-12">
					<div class="form-group">
						<label for="cara_bayar">Cara Bayar</label>
						<textarea name="cara_bayar" rows="5" class="form-control" id="cara_bayar" placeholder="Detail Cara bayar">
							{{ old('cara_bayar', $pMethod->cara_bayar) }}
						</textarea>
						<div class="alert-message">
							<code id="cara_bayarError"></code>
						</div>
					</div>
				</div>
			</div>
			<div class="card-footer">
				<a class="btn btn-secondary" href="{{ route('payment-methodes.index') }}">
					<i class="fa fa-arrow-circle-left"></i> &nbsp Kembali
				</a>
				<div class="float-right">
					<button type="submit" class="btn btn-primary">
						@if(request()->routeIs('payment-methodes.create'))
						<i class="fa fa-save"></i> &nbsp Simpan
						@else
						<i class="fa fa-save"></i> &nbsp Update
						@endif
					</button>
				</div>
			</div>
    	</form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('jq-script')

<script type="text/javascript">
	var url;

	$(function() {

		CKEDITOR.replace('cara_bayar');

		$('#form-payment').on('submit', function(e) {
			e.preventDefault();

			var idPayment = $('#payment_code_id').val();
			for ( instance in CKEDITOR.instances )
			        CKEDITOR.instances[instance].updateElement();
			
			if(idPayment === '') url = '{{ route("payment-methodes.store") }}';
			else url = '{{ url("payment-methodes") }}/'+idPayment;

			$.ajax({
				url: url,
				type: 'POST',
				data: $(this).serialize(),
				success: function(data) {
					Swal.fire('Success!', data.message, 'success');
					window.location.href = "{{ url('payment-methodes') }}";
				},
				error: function(response) {
					Swal.fire('Error!', response.responseJSON.errors.message, 'errors');
				},
			});
		});

	});
</script>

@endsection