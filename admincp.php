<?php
	session_start();
	include ("dbconnect.php");
	
	if (!isset($_SESSION["userid"])) {
		header("location:index.php");
	}

	
	if (!$_SESSION["isadmin"]) {
		header("location:index.php");
	}

	?>
<!DOCTYPE html>
		<html>
			<head>
			<title>Admin Control Panel</title>
			</head>
			<body>
				<ul	type="none">
					<li style=" margin-right:10px; float:left;"><a href="admincp.php">ORDINI</a></li>
					<li style="margin-right:10px; float:left;"><a href="admutenti.php">UTENTI</a></li>
					<li style=" margin-right:10px; float:left;"><a href="admfiles.php">FILES</a></li>
					<li style=" margin-right:10px; float:left;"><a href="admcoupon.php">COUPON</a></li>
					<li><a href="logout.php">ESCI</a></li>
				</ul>
				<br />
				<h2>Gestione Ordini</h2>
				<h3>Ordini in attesa di conferma</h3>
				
	<?php

	$queryordinipending = "SELECT id_ordine, username,  data_ordine, title, pagine_finali, prezzo FROM (utente JOIN (ordine JOIN (files JOIN stampa ON id_file = file_stampa) ON stampa_ordine=id_stampa) ON id=proprietario) WHERE stato='In attesa' ORDER BY data_ordine DESC";
	
	if ($result = mysqli_query($link, $queryordinipending)) {
		
		if (mysqli_num_rows($result))
			{
			echo '<table style="text-align:center; background-color:#E5E5E5;">
													<tr><th>Utente</th><th>Data ordine</th><th>Titolo</th><th>Pagine</th><th>Prezzo</th></tr>';
			while ($row = mysqli_fetch_row($result)) {
				echo "<form method='get' action='updateordine.php'>
													<input type='hidden' name='action' value='conferma' />
													<input type='hidden' name='ordine_id' value='" . $row['0'] . "' />
													<tr>
				 									<td>" . strip_tags($row['1']) . "</td>
													<td>" . strip_tags($row['2']) . "</td>
													<td>" . strip_tags($row['3']) . "</td>
													<td>" . strip_tags($row['4']) . "</td>
													<td>" . strip_tags($row['5']) . " &euro;</td>
													<td><input style='cursor:pointer;' type='submit' value='Conferma' /></td>
													</tr></form>";
			}
			echo '</table></div>';

		} else //query vuota
			{
			echo "Nessun ordine in attesa di conferma.<br /><br /><br />";
		}

	} else {
		echo "failed query";
	}

	?>
	<br /><br />
	<h3>Ordini in attesa di rimborso</h3>
	
	
	<?php
	$queryordinirimb = "SELECT id_ordine, username,  data_ordine, title, pagine_finali, prezzo FROM (utente JOIN (ordine JOIN (files JOIN stampa ON id_file = file_stampa) ON stampa_ordine=id_stampa) ON id=proprietario) WHERE stato='Richiesta rimborso' ORDER BY data_ordine DESC";
	
	if ($result = mysqli_query($link, $queryordinirimb)) {
		
		if (mysqli_num_rows($result))
			{
			echo '<table style="text-align:center; background-color:#E5E5E5;">
													<tr><th>Utente</th><th>Data ordine</th><th>Titolo</th><th>Pagine</th><th>Prezzo</th></tr>';
			while ($row = mysqli_fetch_row($result)) {
				echo "<form method='get' action='updateordine.php'>
													<input type='hidden' name='ordine_id' value='" . $row['0'] . "' />
													<tr>
				 									<td>" . strip_tags($row['1']) . "</td>
													<td>" . strip_tags($row['2']) . "</td>
													<td>" . strip_tags($row['3']) . "</td>
													<td>" . strip_tags($row['4']) . "</td>
													<td>" . strip_tags($row['5']) . " &euro;</td>
													<td><input style='cursor:pointer;' name='action' type='submit' value='Accetta' /></td>
													<td><input style='cursor:pointer;' name='action' type='submit' value='Rifiuta' /></td>
													</tr></form>";
			}
			echo '</table>';

		} else //query vuota
			{
			echo "Nessun ordine in attesa di rimborso.<br /><br /><br />";
		}

	} else {
		echo "failed query";
	}
		?>										
			
			</body>
		</html>