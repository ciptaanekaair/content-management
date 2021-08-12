@extends('layouts.dashboard-layout')

@section('header')
  <h1>Payment Method</h1>
@endsection

@section('content')
  <div class="row mb-3">
    <div class="col-12">
      <a href="{{ route('payment-methodes.create') }}" class="btn btn-success"><i class="fa fa-plus"></i> &nbsp Tambah Data</a>
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
        <div class="card-body">
          <div class="table-data">
            @include('admin.payment-code.table-data')
          </div>
          <input type="hidden" name="perpage" id="posisi_page">
        </div>
      </div>
    </div>
  </div>
@endsection

@section('formodal')
  @include('admin.payment-code.form')
  @include('admin.modal-loading')
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
  $('input[name="pencarian"]').bind('change paste', function(){
    search = $(this).val();
    perpage = $('#perpage').val();
    page    = 1;

    fetch_table(page, perpage, search);
  }); // end pencarian

  // start script delete
  $('#delete-form').on('submit', function(e) {
    e.preventDefault();

    var id         = $('#peyment_method_id_d').val();
    var total_data = "{{ $pMethod->total() }}";

    perpage = $('#perpage').val();
    search  = $('#pencarian').val();
    if (total_data <= 10) {
      page    = $('#posisi_page').val(1);
    } else {
      page = $('#posisi_page').val();
    }

    $.ajax({
      url: '{{ url("payment-methodes") }}/'+id,
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
        Swal.fire('Success!', 'Berhasil menghapus data tersebut.', 'success');
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

function fetch_table(page, perpage, search) {
  $.ajax({
    url: '{{ route("payment-methodes.data") }}?page='+page+'&list_perpage='+perpage+'&search='+search,
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

function confirmDelete(id) {
  save_method = 'delete';
  $.ajax({
    url: '{{ url("payment-methodes") }}/'+id,
    type: 'GET',
    dataType: 'JSON',
    beforeSend: function(){
      // Show image container
      $("#modal-loading").modal('show');
    },
    success: function(data) {
      $("#modal-loading").modal('hide');
      $('.modal-title-delete').text('Delete data: '+data.data.nama_pembayaran);
      $('#peyment_method_id_d').val(data.data.id);
      $('#formMethodD').val('DELETE');
      $('#payment_method_name_d').text(data.data.nama_pembayaran);
      $('#modal-delete').modal('show');
    }
  });
}
</script>
@endsection