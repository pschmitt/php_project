<header>
    <form id="login" name="login" method="post" action="">
    <img src="images/se-connecter.png" alt="Se connecter" />
        <p>
            <label>Nom
                <input type="text" name="name" id="name" />
            </label>
            <br />
            <label>Mot de passe
                <input type="text" name="password" id="password" />
            </label>
            <br />
            <a href="">
                Connexion
            </a>
            |
            <a href="<?php echo $_SERVER['PHP_SELF'].'?p=register'; ?>">
                S'enregister
            </a>
        </p>
    </form>
    
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
					include("thesaurus.inc.php");
				?>
			</li>
			
            <li><a href="<?php echo $_SERVER['PHP_SELF'].'?p=search'; ?>">Recherche avancée</a></li>
        </ul>
    </nav>
    <!-- end mainnav -->

</header>
<!-- end header -->

