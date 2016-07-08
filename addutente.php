<?php

include("dbconnect.php");


$checkuniquequery = "SELECT email,username FROM utente WHERE email='".mysqli_real_escape_string($link, $_GET['newEmail'])."' OR username='".mysqli_real_escape_string($link, $_GET['newUsername'])."'";

			if ($checkunique=mysqli_query($link, $checkuniquequery))
			{
				if(mysqli_num_rows($checkunique)) //Se la query NON è vuota
				{
					header("location:admutenti.php?error=1");
				}
				else 
				{
					$queryinsert ="INSERT INTO utente (email,username,password) VALUES ('".$_GET['newEmail']."','".$_GET['newUsername']."','".$_GET['newPassword']."')";
					
					if (mysqli_query($link, $queryinsert))
					{
						header("location:admutenti.php");
					}		
				}
			}
			
			
?>