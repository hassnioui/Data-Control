<?php
    include '../Fonctions/Fonctions.php';

    $db = $_GET['Nom_db'];
    $table = $_GET['Name_Table'];
    $id = $_GET['id'];
    $del = new GererTable();
    $del->DeletContent($db,$table,$id);
    header('Location: ./AficherTable.php?Name_Table='.$table.'&Nom_db='.$db);

?>
