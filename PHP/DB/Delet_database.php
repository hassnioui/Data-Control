<?php
    include '../Fonctions/Fonctions.php';

    $db = $_GET['Nom_db'];
    $del = new GererDB();
    $del->DropDB($db);

    header('Location: ./DBGestion.php');

?>