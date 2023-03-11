<?php
    include("../Fonctions/Fonctions.php");
    $db = $_GET['db'];
    $table = $_GET['table'];
    $iputnames = $_GET['input_name'];
    $Addcol = new GererTable();
    $Addcol->addContent($db, $table, $iputnames);
    header('Location: ../Table/AficherTable.php?Nom_db='.$db.'&Name_Table='.$table);
