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
											<div class="navtext"  style="color:#F2DA29;">STAMPA</div>
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
											<div class="navtext">IL MIO PROFILO</div>
										</div>
									</a>
									
								</div>
								
							</div>
							
						</div>
						
					<div class="fixedwidth">
									
							<div class="header">
								
								<h2 id="titleshop">Indirizzo di spedzione</h2>
								<h2 id="step">3/4</h2>
								<div style="clear:both;"></div>
								<hr />
								<br />
								
								<?php
								$queryindirizzi = "SELECT id_indirizzo,nome,cognome,via,citta,CAP,regione FROM indirizzo WHERE link_utente ='" . $_SESSION['userid'] . "'";

									if ($result = mysqli_query($link, $queryindirizzi)) {
										if (mysqli_num_rows($result))//Se la query NON è vuota
										{
											echo '<table class="indirizzi">
													<tr><th>Sel.</th><th>Nome</th><th>Cognome</th><th>Via, Nr.</th><th>Citt&agrave;</th><th>CAP</th><th>Regione</th></tr>
													<form method="post" action=stampa4.php>';

											while ($row = mysqli_fetch_row($result)) {

												echo "
													<tr>
													<td><input type='radio' checked='checked' name='sel_ind' value='" . $row[0] . "' /></td>
				 									<td>" . strip_tags($row[1]) . "</td>
													<td>" . strip_tags($row[2]) . "</td>
													<td>" . strip_tags($row[3]) . "</td>
													<td>" . strip_tags($row[4]) . "</td>
													<td>" . strip_tags($row[5]) . "</td>
													<td>" . strip_tags($row[6]) . "</td>
													</tr>";
											}

											echo '</table>';

										} 
									} else {
										echo "failed query";
									}
									
									?>
									
								<br />
								<hr />
								
									
										<input type='hidden' name='file_id' value='<?php echo $_GET['file_id'];?>' />
										<input style='float:right;' type='submit' value='Avanti' />
									</form>						
								
								<div style="clear:both;"></div>
								
							</div>			
					</div>
					
				</body>
			
		</html>		
		