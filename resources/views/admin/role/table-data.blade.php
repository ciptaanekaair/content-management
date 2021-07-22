<div class="table-responsive">
	<table class="table table-stripped">
		<thead>
			<tr>
				<th width="20"><input type="checkbox" value="1" id="select-all"></th>
				<th width="20">No</th>
				<th>Nama Level</th>
				<th>Status</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			@foreach($roles as $index => $item)
			<tr>
				<td><input type='checkbox' name='id[]' value='{{ $item->id }}'></td>
				<td>{{ $roles->firstItem() + $index }}</td>
				<td>{{ $item->nama_role }}</td>
				<td>
					@if ($item->status == 1)
						<div class="badge badge-success">Active</div>
					@else
						<div class="badge badge-warning">Draft</div>
					@endif
				</td>
				<td>
					<div class="dropdown">
						<botton class="btn btn-sm btn-primary" type="button" id="actionMenu{{ $item->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fa fa-gear"></i> 
						</botton>
						<div class="dropdown-menu" aria-labelledby="actionMenu{{ $item->id }}">
							<a onclick="viewData({{ $item->id }})" class="dropdown-item" type="button">
								<i class="fa fa-eye"></i>&nbsp View Data
							</a>
							<a onclick="editData({{ $item->id }})" class="dropdown-item" type="button">
								<i class="fa fa-pencil"></i>&nbsp Ubah Data
							</a>
							<a onclick="deleteData({{ $item->id }})" class="dropdown-item" type="button">
								<i class="fa fa-trash"></i>&nbsp Delete Data
							</a>
						</div>
					</div>
				</td>
			</tr>
			@endforeach
			<tr>
				<td colspan="7">
					{{ $roles->links() }}
				</td>
			</tr>
		</tbody>
	</table>
</div>