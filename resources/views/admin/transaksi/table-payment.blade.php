@forelse($pConfirmation as $item)
<tr>
	<td>
		{{ $item->created_at->toDateString() }}
	</td>
	<td>
		{{ $item->deskripsi == '' ? '-' : $item->deskripsi }}
	</td>
	<td width="30">
		<a href="{{ $item->imageurl }}" data-fancybox class="btn btn-sm btn-primary">
			<i class="fa fa-eye"></i>
		</a>
	</td>
	<td width="200">
		@if($item->status == 0)
		<div class="badge badge-warning">Belum Diverifikasi</div>
		@elseif($item->status == 9)
		<div class="badge badge-danger">Dibatalkan</div>
		@else
		<div class="badge badge-success">Terverifikasi</div>
		@endif
	</td>
	<td width="150">
		@if ($item->status == 0)
		<button class="btn btn-sm btn-primary" onclick="verify({{ $item->id }})">
			<i class="fa fa-thumbs-up"></i>
		</button>
		<button class="btn btn-sm btn-danger" onclick="terminate({{ $item->id }})">
			<i class="fa fa-thumbs-down"></i>
		</button>
		@elseif ($item->status == 1)
		<button class="btn btn-sm btn-warning" onclick="unverify({{ $item->id }})">
			<i class="fa fa-minus"></i>
		</button>
		<button class="btn btn-sm btn-danger" onclick="terminate({{ $item->id }})">
			<i class="fa fa-thumbs-down"></i>
		</button>
		@else
		-
		@endif
	</td>
</tr>
@empty
<tr>
	<td colspan="5" align="center">
		<b>Belum ada data</b>
	</td>
</tr>
@endforelse