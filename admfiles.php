<?php
	session_start();
	include ("dbconnect.php");
	
	if (!isset($_SESSION["userid"])) {
		header("location:index.php");
	}

	
	if (!$_SESSION["isadmin"]) {
		header("location:index.php");
	}
	
	
	if ($_GET['action']=='Elimina')
	{
		$queryelimina="DELETE FROM files WHERE id_file='".$_GET['fid']."'";
		mysqli_query($link, $queryelimina);
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
				<h2>Gestione Files</h2>
				<h3>File Orfani (senza una STAMPA da almeno 24h)</h3>
				
				<?php
	
	$queryorfani = "SELECT id_file, title, timestamp FROM (files LEFT JOIN stampa ON id_file=file_stampa) WHERE file_stampa IS NULL  AND timestamp + INTERVAL 1 DAY <= NOW()";
	
	if ($result = mysqli_query($link, $queryorfani)) {
		
		if (mysqli_num_rows($result))
			{
			echo '<table style="text-align:center; background-color:#E5E5E5;">
													<tr><th>Titolo</th><th>Data ordine</th>';
			while ($row = mysqli_fetch_row($result)) {
				echo "<form method='get'>			
													<input type='hidden' name='action' value='delfile' />
													<input type='hidden' name='fid' value='" . $row['0'] . "' />
													<tr>
				 									<td>" . strip_tags($row['1']) . "</td>
													<td>" . strip_tags($row['2']) . "</td>
													<td><input style='cursor:pointer;' name='action' type='submit' value='Elimina' /></td>
													</tr></form>";
			}
			echo '</table>';

		} else //query vuota
			{
			echo "Nessun file orfano<br /><br /><br />";
		}

	} else {
		echo "failed query";
	}
		?>	<br />
				<h3>File con una STAMPA ma senza un ORDINE (da almeno 24h)</h3>			
				<?php
	
	$querynoord = "SELECT id_file, title, timestamp FROM ((files RIGHT JOIN stampa ON id_file=file_stampa) LEFT JOIN ordine ON id_stampa=stampa_ordine) WHERE id_ordine IS NULL AND timestamp + INTERVAL 1 DAY <= NOW()";
	
	if ($result = mysqli_query($link, $querynoord)) {
		
		if (mysqli_num_rows($result))
			{
			echo '<table style="text-align:center; background-color:#E5E5E5;">
													<tr><th>Titolo</th><th>Data ordine</th>';
			while ($row = mysqli_fetch_row($result)) {
				echo "<form method='get'>
													<input type='hidden' name='fid' value='" . $row['0'] . "' />
													<tr>
				 									<td>" . strip_tags($row['1']) . "</td>
													<td>" . strip_tags($row['2']) . "</td>
													<td><input style='cursor:pointer;' name='action' type='submit' value='Elimina' /></td>
													</tr></form>";
			}
			echo '</table>';

		} else //query vuota
			{
			echo "Nessun file con stampa senza ordine<br /><br /><br />";
		}

	} else {
		echo "failed query";
	}
		?>

			</body>
		</html>