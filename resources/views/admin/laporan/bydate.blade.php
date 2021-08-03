@extends('layouts.dashboard-layout')

@section('header')
    <h1>Laporan Transaksi</h1>
@endsection

@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    Tarik Data Transaksi Harian
                </div>
                <form action="{{ route('report.harian') }}" name="form-export" id="form-export" method="POST">
                    <div class="card-body p-0">
                        @csrf
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="from_date">Laporan hari ini Tanggal:</label>
                                <input type="date" name="from_date" id="from_date" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-file-excel-o"></i> &nbsp Export
                            </button>
                    </div>
                </form>
                <input type="hidden" name="perpage" id="posisi_page">
            </div>
        </div>
    </div>
@endsection

@section('jq-script')
<script type="text/javascript">
</script>
@endsection
