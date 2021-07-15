@extends('layouts.dashboard-layout')

@section('header')
  <h1>Product Categories</h1>
@endsection

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <div class="col-2">
            <select name="perpage" id="perpage" class="form-control">
              <option value="10" selected>10</option>
              <option value="50">50</option>
              <option value="100">100</option>
            </select>
          </div>
          <div class="col">
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
});

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

function formReset() {
  // 
}

function editData(id) {
  save_method = 'update';
  $.ajax({
    url: '{{ url("product-categories") }}/'+id+'/edit',
    type: 'GET',
    dataType: 'JSON',
    success: function(data) {
      $('.modal-title').text('Edit: '+data.data.category_name);
      $('#category_name').val(data.data.category_name);
      $('#category_description').text(data.data.category_description);
      $('#modal-form').modal('show');
    },
    error: function(message) {
      alert('gagal load data');
    }
  });
}
</script>
@endsection