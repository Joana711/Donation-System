<?php
    include '../main/data.php';
    session_destroy();
    header("location: ../index.php");
?>