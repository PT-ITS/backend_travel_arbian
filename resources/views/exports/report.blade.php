<table>
    <thead>
        <tr>
            <th>Produk</th>
            <th>Status</th>
            <th>Total Harga</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transactions as $trx)
            <tr>
                <td>{{ $trx->product->name_product ?? '-' }}</td>
                <td>{{ $trx->status == 1 ? 'Penjualan' : 'Pembelian' }}</td>
                <td>{{ $trx->total_price }}</td>
                <td>{{ $trx->created_at->format('Y-m-d') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
