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
					<a href=<?php echo "../DB/TableDB.php?Nom_db=" . $_GET['Nom_db']; ?> class="btn btn-primary" style="background:#4e73df;">Retour</a>
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

								<button href="#" id="addColumn" title="More"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
										<path d="M12 5v14m-7-7h14" stroke="#4E73DF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
									</svg>
								</button>
								<a onclick="submitform()"  name="submit" class="btn btn-primary" style="background:#4e73df;">Save</a>

							</div>
							<div class="card-body" id="card-body">
								<form id="addc" action="./AddColumn.php" method="GET">
									<table class="table table-hover">
										<thead>
											<tr>
												<th scope="col">Column Name</th>
												<th scope="col">Type</th>
												<th scope="col">is Primary key</th>
												<th scope="col" style="width:7%;">Actions</th>
											</tr>
										</thead>
										<tbody id="mytable">

										<tr id="trg">

												<?php

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

												?>

											<tr>

												<th scope="row"><?php $form->formInputDis("text", "column_names[]", "form-control", "id", "", $row['Field'], 'disabled'); ?></th>
												<td>
													<?php
														$form->formInputDis("text", "column_names[]", "form-control", "id", "", $row['Type'], 'disabled');
													?>
												</td>
												<td>
													<?php

														if ($row['Key'] == "PRI") {
															$form->formCheckboxDis("primary_key[]", "checked", "form-control", "disabled");
															
														} else {
															$form->formCheckboxDis("primary_key[]", "", "form-control", "disabled");
														}
													?>
												</td>
												<td class="py-3 d-flex flex-row align-items-center justify-content-around">
													<a  href="./Delet_column.php?Name_Table=<?php echo $Name_Table; ?>&Nom_db=<?php echo $db; ?>&Nom_column=<?php echo $row['Field']; ?> "><i id="1" class='bx bx-trash' style='color:#e02626;font-size:25px;'></i></a>

												</td>

											</tr>
									<?php }} ?>

									<tr id="tr1">

										<th scope="row"><?php $form->formInput("text", "column_names[]", "form-control", "id", "", "Enter column Name",); ?></th>
										<td>
											<?php
											$form->formSelectOpen("form-control", "Select column type", "column_type[]");
											$form->SelectOption("INT", "INT", "INT");
											$form->SelectOption("VARCHAR(255)", "VARCHAR(255)", "VARCHAR(255)");
											$form->SelectOption("TEXT", "TEXT", "VARCHAR");
											$form->formSelectferme();
											?>
										</td>
										<td>
											<?php
											$form->formCheckbox("primary_key[]", "", "", "form-control check_boxes_class");
											$form->formInput("hidden", "is_checked[]", "is_checked_class", "id_isch", "1", "test",);
											$db = $_GET['Nom_db'];
											$table = $_GET['Name_Table'];
											$form->formInput("hidden", "db", "form-control", "exampleFormControlInput1", "$db", "",);
											$form->formInput("hidden", "table", "form-control", "exampleFormControlInput1", "$table", "",);
											?>
										</td>
										<td class="py-3 d-flex flex-row align-items-center justify-content-around">
											<a class="remove-column" data-remove="column" href="#"><i id="1" class='bx bx-trash' style='color:#e02626;font-size:25px;'></i></a>

										</td>

									</tr>

										</tbody>

									</table>
								</form>

							</div>
						</div>
					</div>

					<script>
						var m = 2;
						document.getElementById("addColumn").addEventListener("click", function() {
							if (m > 10) {
								alert("you cant add more than 10 of colums");
							} else {
								var columnContainer = document.getElementById("mytable");
								var newRow = document.createElement("tr");
								newRow.classList.add("tr" + m);
								newRow.innerHTML = `
                                <th scope="row"><input type="text" name="column_names[]" placeholder="Column Name" class="form-control"></th>
                                <td>
                                    <select name="column_type[]" class="form-control">
										<option Name="INT" value="INT">INT</option>
										<option Name="VARCHAR" value="VARCHAR">VARCHAR</option>
										<option Name="TEXT"value="TEXT">TEXT</option>
                                    </select>
                                </td>
                                <td>
									<input type="checkbox" class="form-control check_boxes_class" name="primary_key[]" value="1">
                                	<input type="hidden" class="is_checked_class" name="is_checked[]" value="1">
								</td>
                                <td class="py-3 d-flex flex-row align-items-center justify-content-around">
                                <a href="#"><i id="${m}" class='bx bx-trash' style='color:#e02626;font-size:25px;'></i></a>
                                </td>
                                `;
								m++;
								columnContainer.appendChild(newRow);
							}
						});



						const table = document.querySelector('table');
						table.addEventListener('click', (event) => {
							const clickedElement = event.target;
							if (clickedElement.classList.contains('bx-trash')) {
								const rowToRemove = clickedElement.closest('tr');
								rowToRemove.remove();
								m--;
							}
						});


						function submitform() {
							let addc = document.getElementById("addc");
							let check_boxes_class = document.getElementsByClassName('check_boxes_class');
							let is_checked_class = document.getElementsByClassName('is_checked_class');
							for (let index = 0; index < check_boxes_class.length; index++) {
								if ((check_boxes_class[index].checked) == false)
									is_checked_class[index].value = "0";
							}

							addc.submit();
						}
					</script>


				</center>

				<div class="modal fade" id="Edittable" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">Modifier Le Nom</h5>
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
										$form->formInput("text", "New_table", "form-control", "exampleFormControlInput1", "", "Entrer new name");
										$form->formInput("hidden", "db", "form-control", "exampleFormControlInput1", "$db", "");
										$form->formInput("hidden", "old", "form-control", "exampleFormControlInput1", "$old_table", "",);
										?>

									</div>
							</div>
							<div class="modal-footer">

								<?php
								$form->formButton("reset", "button", "btn btn-secondary", "", "Cancel", "modal", "");
								$form->formButton("submit", "button2", "btn btn-primary", "", "Change", "", "");
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