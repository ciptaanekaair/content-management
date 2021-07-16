@extends('layouts.dashboard-layout')

@section('header')
  <h1>Product Categories</h1>
@endsection

@section('content')
  <div class="row mb-3">
    <div class="col-12">
      <button onclick="newData()" class="btn btn-success"><i class="fa fa-plus"></i> &nbsp Tambah Data</button> &nbsp&nbsp
      <button onclick="exportData()" class="btn btn-warning"><i class="fa fa-file-pdf-o"></i> &nbsp Export Data</button>
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
                  <input type="text" class="form-control" id="pencarian" placeholder="Search">
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="card-bory p-0">
          <div class="table-data">
            @include('admin.products-category.table-data')
          </div>
          <input type="hidden" name="perpage" id="posisi_page">
        </div>
      </div>
    </div>
  </div>
@endsection

@section('formodal')
  @include('admin.products-category.form')
@endsection

@section('jq-script')
<script type="text/javascript">
var table, save_method, page, perpage, search;
$(function() {
  $('#perpage').on('change', function() {
    perpage = $(this).val();
    search  = $('#pencarian').val();
    page    = $('#posisi_page').val();

    fetch_table(page, perpage, search);
  });

  $('#category_form').on('submit', function(e) {
    if (!e.isDefaultPrevented()) {

    }
  });

  $('#btnDelete').on('click', function() {
    var id = $('#category_id_d').val();

    $.ajax({
      url: '{{ url("product-categories") }}/'+id,
      type: 'POST',
      data: $('#category_delete_form').serialize(),
      success: function(data) {
        Swal.fire(
          'Berhasil!',
          'Berhasil menghapus data Category Product!',
          'success'
        );
      },
      error: function(data) {

      }
    });
  });
});

function newData() {
  save_method = 'create';
  formReset();
  $('.modal-title').text('Tambah data baru');
  $('#category_image_link').removeAttr('href');
  $('#modal-form').modal('show');
}

function fetch_table(page, perpage, search) {
  perpage = $(this).val();
  search  = $('#pencarian').val();
  page    = $('#posisi_page').val();

  $.ajax({
    url: '{{ url("product-categories/data") }}/?page='+page+'&list_perpage='+perpage+'&search='+search,
    type: 'GET',
    success: function(data) {
      $('.table-data').html(data);
    },
  });
}

function formDeleteReset() {
  $('#modal-delete form')[0].reset();
}

function formReset() {
  $('#modal-form form')[0].reset();
}

function editData(id) {
  save_method = 'update';
  $.ajax({
    url: '{{ url("product-categories") }}/'+id+'/edit',
    type: 'GET',
    dataType: 'JSON',
    success: function(data) {
      $('.modal-title').text('Edit: '+data.data.category_name);
      $('#category_id').val(data.data.id);
      $('#formMethod').val('PUT');
      $('#category_name').val(data.data.category_name);
      $('#category_description').val(data.data.category_description);
      $('#keywords').val(data.data.keywords);
      $('#description_seo').val(data.data.description_seo);
      $('#category_image_link').attr('href', data.data.imageurl);
      $('#btnSave').text('Update Data');
      $('#modal-form').modal('show');
    },
    error: function(message) {
      $('#nameError').text(response.responseJSON.errors.name);
      $('#nameError').text(response.responseJSON.errors.name);
      $('#nameError').text(response.responseJSON.errors.name);
      $('#nameError').text(response.responseJSON.errors.name);
      $('#nameError').text(response.responseJSON.errors.name);
      $('#nameError').text(response.responseJSON.errors.name);
      $('#nameError').text(response.responseJSON.errors.name);
      $('#nameError').text(response.responseJSON.errors.name);
      $('#nameError').text(response.responseJSON.errors.name);
    }
  });
}

function confirmDelete(id) {
  save_method = 'delete';
  $.ajax({
    url: '{{ url("product-categories") }}/'+id,
    type: 'GET',
    dataType: 'JSON',
    success: function(data) {
      $('.modal-title-delete').text('Delete data: '+data.data.category_name);
      $('#category_id_d').val(data.data.id);
      $('#formMethodD').val('DELETE');
      $('#category_name_d').text(data.data.category_name);
      $('#modal-delete').modal('show');
    },
  });
}
</script>
@endsection