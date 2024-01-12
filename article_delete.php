<?php
include("connect.php");
include("articles_CRUD.php");
include("helpers.php");
$id=mysqli_real_escape_string($connection, $_GET['delete']);
$article = GetArticle($id);
if(is_null($article))Messege("Nie ma takiego artykułu");
$authorId=$article['user_id'];
$image=$article['image'];

if($_SESSION['user']['user_id']==$authorId||$_SESSION['user']['type_id']==1){
    $result = DeleteArticle($id);
    if($result)  { 
        Messege("Artykuł usunięty pomyślnie");
        unlink("img/".$image); 
    } else {
        Messege("Usuwanie artykułu nie podwiodło się");
    }
} else Messege("Nie posiadasz uprawnień do edycji tego artykułu");

?>
