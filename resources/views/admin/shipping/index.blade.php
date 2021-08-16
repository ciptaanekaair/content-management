@extends('layouts.dashboard-layout')

@section('header')
	<h1>Data Pengiriman</h1>
@endsection

@section('content')
<div class="row mb-3">
	<div class="col-12">
		<button onclick="refresh()" class="btn btn-success"><i class="fa fa-refresh"></i> &nbsp Refresh</button> &nbsp&nbsp
		<a href="" target="_blank" class="btn btn-warning">
			<i class="fa fa-file-excel-o"></i> &nbsp Export Data
		</a>
	</div>
</div>
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<div class="col-lg-2 col-md-12">
					<select name="perpage" id="perpage" class="form-control">
						<option value="10" selected>10</option>
						<option value="50">50</option>
						<option value="100">100</option>
					</select>
				</div>
				<div class="col-lg-4 col-md-12">
					<select name="jenis_transaksi" id="jenis_transaksi" class="form-control">
						<option value="3" selected>Pengemasan</option>
						<option value="4">Pengiriman</option>
						<option value="5">Terkirim</option>
						<option value="1">Complete</option>
					</select>
				</div>
				<div class="col-lg-6 col-md-12">
					<div class="card-header-form">
						<div class="float-right">
							<form id="form-search">
								<input type="text" name="pencarian" onchange="cariData($(this).val())" class="form-control" id="pencarian" placeholder="Search">
							</form>
						</div>
					</div>
				</div>
			</div>
			<div class="card-body">
				<div class="table-data">
				</div>
				<input type="hidden" name="perpage" id="posisi_page">
			</div>
		</div>
	</div>
</div>
@endsection

@section('formodal')
	@include('admin.shipping.form')
@endsection

@section('jq-script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

<script type="text/javascript">
const loadingModal = $('#modal-loading');
let table, save_method, page, perpage, search, url, data;

$(function() {
	fetch_table(1, 10, '', $('#jenis_transaksi').val());

	$("#tanggal_kirim, #tanggal_sampai").on("change", function() {
    this.setAttribute(
        "data-date",
        moment(this.value, "YYYY-MM-DD")
        .format( this.getAttribute("data-date-format") )
    )
	}).trigger("change");

	$('#perpage').on('change', function() {
		perpage         = $(this).val();
		search          = $('#pencarian').val();
		page            = $('#posisi_page').val();
		jenis_transaksi = $('#jenis_transaksi').val();

		fetch_table(page, perpage, search, jenis_transaksi);
	});

	$('#jenis_transaksi').on('change', function() {
		perpage         = $('#perpage').val();
		search          = $('#pencarian').val();
		page            = $('#posisi_page').val();
		jenis_transaksi = $('#jenis_transaksi').val();

		fetch_table(page, perpage, search, jenis_transaksi);
	});

	$('#shipping_form').on('submit', function(e) {
		e.preventDefault();
		createShipping();
	});

	$('body').on('click', '.inline-flex a', function(e) {
		e.preventDefault();

		page            = $(this).attr('href').split('page=')[1];
		search          = $('#pencarian').val();
		perpage         = $('#perpage').val();
		jenis_transaksi = $('#jenis_transaksi').val();

		$('#posisi_page').val(page);

		fetch_table(page, perpage, search, jenis_transaksi);
	});
});


function cariData(data) {
	perpage = $('#perpage').val();
	jenis_transaksi = $('#jenis_transaksi').val();

	fetch_table(1, perpage, data, jenis_transaksi);
}


function newData() {
	save_method = 'add';
	formReset();
	$('.modal-title').text('Tambah data baru');
	$('#formMethod').val('POST');
	$('#category_image_link').removeAttr('href');
	$('#modal-form').modal('show');
}

function addShipping (id) {
	$.ajax({
		url: '{{ url("data/shippings/transaction") }}/'+id,
		type: 'GET'
	})
	.done(data => {
		save_method = 'add';
		$('#formMethod').val('POST');
		$('#shipping-form-title').text('Pengiriman untuk transaksi: '+data.data.transaction_code);
		$('#transaction_id').val(data.data.id);
		$('#transaction_code').val(data.data.transaction_code);
		$('#modal-shipping').modal('show');
	})
	.fail(response => {
		Swal.fire('Error', response.message, 'error');
	});
}

function editShipping(id) {
	save_method = 'edit';
	$.ajax({
		url: '{{ url("data/shippings/transaction") }}/'+id,
		type: 'GET'
	})
	.done(data => {
		// format tanggalan agar sesuai dengan format HMTL5
		let tgl_kirim      = new Date(data.data.shipping[0].tanggal_kirim);
		let tgl_sampai     = new Date(data.data.shipping[0].tanggal_sampai);
		let tanggal_kirim  = tgl_kirim.getFullYear()+'-'+("0"+(tgl_kirim.getMonth()+1)).slice(-2)+'-'+("0"+tgl_kirim.getDate()).slice(-2);
		let tanggal_sampai = tgl_sampai.getFullYear()+'-'+("0"+(tgl_sampai.getMonth()+1)).slice(-2)+'-'+("0"+tgl_sampai.getDate()).slice(-2);;

		$('#formMethod').val('PUT');
		$('#shipping-form-title').text('Pengiriman untuk transaksi: '+data.data.transaction_code);
		$('#transaction_id').val(data.data.id);
		$('#transaction_code').val(data.data.transaction_code);
		$('#shipping_id').val(data.data.shipping[0].id);
		$('#user_id [value="'+data.data.shipping[0].user_id+'"]').attr('selected', 'selected');
		$('#tanggal_kirim').val(tanggal_kirim);
		$('#tanggal_sampai').val(tanggal_sampai);
		$('#keterangan').val(data.data.shipping[0].keterangan);
		$('#status [value="'+data.data.shipping[0].status+'"]').attr('selected', 'selected');
		$('#modal-shipping').modal('show');
	})
	.fail(response => {});
}

function fetch_table(page, perpage, search, jenis_transaksi) {
	loadingModal.modal('show');
	$.ajax({
		url: '{{ route("shippings.data") }}?page='+page+'&list_perpage='+perpage+'&search='+search+'&jenis_transaksi='+jenis_transaksi,
		type: 'GET'
	})
	.done(response => {
		$('.table-data').html(response);
	})
	.fail(error => {
		Swal.fire('Error', response.message, 'error');
	});
}

function refresh() {
	jenis_transaksi = $('#jenis_transaksi').val();
	fetch_table(1, 10, '', jenis_transaksi);
}

function formDeleteReset() {
	$('#modal-delete form')[0].reset();
}

function formReset() {
	$('#modal-shipping form')[0].reset();
}

// Insert & Update
function createShipping() {
	let id = $('#shipping_id').val();

	if (save_method == 'add') url = '{{ route("shippings.store") }}';
	else url = '{{ url("shippings") }}/'+id;

	perpage         = $('#perpage').val();
	search          = $('#pencarian').val();
	jenis_transaksi = $('#jenis_transaksi').val();

	$.ajax({
		url: url,
		type: 'POST',
		data: $('#shipping_form').serialize(),
	})
	.done(data => {
		Swal.fire('Success', data.message, 'success');
		formReset();
		$('#modal-shipping').modal('hide');
		fetch_table(1, perpage, search, jenis_transaksi);
	})
	.fail(response => {
		Swal.fire('Error', response.message, 'error');
	})
}
</script>
@endsection