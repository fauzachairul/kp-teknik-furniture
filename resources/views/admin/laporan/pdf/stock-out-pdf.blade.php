<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <script src="https://unpkg.com/feather-icons"></script> --}}
    <title>View Pdf</title>

    <style>
        body {

            font-family: 'Arial', sans-serif;
        }

        .styled-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
            color: #333;
            margin-top: 20px;
        }

        .styled-table thead {
            background-color: #f0f0f0;
            border-bottom: 2px solid #ccc;
        }

        .styled-table th,
        .styled-table td {
            padding: 10px 14px;
            text-align: left;
            vertical-align: top;
            border: 1px solid #ddd;
        }

        .styled-table tbody tr:nth-child(even) {
            background-color: #fafafa;
        }

        .styled-table tbody tr:hover {
            background-color: #f1f5f9;
        }

        .capitalize {
            text-transform: capitalize;
        }

        .empty-message {
            text-align: center;
            padding: 20px;
            font-style: italic;
            color: #777;
        }

        @media print {
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .styled-table {
                font-size: 12px;
                color: #000;
            }

            .styled-table th {
                background-color: #e0e0e0 !important;
                -webkit-print-color-adjust: exact;
            }

            .styled-table tbody tr:nth-child(even) {
                background-color: #f9f9f9 !important;
                -webkit-print-color-adjust: exact;
            }

            .styled-table td,
            .styled-table th {
                border: 1px solid #888;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="{{ $logoPath }}" alt="Logo" width="200">
    </div>
    <h1>Laporan Transaksi Stok Keluar</h1>
    <div style="margin-bottom: 10px;">
        <strong>Periode:</strong>
        @if ($start_date && $end_date)
            {{ \Carbon\Carbon::parse($start_date)->format('d-m-Y') }} s/d
            {{ \Carbon\Carbon::parse($end_date)->format('d-m-Y') }}
        @elseif($start_date)
            Mulai {{ \Carbon\Carbon::parse($start_date)->format('d-m-Y') }}
        @elseif($end_date)
            Sampai {{ \Carbon\Carbon::parse($end_date)->format('d-m-Y') }}
        @else
            Semua Periode
        @endif
    </div>

    <div style="margin-bottom: 20px;">
        <strong>Jenis Pengeluaran:</strong>
        {{ $jenis_pengeluaran ? ucfirst($jenis_pengeluaran) : 'Semua Jenis' }}
    </div>
    <table class="styled-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Transaksi</th>
                <th>Tanggal</th>
                <th>Jenis</th>
                <th>Proyek</th>
                <th>Keterangan</th>
                <th>Bahan Baku & Jumlah</th>
                <th>Total Item</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($stockOuts as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->stock_out_kode }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_keluar)->format('d-m-Y') }}</td>
                    <td class="capitalize">{{ $item->jenis_pengeluaran }}</td>
                    <td>{{ $item->project->name ?? '-' }}</td>
                    <td>{{ $item->keterangan ?? '-' }}</td>
                    <td>
                        @foreach ($item->detailOuts as $detail)
                            <p>{{ $detail->rawMaterial->name }} - <strong>{{ $detail->jumlah }}</strong></p>
                        @endforeach
                    </td>
                    <td>{{ $item->detailOuts->sum('jumlah') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="empty-message">Belum ada data transaksi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>



    {{-- <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        feather.replace();
    </script> --}}
</body>

</html>
