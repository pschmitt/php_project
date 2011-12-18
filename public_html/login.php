<h2>Login</h2>

<?php
    require_once("includes/functions/mysqli.inc.php");
    require_once("includes/functions/queries.inc.php");
    
    function check_login($username, $pass) {
        if (!isset($GLOBALS['tables']))
            die("Couldn't acces tables array !");
        $tables = $GLOBALS['tables'];
        $db = db_con();
        
        $sql = "SELECT password
                FROM ".$tables['Users']." 
                WHERE username='".mysqli_real_escape_string($db, $username)."'";

        $res = query($db, $sql);
        $user = mysqli_fetch_assoc($res);
        mysqli_free_result($res);
        if ($user['password'] === sha1($pass)) {
            printf("Welcome, %s !", $username);
            // TODO start/resume session  
        } else
            printf("Wrong username or password !");
        mysqli_close($db);
    }

    if (isset($_POST['login'],  $_POST['passwd'])) 
        check_login($_POST['login'], $_POST['passwd']);
?>

