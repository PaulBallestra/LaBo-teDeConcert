<!-- Dashboard de l'administrateur -->
<section class="mainAccroche">
    <h1 class="pageTitle"> Dashboard </h1>
</section>

<!-- Affichages des card avec les infos du site (Nombre de catégories, Produits, Users, Commandes) -->
<section class="dashboardCards">

    <!-- Carte des catégories -->
    <a href="index.php?page=categories&action=list">
        <div class="dashboard-card">
            <h1 class="numberOf-card"> <?= $numberOfCategories ?> </h1>
            <h2 class="titleOf-card"> Catégories </h2>
        </div>
    </a>

    <a href="index.php?page=users&action=list">
        <!-- Carte des users -->
        <div class="dashboard-card">
            <h1 class="numberOf-card"> <?= $numberOfUsers ?> </h1>
            <h2 class="titleOf-card"> Utilisateurs </h2>
        </div>
    </a>

    <a href="index.php?page=products&action=list">
        <!-- Carte des produits -->
        <div class="dashboard-card">
            <h1 class="numberOf-card"> <?= $numberOfProducts ?> </h1>
            <h2 class="titleOf-card"> Produits </h2>
        </div>
    </a>

</section>