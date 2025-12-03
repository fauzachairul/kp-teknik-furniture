<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Detail Stok Keluar</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .header {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="{{ $logoPath }}" alt="Logo" width="120">
        <h2>Detail Transaksi Stok Keluar</h2>
        <p><strong>No Transaksi:</strong> {{ $stockOut->stock_out_kode }} </p>
        <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($stockOut->tanggal_keluar)->format('d M Y') }}</p>
        <p><strong>Jenis Pengeluaran:</strong> {{ ucfirst($stockOut->jenis_pengeluaran) }}</p>
        @if ($stockOut->project)
            <p><strong>Proyek:</strong> {{ $stockOut->project->project_kode }} | {{ $stockOut->project->name }}</p>
        @endif
        <p><strong>Keterangan Umum:</strong> {{ $stockOut->keterangan ?? '-' }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Bahan Baku</th>
                <th>Jumlah</th>
                <th>Keterangan Item</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($stockOut->detailOuts as $detail)
                <tr>
                    <td>{{ $detail->rawMaterial->name }}</td>
                    <td>{{ $detail->jumlah }}</td>
                    <td>{{ $detail->keterangan ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
