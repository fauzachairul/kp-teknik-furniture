<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://unpkg.com/feather-icons"></script>
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
    <h1>Laporan Data Bahan Baku</h1>
    <p></p>
    <div style="margin-bottom: 10px;">
        <strong>Tanggal:</strong>
        {{ \Carbon\Carbon::parse($hariIni)->format('d-m-Y') }}
    </div>

    <div style="margin-bottom: 20px;">
        <strong>Jenis Kategori:</strong>
        {{ $categoryName }}
    </div>
    <table class="styled-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Bahan Baku</th>
                <th>Nama Bahan Baku</th>
                <th>Kategori</th>
                <th>Satuan</th>
                <th>Stock</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($rawMaterials as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->bahan_baku_kd }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->category->name }}</td>
                    <td>{{ $item->unit->name }}</td>
                    <td>{{ $item->stock }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="empty-message">Belum ada data transaksi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>



    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        feather.replace();
    </script>
</body>

</html>
