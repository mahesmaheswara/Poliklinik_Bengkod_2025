<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Pasien</title>
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
        <h3>LAPORAN DATA PASIEN</h3>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No RM</th>
                <th>Nama Pasien</th>
                <th>No. KTP</th>
                <th>Alamat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pasiens as $pasien)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $pasien->no_rm }}</td>
                <td>{{ $pasien->nama }}</td>
                <td>{{ $pasien->no_ktp }}</td>
                <td>{{ $pasien->alamat }}</td>
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