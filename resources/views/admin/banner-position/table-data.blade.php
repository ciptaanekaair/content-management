<div class="table-responsive">
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th width="100">No</th>
        <th width="100">#</th>
        <th>Position Name</th>
        <th>Position Description</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @forelse($positions as $index => $item)
        <tr>
          <td width="50">
            {{ $positions->firstItem() + $index }}
          </td>
          <td width="50">{{ $item->id }}</td>
          <td width="150">{{ $item->position_name }}</td>
          <td>{{ $item->position_description }}</td>
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
              Belum ada data Posisi Banner, silahkan hubungi admin.
            </i></b>
          </td>
        </tr>
      @endforelse
        <tr>
          <td colspan="5">
            <div class="text-center">
              {{ $positions->links() }}
            </div>
          </td>
        </tr>
    </tbody>
  </table>
</div>