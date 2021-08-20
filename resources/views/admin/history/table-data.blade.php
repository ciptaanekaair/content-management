<div class="table-responsive">
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>No.</th>
        <th>Tanggal</th>
        <th>Modul Number</th>
        <th>User</th>
        <th>Aksi</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @forelse($rekamJejaks as $index => $item)
        <tr>
          <td width="50">
            {{ $rekamJejaks->firstItem() + $index }}
          </td>
          <td width="50">{{ $item->created_at->toDateString() }}</td>
          <td width="150">{{ $item->modul_code }}</td>
          <td width="150">{{ $item->user->email }}</td>
          <td width="150">{{ $item->action }}</td>
          <td width="100">
            <div class="btn-group">
              <button onclick="seeData({{ $item->id }})" class="btn btn-sm btn-primary">
                <i class="fa fa-eye"></i>
              </button>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="5" align="center">
            <b><i>
              Belum ada rekam history yang anda cari.
            </i></b>
          </td>
        </tr>
      @endforelse
        <tr>
          <td colspan="5">
            <div class="text-center">
              {{ $rekamJejaks->links() }}
            </div>
          </td>
        </tr>
    </tbody>
  </table>
</div>