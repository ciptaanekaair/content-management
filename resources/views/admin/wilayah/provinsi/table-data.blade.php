<div class="table-responsive">
  <table class="table table-striped">
    <thead>
      <tr>
        <th width="100">No</th>
        <th width="100">#</th>
        <th>Kode Provinsi</th>
        <th>Nama Provinsi</th>
        <th>Status</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @forelse($provinsis as $index => $item)
        <tr>
          <td>
            {{ $provinsis->firstItem() + $index }}
          </td>
          <td>{{ $item->id }}</td>
          <td>{{ $item->provinsi_code }}</td>
          <td>{{ $item->provinsi_name }}</td>
          <td>
            @if ($item->status == 1)
              <div class="badge badge-success">active</div>
            @else
              <div class="badge badge-warning">draft</div>
            @endif
          </td>
          <td>
            <div class="dropdown">
              <botton class="btn btn-primary" type="button" id="actionMenu{{ $item->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Aksi
              </botton>
              <div class="dropdown-menu" aria-labelledby="actionMenu{{ $item->id }}">
                <a onclick="editData({{ $item->id }})" class="dropdown-item" type="button"><i class="fa fa-pencil"></i>&nbsp Edit</a>
                <a onclick="confirmDelete({{ $item->id }})" class="dropdown-item" type="button"><i class="fa fa-trash"></i>&nbsp Delete</a>
              </div>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6" align="center">
            <b><i>
              Belum ada data provinsi, silahkan hubungi admin.
            </i></b>
          </td>
        </tr>
      @endforelse
      <tr>
        <td colspan="8">
          <div class="text-center">
            {{ $provinsis->links('vendor.pagination.simple-tailwind') }}
          </div>
        </td>
      </tr>
    </tbody>
  </table>
</div>