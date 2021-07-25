@extends('layouts.dashboard-layout')

@section('header')
  <h1>Roles Management</h1>
@endsection

@section('content')
  <div class="row mb-3">
    <div class="col-12">
      <button onclick="newData()" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> &nbsp Tambah Data</button> &nbsp
      <button onclick="refresh()" class="btn btn-sm btn-success"><i class="fa fa-refresh"></i> &nbsp Refresh</button>&nbsp
      <button onclick="showLevel()" class="btn btn-sm btn-primary">
        <i class="fa fa-cogs"></i> Level
      </button>
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
                  <input type="text" name="pencarian" class="form-control" id="pencarian" placeholder="Search">
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body pb-0" id="card-attachment">
          <form name="form-attachment" id="form-attachment" >
            <div class="table-data">
              @include('admin.role.table-data')
            </div>
            <input type="hidden" name="level_id" id="level_id">
          </form>
          <input type="hidden" name="perpage" id="posisi_page">
        </div>
      </div>
    </div>
  </div>
@endsection

@section('formodal')
  @include('admin.role.form')
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

  $('#select-all').click(function(){
    $('input[type="checkbox"]').prop('checked', this.checked);
  });

  $('#perpage').on('change', function() {
    perpage = $(this).val();
    search  = $('#pencarian').val();
    page    = $('#posisi_page').val();

    fetch_table(page, perpage, search);
  });

  $('#role_form').on('submit', function(e){
    e.preventDefault();

    resetAddFormError();

    var id = $('#role_id').val();

    perpage = $('#perpage').val();
    search  = $('#pencarian').val();
    page    = $('#posisi_page').val();

    if (save_method == "update") url = "{{ url('roles') }}/"+id;
    else url = "{{ route('roles.store') }}";

    $.ajax({
      url: url,
      type: 'POST',
      data: new FormData($('#modal-form form')[0]),
      contentType: false,
      processData: false,
      success: function(data) {
        formReset();
        $('#modal-form').modal('hide');
        Swal.fire(
          'Success!',
          data.message,
          'success'
        );
        fetch_table(page, perpage, search);
      }, error: function(response) {
        Swal.fire('Error!', 'Silahkan cek kembali pengisian form anda!', 'error');
        $('#nama_roleError').text(response.responseJSON.errors.nama_role);
        $('#statusError').text(response.responseJSON.errors.status);
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
    var total_data = "{{ $roles->total() }}";

      perpage = $('#perpage').val();
      search  = $('#pencarian').val();
    if (total_data <= 10) {
      page    = $('#posisi_page').val(1);
    } else {
      page = $('#posisi_page').val();
    }

    $.ajax({
      url: '{{ url("roles") }}/'+id,
      type: 'POST',
      data: $(this).serialize(),
      success: function(data) {
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

  $('#levels').on('change', function(){
    $('#level_id').val($(this).val());
    $('#modal-level').modal('hide');
    attachingRole();
  });
});

function resetAddFormError() {
  $('#nama_roleError').text('');
  $('#statusError').text('');
}

function formDeleteReset() {
  $('#modal-delete form')[0].reset();
}

function formReset() {
  $('#modal-form form')[0].reset();
}

function showLevel() {
  $('#modal-level').modal('show');
}

function refresh() {
  $('#pencarian').val('');
  perpage = $('#perpage').val();
  search  = '';
  page    = 1;

  fetch_table(page, perpage, search);
}

function newData() {
  save_method = 'add';
  formReset();
  resetAddFormError();
  $('.modal-title').text('Tambah data Roles baru');
  $('#formAddMethod').val('POST');
  $('#modal-form').modal('show');
}

function fetch_table(page, perpage, search) {
  $.ajax({
    url: '{{ route("roles.data") }}?page='+page+'&list_perpage='+perpage+'&search='+search,
    type: 'GET',
    success: function(data) {
      $('.table-data').html(data);
    },
  });
}

function editData(id) {
  save_method = 'update';
  $.ajax({
    url: '{{ url("roles") }}/'+id+'/edit',
    type: 'GET',
    dataType: 'JSON',
    success: function(data) {
      resetAddFormError();
      $('#formAddMethod').val('PUT');
      $('.modal-title').text('Edit: '+data.data.nama_role);
      $('#role_id').val(data.data.id);
      $('#nama_role').val(data.data.nama_role);
      $('#status [value="'+data.data.status+'"]').attr('selected', 'selected');
      $('#modal-form').modal('show'); 
    },
    error: function(message) {
      Swal.fire('Error!', 'Gagal mengambil data user.', 'error');
    }
  });
}

function confirmDelete(id) {
  save_method = 'delete';
  $.ajax({
    url: '{{ url("roles") }}/'+id,
    type: 'GET',
    dataType: 'JSON',
    success: function(data) {
      $('.modal-title-delete').text('Delete data: '+data.data.name);
      $('#formMethodD').val('DELETE');
      $('#userid_delete').val(data.data.id);
      $('#user_name_d').text(data.data.name);
      $('#modal-delete').modal('show');
    },
  });
}

function attachingRole() {
  $.ajax({
    url: '{{ url("roles/attach") }}',
    type: 'POST',
    data: $('#form-attachment').serialize(),
    success: function(data) {
      $('#form-attachment').reset();
      $('#levels [value=""]').attr('selected', 'selected');
      Swal.fire('Berhasil!', 'Berhasil attach level dengan role yang dipilih.', 'success');
    }, error: function(response) {
      Swal.fire('Error!', 'gagal attach level dengan role yang di pilih.', 'error');
    }
  });
}

</script>
@endsection