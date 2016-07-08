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
	
	//validate field inputs
	if ((strlen($_GET["newusername"])==0) OR (strlen($_GET["newpassword"])==0) OR (strlen($_GET["newemail"])==0))
	{
		errore("1"); //campo vuoto
		die();
	}
	
	
	if(!(filter_var($_GET["newemail"], FILTER_VALIDATE_EMAIL))) 
	{
		errore("2"); //formato mail invalido
		die();
	}
	
	function errore($errorcode)
	{
		header("location:usercp.php?error=$errorcode&edit=Modifica");
	}

//query

	 //include ("dbconnect.php")
				 		
		$checkuniquequery = "SELECT email,username FROM utente WHERE (email='".mysqli_real_escape_string($link, $_GET['newemail'])."' OR username='".mysqli_real_escape_string($link, $_GET['newusername'])."') AND (id !=".$_SESSION['userid'].")";
			
			
				
			if ($checkunique=mysqli_query($link, $checkuniquequery))
			{
				if(mysqli_num_rows($checkunique)) //Se la query NON è vuota
				{
					errore("3"); //username o mail già presente
				}
				else 
				{
					$updateuserquery="UPDATE utente SET email='".mysqli_real_escape_string($link,$_GET['newemail'])."',username='".mysqli_real_escape_string($link,$_GET['newusername'])."',password='".mysqli_real_escape_string($link,$_GET['newpassword'])."'
											
											WHERE id='".$_SESSION['userid']."'";
					
					if ($updateuser=mysqli_query($link, $updateuserquery))
					{
						header("location:usercp.php?success=1");
					}
/*					else 
					{
						//echo "query non riuscita";
						//echo $updateuserquery;
					}
*/
				}
			}
/*			else
			{
				//echo "query non riuscita"; debug
				//echo $checkunique;
			}

 */
 
//redirect (with error)
?>
