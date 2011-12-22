<header>
    <?php if (!isset($_SESSION['logged_in'])) { ?>
    <form id="login_form" name="login_form" method="post" action="<?php echo $_SERVER['PHP_SELF']."?p=login" ?>"> <!-- action="javascript:alert('success!');"--> 
    <img src="images/se-connecter.png" alt="Se connecter" />
        <p>
            <label>Login
                <input type="text" name="login" id="login" value="<?php echo isset($_POST['login']) ? $_POST['login'] : null ?>" required />
            </label>
            <br />
            <label>Mot de passe
                <input type="password" name="passwd" id="passwd" required />
            </label>
            <br />
			<a id="submit" onclick="$(this).parents('form:first').submit();" href="#">
                Connexion
            </a>
            |
            <a href="<?php echo $_SERVER['PHP_SELF'].'?p=register'; ?>">
                S'enregister
            </a>
        </p>
    </form>
    <script>
        // Permet de soumettre le formulaire en appuyant sur la touche Entrée
        $("#login_form input").keypress(function(e) {
            if (e.keyCode == 13)
                $(this).closest("form").submit();
        });
    </script>
    
    <?php } else {  ?>
        <p id="hello">
            Hi, <?php echo $_SESSION['username']; ?> !
            <br/>
            <a href="<?php echo $_SERVER['PHP_SELF']."?p=logout"; ?>">
                Logout
            </a>
			| 
			<a href="<?php echo $_SERVER['PHP_SELF']."?p=update"; ?>">
				Profil
			</a>
            | <a href="<?php echo $_SERVER['PHP_SELF']."?p=favs"; ?>">
                <img src="images/star.png" alt="bookmarks" title="bookmarks" height="16" width="16" />
              </a>
		</p>
    <?php } ?>
    <div class="logo">
        <h1>
            <a title="JeNeSaisPasCuisiner.com" href="<?php echo $_SERVER['PHP_SELF'].'?p=home'; ?>"/>JeNeSaisPasCuisiner.com</a>
        </h1>
    </div>
    <!-- end logo -->

    <nav id="mainnav">
        <ul class="menu">
            <!-- premier niveau -->
            <li><a href="<?php echo $_SERVER['PHP_SELF'].'?p=home'; ?>">Accueil</a></li>
			
			<li><a href="<?php echo $_SERVER['PHP_SELF']; ?>">Ingrédients</a>
				<?php
					//include("thesaurus.inc.php");
				?>
			</li>
			
            <li><a href="<?php echo $_SERVER['PHP_SELF'].'?p=search'; ?>">Recherche avancée</a></li>
        </ul>
    </nav>
    <!-- end mainnav -->

</header>
<!-- end header -->

