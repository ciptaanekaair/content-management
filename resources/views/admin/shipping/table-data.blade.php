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
      @forelse($transactions as $index => $item)
        <tr>
          <td>
            {{ $transactions->firstItem() + $index }}
          </td>
          <td>{{ $item->transaction_code }}</td>
          <td align="center">{{ $item->transaction_date }}</td>
          <td align="center">{{ $item->total_item }}</td>
          <td align="center">
            <div class="badge badge-info">{{ $item->status_transaksi }}</div>
          </td>
          <td>
            @if($item->shipping_status == 99)
              <button onclick="addShipping({{ $item->id }})" class="btn btn-sm btn-primary">
                <i class="fa fa-truck"></i>
              </button>
            @else
              <button onclick="editShipping({{ $item->id }})" class="btn btn-sm btn-warning">
                <i class="fa fa-truck"></i>
              </button>
            @endif
             <!-- <button onclick="seeDetail({{ $item->id }})" class="btn btn-sm btn-primary">
                <i class="fa fa-eye"></i>
              </button> -->
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6">
            <span style="font-weight: bold;">
              <center>Belum ada data transaksi.</center>
            </span>
          </td>
        </tr>
      @endforelse
      <tr>
        <td colspan="5">
          <div class="text-center">
            {{ $transactions->links() }}
          </div>
        </td>
      </tr>
    </tbody>
  </table>
</div>