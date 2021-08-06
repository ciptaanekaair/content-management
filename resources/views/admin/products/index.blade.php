@extends('layouts.dashboard-layout')

@section('header')
  <h1>Products</h1>
@endsection

@section('content')
  <div class="row mb-3">
    <div class="col-12">
      <a href="{{ url('products/create') }}" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> &nbsp Tambah Data</a> &nbsp&nbsp
      <a onclick="refresh()" class="btn btn-sm btn-success"><i class="fa fa-refresh"></i> &nbsp Refresh</a> &nbsp&nbsp
      <a href="{{ route('product.data.export') }}" target="_blank" class="btn btn-sm btn-warning"><i class="fa fa-file-excel-o"></i> &nbsp Export Data</a>
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
        <div class="card-body p-0">
          <div class="table-data">
            @include('admin.products.table-data')
          </div>
          <input type="hidden" name="posisi_page" id="posisi_page" value="1">
        </div>
      </div>
    </div>
  </div>
@endsection

@section('formodal')
 @include('admin.products.modal-form')
 @include('admin.modal-loading')
@endsection

@section('jq-script')
<script type="text/javascript">
var table, save_method, page, perpage, search, url, data;

$(function() {
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

  // start script pencarian
  $('input[name="pencarian"]').bind('change paste', function(){
    search = $(this).val();
    perpage = $('#perpage').val();
    page    = 1;

    fetch_table(page, perpage, search);
  }); // end pencarian

  // start script delete
  $('#form_product_delete').on('submit', function(e) {
    e.preventDefault();

    var id         = $('#product_id').val();
    var total_data = "{{ $products->total() }}";

    perpage = $('#perpage').val();
    search  = $('#pencarian').val();

    if (total_data <= 10) page = 1;
    else page = $('#posisi_page').val();

    $.ajax({
      url: '{{ url("products") }}/'+id,
      type: 'POST',
      data: $(this).serialize(),
      beforeSend: function(){
        // Show image container
        $("#modal-loading").modal('show');
      },
      success: function(data) {
        fetch_table(page, perpage, search);
        $('#modal-delete').modal('hide');
        formDeleteReset();
        Swal.fire(
          'Success!',
          'Berhasil menghapus data tersebut.'+total_data,
          'success'
        );
      },
      complete: function(data) {
        // Hide image container
        $("#modal-loading").modal('hide');
      }
    });
  }); // end script delete

  // paginate start
  $('body').on('click', '.inline-flex a', function(e) {
    e.preventDefault();

    page    = $(this).attr('href').split('page=')[1];
    search  = $('#pencarian').val();
    perpage = $('#perpage').val();

    $('#posisi_page').val(page);

    fetch_table(page, perpage, search);
   }); // end script paginate
});

function cariData(data) {
  perpage = $('#perpage').val();
  
  fetch_table(1, perpage, data);
}

function refresh() {
  perpage = $('#perpage').val();
  search  = $('#pencarian').val();
  page    = $('#posisi_page').val();

  fetch_table(page, perpage, search);
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
  $.ajax({
    url: '{{ route("product.data") }}?page='+page+'&list_perpage='+perpage+'&search='+search,
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

function formDeleteReset() {
  $('.modal-title-delete').text('');
  $('#product_id').val('');
  $('#modalProductName').text('');
}

function seeDetail(id) {
  $.ajax({
    url: '{{ url("products/detail") }}/'+id,
    type: 'GET',
    dataType: 'JSON',
    beforeSend: function(){
      // Show image container
      $("#modal-loading").modal('show');
    },
    success: function(data) {
      $('#detail-title').text('Data Product: '+data.data.product_name);
      $('#product_name_text').text(data.data.product_name);
      $('#product_code_text').text(data.data.product_code);
      $('#product_price_text').text('Rp. '+data.data.price);
      $('#product_stock_text').text(data.data.product_stock);
      $('#product_terjual_text').text(data.data.qty_terjual);
      $('#modal-detail').modal('show');
    },
    complete: function(data) {
      // Hide image container
      $("#modal-loading").modal('hide');
    }
  });
}

function confirmDelete(id) {
  save_method = 'delete';
  $.ajax({
    url: '{{ url("products") }}/'+id,
    type: 'GET',
    dataType: 'JSON',
    beforeSend: function(){
      // Show image container
      $("#modal-loading").modal('show');
    },
    success: function(data) {
      $('.modal-title-delete').text('Delete data: '+data.data.product_name);
      $('#product_id').val(data.data.id);
      $('#formMethodD').val('DELETE');
      $('#modalProductName').text(data.data.product_name);
      $('#modal-delete').modal('show');
    },
    complete: function(data) {
      // Hide image container
      $("#modal-loading").modal('hide');
    }
  });
}
</script>
@endsection