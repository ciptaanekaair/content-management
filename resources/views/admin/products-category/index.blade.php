@extends('layouts.dashboard-layout')

@section('header')
  <h1>Product Categories</h1>
@endsection

@section('content')
  <div class="row mb-3">
    <div class="col-12">
      <button onclick="newData()" class="btn btn-success"><i class="fa fa-plus"></i> &nbsp Tambah Data</button> &nbsp&nbsp
      <a href="{{ route('product-categories.data.export') }}" target="_blank" class="btn btn-warning"><i class="fa fa-file-excel-o"></i> &nbsp Export Data</a>
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
var table, save_method, page, perpage, search, url, data;

$(function() {
  $('#perpage').on('change', function() {
    perpage = $(this).val();
    search  = $('#pencarian').val();
    page    = $('#posisi_page').val();

    fetch_table(page, perpage, search);
  });

  $('#category_form').on('submit', function(e){
    e.preventDefault();

    var id = $('#category_id').val();

    perpage = $('#perpage').val();
    search  = $('#pencarian').val();
    page    = $('#posisi_page').val();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    if (save_method == "update") {
      url  = "{{ url('product-categories') }}/"+id;
    }
    else {
      url = "{{ url('product-categories') }}";
    }

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
        console.log(response);
        $('#category_nameError').text(response.responseJSON.errors.category_name);
        $('#category_descriptionError').text(response.responseJSON.errors.category_description);
        $('#category_imageError').text(response.responseJSON.errors.category_image);
        $('#keywordsError').text(response.responseJSON.errors.keywords);
        $('#description_seoError').text(response.responseJSON.errors.description_seo);
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
  $('#category_delete_form').on('submit', function(e) {
    e.preventDefault();

    var id         = $('#category_id_d').val();
    var total_data = "{{ $pCategory->total() }}";

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

  $('body').on('click', '.inline-flex a', function(e) {
    e.preventDefault();

    page    = $(this).attr('href').split('page=')[1];
    search  = $('#pencarian').val();
    perpage = $('#perpage').val();

    $('#posisi_page').val(page);

    fetch_table(page, perpage, search);
   });
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
    url: '{{ route("product-catetgories.data") }}?page='+page+'&list_perpage='+perpage+'&search='+search,
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
      $('#status [value="'+data.data.status+'"]').attr('selected', 'selected');
      $('#modal-form').modal('show');
    },
    error: function(message) {
      // var error = jQuery.parseJSON(xhr.responseText);
      // for(var k in error.message){
      //   if (error.massage.hasOwnProperty(k)) {
      //     error.message[k].forEach(function(pesan) {

      //     });
      //   }
      // }
      // $('#category_nameError').text(e.data.category_name);
      // $('#statusError').text(e.data.status);
      // $('#nameError').text(response.responseJSON.errors.name);
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