<h2>Login</h2>

<?php
    require_once("functions/mysqli.inc.php");
    require_once("functions/queries.inc.php");
    
    function check_login($username, $pass) {
        if (!isset($GLOBALS['tables']))
            die("Couldn't acces tables array !");
        $tables = $GLOBALS['tables'];
        $db = db_con();
        
        $sql = "SELECT *
                FROM ".$tables['Users']." 
                WHERE username='".mysqli_real_escape_string($db, $username)."'
                      AND password='".sha1($pass)."'";

        $res = query($db, $sql);
        if (mysqli_num_rows($res)) {
            printf("Welcome, %s !", $username);
            // TODO start/resume session
            if(!isset($_SESSION['username']) || $_SESSION['username'] != $username) {
                echo "<br/>BREAKPOINT</br>";
                $old_session_name = session_name($username);
                $_SESSION['username'] = $username;
            }
            /*if (!isset($_SESSION['test']))
                $_SESSION['test'] = 1;
            else
                $_SESSION['test']++;*/
            printf("\n<br/><br/><strong>var:</strong> %d\n<br/><br/>",  $_SESSION['test']);
            print_r($_SESSION);
        } else
            printf("Wrong username or password !\n");
        mysqli_free_result($res);
        mysqli_close($db);
    }

    if (isset($_POST['login'],  $_POST['passwd'])) 
        check_login($_POST['login'], $_POST['passwd']);

    // DEBUG
    if (isset($_GET['logout'])) {
        session_destroy();
    }
    echo session_id();
?>
<p>
    <a href="<?php $_SERVER['PHP_SELF']."&logout"?>">
        LOGOUT
    </a>
</p>
