<div class="table-responsive">
  <table class="table table-striped">
    <thead>
      <tr>
        <th width="100">No</th>
        <th>No. Transaksi</th>
        <th>Tgl Transansaksi</th>
        <th>Jumlah Item</th>
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
          <td>{{ $item->transaction_date }}</td>
          <td>{{ $item->total_item }}</td>
          <td>
            @if ($item->status == 1)
              <div class="badge badge-success">active</div>
            @else
              <div class="badge badge-warning">draft</div>
            @endif
          </td>
          <td>
              <button onclick="editData({{ $item->id }})" class="btn btn-sm btn-primary">
                <i class="fa fa-pencil"></i>
              </button>
              <button onclick="confirmDelete({{ $item->id }})" class="btn btn-sm btn-danger">
                <i class="fa fa-trash"></i>
              </button>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6">
            <span style="font-weight: bold; text-align: center;">
              Belum ada data transaksi yang siap untuk proses pengiriman.
            </span>
          </td>
        </tr>
      @endforelse
      <tr>
        <td colspan="5">
          <div class="text-center">
            {{ $pCategory->links() }}
          </div>
        </td>
      </tr>
    </tbody>
  </table>
</div>