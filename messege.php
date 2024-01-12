<div class="messege">
    <h1>
        <?php
        if (isset($_SESSION['messege'])) {
            echo $_SESSION['messege'];
            unset($_SESSION['messege']);
        } else header("Location:index.php");

        ?>
    </h1>
</div>