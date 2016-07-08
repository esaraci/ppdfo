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
				<h2>Gestione Utenti</h2>
				<h3>Lista utenti</h3>
			<?php
			
			$queryutenti = "SELECT * FROM utente";
				
				if ($result = mysqli_query($link, $queryutenti)) {
		
		if (mysqli_num_rows($result))
			{
			echo '<table style="text-align:center; background-color:#E5E5E5;">
													<tr><th>Username</th><th>Admin</th><th>E-Mail</th><th>Password</th><th>Soldi Spesi</th><th>Pagine Stampate</th></tr>';
			while ($row = mysqli_fetch_row($result)) {
				echo "<form method='get' action='edituser.php'>
													<input type='hidden' name='uid' value='" . $row['0'] . "' />
													<tr>
				 									<td>" . strip_tags($row['3']) . "</td>
													<td>" . strip_tags($row['1']) . "</td>
													<td>" . strip_tags($row['2']) . "</td>
													<td>" . strip_tags($row['4']) . "</td>
													<td>" . strip_tags($row['5']) . " &euro;</td>
													<td>" . strip_tags($row['6']) . "</td>
													<td><input style='cursor:pointer;' type='submit' value='Modifica' /></td>
													</tr></form>";
			}
			echo '</table>';

		} else //query vuota
			{
			echo "Nessun ordine in attesa di conferma.<br /><br /><br />";
		}

	} else {
		echo "failed query";
	}

	?>	
	<br /><h3>Aggiungi Utente</h3>
	<form action="addutente.php" method="GET">
	<table style="text-align:center; background-color:#E5E5E5;">
		<tr><td>Username</td><td ><input name="newUsername" type="text" required /></td></tr>
		<tr><td>Password</td><td><input name="newPassword" type="text" required /></td></tr>
		<tr><td>E-Mail</td><td><input name="newEmail" type="email" required /></td></tr>
	</table>
	<input type="submit" value="Crea" />
	</form>	
		<?php if (isset($_GET['error'])) echo "Username o indirizzo email gi&agrave; in uso." ?>
			</body>
		</html>