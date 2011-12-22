<h2>Login</h2>

<?php
    require_once("functions/mysqli.inc.php");
    require_once("functions/queries.inc.php");
    
    $db = db_con();
    
    function check_login($username, $pass) {
        if (!isset($GLOBALS['tables']))
            die("Couldn't acces tables array !");
        $tables = $GLOBALS['tables'];
        $db = $GLOBALS['db']; 
        $sql = get_uid($username, $pass);
        $res = query($db, $sql);

        if (mysqli_num_rows($res) == 1) {
            printf("Welcome, %s !", $username);
            // TODO start/resume session
            $id = mysqli_fetch_assoc($res);
            $_SESSION['user_id'] = $id['id'];
            $_SESSION['username'] = $username;
            $_SESSION['logged_in'] = true;
            $_SESSION['referer'] = $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
        } else
            printf("Wrong username or password !\n");
        mysqli_free_result($res);
    }

    if (isset($_POST['login'],  $_POST['passwd'])) {
        check_login($_POST['login'], $_POST['passwd']);
    }
    mysqli_close($db);
?>

redirecting to last visited page ...
