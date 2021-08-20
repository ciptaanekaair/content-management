@extends('layouts.dashboard-layout')

@section('header')
    <h1>User History</h1>
@endsection

@section('content')
    <div class="row mb-3">
        <div class="col-12">
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
                                    <input type="text" name="pencarian" class="form-control" id="pencarian" onchange="search($(this).val())" placeholder="Search">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-data">
                    </div>
                    <input type="hidden" name="perpage" id="posisi_page" value="1">
                </div>
            </div>
        </div>
    </div>
@endsection

@section('formodal')
    @include('admin.history.modal')
@endsection

@section('jq-script')
<script type="text/javascript">
var page, perpage, search, url;

$(function() {
    fetch_table(1, $('#perpage').val(), '');

    $('#perpage').on('change', function(e) {
        e.preventDefault();
        perpage = $(this).val();
        page    = $('#posisi_page').val();
        search  = $('input[name="pencarian"]').val();

        fetch_table(page, perpage, search);
    })

    $('#pencarian').on('submit', function(e) {
        e.preventDefault();

        perpage = $('#perpage').val();
        page    = $('#posisi_page').val();
        search  = $(this).val();

        fetch_table(page, perpage, search);
    })

    // paginate start
    $('body').on('click', '.inline-flex a', function(e) {
        e.preventDefault();

        page    = $(this).attr('href').split('page=')[1];
        search  = $('#pencarian').val();
        perpage = $('#perpage').val();

        $('#posisi_page').val(page);

        fetch_table(page, perpage, search);
    }); // end script paginate
})

function seeData(id) {
    $.get({
        url: '{{ url("user-histories") }}/'+id,
        dataType: 'JSON'
    })
    .done(data => {
        $('#recorded_email').text(data.data.user.email);
        $('#recorded_module_code').text(data.data.modul_code);
        $('#recorded_action').text(data.data.action);
        $('#recorded_detail').text(data.data.description);
        $('#modal-history').modal('show');
    })
    .fail(response => {
        console.log(response);
    })
}

function refresh() {
    $('#perpage[value="10"]').prop('selected', 'selected');
    $('#posisi_page').val('');
    $('#search').val('');

    fetch_table(1, 10, '');
}

function search(search) {
    perpage = $('#perpage').val();
    page    = $('#posisi_page').val();

    fetch_table(page, perpage, search);
}

function fetch_table(page, perpage, search) {
    $.ajax({
        url: '{{ route("user-histories.data") }}?page='+page+'&list_perpage='+perpage+'&search='+search,
        type: 'GET',
        success: function(data) {
            $('.table-data').html(data);
        },
        error: function (response) {
            console.log(response);
        }
    })
}

</script>
@endsection