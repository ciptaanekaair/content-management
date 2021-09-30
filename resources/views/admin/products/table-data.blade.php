<div class="table-responsive">
  <table class="table table-striped">
    <thead>
      <tr>
        <th width="100">No</th>
        <th>Part Code</th>
        <th>Product Name</th>
        <th>Price</th>
        <th>Discount</th>
        <th>Stock</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
    @if($products->isEmpty())
      <tr>
        <td colspan="8" class="text-center">
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
          <td>{{ $item->product_code }}</td>
          <td>{{ $item->product_name }}</td>
          <td>Rp. {{ number_format($item->product_price) }}</td>
          <td>
            @if(isset($item->Discount->discount))
            {{ $item->Discount->disount }}
            @else
            -
            @endif
          </td>
          <td>{{ $item->product_stock }}</td>
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
                Aksi <i class="fa fa-arrow-down"></i> 
              </botton>
              <div class="dropdown-menu" aria-labelledby="actionMenu{{ $item->id }}">
                <a onclick="seeDetail({{ $item->id }})" class="dropdown-item">
                  <i class="fa fa-eye"></i> &nbsp View
                </a>
                <a href="{{ url('products/'.$item->id.'/edit') }}" class="dropdown-item" type="button"><i class="fa fa-pencil"></i>&nbsp Edit</a>
                <a onclick="confirmDelete({{ $item->id }})" class="dropdown-item" type="button"><i class="fa fa-trash"></i>&nbsp Delete</a>
              </div>
            </div>
          </td>
        </tr>
      @endforeach
      <tr>
        <td colspan="8">
          <div class="text-center">
            {{ $products->links() }}
          </div>
        </td>
      </tr>
    @endif
    </tbody>
  </table>
</div>