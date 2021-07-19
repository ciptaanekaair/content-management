<div class="table-responsive">
	<table class="table table-striped">
		<thead>
			<tr>
				<th>No.</th>
				<th>Gambar</th>
				<th>Aksi</th>
			</tr>
		</thead>
		<tbody>
			@if($product->id == '')
			<tr>
				<td colspan="3" align="center">
					<b><i>Anda harus menyimpan data produk terlebih dahulu.</i></b>
				</td>
			</tr>
			@else
				@foreach($images as $key => $item)
				<tr>
					<td>{{ $images->firstItem() + $key }}</td>
					<td><a href="{{ asset($item->imageurl) }}" target="_blank">{{ $item->images }}</a></td>
					<td>
						<a onclick="editImage({{ $item->id }})" class="btn btn-primary"><i class="fa fa-pencil"></i> Edit</a>
					</td>
				</tr>
				@endforeach
			@endif
		</tbody>
	</table>
</div>