<?php

if (isset($_POST['submit'])) {
  $error = "";
  require("connect.php");
  $username = mysqli_real_escape_string($connection, $_POST['username']);
  $password = md5($_POST['password']);

  $query = "Select user_id,username,passwordHash,type_id From users Where (username='$username' OR email='$username') AND passwordHash='$password';";
  $result = mysqli_query($connection, $query);
  $user = mysqli_fetch_assoc($result);
  if ($user) {
    $_SESSION['user'] = $user;
    $_SESSION['messege']="Zalogowano pomyślnie <br> Witaj ".$user['username']."!";
    echo "<script>window.location='index.php?url=messege' </script>";
  }
  else $error = "Nie poprawny login lub hasło";
}
?>


<div class="text-center">
  <form class="form-signin" method="post">
    <img class="mb-4" src="img/logo.png" alt="" width="150">
    <h1 class="h3 mb-3 font-weight-normal">Zaloguj się!</h1>
    <label for="email" class="sr-only">Nazwa użytkownika/E-mail</label>
    <input name="username" type="text" id="username" class="form-control" placeholder="Nazwa użytkownika/E-mail" required="" autofocus="">
    <label for="password" class="sr-only">Password</label>
    <input name="password" type="password" id="password" class="form-control" placeholder="Hasło" required="">
    
      <?php
      if(!empty($error))
      echo '<p class="error">' . $error . '</p>';
      ?>
      <br>
    <button name="submit" class="btn btn-lg btn-primary btn-block" type="submit">Zaloguj się</button>
    <p class="mt-5 mb-3">Nie masz konta? <a href="index.php?url=register">Zarejestruj się</a> </p>
    <p class="mt-5 mb-3 text-muted">© 2020</p>
  </form>
</div>