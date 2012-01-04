<?php
    isset($_POST['recipe_id'], $_POST['user_id']) or die ("Incomplete POST data received");

    session_start();
    if ($_POST['user_id'] != -1) {
        $passwd_file = realpath('../../../.login/DB_credentials.php');
        require_once($passwd_file);

        $db = mysqli_connect($db_host, $db_user, $db_password, $db_name)
            or die("Error: ".mysqli_error());

        function is_bookmarked($user_id, $bookmark_id) {
            if (!isset($GLOBALS['db'], $GLOBALS['tables']))
                die("No DB connection !");
            $db = $GLOBALS['db'];
            $tables = $GLOBALS['tables'];

            return "SELECT * 
                    FROM ".$tables['Carts']." 
                    WHERE id_user='".mysqli_real_escape_string($db, $user_id)."' 
                        AND id_recipe='".mysqli_real_escape_string($db, $bookmark_id)."'"; 
        }
        $sql = is_bookmarked($_POST['user_id'], $_POST['recipe_id']);
        $res = mysqli_query($db, $sql);
        if (mysqli_num_rows($res) == 0)
            echo '1';
        else
            echo '0';
        mysqli_close($db);
    } elseif($_POST['user_id'] == -1) {
         if (isset($_SESSION['favs'])) {
            $bookmarked = false;
            foreach($_SESSION['favs'] as $index => $fav) {
                if ($fav == $_POST['recipe_id'])
                    $bookmarked = true;
            }
            if ($bookmarked)
                echo '0';
            else
                echo '1';
         }
    }
?>
