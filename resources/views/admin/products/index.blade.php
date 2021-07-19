@extends('layouts.dashboard-layout')

@section('header')
  <h1>Products</h1>
@endsection

@section('content')
  <div class="row mb-3">
    <div class="col-12">
      <a href="{{ url('products/create') }}" class="btn btn-success"><i class="fa fa-plus"></i> &nbsp Tambah Data</a> &nbsp&nbsp
      <a href="{{ url('products/data-export') }}" class="btn btn-warning"><i class="fa fa-file-excel-o"></i> &nbsp Export Data</a>
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
          <input type="hidden" name="perpage" id="posisi_page">
        </div>
      </div>
    </div>
  </div>
@endsection

@section('jq-script')
<script type="text/javascript">
var table, save_method, page, perpage, search, url, data;

$(function() {
  $('#perpage').on('change', function() {
    perpage = $(this).val();
    search  = $('#pencarian').val();
    page    = $('#posisi_page').val();

    fetch_table(page, perpage, search);
  });

  // start script pencarian
  $('input[name="pencarian"]').bind('change paste keyup', function(){
    search = $(this).val();
    perpage = $('#perpage').val();
    page    = 1;

    fetch_table(page, perpage, search);
  }); // end pencarian

  // start script delete
  $('#category_delete_form').on('submit', function(e) {
    e.preventDefault();

    var id         = $('#category_id_d').val();
    var total_data = "{{ $products->total() }}";

      perpage = $('#perpage').val();
      search  = $('#pencarian').val();
    if (total_data <= 10) {
      page    = $('#posisi_page').val(1);
    } else {
      page = $('#posisi_page').val();
    }

    $.ajax({
      url: '{{ url("product-categories") }}/'+id,
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

  // paginate start
  $('body').on('click', '.flex a', function(e) {
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
    url: '{{ url("products/data?page=") }}'+page+'&list_perpage='+perpage+'&search='+search,
    type: 'GET',
    success: function(data) {
      $('.table-data').html(data);
    },
  });
}

function confirmDelete(id) {
  save_method = 'delete';
  $.ajax({
    url: '{{ url("products") }}/'+id,
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