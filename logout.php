<?php
// supression de la ssession
session_start();
session_destroy();
header('Location: acceuil.php');
exit;
?>