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
            /* background-color: #F6F5F8; */
            margin: 0;
            font-family: system-ui, sans-serif;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1.5rem;
        }

        .card {
            background-color: white;
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: relative;
            width: 100%;
        }

        .header {
            margin-bottom: 1.5rem;
        }

        .flex-between {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .title {
            font-size: 1rem;
            font-weight: bold;
            color: #2D3748;
        }

        .grid-info {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1rem;
            background-color: white;
            padding: 1.5rem;
            border-bottom: 1px solid #000;
            /* box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); */
        }

        @media (min-width: 768px) {
            .grid-info {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .label {
            font-size: 0.875rem;
            color: #718096;
        }

        .value {
            font-size: 1rem;
            color: #2D3748;
            font-weight: 600;
            text-transform: capitalize;
        }

        .value-normal {
            font-weight: normal;
        }

        .table-container {
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border: 1;
        }

        thead {
            background-color: #F7FAFC;
        }

        th,
        td {
            padding: 0.75rem 1rem;
            text-align: left;
            font-size: 0.875rem;
        }

        th {
            font-weight: 500;
            color: #262626;
            background-color: #bfbfbf
        }

        td {
            color: #2D3748;
        }

        tr {
            border: 1px solid #a0a0a0;
        }

        tr:nth-child(even) {
            background-color: #efefef;
        }

        tbody tr:hover {
            background-color: #F9FAFB;
        }

        .empty {
            text-align: center;
            padding: 1.5rem;
            font-size: 0.875rem;
            color: #A0AEC0;
        }
    </style>
</head>

<body>

    {{-- <div class="card"> --}}
    <div class="container">
        <div class="header">
            <div class="header">
                <img src="{{ $logoPath }}" alt="Logo" width="200">
            </div>
            <div class="flex-between">
                <h1 class="title">Detail Transaksi</h1>
                <h1 class="title">{{ $stockOut->stock_out_kode }}</h1>
            </div>

            <div class="grid-info">
                <div>
                    <p class="label">Tanggal Keluar:</p>
                    <p class="value">
                        {{ \Carbon\Carbon::parse($stockOut->tanggal_keluar)->format('d M Y') }}
                    </p>
                </div>
                <div>
                    <p class="label">Jenis Pengeluaran:</p>
                    <p class="value">
                        {{ $stockOut->jenis_pengeluaran }}
                    </p>
                </div>
                @if ($stockOut->project)
                    <div>
                        <p class="label">Kode Proyek:</p>
                        <p class="value" style="text-transform: uppercase;">
                            {{ $stockOut->project->project_kode }}
                        </p>
                    </div>
                    <div>
                        <p class="label">Nama Proyek:</p>
                        <p class="value">
                            {{ $stockOut->project->name }}
                        </p>
                    </div>
                @endif
                <div>
                    <p class="label">Keterangan Umum:</p>
                    <p class="value value-normal">
                        {{ $stockOut->keterangan ?? '-' }}
                    </p>
                </div>
            </div>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>Bahan Baku</th>
                        <th>Jumlah</th>
                        <th>Keterangan Item</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stockOut->detailOuts as $detail)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $detail->rawMaterial->name }}</td>
                            <td>{{ $detail->jumlah }}</td>
                            <td>{{ $detail->keterangan ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="empty">
                                Tidak ada detail bahan baku.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- </div> --}}

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        feather.replace();
    </script>
</body>

</html>
