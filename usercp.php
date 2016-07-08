<?php

session_start();

include ("dbconnect.php");

if (!isset($_SESSION["userid"])) {
	header("location:index.php");
}

if ($_SESSION["isadmin"]) {
	header("location:index.php");
	//un Admin non può accedere a questa "interfaccia"
}

if (isset($_POST["back"])) {
	header("location:usercp.php");
}

if (isset($_GET["edit"])) {
	$_POST["edit"] = "Modifica";
}

$errorcode = array('1' => "Tutti i campi sono obbligatori.", '2' => "Inserire un indirizzo email valido.", '3' => "Username o indirizzo email gi&agrave; in uso.");

//fetch all user data from $_SESSION["userid"]

$getuserinfo = "SELECT * FROM utente WHERE id ='" . $_SESSION['userid'] . "'";

if ($userinfo = mysqli_query($link, $getuserinfo)) {
	if (mysqli_num_rows($userinfo))//Se la query NON è vuota
	{
		$row = mysqli_fetch_array($userinfo);

	}
}

if ($_POST["save"] == "Salva") {
	header("location:updateprofile.php?uid=" . $_SESSION["userid"] . "&newusername=" . $_POST["usernametxt"] . "&newpassword=" . $_POST["passwordtxt"] . "&newemail=" . $_POST["emailtxt"]);
}
?>

<!DOCTYPE html>
		<html>
			<head>
				<link href='http://fonts.googleapis.com/css?family=Itim' rel='stylesheet' type='text/css' />
				<link href='http://fonts.googleapis.com/css?family=Poppins' rel='stylesheet' type='text/css' />
				<link rel="stylesheet" type="text/css" href="usercp.css" />
				<title>User Control Panel</title>
			</head>
			
			<body>
						<div id="navbarcontainer">
									
							<div class="fixedwidth">
							
								<div id="navbar">
									
									<a href="index.php">
										<div id="navbarlogo">
											Print PDFs Online
										</div>
									</a>
									
									<a href="logout.php">
										<div class="navbarbutton">
											<div class="navtext">LOGOUT</div>
										</div>
									</a>
									
									<a href="stampa.php">
										<div class="navbarbutton">
											<div class="navtext">STAMPA</div>
										</div>
									</a>
									
									<a href="ordini.php">
										<div class="navbarbutton">
											<div class="navtext">I MIEI ORDINI</div>
										</div>
									</a>
									
									<a href="indirizzi.php">
										<div class="navbarbutton">
											<div class="navtext">I MIEI INDIRIZZI</div>
										</div>
									</a>
									
									<a href="index.php">
										<div class="navbarbutton">
											<div class="navtext" style="color:#F2DA29;">IL MIO PROFILO</div>
										</div>
									</a>
									
								</div>
								
							</div>
							
						</div>
						
						<div class="fixedwidth">
									
							<div class="header" id="profilo">
									
									<h2>Il mio profilo - <span id="usrnm"><?php echo strip_tags($row["username"]); ?></span></h2>
									<hr />
									<br />
									
									<div id="avatar"> 
										<img src="images/avatar.jpg" />
									</div>
									
									<form method="POST">
										
									<div id="tabella_dati">
									<table>
									<tr><td class="primocampo">Username:</td> <td class="secondocampo">
									
									
									
									<?php
									if ($_POST["edit"] == "Modifica") {
										echo '<input class="modtextbox" type="text" maxlength="32" name="usernametxt" value="';
									}
									echo strip_tags($row["username"]);

									if ($_POST["edit"] == "Modifica") {
										echo '"/>';
									}
									?>
									
									</td></tr>
									
									
									<tr><td class="primocampo">Password:</td> <td class="secondocampo">
									<?php
									if ($_POST["edit"] == "Modifica") {
										echo '<input class="modtextbox" type="text" maxlength="32" name="passwordtxt" value="';
									}
									echo strip_tags($row["password"]);

									if ($_POST["edit"] == "Modifica") {
										echo '"/>';
									}
									?>
									</td></tr>
									
									<tr><td class="primocampo">E-mai:</td> <td class="secondocampo">
									<?php
									if ($_POST["edit"] == "Modifica") {
										echo '<input class="modtextbox" type="text" maxlength="64" name="emailtxt" value="';
									}
									echo strip_tags($row["email"]);

									if ($_POST["edit"] == "Modifica") {
										echo '"/>';
									}
									?>
									</td></tr>
							
	
									<tr><td class="primocampo">Tot. Spese:</td> <td class="secondocampo"><?php echo $row["soldi_spesi"]; ?> &euro;</td></tr>
									<tr><td class="primocampo">Pag. Stampate:</td> <td class="secondocampo"><?php echo $row["tot_pagine_stampate"]; ?></td></tr>
									</table>
									</div>
									
									<div id="break" style="clear:both"></div>
									<br />
									<hr />
									
										<?php

										if (isset($_GET["error"])) {
											echo "<div class='message' id='error'><p>" . $errorcode[$_GET['error']] . "</p></div>";
										} else if (isset($_GET["success"])) {
											echo "<div class='message' id='success'><p>Modifica dati avvenuta con successo.</p></div>";
										}

										if ($_POST["edit"] == "Modifica") {

											echo '<div><input class="btn" id="save" type="submit" name="save" value="Salva" /></div>';
											echo '<div><input class="btn" id="back" type="submit" name="back" value="Annulla" /></div>';

										} else {
											echo '<div><input class="btn" id="edit" type="submit" name="edit" value="Modifica" /></div>';
										}
										?>
									</form>									
								
							</div>
							
						</div>
						
			</body>
			
		</html>		