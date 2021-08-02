<div class="table-responsive">
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th width="100">No</th>
        <th width="100">#</th>
        <th>Position Name</th>
        <th>Nama Banner</th>
        <th>Gambar</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @forelse($banners as $index => $item)
        <tr>
          <td width="50">
            {{ $banners->firstItem() + $index }}
          </td>
          <td width="50">{{ $item->id }}</td>
          <td>{{ $item->position_name }}</td>
          <td>{{ $item->banner_name }}</td>
          <td>
            <a href="{{ $item->imageurl }}" data-fancybox="images" >
              <button class="btn btn-sm btn-primary">
                <i class="fa fa-eye"></i>
              </button>
            </a>
          </td>
          <td width="100">
            <div class="btn-group">
              <button onclick="editData({{ $item->id }})" class="btn btn-sm btn-info">
                <i class="fa fa-pencil"></i>
              </button>
              <button onclick="confirmDelete({{ $item->id }})" class="btn btn-sm btn-danger">
                <i class="fa fa-trash"></i>
              </button>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="5" align="center">
            <b><i>
              Belum ada data Banner, silahkan hubungi IT.
            </i></b>
          </td>
        </tr>
      @endforelse
        <tr>
          <td colspan="5">
            <div class="text-center">
              {{ $banners->links() }}
            </div>
          </td>
        </tr>
    </tbody>
  </table>
</div>