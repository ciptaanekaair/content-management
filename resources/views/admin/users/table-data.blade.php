<div class="table-responsive">
  <table class="table table-striped">
    <thead>
      <tr>
        <th width="100">No</th>
        <th width="100">#</th>
        <th>Name</th>
        <th>Email</th>
        <th>Level</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
    @if($users->isEmpty())
      <tr>
        <td colspan="8" align="center">
          <code>
            Belum ada data pengguna, silahkan hubungi admin.
          </code>
        </td>
      </tr>
    @else
      @foreach($users as $index => $item)
        <tr>
          <td>
            {{ $users->firstItem() + $index }}
          </td>
          <td>{{ $item->id }}</td>
          <td>{{ $item->name }}</td>
          <td>{{ $item->email }}</td>
          <td>{{ $item->Level->nama_level }}
            {!! $item->company == 1 ? '<br><small>[ Perusahaan ]</small>' : '' !!}
          </td>
          <td>
            @if ($item->status == 1)
              <div class="badge badge-success">Active</div>
            @elseif($item->status == 0)
              <div class="badge badge-warning">Unactive</div>
            @endif
          </td>
          <td>
            <div class="dropdown">
              <botton class="btn btn-primary" type="button" id="actionMenu{{ $item->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Aksi
              </botton>
              <div class="dropdown-menu" aria-labelledby="actionMenu{{ $item->id }}">
                <a onclick="editData({{ $item->id }})" class="dropdown-item" type="button"><i class="fa fa-key"></i>&nbsp Ubah Data</a>
                <a onclick="editShipping({{ $item->id }})" class="dropdown-item" type="button"><i class="fa fa-home"></i>&nbsp Ubah Alamat</a>
                @if ($item->company == 1)
                <a onclick="viewData({{ $item->id }})" class="dropdown-item" type="button"><i class="fa fa-eye"></i>&nbsp Data Perusahaan</a>
                @endif
                <a onclick="confirmDelete({{ $item->id }})" class="dropdown-item" type="button"><i class="fa fa-trash"></i>&nbsp Delete Data</a>
              </div>
            </div>
          </td>
        </tr>
      @endforeach
      <tr>
        <td colspan="7">
          <div class="text-center">
            {{ $users->links('vendor.pagination.simple-tailwind') }}
          </div>
        </td>
      </tr>
    @endif
    </tbody>
  </table>
</div>