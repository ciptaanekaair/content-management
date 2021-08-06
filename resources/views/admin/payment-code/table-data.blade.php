<div class="table-responsive">
  <table class="table table-striped">
    <thead>
      <tr>
        <th width="100">No</th>
        <th width="100">Kode</th>
        <th>Payment Name</th>
        <th>Payment Name</th>
        <th>Bank</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @forelse($pMethod as $index => $item)
        <tr>
          <td>
            {{ $pMethod->firstItem() + $index }}
          </td>
          <td>{{ $item->kode_pembayaran }}</td>
          <td>{{ $item->nama_pembayaran }}</td>
          <td>{{ $item->nama_bank }}</td>
          <td>{{ $item->nomor_rekening }}</td>
          <td>{{ $item->atas_nama_rekening }}</td>
          <td>
            @if ($item->status == 1)
              <div class="badge badge-success">active</div>
            @else
              <div class="badge badge-warning">draft</div>
            @endif
          </td>
          <td>
            <div class="btn-group">
              <a href="{{ route('payment-methodes.edit', $item->id) }}" class="btn btn-sm btn-info">
                <i class="fa fa-pencil"></i>
              </a>
              <button onclick="confirmDelete({{ $item->id }})" class="btn btn-sm btn-danger">
                <i class="fa fa-trash"></i>
              </button>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="5">
            <b><i>
              Belum ada data categories, silahkan hubungi admin.
            </i></b>
          </td>
        </tr>
      @endforelse
      <tr>
        <td colspan="5">
          <div class="text-center">
            {{ $pMethod->links() }}
          </div>
        </td>
      </tr>
    </tbody>
  </table>
</div>