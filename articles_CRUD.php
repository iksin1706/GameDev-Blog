<?php


function CreateArticle($user_id, $title, $description, $content, $image)
{
    require("connect.php");
    $errors = [];
    $dir = "img/";
    $file = $dir . basename($image["name"]);
    $imageFileType = strtolower(pathinfo($file, PATHINFO_EXTENSION));

    if (empty($title)) $errors[] = "Tytuł jest wymagany";
    if (empty($description)) $errors[] = "Opis jest wymagany";
    if (empty($content)) $errors[] = "Treść jest wymagana";


    $check = getimagesize($image["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $errors[] = "Plik nie jest obrazem";
    }
    if ($image["size"] > 5000000) {
        $errors[] = "Wbyrany obraz jest zbyt duży";
    }
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        $errors[] = "Plik musi być w formacie jpg,jpeg lub png";
    }

    if (count($errors) == 0) {
        $selectIdQuery =
            "SELECT AUTO_INCREMENT as 'id'
      FROM information_schema.tables
      WHERE table_name = 'articles'
      AND table_schema = DATABASE( ) ;";

        $selectIdResult = mysqli_query($connection, $selectIdQuery);
        $articleId = mysqli_fetch_assoc($selectIdResult);

        if ($articleId) {
            $id = $articleId['id'];
            move_uploaded_file($image["tmp_name"], $dir . $id . "." . $imageFileType);
            $insertQuery = "INSERT INTO articles(user_id,add_date,title,description,content,image) values($user_id,NOW(),'$title','$description','$content','" . $id . "." . $imageFileType . "')";
            $result = mysqli_query($connection, $insertQuery);
            if ($result) {
                return true;
            } else $errors[] = "Internal Server Error";
        } else $errors[] = "Internal Server Error";
    }
    return $errors;
}

function GetArticle($id)
{
    require("connect.php");
    $query = "SELECT username,articles.user_id,add_date,title,description,content,image FROM articles INNER JOIN users ON articles.user_id=users.user_id WHERE articles.article_id=$id";
    $result = mysqli_query($connection, $query);
    if ($result) {
        $article = mysqli_fetch_assoc($result);
        return $article;
    } else return null;
}


function UpdateArticle($id, $user_id, $title, $description, $content, $imageFile)
{

    require("connect.php");

    $errors = [];
    $dir = "img/";

    if (empty($title)) $errors[] = "Tytuł jest wymagany";
    if (empty($description)) $errors[] = "Opis jest wymagany";
    if (empty($content)) $errors[] = "Treść jest wymagana";

    if (file_exists($imageFile['tmp_name'])) {
        $file = $dir . basename($imageFile["name"]);
        $imageFileType = strtolower(pathinfo($file, PATHINFO_EXTENSION));

        $check = getimagesize($imageFile["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $errors[] = "Plik nie jest obrazem";
        }
        if ($imageFile["size"] > 5000000) {
            $errors[] = "Wbyrany obraz jest zbyt duży";
        }
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            $errors[] = "Plik musi być w formacie jpg,jpeg lub png";
        }
        $image = "$id.$imageFileType";
    }

    if (count($errors) == 0) {
        $user_id = $_SESSION['user']['user_id'];
        if (file_exists($imageFile['tmp_name'])) move_uploaded_file($_FILES["image"]["tmp_name"], $dir . $image);
        $insertQuery = "UPDATE articles SET user_id=$user_id,add_date=NOW(),title='$title',description='$description',content='$content' WHERE article_id =$id";
        $result = mysqli_query($connection, $insertQuery);
        if ($result) {
            return true;
        } else $errors[] = "Internal Server Error";
    }
    return $errors;
}
function DeleteArticle($id)
{
    require("connect.php");
    $query = "DELETE FROM articles WHERE article_id=$id";
    $result = mysqli_query($connection, $query);
    if ($result)
        return true;
    else return false;
}
function AddArticleComment($userId,$articleId,$text){
    require("connect.php");
    $query = "INSERT INTO comments(user_id,article_id,text,add_date) VALUES($userId,$articleId,'$text',NOW())";
    $result = mysqli_query($connection,$query);
}
function GetArticleComments($id){
    require("connect.php");
    $query = "SELECT username,article_id,text,add_date FROM comments INNER JOIN users ON comments.user_id=users.user_id WHERE article_id=$id ORDER BY comment_id  DESC";
    $comments = mysqli_query($connection,$query);
    return $comments;
}
