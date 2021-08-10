@extends('layouts.dashboard-layout')

@section('header')
	<h1>List Kota</h1>
@endsection

@section('content')
<div class="row mb-3">
	<div class="col-12">
		<a onclick="addData()" class="btn btn-success"><i class="fa fa-plus"></i> &nbsp Tambah Data</a> &nbsp&nbsp
		<button onclick="refresh()" class="btn btn-success"><i class="fa fa-refresh"></i> &nbsp Refresh</button> &nbsp&nbsp
		<a onclick="importData()" target="_blank" class="btn btn-primary"><i class="fa fa-file-excel-o"></i> &nbsp Import Data</a>
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
					@include('admin.wilayah.kota.table-data')
				</div>
				<input type="hidden" name="perpage" id="posisi_page" value="1">
			</div>
		</div>
	</div>
</div>
@endsection

@section('formodal')
  @include('admin.wilayah.kota.form')
  @include('admin.modal-loading')
@endsection

@section('jq-script')
<script type="text/javascript">

var save_method, page, perpage, search, url, data;

$(function() {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	})

	$('#form-import').on('submit', function(e) {
		e.preventDefault();

		page    = $('#posisi_page').val();
		perpage = $('#perpage').val();
		search  = $('#pencarian').val();

		$.ajax({
			url: '{{ route("kotas.import") }}',
			type: 'POST',
			data: new FormData($('#modal-import form')[0]),
			contentType: false,
			processData: false,
			beforeSend: function(){
				// Show image container
				$("#modal-loading").modal('show');
			},
			success: function(data) {
				$('#file_upload').val('');
				$('#modal-import').modal('hide');
				fetch_table(page, perpage, search);
				Swal.fire('Success!', 'Berhasil import data kota.', 'success');
			}, error: function(response) {
				$('#file_uploadError').text(response.responseJSON.errors.file_upload);
			},
			complete: function(data) {
				// Hide image container
				$("#modal-loading").modal('hide');
			}
		});
	});

	$('#form-data').on('submit', function(e) {
		e.preventDefault();

		id = $('#kota_id').val();

		page    = $('#posisi_page').val();
		perpage = $('#perpage').val();
		search  = $('#pencarian').val();

		if (save_method === 'add') url = '{{ route("kotas.store") }}';
		else url = '{{ url("kotas") }}/'+id;

		$.ajax({
			url: url,
			type: 'POST',
			data: $(this).serialize(),
			beforeSend: function(){
				$("#modal-loading").modal('show');
			},
			success: function(data) {
				formDataReset();
				fetch_table(page, perpage, search);
				$('#modal-form').modal('hide');
				Swal.fire('Success!', 'Berhasil menyimpan data.', 'success');
			}, error: function(response) {
				Swal.fire('Error!', 'Gagal melakukan penyimpanan data. Silahkan cek pengisian form.', 'error');
				$('#provinsi_idError').text(response.responseJSON.errors.provinsi_id);
				$('#nama_kotaError').text(response.responseJSON.errors.nama_kota);
				$('#statusError').text(response.responseJSON.errors.status);
			},
			complete: function(data) {
				$("#modal-loading").modal('hide');
			}
		});
	});

	$('#formDataDelete').on('submit', function(e) {
		e.preventDefault();

		var id = $('#kota_id_d').val();

		page    = $('#posisi_page').val();
		perpage = $('#perpage').val();
		search  = $('#pencarian').val();

		$.ajax({
			url: '{{ url("kotas") }}/'+id,
			type: 'POST',
			data: $(this).serialize(),
			beforeSend: function(){
				// Show image container
				$("#modal-loading").modal('show');
			},
			success: function(data) {
				formDeleteReset();
				$('#modal-delete').modal('hide');
				fetch_table(page, perpage, search);
				Swal.fire('Success!', data.message, 'success');
			}, error: function(response) {
				Swal.fire('Error!', response.responseJSON.message, 'error');
			},
			complete: function(data) {
				// Hide image container
				$("#modal-loading").modal('hide');
			}
		});
	});
	

	$('body').on('click', '.paginasi a', function(e) {
		e.preventDefault();

		page    = $(this).attr('href').split('page=')[1];
		search  = $('#pencarian').val();
		perpage = $('#perpage').val();

		$('#posisi_page').val(page);

		fetch_table(page, perpage, search);
	});

});

function addData() {
	save_method = 'add';
	formDataReset();
	$('#modal-form').modal('show');
}

function importData() {
	$('#file_upload').val('');
	$('#modal-import').modal('show');
}

function formDataReset() {
	$('#form-data').find('input').each(function(i, v) {
		$(this).val('');
  });
  $('#provinsi_id').prop('selectedIndex', 0);
  $('#status').prop('selectedIndex', 0);
}

function formDeleteReset() {
	$('.title-delete').text('');
	$('#kota_id_d').val('');
	$('#kota_name_d').text('');
}

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
		url: '{{ route("kotas.data") }}?page='+page+'&list_perpage='+perpage+'&search='+search,
		type: 'GET',
		beforeSend: function(){
			// Show image container
			$("#modal-loading").modal('show');
		},
		success: function(data) {
			$('.table-data').html(data);
		},
		complete: function(data) {
			// Hide image container
			$("#modal-loading").modal('hide');
		}
	});
}

function editData(id) {
	var id_ku = id;
	$.ajax({
		url: '{{ url("kotas") }}/'+id_ku+'/edit',
		type: 'GET',
		beforeSend: function(){
			// Show image container
			$("#modal-loading").modal('show');
		},
		success: function(data) {
			save_method = 'edit';
			$('#formAddMethod').val('PUT');
			$('.title-form').text('Edit data: ['+data.data.id+'] -'+data.data.nama_kota);
			$('#kota_id').val(data.data.id);
			$('#provinsi_id [value="'+data.data.provinsi_id+'"]').prop('selected', 'selected');
			$('#nama_kota').val(data.data.nama_kota);
			$('#status [value="'+data.data.status+'"]').prop('selected', 'selected');
			$('#modal-form').modal('show');
		},
		error: function(response) {
			Swal.fire('Error!', response.responseJSON.message, 'error');
		},
		complete: function(data) {
			// Hide image container
			$("#modal-loading").modal('hide');
		}
	});
}

function confirmDelete(id) {
	$.ajax({
		url: '{{ url("kotas") }}/'+id+'/edit',
		type: 'GET',
		beforeSend: function(){
			// Show image container
			$("#modal-loading").modal('show');
		},
		success: function(data) {
			$('.title-delete').text('Delete data: ['+data.data.id+'] -'+data.data.nama_kota);
			$('#kota_id_d').val(data.data.id);
			$('#kota_name_d').text(data.data.nama_kota);
			$('#modal-delete').modal('show');
		},
		error: function(response) {
			Swal.fire('Error!', response.responseJSON.message, 'error');
		},
		complete: function(data) {
			// Hide image container
			$("#modal-loading").modal('hide');
		}
	});
}
</script>

@endsection