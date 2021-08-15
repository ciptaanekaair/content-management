<div class="table-responsive">
  <table class="table table-striped">
    <thead>
      <tr>
        <th width="100">No</th>
        <th>No. Transaksi</th>
        <th><center>Tgl Transansaksi</center></th>
        <th><center>Jumlah Item</center></th>
        <th>Status</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @forelse($shippings as $index => $item)
        <tr>
          <td>
            {{ $shippings->firstItem() + $index }}
          </td>
          <td>{{ $item->transaction_code }}</td>
          <td align="center">{{ $item->transaction_date }}</td>
          <td align="center">{{ $item->total_item }}</td>
          <td align="center">
            <div class="badge badge-info">{{ $item->status_transaksi }}</div>
          </td>
          <td>
            @if(empty($item->shipping))
              <button onclick="editData({{ $item->id }})" class="btn btn-sm btn-primary">
                <i class="fa fa-truck"></i>
              </button>
            @elseif($item->shipping->status == 0)
              <button onclick="editData({{ $item->id }})" class="btn btn-sm btn-primary">
                <i class="fa fa-truck"></i>
              </button>
            @endif
              <button onclick="confirmDelete({{ $item->id }})" class="btn btn-sm btn-primary">
                <i class="fa fa-eye"></i>
              </button>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6">
            <span style="font-weight: bold;">
              <center>Belum ada data transaksi yang siap untuk proses pengiriman.</center>
            </span>
          </td>
        </tr>
      @endforelse
      <tr>
        <td colspan="5">
          <div class="text-center">
            {{ $shippings->links() }}
          </div>
        </td>
      </tr>
    </tbody>
  </table>
</div>