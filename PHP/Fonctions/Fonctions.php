<?php
date_default_timezone_set('Africa/casablanca');

class GererDB
{
    public function ConnectionDB($nomdb)
    {
        $host = "localhost";
        $base = $nomdb;
        $utilisateur = "root";
        $mdp = "";
        $dsn = 'mysql:host=' . $host . ';dbname=' . $base;
        $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
        $pdo = new PDO($dsn, $utilisateur, $mdp, $options);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    }
    public function AddDB($nomdb)
    {
        $host = "localhost";
        $utilisateur = "root";
        $mdp = "";
        $pdo = new PDO("mysql:host=$host",  $utilisateur, $mdp);
        $pdo->exec("CREATE DATABASE `$nomdb`");

        // Add info database
        $base = "db";
        $pdo = Self::ConnectionDB($base);
        $req = "INSERT INTO `databases`(`Nom_db`, `Date_Ajouter`) VALUES (?,?)";
        $prepare =  $pdo->prepare($req);
        $prepare->execute(array($nomdb, date("Y-m-d")));

        return "the database <<" . $nomdb . ">> has been created";
    }
    public function DropDB($nomdb)
    {
        $host = "localhost";
        $utilisateur = "root";
        $mdp = "";
        $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
        $pdo = new PDO("mysql:host=$host",  $utilisateur, $mdp);
        $pdo->exec("DROP DATABASE `$nomdb`");
        $base = "db";
        $dsn = 'mysql:host=' . $host . ';dbname=' . $base;
        $pdo =  new PDO($dsn, $utilisateur, $mdp, $options);
        $req = "DELETE FROM `databases` WHERE Nom_db=?";
        $prepare =  $pdo->prepare($req);
        $prepare->execute(array($nomdb));
        $req = "DELETE FROM `tables` WHERE Nom_db=?";
        $prepare =  $pdo->prepare($req);
        $prepare->execute(array($nomdb));

        return "the database <<" . $nomdb . ">> has been Deleted";
    }
}


class GererTable extends GererDB
{

    public function addTable($nomdb, $nomTable)
    {

        $host = "localhost";
        $utilisateur = "root";
        $mdp = "";
        $dsn = 'mysql:host=' . $host . ';dbname=' . $nomdb;
        $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
        $pdo = new PDO($dsn, $utilisateur, $mdp, $options);
        $req = "CREATE TABLE $nomTable (id int unique AUTO_INCREMENT)";
        $prepare = $pdo->prepare($req);
        $prepare->execute();

        $base = "db";
        $pdo = Parent::ConnectionDB($base);
        $req = "INSERT INTO `tables`(`Name_Table`,`Nom_db`, `Date_Ajouter`) VALUES (?,?,?)";
        $prepare =  $pdo->prepare($req);
        $prepare->execute(array($nomTable, $nomdb, date("Y-m-d H:i:sa")));

        $req = "SELECT Name_Table FROM `tables` WHERE `Nom_db` =?";
        $prepare =  $pdo->prepare($req);
        $prepare->execute(array($nomdb));
        $var = 0;
        while ($prepare->fetch(PDO::FETCH_BOTH)) {
            $var += 1;
        }

        $req = "UPDATE `databases` SET `Number_Table`=? WHERE  `Nom_db`=?";
        $prepare =  $pdo->prepare($req);
        $prepare->execute(array($var, $nomdb));

        return "the table <<" . $nomTable . ">> has been created";
    }

    public function EditNameTable($nomdb, $nomOldTable, $nomNewTable)
{
    $pdo = Parent::ConnectionDB($nomdb);
    $req = "ALTER TABLE $nomOldTable RENAME $nomNewTable";
    $prepare = $pdo->prepare($req);
    $prepare->execute();

    $base = "db";
    $pdo = Parent::ConnectionDB($base);

    $req = "UPDATE `tables` SET `Name_Table` = ? WHERE `Nom_db` = ? AND `Name_Table` = ?";
    $prepare = $pdo->prepare($req);
    $prepare->execute(array($nomNewTable, $nomdb, $nomOldTable));

    return "The table <<" . $nomOldTable . ">> has been renamed to <<" . $nomNewTable . ">>";
}

public function DropTable($nomdb, $nomTable)
{

    $pdo = Parent::ConnectionDB($nomdb);
    $req = "DROP TABLE `$nomTable`";
    $prepare = $pdo->prepare($req);
    $prepare->execute();

    $base = "db";
    $pdo = Parent::ConnectionDB($base);
    $req = "DELETE FROM `tables` WHERE `Name_Table` = ? AND `Nom_db` = ?";
    $prepare = $pdo->prepare($req);
    $prepare->execute(array($nomTable, $nomdb));

    $requête = "SELECT Name_Table FROM `tables` WHERE `Nom_db` =?";
        $prepare =  $pdo->prepare($requête);
        $prepare->execute(array($nomdb));
        $var = 0;
        while ($prepare->fetch(PDO::FETCH_BOTH)) {
            $var += 1;
        }

        $req = "UPDATE `databases` SET `Number_Table`=? WHERE  `Nom_db`=?";
        $prepare =  $pdo->prepare($req);
        $prepare->execute(array($var, $nomdb));

    return "The table <<" . $nomTable . ">> has been dropped";
}

public function ShowColumns($nomdb, $nomTable)
{
    $pdo = Parent::ConnectionDB($nomdb);
    
    $req = "DESCRIBE `$nomTable`";
    $stmt = $pdo->prepare($req);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $output = array();
    foreach ($result as $row) {
        if ($row['Field'] != "id")
        $output[]= $row['Field'];
    }
    return $output;
}


public function addColumn($nomdb, $nomTable, $nomColumn, $typeColumn, $checkbox)
{
    $bdd = Parent::ConnectionDb($nomdb);
    foreach ($nomColumn as $nomColumn_key => $nomColumn_value)
    {
        $requete = " ALTER TABLE $nomTable ADD $nomColumn_value " . $typeColumn[$nomColumn_key] . " ";
            $prepare = $bdd->prepare($requete);
            $prepare->execute();
        
        if ($checkbox[$nomColumn_key] == "1")
        {
            $requete = " ALTER TABLE $nomTable ADD PRIMARY KEY ($nomColumn_value)";
            $prepare = $bdd->prepare($requete);
            $prepare->execute();
        }
    }
    return "the column <<".$nomColumn.">> has been added";
}


public function DropColumn($nomdb,$nomTable,$nomColumn){
    $bdd=Parent::ConnectionDb($nomdb);
    $requête = "ALTER TABLE ".$nomTable." DROP COLUMN ".$nomColumn;
    $prepare = $bdd->prepare($requête);
    $prepare->execute();
    return "the column <<".$nomColumn.">> has been deleted ";    

}

public function addContent($nomdb, $nomTable, $tab_val){
        $colnames=Self::ShowColumns($nomdb,$nomTable);
        $bdd=Parent::ConnectionDb($nomdb);
        $i = 0;
        foreach ($tab_val as $key => $value)
        {
            if ($i == 0)

                $requete = " INSERT INTO ". $nomTable."(". $colnames[$key] .") VALUE ('$value'); ";
            else
            {
                $get_last = "SELECT id FROM $nomTable ORDER by(id) DESC LIMIT 1;";
                $prepare_update = $bdd->prepare($get_last);
                $prepare_update->execute();
                $last_id = ((int) ($prepare_update->fetch(PDO::FETCH_ASSOC)['id']));
                $requete = " UPDATE $nomTable SET $colnames[$key] = '$value' WHERE id = $last_id; ";
            }
            $prepare = $bdd->prepare($requete);
            $prepare->execute();
            $i++;
        }
        return "the line  has been added";
    }
    public function DeletContent($nomdb, $nomTable,$id){
        $bdd=Parent::ConnectionDb($nomdb);
        $req = " DELETE FROM $nomTable WHERE id= $id ";
         $prepare= $bdd->prepare($req);
         $prepare->execute();

         return "the line  has been removed";
    }


}

