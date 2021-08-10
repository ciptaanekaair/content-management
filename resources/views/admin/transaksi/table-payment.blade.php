@forelse($pConfirmation as $payment)
<tr>
	<td>
		{{ $payment->id }}
	</td>
	<td>
		{{ $payment->created_at->toDateString() }}
	</td>
	<td>
		{{ $payment->deskripsi == '' ? '-' : $payment->deskripsi }}
	</td>
	<td width="30">
		<a href="{{ $payment->imageurl }}" data-fancybox class="btn btn-sm btn-primary">
			<i class="fa fa-eye"></i>
		</a>
	</td>
	<td width="200">
		@if($payment->status == 0)
		<div class="badge badge-warning">Belum Diverifikasi</div>
		@elseif($payment->status == 9)
		<div class="badge badge-danger">Dibatalkan</div>
		@else
		<div class="badge badge-success">Terverifikasi</div>
		@endif
	</td>
	<td width="150">
		@if ($payment->status == 0)
		<a class="btn btn-sm btn-primary" onclick="verify({{ $payment->id }})">
			<i class="fa fa-thumbs-up"></i>
		</a>
		<a class="btn btn-sm btn-danger" onclick="terminate({{ $payment->id }})">
			<i class="fa fa-thumbs-down"></i>
		</a>
		@elseif ($payment->status == 1)
		<a class="btn btn-sm btn-warning" onclick="unverify({{ $payment->id }})">
			<i class="fa fa-minus"></i>
		</a>
		<a class="btn btn-sm btn-danger" onclick="terminate({{ $payment->id }})">
			<i class="fa fa-thumbs-down"></i>
		</a>
		@else
		-
		@endif
	</td>
</tr>
@empty
<tr>
	<td colspan="6" align="center">
		<b>Belum ada data</b>
	</td>
</tr>
@endforelse