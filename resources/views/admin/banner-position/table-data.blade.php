<div class="table-responsive">
  <table class="table table-striped">
    <thead>
      <tr>
        <th width="100">No</th>
        <th width="100">#</th>
        <th>Category Name</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
    @if($pCategory->isEmpty())
      <tr>
        <td colspan="5">
          <b><i>
            Belum ada data categories, silahkan hubungi admin.
          </i></b>
        </td>
      </tr>
    @else
      @foreach($pCategory as $index => $item)
        <tr>
          <td>
            {{ $pCategory->firstItem() + $index }}
          </td>
          <td>{{ $item->id }}</td>
          <td>{{ $item->category_name }}</td>
          <td>
            @if ($item->status == 1)
              <div class="badge badge-success">active</div>
            @else
              <div class="badge badge-warning">draft</div>
            @endif
          </td>
          <td>
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
      @endforeach
      <tr>
        <td colspan="5">
          <div class="text-center">
            {{ $pCategory->links() }}
          </div>
        </td>
      </tr>
    @endif
    </tbody>
  </table>
</div>