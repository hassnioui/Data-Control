<?php
    include '../Fonctions/Fonctions.php';

    $db = $_GET['Nom_db'];
    $table = $_GET['Name_Table'];
    $column = $_GET['Nom_column'];
    $del = new GererTable();
    $del->DropColumn($db,$table,$column);
    // header('Location: TableDB.php?Nom_db='.$db);
    header('Location: ./column.php?Name_Table='.$table.'&Nom_db='.$db);

?>
