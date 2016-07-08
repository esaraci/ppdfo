<?php
	session_start();
	include ("dbconnect.php");
	
	if (!isset($_SESSION["userid"])) {
		header("location:index.php");
	}

	
	if ($_GET['action']=='annulla'){
		
		if(isset($_GET['ordine_id'])){
			$querydelete ="DELETE FROM ordine WHERE id_ordine='".$_GET['ordine_id']."'";
			
			if (mysqli_query($link, $querydelete)){
				header("location:ordini.php");
				//non salvo gli ordini cancellati
			}

		}

	}

	
	if ($_GET['action']=='rimborso'){
		
		if(isset($_GET['ordine_id'])){
			$queryrimborso ="UPDATE ordine SET stato='Richiesta rimborso' WHERE id_ordine='".$_GET['ordine_id']."'";
			
			if (mysqli_query($link, $queryrimborso)){
				header("location:ordini.php");
			} else {
				echo "Unexpetcted error <br />";
			}

		}

	}
	
		if ($_GET['action']=='conferma')
		{
		
		if(isset($_GET['ordine_id']))
		{
			$queryconferma ="UPDATE ordine SET stato='Concluso' WHERE id_ordine='".$_GET['ordine_id']."'";
			
			if (mysqli_query($link, $queryconferma))
			{
				header("location:admincp.php");
			} else 
			{
				echo "Unexpetcted error <br />";
				echo mysqli_error($link);
			}

		}

	}
	
	if ($_GET['action']=='Accetta'){
		
		if(isset($_GET['ordine_id'])){
			$queryaccetta ="UPDATE ordine SET stato='Rimborsato' WHERE id_ordine='".$_GET['ordine_id']."'";
			
			if (mysqli_query($link, $queryaccetta)){
				header("location:admincp.php");
			} else {
				echo "Unexpetcted error <br />";
			}

		}

	}
	
	if ($_GET['action']=='Rifiuta'){
		
		if(isset($_GET['ordine_id'])){
			$queryrifiuta ="UPDATE ordine SET stato='Rifiutato' WHERE id_ordine='".$_GET['ordine_id']."'";
			
			if (mysqli_query($link, $queryrifiuta)){
				header("location:admincp.php");
			} else {
				echo "Unexpetcted error <br />";
			}

		}

	}

	?>