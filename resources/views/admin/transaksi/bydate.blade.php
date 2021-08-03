<table>
    <thead>
        <tr>
            <td colspan="13" align="center">
                <h3>Laporan Transaksi</h3>
            </td>
        </tr>
        <tr>
            <th>No</th>
            <th>ID</th>
            <th>Kode Transaksi</th>
            <th>Email</th>
            <th>Nama Client</th>
            <th>Jumlah Item</th>
            <th>Total Harga Item</th>
            <th>Discount</th>
            <th>Harga Setelah Discount</th>
            <th>Pajak PPN</th>
            <th>Sub Total</th>
            <th>Tanggal Transaksi</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
    @php
        $summing = 0;
    @endphp
    @foreach($data as $index => $item)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $item->id }}</td>
            <td>{{ $item->transaction_code }}</td>
            <td>{{ $item->user->email }}</td>
            <td>{{ $item->user->name }}</td>
            <td>{{ $item->total_item }}</td>
            <td data-format="0">{{ $item->total_price }}</td>
            <td data-format="0">{{ $item->discount }}</td>
            <td data-format="0">{{ $item->price_after_discount }}</td>
            <td data-format="0">{{ $item->pajak_ppn }}</td>
            <td data-format="0">{{ $item->sub_total_price }}</td>
            <td data-format="dd/mm/yy">{{ $item->created_at }}</td>
            <td>{{ $item->status_transaksi }}</td>
        </tr>
        {{ $summing += $item->sub_total_price }}
    @endforeach
        <tr>
            <td colspan="13"></td>
        </tr>
        <tr>
            <td colspan="10" align="center">Sub Total Transaksi</td>
            <td colspan="3" align="left">{{ $summing }}</td>
        </tr>
    </tbody>
</table>