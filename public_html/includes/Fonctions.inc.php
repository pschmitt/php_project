<?php
	//fonction prenant en param�tre une requete et l'execute et affichage eventuellement un message d'erreur
  function query($requete)
  { 
    $resultat = mysql_query($requete) or die("$requete : ".mysql_error());
	return($resultat);
  }
 ?>