<h2>Enregistrement</h2>

<?php
	$passwd_file = realpath('../.login/DB_credentials.php');
    require "$passwd_file";
	require_once "Fonctions.inc.php"; 
    function create_db() {
        
    }

    function submit() {
        
    }
    
    if (isset($_POST['username'], $_POST['password'])) {
        printf("Bienvenur sur JeNeSaisPasCuisiner.com, ".$_POST['username'].".\n<br/>\n
                You can now save your favorite recipes.
               ");
		//enregistrer les données saisies.
		
		$connect = mysql_connect($db_host, $db_user, $db_password) or die("Erreur de connexion au serveur: ".mysql_error());
		mysql_select_db($db_name) or die("Impossible de sélectionner la base :". $db_name);
		//verifier si le login est deja present dans la base si oui inviter l'user à changer de login sinon insérer
		$query = "SELECT username FROM user WHERE (username='".$_POST['username']."')";
		$result = query($query);
		if(mysql_num_rows($result) == 0){
			//login pas encore présent donc l'inserer
			$insert = "INSERT INTO user (";
			$valeur = "VALUES (";
			foreach($_POST as $cle=>$value){
				if(isset($_POST[$cle]) && !empty($_POST[$cle])){
					$insert .= $cle.", ";
					$valeur .="'";
					$valeur .= $value."'".", ";
				}
			}
			$insert = substr($insert, 0, strlen($insert) - 2);
			$valeur = substr($valeur, 0, strlen($valeur) - 2);
			$insert .= ")";
			$valeur .= ")";
		
			query($insert);
			mysql_close($connect);
			
		}
		else{
			//ce login est deja present, veuillez changer de login
			echo "ce login est deja present, veuillez changer de login";
		}
		
			
     } else {
        printf("<p>\n\tWoops, quelque chose n'a pas fonctionné\n<br />\n<br />\n");
        printf("\t<a href=\"".$_SERVER['PHP_SELF']."?p=home\">Retourner à l'accueil</a>\n<br />\n");
        printf("\t<a href=\"".$_SERVER['PHP_SELF']."?p=register\">S'enregister à nouveau</a>\n</p>");
     }
?>
