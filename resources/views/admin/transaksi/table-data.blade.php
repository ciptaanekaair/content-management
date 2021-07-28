<div class="table-responsive">
	<table class="table table-stripped table-hover table-bordered">
		<thead>
			<tr>
				<th>No</th>
				<th>ID</th>
				<th>Tanggal</th>
				<th>Jumlah Item</th>
				<th>Discount</th>
				<th>Sub Total</th>
				<th>Status</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			@forelse($transactions as $index => $item)
			<tr>
				<td>{{ $transactions->firstItem() + $index }}</td>
				<td>{{ $item->transaction_code }}</td>
				<td>{{ $item->transaction_date }}</td>
				<td>{{ $item->total_item }}</td>
				<td>{{ number_format($item->discount) }}</td>
				<td>{{ number_format($item->sub_total_price) }}</td>
				<td>
					@if($item->status == 0)
					<div class="badge badge-warning">{{ $item->status_transaksi }}</div>
					@elseif($item->status == 1)
					<div class="badge badge-info">{{ $item->status_transaksi }}</div>
					@elseif($item->status == 2)
					<div class="badge badge-warning">{{ $item->status_transaksi }}</div>
					@elseif($item->status == 3)
					<div class="badge badge-secondary">{{ $item->status_transaksi }}</div>
					@elseif($item->status == 4)
					<div class="badge badge-primary">{{ $item->status_transaksi }}</div>
					@elseif($item->status == 5)
					<div class="badge badge-success">{{ $item->status_transaksi }}</div>
					@elseif($item->status == 6)
					<div class="badge badge-danger">{{ $item->status_transaksi }}</div>
					@endif
				</td>
				<td>
					<div class="dropdown">
						<botton class="btn btn-primary" type="button" id="actionMenu{{ $item->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Aksi &nbsp&nbsp<i class="fa fa-arrow-down"></i> 
						</botton>
						<div class="dropdown-menu" aria-labelledby="actionMenu{{ $item->id }}">
							<a href="{{ route('transactions.show', $item->id) }}" class="dropdown-item" type="button">
								<i class="fa fa-eye"></i>&nbsp View Data
							</a>
							<a href="{{ route('transactions.edit', $item->id) }}" class="dropdown-item" type="button">
								<i class="fa fa-pencil"></i>&nbsp Ubah Data
							</a>
							@if(auth()->user()->hasAccess('spesial'))
							<a onclick="deleteData({{ $item->id }})" class="dropdown-item" type="button">
								<i class="fa fa-trash"></i>&nbsp Delete Data
							</a>
							@endif
						</div>
					</div>
				</td>
			</tr>
			@empty
			<tr>
				<td colspan="7" align="center">
					<code>Belum ada transaksi.</code>
				</td>
			</tr>
			@endforelse
			<tr>
				<td colspan="7">
					{{ $transactions->links() }}
				</td>
			</tr>
		</tbody>
	</table>
</div>