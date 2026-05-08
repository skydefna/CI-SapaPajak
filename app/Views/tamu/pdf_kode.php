<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial; text-align:center; }
        .card {
            border: 2px solid #4e73df;
            padding: 20px;
            border-radius: 10px;
        }
        h2 { color: #4e73df; }
        table { width:100%; margin-top:20px; }
        td { padding:6px; text-align:left; }
    </style>
</head>
<body>

<div class="card">
    <h2>KARTU TAMU</h2>

    <table>
        <tr><td>Kode</td><td><?= $data['codeTamu'] ?></td></tr>
        <tr><td>Nama</td><td><?= $data['namaTamu'] ?></td></tr>
        <tr><td>Alamat</td><td><?= $data['alamatTamu'] ?></td></tr>
        <tr><td>Bertemu</td><td><?= $data['ditemui'] ?></td></tr>
        <tr><td>Tanggal</td><td><?= $data['tanggal'] ?></td></tr>
    </table>
</div>

</body>
</html>