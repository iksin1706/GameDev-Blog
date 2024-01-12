<?php
$_SESSION['registerErrors'] = [];
if (isset($_POST['submitBtn'])) {
  require("connect.php");
  require("helpers.php");

  $username = mysqli_real_escape_string($connection, $_POST['username']);
  $email = mysqli_real_escape_string($connection, $_POST['email']);
  $password = mysqli_real_escape_string($connection, $_POST['password']);
  $secondPassword = mysqli_real_escape_string($connection, $_POST['secondPassword']);
  $passwordHash = $_POST['password'];

  $errors = [];
  if (empty($username)) $errors[] = "Nazwa użytkownika jest wymagana";
  if (empty($email)) $errors[] = "E-mail jest wymagany";
  if (empty($password)) $errors[] = "Hasło jest wymagane";
  if ($password != $secondPassword) $errors[] = "Hasła nie są jednakowe";

  $passwordHash = md5($password);
  if (count($errors) == 0) {
    $checkQuery = "Select username,email from users where username='$username' OR email='$email'";
    $result = mysqli_query($connection, $checkQuery);
    $user = mysqli_fetch_assoc($result);
    if ($user) {
      if ($user['username'] == $username) $errors[] = "Użytkownik o podanej nazwie już istnieje";
      if ($user['email'] == $email) $errors[] = "Użytkownik o podanym emailu już istnieje";
    }
  }

  if (count($errors) == 0) {
    $query = "INSERT INTO users(username,email,passwordHash,type_id) VALUES('$username','$email','$passwordHash',2)";
    mysqli_query($connection, $query);
    Messege("Zarejestrowano pomyślnie");
  } else $_SESSION['registerErrors'] = $errors;
}

?>

<div class="text-center">
  <form class="form-signin" action="" method="post">
    <img class="mb-4" src="img/logo.png" alt="" width="150">
    <h1 class="h3 mb-3 font-weight-normal">Zarejestruj sie!</h1>
    <label for="username" class="sr-only">Login</label>
    <input name="username" type="text" id="username" class="form-control" placeholder="Login" autofocus>
    <label for="email" class="sr-only">Email</label>
    <input name="email" type="email" id="email" class="form-control" placeholder="E-mail">
    <label for="password" class="sr-only">Hasło</label>
    <input name="password" type="password" id="password" class="form-control" placeholder="Hasło">
    <label for="secondPassword" class="sr-only">Powtórz hasło</label>
    <input name="secondPassword" type="password" id="secondPassword" class="form-control" placeholder="Powtórz hasło">
    <div class="error-container">
      <?php
      if (isset($_SESSION['registerErrors'])) {
        $registerErrors = $_SESSION['registerErrors'];
        foreach ($registerErrors as $key => $value) {
          echo '<p class="error">' . $value . '</p>';
        }
      }
      ?>
    </div>
    <br>
    <input name="submitBtn" class="btn btn-lg btn-primary btn-block" type="submit" value="Zarejestruj się"></input>

    <p class="mt-5 mb-3 text-muted">© 2020</p>

  </form>


</div>