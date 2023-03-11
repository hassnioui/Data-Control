

<?php
    include("../Fonctions/Fonctions.php");
    $db=$_GET['db'];
    $table=$_GET['table'];
    $colnames=$_GET['column_names'];
    $coltype=$_GET['column_type'];
    $is_checked = $_GET['is_checked'];
    $Addcol = new GererTable();
    $Addcol->addColumn($db, $table, $colnames, $coltype, $is_checked);
    header('Location: ../DB/TableDB.php?Nom_db='.$db);
?>