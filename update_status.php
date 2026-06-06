<?php
session_start();
include 'koneksi.php';

// 🔐 proteksi admin
if (!isset($_SESSION['admin'])) {
    header("Location: login.html");
    exit;
}

// 🔥 ANTI CACHE (BIAR GA BALIK KE UPDATE LAGI)
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

// ambil id transaksi
$id = $_GET['id'] ?? null;

if(!$id){
    header("Location: admin.php");
    exit;
}

// ambil data transaksi lama
$data = mysqli_query($conn, "SELECT * FROM transaksi WHERE id_transaksi='$id'");
$d = mysqli_fetch_assoc($data);

// proses submit form
if(isset($_POST['update'])){

    $status = $_POST['status'];
    $metode = $_POST['metode'];
    $alamat = $_POST['alamat'];
    $catatan = $_POST['catatan'];

    // default kalau kosong
    if($catatan == ''){
        $catatan = 'Tidak ada catatan';
    }

    if($alamat == ''){
        $alamat = 'Ambil di tempat';
    }

    // update database
    mysqli_query($conn, "UPDATE transaksi SET 
        status='$status',
        metode_pembayaran='$metode',
        alamat_pengiriman='$alamat',
        catatan='$catatan'
        WHERE id_transaksi='$id'
    ");

    // 🔥 REDIRECT BERSIH (HILANGIN CACHE)
    header("Location: admin.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Update Transaksi</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container py-5">
<h3 class="mb-4">Update Transaksi</h3>

<form method="POST">

<label>Status</label>
<select name="status" class="form-control mb-3" required>
    <option value="pending" <?= ($d['status']=='pending')?'selected':'' ?>>Pending</option>
    <option value="diproses" <?= ($d['status']=='diproses')?'selected':'' ?>>Diproses</option>
    <option value="selesai" <?= ($d['status']=='selesai')?'selected':'' ?>>Selesai</option>
</select>

<label>Metode Pembayaran</label>
<select name="metode" class="form-control mb-3" required>
    <option value="">Pilih metode</option>
    <option value="COD" <?= ($d['metode_pembayaran']=='COD')?'selected':'' ?>>COD</option>
    <option value="Transfer" <?= ($d['metode_pembayaran']=='Transfer')?'selected':'' ?>>Transfer</option>
</select>

<label>Alamat / Pengambilan</label>
<input type="text" name="alamat" class="form-control mb-3"
value="<?= $d['alamat_pengiriman']; ?>" placeholder="Contoh: Ambil di tempat / alamat customer">

<label>Catatan</label>
<input type="text" name="catatan" class="form-control mb-3"
value="<?= $d['catatan']; ?>" placeholder="Isi jika ada catatan">

<button type="submit" name="update" class="btn btn-dark">
    Update Transaksi
</button>

<a href="admin.php" class="btn btn-secondary">
    Kembali
</a>

</form>
</div>

</body>
</html>