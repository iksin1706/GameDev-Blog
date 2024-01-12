<?php
require("connect.php");
require("articles_CRUD.php");
require("helpers.php");

$id = mysqli_real_escape_string($connection, $_GET['edit']);
$article = GetArticle($id);
if(is_null($article))Messege("Nie ma takiego artykułu");

$authorId=$article['user_id'];

if ($_SESSION['user']['user_id'] == $authorId || $_SESSION['user']['type_id'] == 1) { 
    $title = $article['title'];
    $description = $article['description'];
    $content = $article['content'];
    $image = $article['image'];
} else Messege("Nie posiadasz uprawnień do edycji tego artykułu");

if (isset($_POST['submit'])) {

    $title = mysqli_real_escape_string($connection, $_POST['title']);
    $description = mysqli_real_escape_string($connection, $_POST['description']);
    $content = mysqli_real_escape_string($connection, $_POST['content']);

    $result = UpdateArticle($id,$authorId,$title,$description,$content,$_FILES['image']);
    if($result===true){
        Messege("Artykuł edytowano pomyślnie");
    } else {
        $_SESSION['articleEditerrors'] = $result;
    }
}
?>

<h1 class="profile-header">Edytowanie</h1>
<form method="post" class="add-form" enctype="multipart/form-data">

    <input name="title" type="text" id="title" class="form-control" placeholder="Tytuł" value="<?php echo $title ?>"><br>
    <input name="description" type="text" id="description" class="form-control" placeholder="Krótki opis" value="<?php echo $description ?>"><br>
    <textarea id="mytextarea" name="content" id="full-featured-non-premium" placeholder="Treść artykułu"><?php echo $content ?></textarea><br>
    <label for="file" class="file_label">Miniaturka</label>
    <input type="file" name="image" class="form-control-file" id="image">
    <div class="error-container">
      <?php
      if (isset($_SESSION['articleEditErrors'])) {
        $registerErrors = $_SESSION['articleEditErrors'];
        foreach ($registerErrors as $key => $value) {
          echo '<p class="error">' . $value . '</p>';
        }
      }
      ?>
    </div>
    <input name="submit" type="submit" class="btn btn-primary add-btn" value="Edytuj"></input>
</form>