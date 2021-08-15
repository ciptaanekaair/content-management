@extends('layouts.dashboard-layout')

@section('header')
	<h1>Product Categories</h1>
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
				<div class="col-lg-3 col-md-12">
					<select name="perpage" id="perpage" class="form-control">
						<option value="10" selected>10</option>
						<option value="50">50</option>
						<option value="100">100</option>
					</select>
				</div>
				<div class="col-lg-9 col-md-12">
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
	@include('admin.modal-loading')
@endsection

@section('jq-script')
<script type="text/javascript">
const loadingModal = $('#modal-loading');
let table, save_method, page, perpage, search, url, data;

$(function() {
	fetch_table(1, 10, '');

	$('#perpage').on('change', function() {
		perpage = $(this).val();
		search  = $('#pencarian').val();
		page    = $('#posisi_page').val();

		fetch_table(page, perpage, search);
	});

	$('body').on('click', '.inline-flex a', function(e) {
		e.preventDefault();

		page    = $(this).attr('href').split('page=')[1];
		search  = $('#pencarian').val();
		perpage = $('#perpage').val();

		$('#posisi_page').val(page);

		fetch_table(page, perpage, search);
	});
});


function cariData(data) {
	perpage = $('#perpage').val();

	fetch_table(1, perpage, data);
}


function newData() {
	save_method = 'create';
	formReset();
	$('.modal-title').text('Tambah data baru');
	$('#formMethod').val('POST');
	$('#category_image_link').removeAttr('href');
	$('#modal-form').modal('show');
}


function fetch_table(page, perpage, search) {
	loadingModal.modal('show');
	$.ajax({
		url: '{{ route("shippings.data") }}?page='+page+'&list_perpage='+perpage+'&search='+search,
		type: 'GET'
	})
	.done(response => {
		loadingModal.modal('hide');
		$('.table-data').html(response);
	})
	.fail(error => {
		loadingModal.modal('hide');
		// 
	});
}

function refresh() {
	fetch_table(1, 10, '');
}

function formDeleteReset() {
	$('#modal-delete form')[0].reset();
}

function formReset() {
	$('#modal-form form')[0].reset();
}

// Insert

// Update

// Delete
</script>
@endsection