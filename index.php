<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


    <script src="https://cdn.tiny.cloud/1/i6s7m5d6vl1rif8uphyjky4eu2nhtzy7bsp4obv8nj9to6ma/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>


    <script>
      tinymce.init({
        selector: '#mytextarea',
        height: 600,
        plugins: 'image',
        toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
    
      });
    </script>
    <link rel="stylesheet" type="text/css" href="style.css?v=1.1">
</head>

<body>
    <?php
    $isHomePage = false;

    if (isset($_GET['profile'])) {
        include("profile.php");
    } else if(isset($_GET['article'])){
        include("article.php");
    } else if(isset($_GET['delete'])){
        include("article_delete.php");
    } else if(isset($_GET['edit'])){
        include("article_edit.php");
    } else if (isset($_GET['url'])) {
        $url = $_GET['url'];

        switch ($url) {
            case "login":
                include("user_log_in.php");
                break;

            case "register":
                include("user_register.php");
                break;

            case "articles":
                include("articles.php");
                break;
            case "articles_add":
                include("article_add.php");
                break;
            case "messege":
                include("messege.php");
                break;
            case "logout":
                unset($_SESSION['user']);
                include("home.php");
                $isHomePage = true;
                break;
        }
    } else {
        include("home.php");
        $isHomePage = true;
    } 

    ?>
    </div>



    <?php
    if (!$isHomePage)
        echo '<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-primary">';
    else {
        echo '<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-transparent">';
    }
    ?>
    <a class="navbar-brand logo" href="index.php">
        <img class="" src="img/logo.png" alt="" height="50px">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse float-right" id="navbarCollapse">
        <ul class="navbar-nav float-right">
            <li class="nav-item active">
                <a class="nav-link" href="index.php">Strona główna <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="index.php?url=articles">Artykuły<span class="sr-only">(current)</span></a>
            </li>
            <?php
            if(isset($_SESSION['user']))$user_id = $_SESSION['user']['user_id'];
            if (isset($_SESSION["user"])) {
                echo '<li class="nav-item active">';
                echo '<a class="nav-link" href="index.php?url=articles_add">Nowy artykuł<span class="sr-only">(current)</span></a>';
                echo '</li>';
                echo '<li class="nav-item active">';
                echo '<a class="nav-link" href="index.php?profile='.$user_id.'">Mój profil<span class="sr-only">(current)</span></a>';
                echo '</li>';
                echo '<li class="nav-item active">';
                echo '<a class="nav-link" href="index.php?url=logout">Wyloguj<span class="sr-only">(current)</span></a>';
                echo '</li>';
            } else {
                echo '<li class="nav-item active">';
                echo '<a class="nav-link" href="index.php?url=login">Zaloguj się<span class="sr-only">(current)</span></a>';
                echo '</li>';
            }

            ?>
        </ul>
    </div>
    </nav>
<?PHP
if(!$isHomePage)
          echo  '<footer class="footer"> Wszelkie prawa zastrzeżone | Polityka prywatnosci | Kontakt </footer>';
?>

</body>

</html>