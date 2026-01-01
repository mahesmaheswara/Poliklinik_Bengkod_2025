<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Dokter</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header { text-align: center; margin-bottom: 30px; }
        .tanda-tangan { float: right; margin-top: 50px; text-align: center; width: 200px; }
    </style>
</head>
<body onload="window.print()">
    <div class="header">
        <h2>POLIKLINIK SEHAT SEJAHTERA</h2>
        <p>Jl. Semarang No. 123, Jawa Tengah</p>
        <hr>
        <h3>LAPORAN DATA DOKTER</h3>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Dokter</th>
                <th>Poli</th>
                <th>No. HP</th>
                <th>Alamat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dokters as $dokter)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $dokter->nama }}</td>
                <td>{{ $dokter->poli->nama_poli ?? '-' }}</td>
                <td>{{ $dokter->no_hp }}</td>
                <td>{{ $dokter->alamat }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="tanda-tangan">
        <p>Semarang, {{ date('d F Y') }}</p>
        <br><br><br>
        <p><strong>Admin Pengelola</strong></p>
    </div>
</body>
</html>