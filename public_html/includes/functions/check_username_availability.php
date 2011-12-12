<?php
    // source: http://youhack.me/2010/05/04/username-availability-check-in-registration-form-using-jqueryphp/
    //require_once("includes/functions/mysqli.inc.php");
    $passwd_file = realpath('../../../.login/DB_credentials.php');
    require_once($passwd_file);


    $db = mysqli_connect($db_host, $db_user, $db_password, $db_name)
            or die("Error: ".mysqli_error());
    if (isset($_POST['username'])) {

        $sql = "SELECT username FROM ".$tables['Users']." WHERE (username='"
               .mysqli_real_escape_string($db, $_POST['username'])
               ."')";
    
        if (mysqli_num_rows(mysqli_query($db, $sql)) !=0)
            echo '1'; //If there is a  record match in the Database - Not Available
        else
            echo '0'; //No Record Found - Username is available
    }

?>
