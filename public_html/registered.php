<h2>Enregistrement</h2>

<?php
    require_once("functions/mysqli.inc.php");
    require_once("functions/queries.inc.php");

    if (isset($_POST['username'], $_POST['password'])) {
        printf("Bienvenue sur JeNeSaisPasCuisiner.com, ".$_POST['username'].".\n<br/>\n
                Vous pouvez dorénavant utiliser votre panier.\n");
        
		// enregistrement des données saisies.
		$db = db_con();

        $columns = get_col_names($db, $tables['Users']);

        // vérifier si le login est deja present dans la base. Si oui, inviter l'user à changer de login. Sinon: insérer.
		$sql = "SELECT username FROM ".$tables['Users']." WHERE (username='".$_POST['username']."')";
		$result = query($db, $sql);

		if (mysqli_num_rows($result) == 0) {
            mysqli_free_result($result);
			// login pas encore présent donc insertion
			$sql = "INSERT INTO ".$tables['Users']." (";
            $values = " VALUES (";
			foreach($_POST as $column => $value) {
				if (!empty($value) && in_array($column, $columns) && strcmp($value, "default") != 0) {
    			    $sql .= $column.", ";
                    if (strcmp($column, "password") == 0)
                        $values .= "SHA1('".mysqli_real_escape_string($db, $value)."'), ";
                    else
                        $values .= "'".mysqli_real_escape_string($db, $value)."', ";
                }
			}
            // remove trailing chars
            $values = substr($values, 0, -2);
			$sql = substr($sql, 0, - 2).")".$values.")";
		    
			query($db, $sql);
            
            $_SESSION['user_id'] = mysqli_insert_id($db);
            $_SESSION['username'] = $_POST['username'];
            $_SESSION['logged_in'] = true;
            
            if(isset($_SESSION['favs'])) {
                $sql = bulk_add_to_bookmarks($_SESSION['user_id'], $_SESSION['favs']);
                echo $sql;
                query($db, $sql);
            }

			mysqli_close($db);
			
		}		
		else {
			echo "Ce login est deja present, veuillez en choisir un autre.";
		}
     } else {
        printf("<p>\n\tWoops, quelque chose n'a pas fonctionné\n<br />\n<br />\n");
        printf("\t<a href=\"".$_SERVER['PHP_SELF']."?p=home\">Retourner à l'accueil</a>\n<br />\n");
        printf("\t<a href=\"".$_SERVER['PHP_SELF']."?p=register\">S'enregister à nouveau</a>\n</p>");
     }
?>
