<?php
    session_start();
    $_SESSION["usuario"] = null;
    session_destroy();
    header('Location: index.php');
?>