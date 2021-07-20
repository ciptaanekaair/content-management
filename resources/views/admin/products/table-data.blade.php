<div class="table-responsive">
  <table class="table table-striped">
    <thead>
      <tr>
        <th width="100">No</th>
        <th width="100">#</th>
        <th>Part Code</th>
        <th>Product Name</th>
        <th>Price</th>
        <th>Stock</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
    @if($products->isEmpty())
      <tr>
        <td colspan="5">
          <b><i>
            Belum ada data products, silahkan hubungi admin.
          </i></b>
        </td>
      </tr>
    @else
      @foreach($products as $index => $item)
        <tr>
          <td>
            {{ $products->firstItem() + $index }}
          </td>
          <td>{{ $item->id }}</td>
          <td>{{ $item->product_code }}</td>
          <td>{{ $item->product_name }}</td>
          <td>Rp. {{ number_format($item->product_price) }}</td>
          <td>{{ $item->product_stock }}</td>
          <td>
            @if ($item->status == 1)
              <div class="badge badge-success">active</div>
            @else
              <div class="badge badge-warning">draft</div>
            @endif
          </td>
          <td>
            <div class="btn-group">
              <a href="{{ url('products/'.$item->id.'/edit') }}" class="btn btn-sm btn-info">
                <i class="fa fa-pencil"></i>
              </a>
              <a onclick="confirmDelete({{ $item->id }})" class="btn btn-sm btn-danger">
                <i class="fa fa-trash"></i>
              </a>
            </div>
          </td>
        </tr>
      @endforeach
      <tr>
        <td colspan="5">
          <div class="text-center">
            {{ $products->links() }}
          </div>
        </td>
      </tr>
    @endif
    </tbody>
  </table>
</div>