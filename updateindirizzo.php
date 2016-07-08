<?php

//check session
session_start();

	include("dbconnect.php");

	if (!isset($_SESSION["userid"]))
	{
		header("location:index.php");
	}
	
	if ($_SESSION["userid"]!=$_GET["uid"])
	{
		//non è lo stesso utente
		header("location:index.php");
	}
	
	if ($_GET["action"]=="delete")
	{
			
		$querycancella="DELETE FROM indirizzo WHERE id_indirizzo=".$_GET['id']." AND link_utente=".$_GET['uid'];
		
		if (mysqli_query($link, $querycancella))
		{
			header("location:indirizzi.php");
		}
		else 
		{
			echo "Unexpetcted error <br />";		
		}
		
	}
	
	if ($_GET["action"]=="add")
	{
		$queryaggiungi="INSERT INTO indirizzo (id_indirizzo, link_utente, nome, cognome, via, citta, regione, CAP) VALUES (NULL, '".mysqli_real_escape_string($link,$_GET['uid'])."','".mysqli_real_escape_string($link,ucfirst($_GET['newNome']))."', '".mysqli_real_escape_string($link,ucfirst($_GET['newCognome']))."', '".mysqli_real_escape_string($link,ucfirst($_GET['newVia']))."', '".mysqli_real_escape_string($link,ucfirst($_GET['newCitta']))."', '".mysqli_real_escape_string($link,ucfirst($_GET['newRegione']))."', '".mysqli_real_escape_string($link,ucfirst($_GET['newCAP']))."')";
		
		if (mysqli_query($link, $queryaggiungi))
		{
			header("location:indirizzi.php");
		}
		else
		{
			//TRIGGER, NON PIù DI 3 INDIRIZZI.
			header("location:indirizzi.php?error=1");		
		}
		
	}
	
	
	
		
?>