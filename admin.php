<?php 
session_start();
require 'logic/function.php';
$trackLocation = file_get_contents('https://ipinfo.io/json');
$getLocation = json_decode($trackLocation, true)['city'];

if (isset($_SESSION["login"])){
  header("Location: index.php");
  exit;
}
// Login
$error = false;
if(isset($_POST["login"])){
  $lusername = $_POST["username"];
  $lpassword = $_POST["password"];
  $loginresult = mysqli_query($conn, "SELECT * FROM users WHERE username = '$lusername'");
  if(mysqli_num_rows($loginresult) === 1){
    $row = mysqli_fetch_assoc($loginresult);
    if(password_verify($lpassword, $row["password"])){
      // session
      $_SESSION["login"] = ucwords($lusername);
      $_SESSION["info"] = [$row['Instansi'],$row['location'],$row["account"]];
      
      header("Location: index.php");
      exit;
    }
  }

  $error = true;
}
// Registration
if(isset($_POST["register"])){
  if(registrasi($_POST) > 0 ){
    echo "<script> alert('Successed') </script>";
  } else {
    echo mysqli_error($conn);
  }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script
      src="https://kit.fontawesome.com/64d58efce2.js"
      crossorigin="anonymous"
    ></script>
    <link rel="stylesheet" href="css/login.css" />
    <title>Sign in & Sign up Form</title>
  </head>
  <body>
    <div class="container">
      <div class="forms-container">
        <div class="signin-signup">
          <form action="#" class="sign-in-form" method="post">
            <h2 class="title">Sign in</h2>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" name="username" placeholder="Username" required/>
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" name="password" placeholder="Password" required/>
            </div>
            <input type="submit" name="login" value="Login" class="btn solid" />
            <p class="social-text">Or Sign in with social platforms</p>
            <div class="social-media">
              <a href="#" class="social-icon">
                <i class="fab fa-facebook-f"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-twitter"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-google"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-linkedin-in"></i>
              </a>
            </div>
          </form>
          <form action="#" class="sign-up-form" method="post">
            <h2 class="title">Sign up</h2>
            <input type="hidden" name="location" value="<?= $getLocation; ?>">
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" name="rusername" placeholder="Username" required/>
            </div>
            <div class="input-field">
              <i class="fas fa-envelope"></i>
              <input type="email" name="remail" placeholder="Email" required/>
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" name="rpassword" placeholder="Password" required/>
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" name="rpassword2" placeholder="Password" required/>
            </div>
            <input type="submit" name="register" class="btn" value="Sign up" />
            <p class="social-text">Or Sign up with social platforms</p>
            <div class="social-media">
              <a href="#" class="social-icon">
                <i class="fab fa-facebook-f"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-twitter"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-google"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-linkedin-in"></i>
              </a>
            </div>
          </form>
        </div>
      </div>

      <div class="panels-container">
        <div class="panel left-panel">
          <div class="content">
            <h3>New here ?</h3>
            <p>
              Get started with Personal Financial Manager and join over 2 million users who trust us with their finances.
            </p>
            <button class="btn transparent" id="sign-up-btn">
              Sign up
            </button>
          </div>
          <img src="aset/S.png" class="image" alt="" />
        </div>
        <div class="panel right-panel">
          <div class="content">
            <h3>One of us ?</h3>
            <p>
              Sign in to your account to access your financial information, manage your investments, and make payments.
            </p>
            <button class="btn transparent" id="sign-in-btn">
              Sign in
            </button>
          </div>
          <img src="aset/S.png" class="image" alt="" />
        </div>
      </div>
    </div>
    <?php if($error === true) : ?>
      <div id="popup">
        <p>Username & Password Error</p>
        <div class="progres"></div>
      </div>
    <?php endif; ?>
    <script src="logic/auth.js"></script>
  </body>
</html>

