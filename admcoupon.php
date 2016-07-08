<?php
	session_start();
	include ("dbconnect.php");
	
	if (!isset($_SESSION["userid"])) {
		header("location:index.php");
	}

	
	if (!$_SESSION["isadmin"]) {
		header("location:index.php");
	}

	if (isset($_GET['add']))
	{
		$queryaddcoupon = "INSERT INTO coupon (codice_coupon, sconto) VALUES ('".strtoupper($_GET['newCodice'])."','".$_GET['newSconto']."')";
				
				if (!mysqli_query($link, $queryaddcoupon)) 
				{		
					echo "Unexpected error <br />";	
				}
	}
	
	if (isset($_GET['del']))
	{
		$querydelcoupon = "DELETE FROM coupon WHERE id_coupon = '".$_GET['cid']."'";
				
				if (mysqli_query($link, $querydelcoupon)) 
				{
					
				}
				else 
				{					
					echo "Unexpected error <br />";				
				}
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
				<h2>Gestione Coupon</h2>
				<h3>Lista Coupon</h3>
		<?php
			
			$querycoupon = "SELECT * FROM coupon";
				
				if ($result = mysqli_query($link, $querycoupon)) {
		
					if (mysqli_num_rows($result))
					{
					echo '<table style="text-align:center; background-color:#E5E5E5;">
							<tr><th>Codice</th><th>Sconto</th></tr>';
						while ($row = mysqli_fetch_row($result)) 
						{
							echo "<form method='get'>
									<input type='hidden' name='cid' value='" . $row['0'] . "' />
									<tr>
				 					<td>" . strip_tags($row['1']) . "</td>
									<td>" . strip_tags($row['2']) . "%</td>	
									<td><input style='cursor:pointer;' type='submit' name='del' value='Elimina' /></td>
									</tr></form>";		
						}
						echo '</table>';

				} else //query vuota
			{
			echo "Nessun Coupon";
			}

	} 
	else 
	{
		echo "failed query";
		echo $querycoupon;
	}

	?>	
	<br /><br />
	<h3>Aggiungi Coupon</h3>
	<form method="GET">
	<table style="text-align:center; background-color:#E5E5E5;">
		<tr><td>Codice</td><td ><input style="text-transform:uppercase;" maxlength="16" name="newCodice" type="text" required /></td></tr>
		<tr><td>Sconto (%)</td><td><input pattern="[0-9]{1,2}" maxlength="2" name="newSconto" type="text" required /></td></tr>
	</table>
	<input type="submit" name="add" value="Aggiungi" />
	</form>	
	

			</body>
		</html>