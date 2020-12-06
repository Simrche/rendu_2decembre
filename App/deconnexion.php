<?php
if (isset($_POST['deco'])) {
    session_destroy();
    header('location:index.php');
}
