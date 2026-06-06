<?php
session_start();

// 🔥 ANTI CACHE (PENTING BANGET)
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

include 'koneksi.php';

// 🔐 Proteksi admin
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Admin Transaksi</title>

<style>
body { font-family: Arial; margin: 30px; background:#f8f9fa;}
.container { background:white; padding:20px; border-radius:10px;}
table { width:100%; border-collapse:collapse; margin-top:20px;}
th, td { padding:10px; border:1px solid #ddd; text-align:center;}
th { background:#6F4E37; color:white;}
.btn { padding:5px 10px; border-radius:5px; text-decoration:none; color:white; }
.proses { background:orange; }
.selesai { background:green; }
.detail { color:blue; text-decoration:none; }
</style>

</head>
<body>

<a href="logout.php" style="
background:red;
color:white;
padding:8px 12px;
text-decoration:none;
border-radius:5px;
float:right;
">Logout</a>

<div class="container">
<h2>Data Transaksi Senja Coffee</h2>

<?php
// 🔥 MODE DETAIL
if(isset($_GET['detail'])){
    $id = $_GET['detail'];

    echo "<h3>Detail Transaksi #$id</h3>";

    $d = mysqli_query($conn, "SELECT * FROM detail_transaksi WHERE id_transaksi='$id'");

    echo "<table>
    <tr>
        <th>Menu</th>
        <th>Jumlah</th>
        <th>Harga</th>
        <th>Subtotal</th>
    </tr>";

    while($row = mysqli_fetch_assoc($d)){
        echo "<tr>
        <td>{$row['nama_menu']}</td>
        <td>{$row['jumlah']}</td>
        <td>Rp ".number_format($row['harga'],0,',','.')."</td>
        <td>Rp ".number_format($row['subtotal'],0,',','.')."</td>
        </tr>";
    }

    echo "</table>";

    echo "<br><br>
    <a href='admin.php' style='
        background:#333;
        color:white;
        padding:8px 12px;
        text-decoration:none;
        border-radius:5px;
    '>
    ← Kembali ke Beranda
    </a>";

} else {
?>

<table>
<tr>
    <th>ID</th>
    <th>Pembeli</th>
    <th>Total</th>
    <th>Status</th>
    <th>Metode</th>
    <th>Alamat</th>
    <th>Catatan</th>
    <th>Detail</th>
    <th>Aksi</th>
</tr>

<?php
$q = mysqli_query($conn, "SELECT * FROM transaksi ORDER BY id_transaksi DESC");

while($t = mysqli_fetch_assoc($q)){
?>
<tr>

<td>#<?= $t['id_transaksi'] ?></td>

<td>
<?= isset($t['id_pembeli']) && $t['id_pembeli'] != 0 
    ? 'User #'.$t['id_pembeli'] 
    : 'Guest' ?>
</td>

<td>Rp <?= number_format($t['total_bayar'],0,',','.') ?></td>

<td><?= $t['status'] ?></td>

<td><?= $t['metode_pembayaran'] ?></td>

<td><?= $t['alamat_pengiriman'] ?></td>

<td><?= $t['catatan'] ?></td>

<td>
<a class="detail" href="?detail=<?= $t['id_transaksi'] ?>">Lihat</a>
</td>

<td>
<a class="btn proses" href="update_status.php?id=<?= $t['id_transaksi'] ?>">
    Update
</a>
</td>

</tr>
<?php } ?>
</table>

<?php } ?>

</div>

</body>
</html>