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
            <li><a href="/Recettes/">Recettes</a>
                <ul class="sub-menu">
                    <!-- 2ème niveau -->
                    <li><a href="/dinde/">Dinde</a>
                        <ul>
                            <!-- 3ème niveau -->
                            <li><a href="/all-dinde/">Toutes les recettes</a>
                                <ul>
                                    <!-- 4ème niveau -->
                                    <li><a href="/all-dinde/">Toutes les recettes</a></li>
                                    <li><a href="/dinde-farcie/">Dinde farcie</a></li>
                                </ul>
                            </li>
                            <li><a href="/dinde-farcie/">Dinde farcie</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li><a href="<?php echo $_SERVER['PHP_SELF'].'?p=search'; ?>">Recherche avancée</a></li>
        </ul>
    </nav>
    <!-- end mainnav -->

</header>
<!-- end header -->

