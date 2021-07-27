@extends('layouts.dashboard-layout')

@section('header')
	<h1>List Transaction</h1>
@endsection

@section('content')
<div class="row mb-3">
	<div class="col-12">
		<a href="{{ route('transactions.create') }}" class="btn btn-success"><i class="fa fa-plus"></i> &nbsp Tambah Data</a> &nbsp&nbsp
		<button onclick="refresh()" class="btn btn-success"><i class="fa fa-refresh"></i> &nbsp Refresh</button>
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
								<input type="text" name="pencarian" onchange="cariData($(this).val())" 
								class="form-control" id="pencarian" placeholder="Search">
							</form>
						</div>
					</div>
				</div>
			</div>	
			<div class="card-body">
				<div class="table-data">
					@include('admin.transaksi.table-data')
				</div>
				<input type="hidden" name="perpage" id="posisi_page">
			</div>
		</div>
	</div>
</div>
@endsection

@section('jq-script')
<script type="text/javascript">

var save_method, page, perpage, search, url, data;

$(function() {

	$('body').on('click', '.inline-flex a', function(e) {
		e.preventDefault();

		page    = $(this).attr('href').split('page=')[1];
		search  = $('#pencarian').val();
		perpage = $('#perpage').val();

		$('#posisi_page').val(page);

		fetch_table(page, perpage, search);
	});

});

function refresh() {
	page    = 1;
	perpage = $('#perpage').val();
	search  = '';

	fetch_table(page, perpage, search);
}

function cariData(search) {
	page    = 1;
	perpage = $('#perpage').val();

	fetch_table(page, perpage, search);
}

function fetch_table(page, perpage, search) {
	$.ajax({
		url: '{{ route("transactions.data") }}?page='+page+'&list_perpage='+perpage+'&search='+search,
		type: 'GET',
		success: function(data) {
			$('.table-data').html(data);
		},
	});
}

</script>

@endsection