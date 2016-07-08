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

//get stampa info from stampa where file_id == $_GET['file_id']
//ottieni formato per capire prezzo totale

if (isset($_POST['code']))
{
	$getcoupon = "SELECT sconto FROM coupon WHERE codice_coupon='" . $_POST['code'] . "'";
		
		if ($result = mysqli_query($link, $getcoupon))
		{
			$row = mysqli_fetch_array($result);
			$sconto=$row[0];
		} 
}



$getriepilogo = "SELECT title,pagine,id_stampa,formato_stampa,pagine_finali
				 
				 FROM 
				 
				 files JOIN stampa 
				 		
				 		ON id_file = file_stampa
								
				WHERE id_file='" . $_POST['file_id'] . "'";
				

if ($result = mysqli_query($link, $getriepilogo)) 

{
		$row = mysqli_fetch_array($result);
		
		$id_stampa=$row['id_stampa'];
		$titolo=$row['title'];
		$formato=$row['formato'];
		$pagineiniz=$row['pagine'];
		$paginefin=$row['pagine_finali'];
		
		if (substr($formato,2)==1)
		{
			$prezzo=$paginefin*0.08;
		}
		else 
		{
			$prezzo = $paginefin*0.04;
		}
		
		if (isset($sconto))
		{
			$prezzo=round($prezzo - ($prezzo/100*$sconto),2);			
		}
		
		//coupon
						
}

else
	{
		echo "Unexpected error <br />";
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
									
									<a href="shop.php">
										<div class="navbarbutton">
											<div class="navtext"  style="color:#F2DA29;">SHOP</div>
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
								
								<h2 id="titleshop">Riepilogo e pagamento</h2>
								<h2 id="step">4/4</h2>
								<div style="clear:both;"></div>
								<hr />
								<br />
								
								<div style="float:left"> 
									Ecco il tuo ordine:<br /><br />

									<span style="color:#F2DA29;">Titolo PDF: </span><?php echo $titolo; ?><br />				
									<span style="color:#F2DA29;">Pagine iniziali: </span><?php echo $pagineiniz; ?><br />
									<span style="color:#F2DA29;">Pagine finali: </span><?php echo $paginefin; ?><br />
									<?php if (isset($sconto)) echo "<span style='color:#F2DA29;'>Sconto coupon: </span>".$sconto."%<br />" ?>
									<hr />
									<span style="color:#F2DA29;">Prezzo: </span><?php echo $prezzo; ?> &euro;<br />
									<br /><br />
								</div>
										
									<div style="clear:both;"></div>							
								<br />
								<hr />
								
								<div style="float:left;">
									Inserisci il codice:<br />
									<form action="stampa4.php" method="post">
									<input style="text-transform:uppercase;" type="text" maxlength="16" name="code" placeholder="B4S1D1D4T1" />
									<input type="hidden" name="file_id" value="<?php echo $_POST['file_id']; ?>" />																		<input type="hidden" name="indirizzo" value="<?php echo $_POST['sel_ind']; ?>" />
									<input type="submit" value="Applica" />
									</form>
								</div>
								<div style="float:right;">
									Effettua il pagamento con PayPal:<br />
									<form action="creaordine.php" method="post">
									<input type="hidden" name="coupon" value="<?php echo $_POST['code']; ?>" />
									<input type="hidden" name="id_stampa" value="<?php echo $id_stampa; ?>" />																		<input type="hidden" name="sel_ind" value="<?php echo $_POST['sel_ind']; ?>" />
									<input type="hidden" name="prezzo" value="<?php echo $prezzo; ?>" />
									<input type="email" required="Inserisci un'indirizzo email." name="paypal" placeholder="nome@esempio.it" />
									<input type="submit" value="Procedi" />
									</form>
								</div>						
								<div style="clear:both;"></div>
							</div>			
					</div>
					
				</body>
			
		</html>		
			