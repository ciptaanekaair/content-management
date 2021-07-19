@extends('layouts.dashboard-layout')

@section('header')
  <h1>Create Products</h1>
@endsection

@section('content')
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<ul class="nav nav-tabs" id="myTab" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" id="form-tab" data-toggle="tab" href="#formTab" role="tab" aria-controls="form" aria-selected="true">Form Data</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="image-tab" data-toggle="tab" href="#tabImage" role="tab" aria-controls="Image" aria-selected="false" aria-disabled="true">Product Images</a>
					</li>
				</ul>
				<div class="tab-content tab-bordered" id="tabContent">
					<div class="tab-pane fade show active" id="formTab" role="tabpanel" aria-labelledby="form-tab">
					<form method="POST" id="product-form" enctype="multipart/form-data">
						<input type="hidden" name="product_id" id="product_id" value="{{ old('product_id', $product->id) }}">
						<input type="hidden" name="_method" id="formMethod">
						<div class="row">
							<div class="col-12 pt-4">
								<div class="form-group">
									<label for="category_product_id">Kategory Product</label>
									<select name="category_product_id" id="category_product_id" class="form-control">
										<option value="kategori" selected>Pilih Kategori Product</option>
										@foreach($pCategory as $item)
											<option value="{{ $item->id }}" {{ $item->id == $product->category_product_id ? 'selected' : '' }}>{{ $item->category_name }}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-md-12 col-lg-6">
								<div class="form-group">
									<label for="product_code">Part Code *</label>
									<input type="text" name="product_code" class="form-control" placeholder="Kode Part" value="{{ old('product_code', $product->product_code) }}">
									<div class="alert-message">
										<code id="product_codeError"></code>
									</div>
								</div>
							</div>
							<div class="col-md-12 col-lg-6">
								<div class="form-group">
									<label for="product_name">Product Name *</label>
									<input type="text" name="product_name" class="form-control" placeholder="Nama Product" value="{{ old('product_name', $product->product_name) }}">
									<div class="alert-message">
										<code id="product_nameError"></code>
									</div>
								</div>
							</div>
							<div class="col-12">
								<div class="form-group">
									<label for="product_description">Deskripsi Product *</label>
									<textarea name="product_description" cols="30" rows="10" id="product_description" id="summernote" placeholder="Deskripsi Product">
										{{ old('product_description', $product->product_description) }}
									</textarea>
								</div>
							</div>
							<div class="col-md-12 col-lg-6">
								<div class="form-group">
									<label for="product_price">Harga Product *</label>
									<input type="text" name="product_price" id="product_price" class="form-control" value="{{ old('product_price', $product->product_price) }}" placeholder="Harga jual Product">
									<div class="alert-massage">
										<code id="product_priceError"></code>
									</div>
								</div>
							</div>
							<div class="col-md-12 col-lg-6">
								<div class="form-group">
									<label for="product_stock">Stock Product *</label>
									<input type="text" name="product_stock" id="product_stock" class="form-control" value="{{ old('product_stock', $product->product_stock) }}" placeholder="Stok Product">
									<div class="alert-massage">
										<code id="product_stockError"></code>
									</div>
								</div>
							</div>
							<div class="col-md-12 col-lg-6">
								<div class="form-group">
									<label for="keywords">Keywords</label>
									<input type="text" name="keywords" id="keywords" class="form-control" value="{{ old('keywords', $product->keywords) }}" placeholder="Keywords untuk SEO">
									<div class="alert-massage">
										<code id="keywordsError"></code>
									</div>
								</div>
							</div>
							<div class="col-md-12 col-lg-6">
								<div class="form-group">
									<label for="description_seo">Description SEO</label>
									<input type="text" name="description_seo" id="description_seo" class="form-control" value="{{ old('description_seo', $product->description_seo) }}" placeholder="Deskripsi untuk SEO">
									<div class="alert-massage">
										<code id="description_seoError"></code>
									</div>
								</div>
							</div>
							<div class="col-md-12 col-lg-6">
								<div class="form-group">
									<label for="product_commision">Commision</label>
									<input type="text" name="product_commision" id="product_commision" class="form-control" value="{{ old('product_commision', $product->product_commision) }}" placeholder="Komisi. (Tidak wajib di isi)">
									<div class="alert-massage">
										<code id="product_commisionError"></code>
									</div>
								</div>
							</div>
							<div class="col-md-12 col-lg-6">
								<div class="form-group">
									<label for="status">Status Product</label>
									<select name="status" id="status" class="form-control">
										<option value="Pilih Status Product" {{ $product->status = '' ? 'active' : '' }}>Pilih Status Product</option>
										<option value="0" {{ $product->status == 0 ? 'selected' : '' }}>Draft</option>
										<option value="1" {{ $product->status == 1 ? 'selected' : '' }}>Active / Publish</option>
									</select>
									<div class="alert-massage">
										<code id="statusError"></code>
									</div>
								</div>
							</div>
							<div class="col-md-12 col-lg-6">
								<div class="form-group">
									<label for="product_image">Gambar Utama Product</label>
									<input type="file" name="product_image" id="product_image" class="form-control" value="{{ old('product_image', $product->product_image) }}" placeholder="Komisi. (Tidak wajib di isi)">
									<div class="alert-massage">
										<code id="product_commisionError"></code>
									</div>
								</div>
							</div>
							<div class="col-12">
								<a href="{{ url('products') }}" class="btn btn-secondary"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
								<div class="float-right">
									<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
								</div>
							</div>	
						</div>
					</form>
					</div>
					<div class="tab-pane fade" id="tabImage" role="tabpanel" aria-labelledby="tab-image" aria-disabled="true">
						<a onclick="newData()" class="btn btn-success">
							<i class="fa fa-plus"></i> Upload Image
						</a>
						<div class="table-image">
							@include('admin.products.table-image')
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('formodal')
  @include('admin.products.modal-form')
@endsection

@section('jq-script')

<script type="text/javascript">
var save_method, url;

$(document).ready(function() {
	$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
	CKEDITOR.replace('product_description');

	$('#formImage').on('submit', function(e){
    e.preventDefault();

		var id = $('#product_images_id').val();

		if (save_method == 'update') url = '{{ url("products/images") }}/'+id;
		else url = '{{ url("products/images") }}';

		$.ajax({
			url: url,
			type: 'POST',
      data: new FormData($('#modal-form form')[0]),
      contentType: false,
      processData: false,
      success: function(data) {
      	$('#images').val('');
      	Swal.fire(
      		'Success!',
      		'Berhasil upload data baru',
      	);
      }, error: function(response) {
      	Swal.fire('Error!', response.message, 'error');
      	$('#product_id_iError').text(response.responseJSON.errors.product_id_i);
      	$('#images_id').text(response.responseJSON.errors.images_id);
      	$('#imagesError').text(response.responseJSON.errors.images);
      }
		});
	});
});

function newData() {
	if ($('#product_id').val() == '') {
		Swal.fire(
			'Error!',
			'Anda harus menyimpan data product terlebih dahulu, atau anda dapat mengedit data product.',
			'error'
		);
	}
	else {
		save_method = 'add';
		$('#formMethod').val('POST');
		$('#modal-form').modal('show');
	}
}

function simpanGambar() {
	alert('simpan gambar');
}

function fetch_image() {
	$.ajax({
		url: '{{ url("products/") }}/'+id+'/get-image',
		type: 'GET',
		success: function(data) {
			// 
		}, error: function(data) {
			// 
		}
	});
}

</script>

@endsection