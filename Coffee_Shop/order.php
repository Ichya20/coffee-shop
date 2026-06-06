<?php
include 'koneksi.php';
session_start();

$id_pembeli = $_SESSION['id_user'] ?? NULL;
$id_admin = 1;
$nama = $_SESSION['nama'] ?? 'Guest';

// ambil data keranjang
$data = json_decode($_GET['data'], true);

$totalAll = 0;
$pesan = "Pesanan:%0A";

// INSERT TRANSAKSI
mysqli_query($conn, "INSERT INTO transaksi 
(id_pembeli, id_admin, nama_pembeli, total_bayar, status, metode_pembayaran, alamat_pengiriman, catatan) 
VALUES 
('$id_pembeli', '$id_admin', '$nama', 0, 'pending', 'COD', '-', '-')");

$id_transaksi = mysqli_insert_id($conn);

// LOOP KERANJANG
foreach($data as $item){

    $menu = $item['nama'];
    $jumlah = (int)$item['jumlah'];
    $harga = (int)$item['harga'];
    $subtotal = $harga * $jumlah;

    $totalAll += $subtotal;

    // ambil id_menu
    $q = mysqli_query($conn, "SELECT id_menu FROM menu WHERE nama_menu='$menu'");
    $m = mysqli_fetch_assoc($q);

    if(!$m){
        continue;
    }

    $id_menu = $m['id_menu'];

    mysqli_query($conn, "INSERT INTO detail_transaksi 
    (id_transaksi, id_menu, nama_menu, jumlah, harga, subtotal)
    VALUES 
    ('$id_transaksi','$id_menu','$menu','$jumlah','$harga','$subtotal')");

    $pesan .= "- $menu ($jumlah x $harga)%0A";
}

// UPDATE TOTAL
mysqli_query($conn, "UPDATE transaksi 
SET total_bayar='$totalAll' 
WHERE id_transaksi='$id_transaksi'");

// FORMAT WA
$pesan .= "Total: Rp $totalAll";

// REDIRECT WA
$wa = "6285602305477";
header("Location: https://wa.me/$wa?text=" . urlencode($pesan));
exit;
?>