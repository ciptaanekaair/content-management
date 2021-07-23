<table>
	<thead>
		<tr>
			<th>No.</th>
			<th>#</th>
			<th>Nama Lengkap</th>
			<th>Username</th>
			<th>Email</th>
			<th>Verfied At</th>
			<th>Level_ID</th>
			<th>Level</th>
			<th>Status</th>
		</tr>
	</thead>
	<tbody>
		@foreach($data as $index => $item)
		<tr>
			<td>{{ $index + 1 }}</td>
			<td>{{ $item->id }}</td>
			<td>{{ $item->name }}</td>
			<td>{{ $item->username }}</td>
			<td>{{ $item->email }}</td>
			<td>{{ $item->email_verified_at }}</td>
			<td>{{ $item->level_id }}</td>
			<td>{{ $item->nama_level }}</td>
			<td>{{ $item->status == 1 ? 'Active' : 'Need Activation' }}</td>
		</tr>
		@endforeach
	</tbody>
</table>