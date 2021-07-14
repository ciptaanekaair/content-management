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
          <input type="hidden" name="perpage" id="posisipage">
        </div>
      </div>
    </div>
  </div>
@endsection

@section('jq-script')
<script type="text/javascript">
var table, save_method, page, perpage, search;

$.(function() {
  $('#perpage').change(function(){

  });
});

function fetch_table(page, perpage, search) {
  perpage = $(this).val();
  search  = $('#pencarian').val();
  page    = $('#posisipage').val();

  $.ajax({
    url: '{{ url("product-categories/data") }}/?page='+page+'&list_perpage='+perpage+'&search='+searh,
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
  $.ajax({
    url: '{{ url("product-categories") }}/'+id,
    type: 'GET',
    dataType: 'JSON',
    success: function(data) {
      alert(data.category_name);
    },
    error: function(message) {
      alert('gagal load data');
    }
  });
}
</script>
@endsection