<?php
	session_start();
	include ("dbconnect.php");
	
	if (!isset($_SESSION["userid"])) {
		header("location:index.php");
	}

	
	if ($_SESSION["isadmin"]) {
		header("location:index.php");
		//un Admin non puÃ² accedere a questa "interfaccia"
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
											<div class="navtext" style="color:#F2DA29;">I MIEI ORDINI</div>
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
								<h2 id="divordini">Ordini in attesa di conferma</h2>
									<hr />
									<br />
									<?php
	
	if (isset($_GET['success'])){
		echo "<p style='color:lime;'>Ordine effettuato con successo.</p>";
	}

	$queryordinipending = "SELECT id_ordine, data_ordine, title, pagine_finali, prezzo  FROM (ordine JOIN (files JOIN stampa ON id_file = file_stampa) ON stampa_ordine=id_stampa) WHERE utente_ordine='".$_SESSION['userid']."' AND stato='In attesa' ORDER BY data_ordine DESC";
	
	if ($result = mysqli_query($link, $queryordinipending)) {
		
		if (mysqli_num_rows($result))//Se la query NON Ã¨ vuota
			{
			echo '<table class="indirizzi">
													<tr><th>Data ordine</th><th>Titolo</th><th>Pagine</th><th>Prezzo</th></tr>';
			while ($row = mysqli_fetch_row($result)) {
				echo "<form method='get' action='updateordine.php'>
													<input type='hidden' name='action' value='annulla' />
													<input type='hidden' name='ordine_id' value='" . $row['0'] . "' />
													<tr>
				 									<td>" . strip_tags($row['1']) . "</td>
													<td>" . strip_tags($row['2']) . "</td>
													<td>" . strip_tags($row['3']) . "</td>
													<td>" . strip_tags($row['4']) . " &euro;</td>
													<td><input style='cursor:pointer;' type='submit' value='Annulla' /></td>
													</tr></form>";
			}

			echo '</table><br /><p>Un ordine in attesa di conferma pu&ograve; essere annullato in qualsiasi momento.</p><br />';
		} else //query vuota
			{
			echo "Nessun ordine in attesa di conferma.<br /><br /><br />";
		}

	} else {
		echo "failed query";
	}

	?>

								</div>
							<div class="header">
									<h2>Ordini in attesa di rimborso</h2>
									<hr />
									<br />
									<?php
	$queryordiniric_rimb = "SELECT id_ordine, data_ordine, title, pagine_finali, prezzo  FROM (ordine JOIN (files JOIN stampa ON id_file = file_stampa) ON stampa_ordine=id_stampa) WHERE utente_ordine='".$_SESSION['userid']."' AND stato='Richiesta rimborso' ORDER BY data_ordine DESC";
	
	if ($result = mysqli_query($link, $queryordiniric_rimb)) {
		
		if (mysqli_num_rows($result))//Se la query NON Ã¨ vuota
			{
			echo '<table class="indirizzi">
													<tr><th>Data Ordine</th><th>Titolo</th><th>Pagine</th><th>Prezzo</th></tr>';
			while ($row = mysqli_fetch_row($result)) {
				echo "<form method='get' action='updateordine.php'>
													<input type='hidden' name='action' value='rimborso' />
													<input type='hidden' name='ordine_id' value='".$row['0'] ."' />
													<tr>
				 									<td>" . strip_tags($row['1']) . "</td>
													<td>" . strip_tags($row['2']) . "</td>
													<td>" . strip_tags($row['3']) . "</td>
													<td>" . strip_tags($row['4']) . " &euro;</td>
													</tr></form>";
			}

			echo '</table><br /><br /><br />';
		} else //query vuota
			{
			echo "Nessun ordine in attesa di rimborso.<br /><br /><br />";
		}

	} else {
		echo "failed query";
	}

	?>
	
										</div>
							<div class="header">
									<h2>Ordini conclusi</h2>
									<hr />
									<br />
									<?php
	$queryordiniconclusi = "SELECT id_ordine, data_ordine, title, pagine_finali, prezzo, stato  FROM (ordine JOIN (files JOIN stampa ON id_file = file_stampa) ON stampa_ordine=id_stampa) WHERE utente_ordine='".$_SESSION['userid']."' AND stato='Concluso' OR stato='Rifiutato' OR stato='Rimborsato' ORDER BY stato, data_ordine DESC";
	
	if ($result = mysqli_query($link, $queryordiniconclusi)) {
		
		if (mysqli_num_rows($result))
			{
			echo '<table class="indirizzi">
													<tr><th>Data Ordine</th><th>Titolo</th><th>Pagine</th><th>Prezzo</th></tr>';
			while ($row = mysqli_fetch_row($result)) {
				echo "
													<tr><form method='get' action='updateordine.php'>
				 									<td>" . strip_tags($row['1']) . "</td>
													<td>" . strip_tags($row['2']) . "</td>
													<td>" . strip_tags($row['3']) . "</td>
													<td>" . strip_tags($row['4']) . " &euro;</td>
													<input type='hidden' name='action' value='rimborso' />
													<input type='hidden' name='ordine_id' value='".$row['0'] ."' />";
												
													if ($row[5]=='Concluso') {
													echo"<td><input style='cursor:pointer;' type='submit' value='Richiesta rimborso' /></td>";
													}
													elseif ($row[5]=='Rimborsato'){
														echo "<td>Rimborso accettato</td>";
													}
													elseif($row[5]=='Rifiutato'){
														echo "<td>Rimborso rifiutato</td>";
													}
													
													echo "</form>
													</tr>";
			}

			echo '</table><br /><br /><br />';
		} else //query vuota
			{
			echo "Nessun ordine confermato.<br /><br /><br />";
		}

	} else {
		echo "failed query";
	}

	?>
									
							</div>	
							<br />		
					</div>
				</body>
		</html>