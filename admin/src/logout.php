<?php
    if(session_status() === PHP_SESSION_NONE)
        session_start();

    session_destroy();
    session_write_close();
    setcookie(session_name(),'',0,'/');

    header('Location: /veikals/admin/index.php');
    exit();
?>