<?php
include 'koneksi.php';

if (isset($_POST['kirim'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $pesan = $_POST['pesan'];

    mysqli_query($conn, "INSERT INTO kontak (nama, email, pesan)
    VALUES ('$nama','$email','$pesan')");

    echo "<script>alert('Pesan berhasil dikirim!');</script>";
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Kontak</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="css/style.css">

</head>

<body>

<div class="container py-5">

<a href="index.html" class="btn btn-dark mb-4">
⬅ Kembali ke Home
</a>

<h1 class="text-center mb-4">Contact Us</h1>

<div class="row">

<div class="col-md-6">

<form method="POST">

<input type="text" name="nama" class="form-control mb-3" placeholder="Nama" required>

<input type="email" name="email" class="form-control mb-3" placeholder="Email" required>

<textarea name="pesan" class="form-control mb-3" placeholder="Pesan" required></textarea>

<button type="submit" name="kirim" class="btn btn-dark">
Kirim
</button>

</form>

</div>

<div class="col-md-6">

<h5>Alamat</h5>

<p>JL. Letjend Pol. Soemarto, Watumas, Purwanegara,
Kec. Purwokerto Utara, Kabupaten Banyumas, Jawa Tengah 53127</p>

<h5>Instagram</h5>

<p>@CoffeeShop</p>

<h5>Telepon</h5>

<p>0882005906212</p>

</div>

</div>

</div>

</body>
</html>