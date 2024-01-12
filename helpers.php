<?php 

function Messege($messege){
    $_SESSION['messege']=$messege;
    echo "<script>window.location='index.php?url=messege' </script>";
}

?>