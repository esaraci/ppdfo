

<?php
include("dbconnect.php");

if (isset($_GET['uid'])){
			
			$queryutente = "SELECT * FROM utente WHERE id='".$_GET['uid']."'";
				
				if ($result = mysqli_query($link, $queryutente)) {
		
		if (mysqli_num_rows($result))
			{
			echo '<table style="text-align:center; background-color:#E5E5E5;">
													<tr><th>Username</th><th>Admin</th><th>E-Mail</th><th>Password</th><th>Soldi Spesi</th><th>Pagine Stampate</th></tr>';
			while ($row = mysqli_fetch_row($result)) {
				echo "<form method='post' action='exupdate.php'>
													<input type='hidden' name='uid' value='" . $row['0'] . "' />
													<tr>
				 									<td><input name='username' type='text' pattern='.{2,}' required title='Almeno 2 caratteri' value=" . strip_tags($row['3']) . "></td>
													<td><input name='admin' type='text' min=0 max=1 pattern='{1}' required title='0 = user, 1 = admin' value=" . strip_tags($row['1']) . "></td>
													<td><input name='email' type='email' required value=" . strip_tags($row['2']) . "></td>
													<td><input name='password' pattern='{2,}' required title='Almeno 2 caratteri' value=" . strip_tags($row['4']) . "></td>
													<td><input name='soldi_spesi' pattern='\d+(\.\d{2})?' required value=" . strip_tags($row['5']) . " &euro;></td>
													<td><input name='tot_pagine_stampate' pattern='[0-9]{1,}' required value=" . strip_tags($row['6']) . "></td>
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
	}
	?>