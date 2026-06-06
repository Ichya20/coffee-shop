```php
<?php
session_start();
include 'koneksi.php'; 

// ambil data form
$user = $_POST['user'];
$pass = $_POST['pass'];

// query user
$query = mysqli_query($conn, "SELECT * FROM users WHERE username='$user' AND password='$pass'");
$data = mysqli_fetch_assoc($query);
$cek = mysqli_num_rows($query);

if($cek > 0){

    // 🔥 SET SESSION LENGKAP (INI YANG PENTING)
    $_SESSION['admin'] = true;
    $_SESSION['id_user'] = $data['id_user'];
    $_SESSION['nama'] = $data['username'];

    // redirect ke admin
    header("Location: admin.php");
    exit;

} else {
    echo "<script>alert('Login Gagal! Username atau Password salah.'); window.location='login.html';</script>";
}
?>
```
