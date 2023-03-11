<?php
    include '../Fonctions/Fonctions.php';

    $db = $_GET['Nom_db'];
    $table = $_GET['Name_Table'];
    $del = new GererTable();
    $del->DropTable($db,$table);
    header('Location: ../DB/TableDB.php?Nom_db='.$db);

?>

