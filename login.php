<?php
    session_start();
    include('config.php');
    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $query = $connection->prepare("SELECT * FROM users WHERE username=:username");
        $query->bindParam("username", $username, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
            echo '<p class="error">Username password combination is wrong!</p>';
        } else {
            if (password_verify($password, $result['password'])) {
                $_SESSION['user_id'] = $result['id'];
                header("location: index.php");
            } else {
                echo '<p class="error">Username password combination is wrong!</p>';
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Login</title>
  <meta name="keywords" content="PHP,PostgreSQL,Insert,Login">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
  <h2>Login</h2>
  <form method="post">
  
     
    <div class="form-group" action="">
      <label>Username</label>
      <input type="text" class="form-control" id="username" placeholder="Masukkan username" name="username">
    </div>
    
     
    <div class="form-group">
      <label>Password</label>
      <input type="password" class="form-control" id="password" placeholder="Masukkan password" name="pasword">
    </div>
     
    <input type="submit" name="login" class="btn btn-primary" value="login">
  </form>
</div>
</body>
</html>
