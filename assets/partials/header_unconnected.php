<!-- Header du site pour les visiteurs -->
<head>
    <link href="assets/css/headerStyle.css" rel="stylesheet"> <!-- On link le lien du fichier css propre au header -->
</head>

<header>

    <!-- Checkbox qui sera utilisée pour la version mobile -->
    <input type="checkbox" class="trigger">

    <nav>

        <!-- Logo du site -->
        <ul id="logo">
            <li><a href="index.php"> logo </a></li>
        </ul>

        <!-- Navigation entre les pages du site -->
        <ul id="navigation">
            <li class="navContent"><a href="index.php?page=categories&action=list">Catégories</a></li> <!-- Lien vers la page des catégories -->
            <li class="navContent"><a href="index.php?page=products&action=list">Produits</a></li> <!-- Lien vers la page des produits -->
            <li class="navContent"><a href="index.php?page=login">Connexion</a></li> <!-- Lien vers la page de connexion -->
            <li class="navInscription"><a href="index.php?page=register">Inscription</a></li> <!-- Lien vers la page d'inscription -->
            <li class="navBurger"><img src="assets/images/pictos/picto-burger.svg"></li>
            <li class="navCrossBurger"><img src="assets/images/pictos/picto-cross.svg"></li>
        </ul>

    </nav>

</header>