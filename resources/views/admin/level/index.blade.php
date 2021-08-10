@extends('layouts.dashboard-layout')

@section('header')
  <h1>Levels Management</h1>
@endsection

@section('content')
  <div class="row mb-3">
    <div class="col-12">
      <button onclick="newUserData()" class="btn btn-success"><i class="fa fa-plus"></i> &nbsp Tambah Data</button> &nbsp&nbsp
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
  @include('admin.level.form')
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

    if (save_method == "update") url = "{{ url('levels') }}/"+id;
    else url = "{{ route('levels.store') }}";

    $.ajax({
      url: url,
      type: 'POST',
      data: new FormData($('#modal-new form')[0]),
      contentType: false,
      processData: false,
      beforeSend: function() {
        $('#modal-loading').modal('show');
      },
      success: function(data) {
        formReset();
        $('#modal-new').modal('hide');
        Swal.fire(
          'Success!',
          data.message,
          'success'
        );
        fetch_table(page, perpage, search);
      }, error: function(response) {
        Swal.fire('Error!', 'Silahkan cek kembali pengisian form anda!', 'error');
        $('#nameError').text(response.responseJSON.errors.name);
        $('#emailError').text(response.responseJSON.errors.email);
        $('#profile_photo_pathError').text(response.responseJSON.errors.profile_photo_path);
        $('#statusError').text(response.responseJSON.errors.status);
        $('#passwordError').text(response.responseJSON.errors.password);
        $('#password_confirmationError').text(response.responseJSON.errors.password_confirmation);
        $('#level_idError').text(response.responseJSON.errors.level_id);
        $('#statusError').text(response.responseJSON.errors.status);
      },
      complete: function() {
        $('#modal-loading').modal('hide');
      },
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
    var total_data = "{{ $levels->total() }}";

      perpage = $('#perpage').val();
      search  = $('#pencarian').val();
    if (total_data <= 10) {
      page    = $('#posisi_page').val(1);
    } else {
      page = $('#posisi_page').val();
    }

    $.ajax({
      url: '{{ url("levels") }}/'+id,
      type: 'POST',
      data: $(this).serialize(),
      beforeSend: function() {
        $('#modal-loading').modal('show');
      },
      success: function(data) {
        fetch_table(page, perpage, search);
        $('#modal-delete').modal('hide');
        formDeleteReset();
        Swal.fire(
          'Success!',
          'Berhasil menghapus data tersebut.',
          'success'
        );
      },
      complete: function() {
        $('#modal-loading').modal('hide');
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

function formDeleteReset() {
  $('#modal-delete form')[0].reset();
}

function formReset() {
  $('#modal-form form')[0].reset();
}

function refresh() {
  $('#pencarian').val('');
  perpage = $('#perpage').val();
  search  = '';
  page    = 1;

  fetch_table(page, perpage, search);
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
    url: '{{ route("levels.data") }}?page='+page+'&list_perpage='+perpage+'&search='+search,
    type: 'GET',
    beforeSend: function() {
      $('#modal-loading').modal('show');
    },
    success: function(data) {
      $('.table-data').html(data);
    },
    complete: function() {
      $('#modal-loading').modal('hide');
    }
  });
}

function editData(id) {
  save_method = 'update';
  $.ajax({
    url: '{{ url("levels") }}/'+id+'/edit',
    type: 'GET',
    dataType: 'JSON',
    beforeSend: function() {
      $('#modal-loading').modal('show');
    },
    success: function(data) {
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
      $('#status [value="'+data.data.status+'"]').attr('selected', 'selected');
      $('#modal-new').modal('show'); 
    },
    error: function(message) {
      Swal.fire('Error!', 'Gagal mengambil data user.', 'error');
    },
    complete: function() {
      $('#modal-loading').modal('hide');
    }
  });
}

function confirmDelete(id) {
  save_method = 'delete';
  $.ajax({
    url: '{{ url("levels") }}/'+id,
    type: 'GET',
    dataType: 'JSON',
    beforeSend: function() {
      $('#modal-loading').modal('show');
    },
    success: function(data) {
      $('.modal-title-delete').text('Delete data: '+data.data.name);
      $('#formMethodD').val('DELETE');
      $('#userid_delete').val(data.data.id);
      $('#user_name_d').text(data.data.name);
      $('#modal-delete').modal('show');
    },
    complete: function() {
      $('#modal-loading').modal('hide');
    }
  });
}
</script>
@endsection