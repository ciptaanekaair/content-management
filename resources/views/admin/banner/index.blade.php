@extends('layouts.dashboard-layout')

@section('header')
    <h1>Manage Banner</h1>
@endsection

@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <button onclick="newData()" class="btn btn-success"><i class="fa fa-plus"></i> &nbsp Tambah Data</button>
            <button onclick="refresh()" class="btn btn-primary">
                <i class="fa fa-refresh"></i> &nbsp Refresh
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
                                    <input type="text" name="pencarian" onchange="cariData($(this).val())" 
                                    class="form-control" id="pencarian" placeholder="Search">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-data">
                    </div>
                    <input type="hidden" name="perpage" id="posisi_page">
                </div>
            </div>
        </div>
    </div>
@endsection

@section('formodal')
    @include('admin.banner.form')
    @include('admin.modal-loading')
@endsection

@section('jq-script')
    <script type="text/javascript">
        var table, save_method, page, perpage, search, url, data;

        fetch_table(1, 10, '');

        $(function() {
            $('#perpage').on('change', function() {
                perpage = $(this).val();
                search  = $('#pencarian').val();
                page    = $('#posisi_page').val();

                fetch_table(page, perpage, search);
            });

            $('#banner_form').on('submit', function(e){
                e.preventDefault();

                var id = $('#banner_id').val();

                perpage = $('#perpage').val();
                search  = $('#pencarian').val();
                page    = $('#posisi_page').val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                if (save_method == "update") {
                    url  = "{{ url('banners') }}/"+id;
                }
                else {
                    url = "{{ url('banners') }}";
                }

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
                        formReset();
                        $('#modal-form').modal('hide');
                        Swal.fire(
                            'Success!',
                            data.message,
                            'success'
                        );
                        fetch_table(page, perpage, search);
                    }, error: function(response) {
                        $('#banner_nameError').text(response.responseJSON.errors.category_name);
                        $('#banner_imageError').text(response.responseJSON.errors.banner_image);
                    },
                    complete: function(data) {
                        // Hide image container
                        $("#modal-loading").modal('hide');
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
            $('#position_delete_form').on('submit', function(e) {
                e.preventDefault();

                var id         = $('#banner_id_d').val();
                var total_data = "{{ $banners->total() }}";

                perpage = $('#perpage').val();
                search  = $('#pencarian').val();
                if (total_data <= 10) {
                    page    = $('#posisi_page').val(1);
                } else {
                    page = $('#posisi_page').val();
                }

                $.ajax({
                    url: '{{ url("banners") }}/'+id,
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
                            'Berhasil menghapus data tersebut.',
                            'success'
                        );
                    },
                    complete: function(data) {
                        // Hide image container
                        $("#modal-loading").modal('hide');
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

        function refresh() {
            page    = $('#posisi_page').val();
            search  = $('#pencarian').val();
            perpage = $('#perpage').val();

            fetch_table(page, perpage, search);
        }

        function newData() {
            save_method = 'create';
            formReset();
            $('.modal-title').text('Tambah data baru');
            $('#formMethod').val('POST');
            $('#imagenya').remove();
            $('#modal-form').modal('show');
        }

        function fetch_table(page, perpage, search) {
            $.ajax({
                url: '{{ route("banners.data") }}?page='+page+'&list_perpage='+perpage+'&search='+search,
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
            $('#modal-delete form')[0].reset();
        }

        function formReset() {
            $('#banner_position_id').prop('selectedIndex',0);
            $('#modal-form form')[0].reset();
        }

        function editData(id) {
            save_method = 'update';
            $.ajax({
                url: '{{ url("banners") }}/'+id+'/edit',
                type: 'GET',
                dataType: 'JSON',
                beforeSend: function(){
                    // Show image container
                    $("#modal-loading").modal('show');
                },
                success: function(data) {
                    $('.modal-title').text('Edit: '+data.data.banner_name);
                    $('#banner_id').val(data.data.id);
                    $('#formMethod').val('PUT');
                    $('#banner_name').val(data.data.banner_name);
                    $('#banner_position_id [value="'+data.data.banner_position_id+'"]').attr('selected', 'selected');
                    $('#btnSave').text('Update Data');
                    $('#lihat-image').html('<a href="'+data.data.imageurl+'" id="imagenya" data-fancybox><i class="fa fa-eye"></i> lihat gambar</a>');
                    $('#modal-form').modal('show');
                },
                error: function(response) {
                    Swal.fire('Error!', response.responseJSON.errors.message);
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
                url: '{{ url("banners") }}/'+id,
                type: 'GET',
                dataType: 'JSON',
                beforeSend: function(){
                    // Show image container
                    $("#modal-loading").modal('show');
                },
                success: function(data) {
                    $('.modal-title-delete').text('Delete data: '+data.data.banner_name);
                    $('#banner_id_d').val(data.data.id);
                    $('#formMethodD').val('DELETE');
                    $('#banner_name_d').text(data.data.banner_name);
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
