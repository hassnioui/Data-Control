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



                <div class="row  py-3 d-flex flex-row align-items-center justify-content-around">

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            NUMBER OF DATABASES</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php
                                                                                            $req = "SELECT COUNT(*) as number_db FROM `databases`";
                                                                                            $prepare =  $pdo->prepare($req);
                                                                                            $prepare->execute();
                                                                                            $number_db = $prepare->fetch(PDO::FETCH_ASSOC);
                                                                                            echo $number_db['number_db'];  ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            NUMBER OF TABLES</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php
                                                                                            $req = "SELECT SUM(Number_Table) as nombre_tab FROM `databases`";
                                                                                            $prepare =  $pdo->prepare($req);
                                                                                            $prepare->execute();
                                                                                            $nombre_tab = $prepare->fetch(PDO::FETCH_ASSOC);
                                                                                            if (empty($nombre_tab['nombre_tab'])) {
                                                                                                echo "0";
                                                                                            } else {
                                                                                                echo $nombre_tab['nombre_tab'];
                                                                                            }
                                                                                            ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <center>
                    <div style="width: 95%;">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Table of databases</h6>
                                <svg data-toggle="modal" data-target="#AddDB" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(28, 200, 138, 1);cursor:pointer;">
                                    <path d="M3 8v11c0 2.201 1.794 3 3 3h15v-2H6.012C5.55 19.988 5 19.806 5 19c0-.101.009-.191.024-.273.112-.576.584-.717.988-.727H21V4c0-1.103-.897-2-2-2H6c-1.206 0-3 .799-3 3v3zm3-4h13v12H5V5c0-.806.55-.988 1-1z"></path>
                                    <path d="M11 14h2v-3h3V9h-3V6h-2v3H8v2h3z"></path>
                                </svg>

                            </div>
                            <div class="card-body">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">N°</th>
                                            <th scope="col">Database Name</th>
                                            <th scope="col">Number of tables</th>
                                            <th scope="col">Date</th>
                                            <th scope="col" style="width:7%;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        $dsn = 'mysql:host=' . $host . ';dbname=' . $base;
                                        $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
                                        $pdo = new PDO($dsn, $utilisateur, $mdp, $options);

                                        // $info_con =  new PDO("mysql:host=$host;dbname=$base;charset=utf8", $utilisateur, $mdp);
                                        $req = "SELECT * FROM `databases`";
                                        $prepare =  $pdo->prepare($req);
                                        $prepare->execute(array());
                                        $i = 1;
                                        while ($result = $prepare->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                            <tr>

                                                <th scope="row"><?php echo $i;
                                                                $i++; ?></th>
                                                <td><?php echo $result['Nom_db']; ?></td>
                                                <td><?php if ($result['Number_Table'] != null) {
                                                        echo $result['Number_Table'];
                                                    } else {
                                                        echo "0";
                                                    } ?></td>
                                                <td><?php echo $result['Date_Ajouter']; ?></td>
                                                <td class="py-3 d-flex flex-row align-items-center justify-content-around">
                                                    <a href="TableDB.php?Nom_db=<?php echo $result['Nom_db']; ?>" title="More"> <svg xmlns="http://www.w3.org/2000/svg" width="30" height="26" viewBox="0 0 24 24" style="fill: rgba(78, 115, 223, 1);cursor:pointer;">
                                                            <path d="M14 12c-1.095 0-2-.905-2-2 0-.354.103-.683.268-.973C12.178 9.02 12.092 9 12 9a3.02 3.02 0 0 0-3 3c0 1.642 1.358 3 3 3 1.641 0 3-1.358 3-3 0-.092-.02-.178-.027-.268-.29.165-.619.268-.973.268z"></path>
                                                            <path d="M12 5c-7.633 0-9.927 6.617-9.948 6.684L1.946 12l.105.316C2.073 12.383 4.367 19 12 19s9.927-6.617 9.948-6.684l.106-.316-.105-.316C21.927 11.617 19.633 5 12 5zm0 12c-5.351 0-7.424-3.846-7.926-5C4.578 10.842 6.652 7 12 7c5.351 0 7.424 3.846 7.926 5-.504 1.158-2.578 5-7.926 5z"></path>
                                                        </svg> </a>
                                                    <a href="./Delet_database.php?Nom_db=<?php echo $result['Nom_db']; ?>"><i class='bx bx-trash' style='color:#e02626;font-size:25px;'></i></a>

                                                </td>

                                            </tr>
                                        <?php } ?>

                                    </tbody>

                                </table>

                            </div>
                        </div>
                    </div>
                </center>

                <div class="modal fade" id="AddDB" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Ajouter Database</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="AddDB.php" method="POST">
                                    <div class="mb-3">
                                        <?php
                                        $form->formLabel("exampleFormControlInput1", "form-label", "Name Database");
                                        $form->formInput("text", "NDB", "form-control", "exampleFormControlInput1", "", "Entrer name database", "");
                                        ?>
                                    </div>
                            </div>
                            <div class="modal-footer">

                                <?php
                                $form->formButton("reset", "button", "btn btn-secondary", "", "Cancel", "modal", "");
                                $form->formButton("submit", "button2", "btn btn-primary", "", "Add", "", "");
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