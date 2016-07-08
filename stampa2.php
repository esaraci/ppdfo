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

$queryfileinfo="SELECT title, pagine FROM files WHERE id_file='".$_GET['file_id']."'";
			
			if ($result = mysqli_query($link, $queryfileinfo))
			{
		
				$row = mysqli_fetch_array($result);			
			}
			else 
			{
				echo "unexpected error";
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
								
								<h2 id="titleshop">Formato</h2>
								<h2 id="step">2/4</h2>
								<div style="clear:both;"></div>
								<hr />
								<div> 
								File: <?php echo $row['title']; ?><br />
								Pagine: <?php echo $row['pagine']; ?><br />
								<hr />
									
								</div>
								<br />
								<div style="clear:both;"></div>
								<form action="formato.php" method="post">
									<div style="width:175px;float:left;"><p style="margin:0 ;color:#F2DA29;">Orientamento:</p>
									<input type="radio" value="0" name="orientamento" checked="checked">Verticale<br />
									<input type="radio" value="1" name="orientamento">Orizzontale<br /><br /></div>
									
									<div style="width:175px;float:left;"><p style="margin:0; color:#F2DA29;">Fronte/Retro:</p>
									<input type="radio" value="0" name="fr" checked="checked">No<br />
									<input type="radio" value="1" name="fr">S&igrave;<br /><br /></div>
									
									
									<div style="width:175px;float:left;"><p style="margin:0; color:#F2DA29;">Colore:</p>
									<input type="radio" value="0" name="colore" checked="checked">Bianco e nero<br />
									<input type="radio" value="1" name="colore">Colori<br /><br /></div>
									
									<p style=" margin:0; color:#F2DA29;">Rilegatura:</p>
									<input type="radio" value="0" name="rilegatura" checked="checked">No<br />
									<input type="radio" value="1" name="rilegatura">Lato corto<br />
									<input type="radio" value="2" name="rilegatura">Lato Lungo<br /><br />
									
									<p style=" margin:0; color:#F2DA29;">Pi&ugrave; pagine per foglio:</p>
									<input type="radio" value="0" name="pagmult" checked="checked">No<br />
									<input type="radio" value="1" name="pagmult">1 colonna X 2 righe (*) <br />
									<input type="radio" value="2" name="pagmult">1 colonna X 3 righe (*) <br />
									<input type="radio" value="3" name="pagmult">2 colonne X 2 righe (*) <br />
									<input type="radio" value="4" name="pagmult">2 colonna X 3 righe (*) <br />
									*<span style="font-size:0.7em;">Se l'orientamento scelto &egrave; "Orizzontale" invertite il senso di righe e colonne.</span>
									<br /><br />
									<input type='hidden' name='file_id' value='<?php echo $_GET['file_id'];?>' />
									<input type='hidden' name='pagine' value='<?php echo $row['pagine'];?>' />
									<center><input type="submit" value="Anteprima" /><br /><br />
										
										
									</center>
									
								</form>
								<hr />
								
								<div style="clear:both;"></div>
							</div>			
					</div>
					
				</body>
			
		</html>		
			