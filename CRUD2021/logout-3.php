<?php
session_start();
$_SESSION = [];
session_unset();
session_destroy();
// Session dihapus dan logout

header('location: index-3.php');
    // kembali ke index-3.php