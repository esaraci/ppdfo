<?php
include("dbconnect.php");


if (isset($_POST['uid']))
{
	$queryupdate="UPDATE utente SET username='".$_POST['username']."', admin='".$_POST['admin']."', email='".$_POST['email']."', password='".$_POST['password']."',soldi_spesi='".$_POST['soldi_spesi']."',tot_pagine_stampate='".$_POST['tot_pagine_stampate']."' WHERE id='".$_POST['uid']."'";
		
		if (mysqli_query($link, $queryupdate))
		{
			header("location:admutenti.php");
		}
}
?>