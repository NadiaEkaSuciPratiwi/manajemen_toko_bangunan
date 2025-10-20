
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login Form</title>

   <link rel="stylesheet" href="login.css">
   <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

</head>
<body>

  <div class="login-box">
    <h2>Sinar Abadi</h2>
    <p>Bersama Kami, Bangunan Anda Bersinar Abadi</p>

    <?php
    if (isset($_GET['error'])) {
      echo '<div class="error-box">Username atau Password Salah!</div>';
    }
    ?>
    
    <form action="proses_login.php" method="POST">
      <label for="username">Username:</label>
      <input type="text" id="username" name="username" required> 

      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required>

      <button type="submit">Login</button>
    </form>
  </div>

</body>
</html>