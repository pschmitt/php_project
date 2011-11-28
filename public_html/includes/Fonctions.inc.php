<?php
	//fonction prenant en paramètre une requete et l'execute et affichage eventueööement un message d'erreur
  function query($requete)
  { 
    $resultat = mysql_query($requete) or die("$requete : ".mysql_error());
	return($resultat);
  }
 ?>