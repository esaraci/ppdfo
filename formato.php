<?php
	session_start();
	
	if (!isset($_SESSION["userid"])) {
		header("location:index.php");
	}

	
	if ($_SESSION["isadmin"]) {
		header("location:index.php");
		//un Admin non puÃ² accedere a questa "interfaccia"
	}

	$stringaformato=$_POST["orientamento"].$_POST["fr"].$_POST["colore"].$_POST["rilegatura"].$_POST["pagmult"];
	$anteprima=$_POST["orientamento"].$_POST["pagmult"].".png";
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
								<h2 id="titleshop">Formato - Anteprima</h2>
								<h2 id="step">2/4</h2>
								<div style="clear:both;"></div>
								<hr />
								<br />
								<div> 
								<center><img src="images/formato/<?php  echo $anteprima; ?>"/>
									<br /><br />
									<form action='creastampa.php' method='post'>
										<input type='hidden' name='file_id' value='<?php  echo $_POST['file_id']; ?>' />
										<input type='hidden' name='id_formato' value='<?php  echo $stringaformato; ?>' />
										<input type='hidden' name='pagine' value='<?php  echo $_POST['pagine']; ?>' />
										<input style='' type='submit' value='Conferma' />
									</form>
								</center>
								</div>
								<br />
								<hr />
							</div>			
					</div>
				</body>
		</html>