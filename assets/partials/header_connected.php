<!-- Header du site pour les gens connectés -->
<head>
    <link href="assets/css/headerStyle.css" rel="stylesheet"> <!-- On link le lien du fichier css propre au header -->
</head>

<header>

    <nav>

        <!-- Logo du site -->
        <ul id="logo">
            <li><a href="index.php"> logo </a></li>
        </ul>

        <!-- Navigation entre les pages du site -->
        <ul id="navigation">
            <li class="navContent"><a href="index.php?page=categories&action=list">Catégories</a></li> <!-- Lien vers la page des catégories -->
            <li class="navContent"><a href="index.php?page=products&action=list">Produits</a></li> <!-- Lien vers la page des produits -->
            <li class="navContent"><a class="titleNavConnected" href="index.php?page=profil">Profil</a></li> <!-- Lien pour se deconnecter -->
            <li class="navLogout"><a class="titleNavConnected" href="index.php?page=logout">Déconnexion</a></li> <!-- Lien pour se deconnecter -->
            <li class="navBurger"><img src="assets/images/pictos/picto-burger.svg"></li>
        </ul>

    </nav>

</header>