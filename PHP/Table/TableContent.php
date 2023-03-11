<?php
    include("../Forms/Form.php");
    $form = new Form();
    $host = "localhost";
    $base = "db";
    $utilisateur = "root";
    $mdp = "";
    $dsn = 'mysql:host=' . $host . ';dbname=' . $base;
    $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
    $pdo = new PDO($dsn, $utilisateur, $mdp, $options);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Data-Control</title>
    <link rel="ICON" href="/images/icon.ico">

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Add the following code to the <head> section of your HTML file -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Custom styles for this template-->
    <link href="css/style.css" rel="stylesheet">
    <!-- icons -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

</head>

<body id="page-top"></body>

<div id="wrapper">

    <div id="content-wrapper" class="d-flex flex-column">

        <div id="content">

            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                <div class="sidebar-brand-text " style="font-size: 30px;">Data-Control</div>
                <ul class="navbar-nav ml-auto">
                    <?php
                    $Name_Table=$_GET['Name_Table'];
                    $db= $_GET['Nom_db'];
                    ?>
                    <a href="./AficherTable.php?Name_Table=<?php echo $Name_Table; ?>&Nom_db=<?php echo $db; ?>"  class="btn btn-primary" style="background:#4e73df;">Retour</a>
                </ul>
            </nav>


            <div class="container-fluid">

                <style>
                    form button {
                        background-color: inherit;
                        border: none;
                        position: absolute;
                        top: 0px;
                        right: 0px;
                    }
                </style>
                <div class="d-sm-flex align-items-center justify-content-between mb-4">

                </div>

                <center>
                    <div style="width: 95%;">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

                                <h6 class="m-0 font-weight-bold text-primary"><a data-toggle="modal" data-target="#Edittable" href="#"><i class='bx bx-pencil' style='color:#4e73df;font-size:20px;'></i></a> Table <?php echo ($_GET['Name_Table']); ?></h6>

                                <a onclick="submitform()" name="submit" class="btn btn-primary" style="background:#4e73df;">Add</a>

                            </div>
                            <div class="card-body" id="card-body">
                                <form id="addc" action="./AddContent.php" method="GET">
                                    <table class="table table-hover">
                                        <thead>

                                            <tr>

                                                <?php

                                                $c = 0;

                                                $db = $_GET['Nom_db'];
                                                $Name_Table = $_GET['Name_Table'];
                                                $dsn = 'mysql:host=' . $host . ';dbname=' . $db;
                                                $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
                                                $pdoo = new PDO($dsn, $utilisateur, $mdp, $options);
                                                $req = "DESCRIBE `$Name_Table`";
                                                $prepare =  $pdoo->prepare($req);
                                                $prepare->execute();
                                                while ($result = $prepare->fetchAll(PDO::FETCH_ASSOC)) {
                                                    foreach ($result as $row) {
                                                        if ($row['Field'] != "id")
                                                            echo " <th scope='col'> " . $row['Field'] . "</th>";
                                                        $c++;
                                                    }
                                                }

                                                ?>
                                            </tr>
                                        </thead>
                                        <tbody id="mytable">
                                            <tr id="tr1">


                                                <?php for ($i = 1; $i < $c; $i++) {
                                                ?>
                                                    <th scope="row"><?php $form->formInput("text", "input_name[]", "form-control", "id", "", "Entre Valeur"); ?></th>


                                                <?php  } ?>

                                                <td class="py-3 d-flex flex-row align-items-center justify-content-around">
                                                    <?php

                                                    $form->formInput("hidden", "db", "form-control", "exampleFormControlInput1", $db, "",);
											        $form->formInput("hidden", "table", "form-control", "exampleFormControlInput1", $Name_Table, "",);

                                                    ?>

                                                </td>

                                            </tr>

                                        </tbody>

                                    </table>
                                </form>

                            </div>
                        </div>
                    </div>
                    <script>
                        function submitform() {
                            let addc = document.getElementById("addc");
                            addc.submit();
                        }
                    </script>

                </center>

                <div class="modal fade" id="Edittable" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Edit Le Nom de Tableau</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="Etable.php" method="POST">
                                    <div class="mb-3">
                                        <?php
                                        $db = $_GET['Nom_db'];
                                        $old_table = $_GET['Name_Table'];
                                        $form->formLabel("exampleFormControlInput1", "form-label", "Name table");
                                        $form->formInput("text", "New_table", "form-control", "exampleFormControlInput1", "", "Entrer un Nouveau Nom");
                                        $form->formInput("hidden", "db", "form-control", "exampleFormControlInput1", "$db", "");
                                        $form->formInput("hidden", "old", "form-control", "exampleFormControlInput1", "$old_table", "",);
                                        ?>

                                    </div>
                            </div>
                            <div class="modal-footer">

                                <?php
                                $form->formButton("reset", "button", "btn btn-secondary", "", "Annuler", "modal", "");
                                $form->formButton("submit", "button2", "btn btn-primary", "", "Changer", "", "");
                                ?>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; Data-Control</span>
                </div>
            </div>
        </footer>
        
    </div>

</div>

</html>