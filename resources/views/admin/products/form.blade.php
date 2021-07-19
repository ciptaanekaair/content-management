@extends('layouts.dashboard-layout')

@section('header')
  <h1>Create Products</h1>
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
				Product Form Data
			</div>
			<div class="card-body p-0">
				
			</div>
		</div>
	</div>
</div>
@endsection