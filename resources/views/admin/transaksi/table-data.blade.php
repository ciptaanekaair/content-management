<div class="table-responsive">
	<table class="table table-stripped">
		<thead>
			<tr>
				<th>No</th>
				<th>ID</th>
				<th>Tanggal</th>
				<th>Jumlah Item</th>
				<th>Discount</th>
				<th>Sub Total</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			@foreach($transactions as $index => $item)
			<tr>
				<td>{{ $transactions->firstItem() + $index }}</td>
				<td>{{ $item->transaction_code }}</td>
				<td>{{ $item->transaction_date }}</td>
				<td>{{ $item->total_item }}</td>
				<td>{{ number_format($item->discount) }}</td>
				<td>{{ number_format($item->sub_total_price) }}</td>
				<td>
					@if($item->status == 0)
					<div class="badge badge-warning">Unpaid</div>
					@elseif($item->status == 1)
					<div class="badge badge-info">Complete</div>
					@elseif($item->status == 2)
					<div class="badge badge-success">paid</div>
					@elseif($item->status == 3)
					<div class="badge badge-success">paid</div>
					@elseif($item->status == 5)
					<div class="badge badge-danger">Terminated</div>
					@endif

				</td>
				<td>
					<div class="dropdown">
						<botton class="btn btn-primary" type="button" id="actionMenu{{ $item->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Aksi &nbsp&nbsp<i class="fa fa-arrow-down"></i> 
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
					{{ $transactions->links() }}
				</td>
			</tr>
		</tbody>
	</table>
</div>