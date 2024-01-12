<?php
include("connect.php");
include("articles_CRUD.php");
$id = $_GET['article'];

$article = GetArticle($id);
if ($article === null) Messege("Nie ma takiego artykułu");
$title = $article['title'];
$content = $article['content'];
$image = $article['image'];
$add_date = $article['add_date'];
$author_id=$article['user_id'];
$author=$article['username'];

echo '<div class="article-page">';
echo '<div class="article-page-img" style="background-image:linear-gradient(#202020aa, #303030aa), url(img/' . $image . ');"><h1 class="article-page-title">' . $title . '</h1>';

echo '</div>';
echo '<div class="article-page-content">' . $content .  ' <p class="card-text"><span class="text-muted">Dodany ' . $add_date . ' przez <a href="index.php?profile='.$author_id.'">' . $author . '</a></span></p> </div>';
echo '</div>';

?>
<div class="card card-comments mb-3 wow fadeIn">
    <form action="" method="post" class="comment-add">
        <?php
        if (isset($_SESSION['user'])) {
            echo '<div class="input-group"> <input type="text" id="" name="text" class="form-control" placeholder="Twój komentarz">';
            echo '<div class="input-group-append"> <button name="submit" type="submit" class="btn btn-primary waves-effect waves-light btn-custom"><i class="fa fa-search mr-1"></i> Dodaj</button></div></div>';
        } else echo "Zaloguj się aby dodać komentarz";
        ?>
    </form>
    <?php

    if (isset($_POST['submit'])) {
        $text = mysqli_escape_string($connection,$_POST['text']);
        AddArticleComment($_SESSION['user']['user_id'],$id,$text);
    }

    $comments = GetArticleComments($id);
    $count = mysqli_num_rows($comments);
    echo '<div class="card-header font-weight-bold">' . $count . ' komentarzy</div>';
    while ($comment = $comments->fetch_assoc()) {
        echo '<div class="comment"><div class="comment-header"><h4 class="comment-user"> ' . $comment['username'] . ' </h4><p class="comment-date text-muted">' . $comment['add_date'] . ' </p></div>';
        echo '<div class="comment-content">' . $comment['text'] . '</div></div>';
    }
    ?>
</div>

<script>
    $(window).scroll(function() {
        var scrollTop = $(window).scrollTop();
        var height = $(window).height();

        $('.article-page-title').css({
            'opacity': ((height - scrollTop * 5) / height),
            'transform': 'translateY(calc(-50% - ' + (scrollTop / 2) + 'px)) translateX(-50%)'
        });
    });
</script>