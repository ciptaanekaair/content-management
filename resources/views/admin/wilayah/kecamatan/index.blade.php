@extends('layouts.dashboard-layout')

@section('header')
	<h1>List Kecamatan</h1>
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
					
				</div>
				<input type="hidden" name="perpage" id="posisi_page" value="1">
			</div>
		</div>
	</div>
</div>
@endsection

@section('formodal')
  @include('admin.wilayah.kecamatan.form')
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

	fetch_table(1, 10, '');

	$('#form-import').on('submit', function(e) {
		e.preventDefault();

		page    = $('#posisi_page').val();
		perpage = $('#perpage').val();
		search  = $('#pencarian').val();

		$.ajax({
			url: '{{ route("kecamatans.import") }}',
			type: 'POST',
			data: new FormData($('#modal-import form')[0]),
			contentType: false,
			processData: false,
			beforeSend: function(){
				// Show image container
				$("#modal-loading").modal('show');
			},
			success: function(data) {
				$("#modal-loading").modal('hide');
				$('#file_upload').val('');
				$('#modal-import').modal('hide');
				fetch_table(page, perpage, search);
				Swal.fire('Success!', 'Berhasil import data kecamatans.', 'success');
			}, error: function(response) {
				$("#modal-loading").modal('hide');
				$('#file_uploadError').text(response.responseJSON.errors.file_upload);
			},
			complete: function() {
				$("#modal-loading").modal('hide');
			}
		});
	});

	$('#form-data').on('submit', function(e) {
		e.preventDefault();

		id = $('#kecamatan_id').val();

		page    = $('#posisi_page').val();
		perpage = $('#perpage').val();
		search  = $('#pencarian').val();

		if (save_method === 'add') url = '{{ route("kecamatans.store") }}';
		else url = '{{ url("kecamatans") }}/'+id;

		$.ajax({
			url: url,
			type: 'POST',
			data: $(this).serialize(),
			beforeSend: function(){
				// Show image container
				$("#modal-loading").modal('show');
			},
			success: function(data) {
				$("#modal-loading").modal('hide');
				formDataReset();
				$('#modal-form').modal('hide');
				fetch_table(page, perpage, search);
				Swal.fire('Success!', 'Berhasil menyimpan data.', 'success');
			}, error: function(response) {
				$("#modal-loading").modal('hide');
				Swal.fire('Error!', 'Gagal melakukan penyimpanan data. Silahkan cek pengisian form.', 'error');
				$('#kota_idError').text(response.responseJSON.errors.kota_id);
				$('#nama_kecamatanError').text(response.responseJSON.errors.nama_kecamatan);
				$('#statusError').text(response.responseJSON.errors.status);
			},
			complete: function() {
				$("#modal-loading").modal('hide');
			}
		});
	});

	$('#formDataDelete').on('submit', function(e) {
		e.preventDefault();

		var id = $('#kecamatan_id_d').val();

		page    = $('#posisi_page').val();
		perpage = $('#perpage').val();
		search  = $('#pencarian').val();

		$.ajax({
			url: '{{ url("kecamatans") }}/'+id,
			type: 'POST',
			data: $(this).serialize(),
			beforeSend: function(){
				// Show image container
				$("#modal-loading").modal('show');
			},
			success: function(data) {
				$("#modal-loading").modal('hide');
				formDeleteReset();
				$('#modal-delete').modal('hide');
				fetch_table(page, perpage, search);
				Swal.fire('Success!', data.message, 'success');
			}, error: function(response) {
				$("#modal-loading").modal('hide');
				Swal.fire('Error!', response.responseJSON.message, 'error');
			},
			complete: function() {
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

	$('#perpage').on('change', function(e) {
		e.preventDefault(e);

		page    = 1;
		search  = $('#pencarian').val();
		perpage = $(this).val();

		fetch_table(page, perpage, search);
	});

});

function addData() {
	save_method = 'add';
	formDataReset();
	$('#formAddMethod').val('POST');
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
   $('#kota_id').prop('selectedIndex', 0);
   $('#status').prop('selectedIndex', 0);
}

function formDeleteReset() {
	$('.title-delete').text('');
	$('#kecamatan_id_d').val('');
	$('#kecamatan_name_d').text('');
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
		url: '{{ route("kecamatans.data") }}?page='+page+'&list_perpage='+perpage+'&search='+search,
		type: 'GET',
		beforeSend: function(){
			// Show image container
			$("#modal-loading").modal('show');
		},
		success: function(data) {
			$("#modal-loading").modal('hide');
			$('.table-data').html(data);
		},
		error: function(response) {
			Swal.fire('Error!', response.responseJSON.errors.message, 'error');
		},
		complete: function() {
			$("#modal-loading").modal('hide');
		}
	});
}

function editData(id) {
	var id_ku = id;
	$.ajax({
		url: '{{ url("kecamatans") }}/'+id_ku+'/edit',
		type: 'GET',
		beforeSend: function(){
			// Show image container
			$("#modal-loading").modal('show');
		},
		success: function(data) {
			$("#modal-loading").modal('hide');
			save_method = 'edit';
			$('#formAddMethod').val('PUT');
			$('.title-form').text('Edit data: ['+data.data.id+'] -'+data.data.nama_kecamatan);
			$('#kecamatan_id').val(data.data.id);
			$('#kota_id [value="'+data.data.kota_id+'"]').prop('selected', 'selected');
			$('#nama_kecamatan').val(data.data.nama_kecamatan);
			$('#status [value="'+data.data.status+'"]').prop('selected', 'selected');
			$('#modal-form').modal('show');
		},
		error: function(response) {
			$("#modal-loading").modal('hide');
			Swal.fire('Error!', response.responseJSON.message, 'error');
		},
		complete: function() {
			$("#modal-loading").modal('hide');
		}
	});
}

function confirmDelete(id) {
	$.ajax({
		url: '{{ url("kecamatans") }}/'+id+'/edit',
		type: 'GET',
		beforeSend: function(){
			// Show image container
			$("#modal-loading").modal('show');
		},
		success: function(data) {
			$("#modal-loading").modal('hide');
			$('.title-delete').text('Delete data: ['+data.data.id+'] -'+data.data.nama_kecamatan);
			$('#kecamatan_id_d').val(data.data.id);
			$('#kecamatan_name_d').text(data.data.nama_kecamatan);
			$('#modal-delete').modal('show');
		},
		error: function(response) {
			$("#modal-loading").modal('hide');
			Swal.fire('Error!', response.responseJSON.message, 'error');
		},
		complete: function() {
			$("#modal-loading").modal('hide');
		}
	});
}

</script>

@endsection