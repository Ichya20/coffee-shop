<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
    <title>Login CoffeeShop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container py-5">

<h2 class="text-center mb-4">Login Admin Senja Coffee</h2>

<form action="auth.php" method="POST" class="w-50 mx-auto">

<input type="text" name="user" class="form-control mb-3" placeholder="Username" required>

<input type="password" name="pass" class="form-control mb-3" placeholder="Password" required>

<button class="btn btn-dark w-100">Login</button>

<a href="index.html" class="btn btn-secondary w-100">
    ← Kembali ke Beranda
</a>

</form>

</div>

</body>
</html>