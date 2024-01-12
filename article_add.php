<?php
require("connect.php");
require("articles_CRUD.php");
require("helpers.php");
$_SESSION['articleAddErrors'] = [];
if (isset($_POST['submit'])) {
 
  $title = mysqli_real_escape_string($connection, $_POST['title']);
  $description = mysqli_real_escape_string($connection, $_POST['description']);
  $content = mysqli_real_escape_string($connection, $_POST['content']);

  $result = CreateArticle($_SESSION['user']['user_id'], $title, $description, $content, $_FILES['image']);

  if ($result===true) {
    Messege("Artykuł dodany pomyślnie");
  } else {
    $_SESSION['articleAddErrors'] = $result;
  }
}
?>

<h1 class="profile-header">Nowy artykuł</h1>
<form method="post" class="add-form" enctype="multipart/form-data">

  <input name="title" type="text" id="title" class="form-control" placeholder="Tytuł"><br>
  <input name="description" type="text" id="description" class="form-control" placeholder="Krótki opis"><br>
  <textarea id="mytextarea" name="content" id="full-featured-non-premium" placeholder="Treść artykułu"></textarea><br>
  <label for="file" class="file_label">Miniaturka</label>
  <input type="file" name="image" class="form-control-file" id="image">
  <div class="error-container">
      <?php
      if (isset($_SESSION['articleAddErrors'])) {
        $registerErrors = $_SESSION['articleAddErrors'];
        foreach ($registerErrors as $key => $value) {
          echo '<p class="error">' . $value . '</p>';
        }
      }
      ?>
    </div>
  <input name="submit" type="submit" class="btn btn-primary add-btn" value="Dodaj"></input>
</form>