<?php

    session_start();

    if (!isset($_SESSION['AUTENTICADO'])) {
        echo '<script>alert("POR FAVOR INICIE SESIÓN")</script>';
        echo "<script> location.href='../Extras/page-login.html' </script>";
    }

    if ($_SESSION['rol']!="Administrador") {
        echo '<script>alert("NO POSEE PERMISOS PARA ACCEDER A ESTA INTERFAZ")</script>';
        echo "<script> history.go(-1) </script>";
    }


?>