<?php
include("connect.php");
$user_id = $_GET['profile'];
$queryUser = "SELECT username FROM users WHERE user_id=$user_id";
$result = mysqli_query($connection, $queryUser);
$user = mysqli_fetch_assoc($result);
$username = $user['username'];
if (isset($_SESSION['user'])) {
    if ($user_id == $_SESSION['user']['user_id'])
        echo '<h1 class="profile-header">Twoje artykuły</h1>';
} else
    echo '<h1 class="profile-header">' . $username . '</h1>';
?>

<form action="" method="post">
    <div class="input-group search"> <input type="text" id="" name="search" class="form-control" placeholder="Szukaj...">
        <div class="input-group-append"> <button name="submit" type="submit" class="btn btn-primary waves-effect waves-light btn-custom"><i class="fa fa-search mr-1"></i> Search</button></div>
    </div>
</form>

<div class="articles-container">

    <?php
    
    $user_id = $_GET['profile'];
    $query = "SELECT article_id,articles.user_id,username,add_date,title,description,image FROM articles INNER JOIN users ON articles.user_id=users.user_id WHERE articles.user_id=$user_id";
    if (isset($_POST['submit'])) {
        $search = mysqli_escape_string($connection, $_POST['search']);
        $query .= " AND (title LIKE '%$search%' OR description LIKE '%$search%')";
    }
    $query .= " ORDER BY article_id DESC";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) == 0) echo "<div class='text-center'>Nie dodałeś jeszcze żadnych artykuł. <a href='index.php?url=articles_add'>Kliknij tutaj</a> aby przejść do formularza dodawania artykułu</div>";


    if ($result) {
        while ($article = $result->fetch_assoc()) {

            $id = $article['article_id'];
            $title = $article['title'];
            $description = $article['description'];
            $img = $article['image'];
            $author = $article['username'];
            $author_id = $article['user_id'];
            $add_date = $article['add_date'];

            echo '<div class="article" href="index.php?article=' . $id . '">';
            echo '<a class="link" href="index.php?article=' . $id . '">';
            echo '<img class="article-img" src="img/' . $img . '" alt="">';
            echo '</a>';
            echo '<div class="article-content">';
            echo '<a class="link" href="index.php?article=' . $id . '">';
            echo '<h2 class="article-title">' . $title . '</h2>';
            echo '</a>';
            echo '<div class="article-description">' . $description . '</div>';
            echo '<p class="card-text"><small class="text-muted">Dodany ' . $add_date . ' przez <a href="index.php?profile=' . $author_id . '">' . $author . '</a></small></p>';
            if (isset($_SESSION['user'])) {
                if ($_SESSION['user']['user_id'] == $author_id || $_SESSION['user']['type_id'] == 1) {
                    echo '<a href="index.php?edit=' . $id . '" type="button" class="btn btn-primary">Edytuj</a>';
                    echo '<a href="index.php?delete=' . $id . '" type="button" class="btn btn-danger">Usuń</a>';
                }
            }
            echo '</div>';
            echo '</div>';
        }
    }

    ?>
</div>