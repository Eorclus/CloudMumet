<?php
session_start();
$app = new Silex\Application();
$app['debug'] = true;
// Register the monolog logging service
$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => 'php://stderr',
));
$dbopts = parse_url(getenv('DATABASE_URL'));
$app->register(
    new Csanquer\Silex\PdoServiceProvider\Provider\PDOServiceProvider('pdo'),
    array(
        'pdo.server' => array(
            'driver'   => 'pgsql',
            'user' => $dbopts["user"],
            'password' => $dbopts["pass"],
            'host' => $dbopts["host"],
            'port' => $dbopts["port"],
            'dbname' => ltrim($dbopts["path"], '/')
        )
    )
);
$app->get('/db/', function() use($app) {
    if(isset($_POST['submit'])&&!empty($_POST['submit'])){
        $hashpassword = md5($_POST['password']);
        $uname = $_POST['name'];
        $res = $app['pdo']->prepare("select * from public.users where name = '$uname' and password ='$hashpassword'");
        $res->execute();
        $data = pg_query($res); 
        $login_check = pg_num_rows($data);
        if($login_check > 0){ 
            session_start();
            $_SESSION["loggedin"] = true;
            header("location: index.php");
        }else{
            echo "Invalid Details";
        }
    }
})
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
  
     
    <div class="form-group">
      <label>name</label>
      <input type="text" class="form-control" id="name" placeholder="Masukkan username" name="name">
    </div>
    
     
    <div class="form-group">
      <label>Password</label>
      <input type="password" class="form-control" id="password" placeholder="Masukkan password" name="password">
    </div>
     
    <input type="submit" name="login" class="btn btn-primary" value="submit">
  </form>
</div>
</body>
</html>
