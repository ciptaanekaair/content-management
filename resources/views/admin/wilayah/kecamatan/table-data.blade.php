<div class="table-responsive">
  <table class="table table-striped">
    <thead>
      <tr>
        <th width="100">No</th>
        <th width="100">#</th>
        <th>Nama Kecamatan</th>
        <th>Kota</th>
        <th>Status</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @forelse($kecamatans as $index => $item)
        <tr>
          <td>
            {{ $kecamatans->firstItem() + $index }}
          </td>
          <td>{{ $item->id }}</td>
          <td>{{ $item->nama_kecamatan }}</td>
          <td>{{ $item->kota->nama_kota }}</td>
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
                Aksi &nbsp&nbsp<i class="fa fa-arrow-down"></i> 
              </botton>
              <div class="dropdown-menu" aria-labelledby="actionMenu{{ $item->id }}">
                <a onclick="editData({{ $item->id }})" class="dropdown-item" type="button"><i class="fa fa-pencil"></i>&nbsp Edit</a>
                <a onclick="confirmDelete({{ $item->id }})" class="dropdown-item" type="button"><i class="fa fa-trash"></i>&nbsp Delete Data</a>
              </div>
            </div>
          </td>
        </tr>
      @empty
      <tr>
        <td colspan="6" align="center">
          <b><i>
            Belum ada data kecamatan, silahkan hubungi admin.
          </i></b>
        </td>
      </tr>   
      @endforelse
      <tr>
        <td colspan="8">
          <div class="text-center">
            {{ $kecamatans->links('vendor.pagination.simple-tailwind') }}
          </div>
        </td>
      </tr>
    </tbody>
  </table>
</div>