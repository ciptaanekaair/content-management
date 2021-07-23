<div class="table-responsive pt-3">
	<table class="table table-striped">
		<thead>
			<tr>
				<th>ID</th>
				<th>Gambar</th>
				<th>Aksi</th>
			</tr>
		</thead>
		<tbody>
		@if($product->id == '')
			<tr>
				<td colspan="3" align="center">
					<b><i>Tiak ada data gambar product.</i></b>
				</td>
			</tr>
		@else
			@foreach($product->productImages as $item)
			<tr>
				<td>{{ $item->id }}</td>
				<td><a href="{{ asset($item->imageurl) }}" target="_blank">{{ $item->images }}</a></td>
				<td>
					<a onclick="editImage({{ $item->id }})" class="btn btn-primary">edit</a>&nbsp
					<a onclick="deleteImage({{ $item->id }})" class="btn btn-danger">delete</a>
				</td>
			</tr>
			@endforeach
		@endif
		</tbody>
	</table>
</div>