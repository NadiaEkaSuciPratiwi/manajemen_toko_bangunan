
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login Form</title>

  <!-- <link rel="stylesheet" href="login.css"> -->

</head>
<body>

  <div class="login-box">
    <h5>Masuk untuk mengelola data toko bangunan Anda</h5>
    <form action="proses_login.php" method="POST">
      <label for="username">Username atau Email:</label>
      <input type="text" id="username" name="username" required>

      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required>

      <button type="submit">Login</button>
    </form>
  </div>

</body>
</html>