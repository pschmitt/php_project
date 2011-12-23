<?php

	/**
	*check_username_password verifie si un mot de passe donné est attribué à l'utilisateur connecté.
	*/
	session_start();
    $passwd_file = realpath('../../../.login/DB_credentials.php');
    require_once($passwd_file);

    $db = mysqli_connect($db_host, $db_user, $db_password, $db_name)
            or die("Error: ".mysqli_error());
    if (isset($_SESSION['username'])) {
		echo "\nici connecté ".$_SESSION['username'];
		$sql = "SELECT password FROM ".$tables['Users']." WHERE (username='".$_SESSION['username'].
				"' && password='".SHA1('".mysqli_real_escape_string($db, $value)."')."')";	   
    
        if (mysqli_num_rows(mysqli_query($db, $sql)) !=0)
            echo '1'; //If there is a  record match in the Database - Not Available
        else
            echo '0'; //No Record Found - Username is available
    }
	else
		echo "user pas connecté";

?>
