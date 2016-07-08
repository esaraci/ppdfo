<?php

/*	
 *	$_SESSION["userid"]
 * 	$_SESSION["isadmin"]
 */

	session_start();
	
	include("dbconnect.php");
	
	if (isset($_SESSION["userid"]))
	{
		if ($_SESSION["isadmin"]==1) 
						{
							header("location:admincp.php");
						}
						else
						{
							header("location:usercp.php");
						} //admincp.php - usercp.php
	} 
	
	
	if ($_POST["tastologin"])
	{

		if (!$_POST["user"] OR !$_POST["pwd"])
		{
	
			$errLoginemptyfield=1; //debug
		}
		else 
		{ //query per il login
			 		
			$getusername = "SELECT password,id,admin FROM utente WHERE username ='".$_POST['user']."'";
			if ($utenti=mysqli_query($link, $getusername));
			{
				if($nums=mysqli_num_rows($utenti)) //Se la query NON è vuota
				{
					$row=mysqli_fetch_array($utenti);
					if ($row["password"]==$_POST["pwd"])
					{
						$_SESSION["isadmin"]=$row["admin"];
						$_SESSION["userid"]=$row["id"];
						
						if ($_SESSION["isadmin"]==1) 
						{
							header("location:admincp.php");
						}
						else
						{
							header("location:usercp.php");
						}
					}
			  		else 
					{
						$errWrongpassword=1; //unico errore
					}
				}
				else 
				{
					$errUsernotfound=1;	//debug
				}
				
				
			}
		}
	}
?>

	<!DOCTYPE html>
		<html>
			<head>
				<link href='http://fonts.googleapis.com/css?family=Itim' rel='stylesheet' type='text/css'>
				<link href='http://fonts.googleapis.com/css?family=Poppins' rel='stylesheet' type='text/css'>
				<link rel="stylesheet" type="text/css" href="styles.css">
				<title>Login - Print PDFs Online</title>
						
			</head>
			<body>
				
				<div id="container">
									
						<div id="navbarcontainer">
							
							<div class="fixedwidth">
							
								<div id="navbar">
									<div id="navbarlogo">
									Print PDFs Online
									</div>
								</div>
								
							</div>
							
						</div>
					
						<div id="headercontainer">
							
							<div class="fixedwidth">
								
								<div id="header">
									
									<div id="headertext">
										You must login to proceed.
										<hr />
									</div>
								</div>
							</div>
							
						</div>
					
											
						<div class="fixedwidth">
						
							<div id="loginbox">
								<form id="login" method="post">
									<input id="logintxtb" type="text" placeholder="Username" name="user" class="textbox" /><br />
									<input id="passwordtxtb" type="password" placeholder="Password" name="pwd" class="textbox" /><br />
									<input id="accedibtn" type="submit" name="tastologin" value="Log In" /><br />
									<?php
										if ($errWrongpassword OR $errUsernotfound OR $errLoginemptyfield)
										{
											echo '<img id="errorimg" src="images/loginerror.png" /><p id="errormessage">Combinazione Username e Password inesistente!</p>';
										}
									?>
								</form>
							</div>
						
						</div>
						
				
						
				</div>
					
				
			</body>
			
		</html>		
		


