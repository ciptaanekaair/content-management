@extends('layouts.dashboard-layout')

@section('header')
  <h1>User Management</h1>
@endsection

@section('content')
  <div class="row mb-3">
    <div class="col-12">
      <button onclick="newUserData()" class="btn btn-success"><i class="fa fa-plus"></i> &nbsp Tambah Data</button> &nbsp&nbsp
      <button onclick="refresh()" class="btn btn-success"><i class="fa fa-refresh"></i> &nbsp Refresh</button> &nbsp&nbsp
      <a href="{{ route('pengguna.data.export') }}" target="_blank" class="btn btn-warning"><i class="fa fa-file-excel-o"></i> &nbsp Export Data</a>
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
        <div class="card-body pb-0">
          <div class="table-data">
          </div>
          <input type="hidden" name="perpage" id="posisi_page">
        </div>
      </div>
    </div>
  </div>
@endsection

@section('formodal')
  @include('admin.users.form')
  @include('admin.modal-loading')
@endsection

@section('jq-script')
<script type="text/javascript">
var save_method, page, perpage, search, url, data;

$(function() {

  fetch_table(1, 10, '');

  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  })

  $('#perpage').on('change', function() {
    perpage = $(this).val();
    search  = $('#pencarian').val();
    page    = $('#posisi_page').val();

    fetch_table(page, perpage, search);
  });

  $('#user_form').on('submit', function(e){
    e.preventDefault();

    resetErrorUserForm();

    var id = $('#user_id').val();

    perpage = $('#perpage').val();
    search  = $('#pencarian').val();
    page    = $('#posisi_page').val();

    if (save_method == "update") url = "{{ url('pengguna') }}/"+id;
    else url = "{{ route('pengguna.store') }}";

    $.ajax({
      url: url,
      type: 'POST',
      data: new FormData($('#modal-new form')[0]),
      contentType: false,
      processData: false,
      beforeSend: function(){
        // Show image container
        $("#modal-loading").modal('show');
      },
      success: function(data) {
        $("#modal-loading").modal('hide');
        formReset();
        $('#modal-new').modal('hide');
        Swal.fire(
          'Success!',
          data.message,
          'success'
        );
        fetch_table(page, perpage, search);
      }, error: function(response) {
        $("#modal-loading").modal('hide');
        Swal.fire('Error!', 'Silahkan cek kembali pengisian form anda!', 'error');
        $('#nameError').text(response.responseJSON.errors.name);
        $('#emailError').text(response.responseJSON.errors.email);
        $('#profile_photo_pathError').text(response.responseJSON.errors.profile_photo_path);
        $('#statusError').text(response.responseJSON.errors.status);
        $('#passwordError').text(response.responseJSON.errors.password);
        $('#password_confirmationError').text(response.responseJSON.errors.password_confirmation);
        $('#level_idError').text(response.responseJSON.errors.level_id);
        $('#statusError').text(response.responseJSON.errors.status);
      }
    });
  }); // end submit save or update

  $('#detail_form').on('submit', function(e){
    e.preventDefault();

    resetErrorShippingForm();

    var id = $('#detail_id').val();

    perpage = $('#perpage').val();
    search  = $('#pencarian').val();
    page    = $('#posisi_page').val();

    url = "{{ url('pengguna-detail') }}/"+id;

    $.ajax({
      url: url,
      type: 'POST',
      data: new FormData($('#modal-form form')[0]),
      contentType: false,
      processData: false,
      beforeSend: function(){
        // Show image container
        $("#modal-loading").modal('show');
      },
      success: function(data) {
        $("#modal-loading").modal('hide');
        formReset();
        $('#modal-form').modal('hide');
        Swal.fire(
          'Success!',
          data.message,
          'success'
        );
        fetch_table(page, perpage, search);
      }, error: function(response) {
        $("#modal-loading").modal('hide');
        Swal.fire('Error!', 'Silahkan cek kembali pengisian form anda!', 'error');
        $('#nama_ptError').text(response.responseJSON.errors.nama_pt);
        $('#teleponError').text(response.responseJSON.errors.telepon);
        $('#handphoneError').text(response.responseJSON.errors.handphone);
        $('#alamatError').text(response.responseJSON.errors.alamat);
        $('#provinsi_idError').text(response.responseJSON.errors.provinsi_id);
        $('#kode_posError').text(response.responseJSON.errors.kode_pos);
      }
    });
  }); // end submit save or update

  // start script pencarian
  $('input[name="pencarian"]').bind('change paste', function(){
    search = $(this).val();
    perpage = $('#perpage').val();
    page    = 1;

    fetch_table(page, perpage, search);
  }); // end pencarian

  // start script delete
  $('#user_delete_form').on('submit', function(e) {
    e.preventDefault();

    var id         = $('#userid_delete').val();
    var total_data = "{{ $users->total() }}";

      perpage = $('#perpage').val();
      search  = $('#pencarian').val();
    if (total_data <= 10) {
      page    = $('#posisi_page').val(1);
    } else {
      page = $('#posisi_page').val();
    }

    $.ajax({
      url: '{{ url("pengguna") }}/'+id,
      type: 'POST',
      data: $(this).serialize(),
      beforeSend: function(){
        // Show image container
        $("#modal-loading").modal('show');
      },
      success: function(data) {
        $("#modal-loading").modal('hide');
        fetch_table(page, perpage, search);
        $('#modal-delete').modal('hide');
        formDeleteReset();
        Swal.fire(
          'Success!',
          'Berhasil menghapus data tersebut.',
          'success'
        );
      }
    });
  }); // end script delete

  $('body').on('click', '.inline-flex a', function(e) {
    e.preventDefault();

    page    = $(this).attr('href').split('page=')[1];
    search  = $('#pencarian').val();
    perpage = $('#perpage').val();

    $('#posisi_page').val(page);

    fetch_table(page, perpage, search);
   });
});

function resetErrorUserForm() {
  $('#nameError').text('');
  $('#emailError').text('');
  $('#passwordError').text('');
  $('#password_confirmationError').text('');
  $('#profile_photo_pathError').text('');
  $('#level_idError').text('');
  $('#statusError').text('');
}

function resetErrorShippingForm() {
  $('#nama_ptError').text('');
  $('#teleponError').text('');
  $('#handphoneError').text('');
  $('#alamatError').text('');
  $('#provinsi_idError').text('');
  $('#kode_posError').text('');
}

function refresh() {
  $('#pencarian').val('');
  perpage = $('#perpage').val();
  search  = '';
  page    = 1;

  fetch_table(page, perpage, search);
}

function cariData(data) {
  perpage = $('#perpage').val();
  
  fetch_table(1, perpage, data);
}

function newUserData() {
  save_method = 'add';
  formReset();
  resetErrorUserForm();
  $('.modal-title').text('Tambah data baru');
  $('#formUserMethod').val('POST');
  $('#category_image_link').removeAttr('href');
  $('#email').removeAttr('readonly');
  $('#modal-new').modal('show');
}

function fetch_table(page, perpage, search) {
  $.ajax({
    url: '{{ route("pengguna.data") }}?page='+page+'&list_perpage='+perpage+'&search='+search,
    type: 'GET',
    beforeSend: function(){
      // Show image container
      $("#modal-loading").modal('show');
    },
    success: function(data) {
      $("#modal-loading").modal('hide');
      $('.table-data').html(data);
    }
  });
}

function formDeleteReset() {
  $('#modal-delete form')[0].reset();
}

function formReset() {
  $('#modal-new form')[0].reset();
  $('#modal-form form')[0].reset();
}

function editData(id) {
  save_method = 'update';
  $.ajax({
    url: '{{ url("pengguna") }}/'+id+'/edit',
    type: 'GET',
    dataType: 'JSON',
    beforeSend: function(){
      // Show image container
      $("#modal-loading").modal('show');
    },
    success: function(data) {
      $("#modal-loading").modal('hide');
      resetErrorUserForm();
      $('#formUserMethod').val('PUT');
      $('#email').attr('readonly', true);
      $('.modal-title').text('Edit: '+data.data.email);
      $('#user_id').val(data.data.id);
      $('#name').val(data.data.name);
      $('#email').val(data.data.email);
      $('#profile_photo_url').attr('href', data.data.profile_photo_url);
      $('#btnUserSave').text('Update Data');
      $('#level_id [value="'+data.data.level_id+'"]').attr('selected', 'selected');
      $('#company [value="'+data.data.company+'"]').attr('selected', 'selected');
      $('#status [value="'+data.data.status+'"]').attr('selected', 'selected');
      $('#modal-new').modal('show'); 
    },
    error: function(message) {
      $("#modal-loading").modal('hide');
      Swal.fire('Error!', 'Gagal mengambil data user.', 'error');
    }
  });
}

function editShipping(id) {
  save_method = 'update';
  $.ajax({
    url: '{{ url("pengguna-detail") }}/'+id+'/edit',
    type: 'GET',
    dataType: 'JSON',
    beforeSend: function(){
      // Show image container
      $("#modal-loading").modal('show');
    },
    success: function(data) {
      $("#modal-loading").modal('hide');
      resetErrorUserForm();
      formReset();
      $('#formShippingMethod').val('PUT');
      $('#email').attr('readonly', true);
      $('.shipping-title').text('Edit alamat user id: '+data.data.user_id);
      $('#detail_id').val(data.data.id)
      $('#user_id_detail').val(data.data.user_id);
      $('#nama_pt').val(data.data.nama_pt);
      $('#telepon').val(data.data.telepon);
      $('#handphone').val(data.data.handphone);
      $('#alamat').val(data.data.alamat);
      $('#kode_pos').val(data.data.kode_pos);
      $('#provinsi_id [value="'+data.data.provinsi_id+'"]').attr('selected', 'selected');
      $('#modal-form').modal('show'); 
    },
    error: function(message) {
      $("#modal-loading").modal('hide');
      Swal.fire('Error!', 'Gagal mengambil data user.', 'error');
    }
  });
}

function confirmDelete(id) {
  save_method = 'delete';
  $.ajax({
    url: '{{ url("pengguna") }}/'+id,
    type: 'GET',
    dataType: 'JSON',
    beforeSend: function(){
      // Show image container
      $("#modal-loading").modal('show');
    },
    success: function(data) {
      $("#modal-loading").modal('hide');
      $('.modal-title-delete').text('Delete data: '+data.data.name);
      $('#formMethodD').val('DELETE');
      $('#userid_delete').val(data.data.id);
      $('#user_name_d').text(data.data.name);
      $('#modal-delete').modal('show');
    }
  });
}
</script>
@endsection