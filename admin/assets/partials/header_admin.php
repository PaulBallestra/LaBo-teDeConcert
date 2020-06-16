<!-- Header du site pour les admins connectés -->
<head>
    <link href="assets/css/headerStyle.css" rel="stylesheet"> <!-- On link le lien du fichier css propre au header -->
</head>

<header>

    <!-- Checkbox qui sera utilisée pour la version mobile -->
    <input type="checkbox" class="trigger">

    <nav>

        <!-- Logo du site -->
        <ul id="logo">
            <li><a href="../index.php"> logo </a></li>
        </ul>

        <!-- Navigation entre les pages du site -->
        <ul id="navigation">
            <li class="navContent"><a href="index.php?page=categories&action=list">Gestion Catégories</a></li> <!-- Lien vers la page des catégories -->
            <li class="navContent"><a href="index.php?page=products&action=list">Gestion Produits</a></li> <!-- Lien vers la page des produits -->
            <li class="navContent"><a class="titleNavConnected" href="index.php?page=users&action=list">Gestion Profils</a></li> <!-- Lien pour se deconnecter -->
            <li class="navLogout"><a class="titleNavConnected" href="index.php">Dashboard</a></li> <!-- Lien pour se deconnecter -->
            <li class="navBurger"><img src="assets/images/pictos/picto-burger.svg"></li>
            <li class="navCrossBurger"><img src="assets/images/pictos/picto-cross.svg"></li>

        </ul>

    </nav>

</header>