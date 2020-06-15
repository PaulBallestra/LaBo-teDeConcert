<!-- Accroche de la page avec le nom de la salle -->
<h1 class="pageTitle">
    <?= $product['name'] ?> - <?= $product['town'] ?>
</h1>

<!-- Contenu de la page d'un produit unique -->
<section class="contentUniqueProduct">

    <!-- Div qui contiendra le carrousel des images du produit unique -->
    <div class="imagesUniqueProduct">
        <img src="assets/images/backgroundLA.jpg" alt="">
    </div>

    <div class="infosUniqueProduct">

        <!-- Affichage du prix du produit -->
        <div class="valueInfosProduct">
            <h3 class="h3infosUniqueProduct"> Prix : </h3>
            <h3 class="h3infosUniqueProduct"> <?= $product['price'] ?>€ </h3>
        </div>

        <!-- Affichage de l'adresse du produit -->
        <div class="valueInfosProduct">
            <h3 class="h3infosUniqueProduct"> Adresse : </h3>
            <h3 class="h3valueUniqueProduct"> <?= $productAddress['number'] ?> <?= $productAddress['street'] ?> </h3>
        </div>

        <!-- Affichage de la ville et du code postal du produit -->
        <div class="valueInfosProduct">
            <h3 class="h3infosUniqueProduct"> Ville : </h3>
            <h3 class="h3valueUniqueProduct"> <?= $productAddress['town'] ?> - <?= $productAddress['postal_code'] ?></h3>
        </div>

        <!-- Affichage du pays du produit -->
        <div class="valueInfosProduct">
            <h3 class="h3infosUniqueProduct"> Pays : </h3>
            <h3 class="h3valueUniqueProduct"> <?= $productAddress['country'] ?> </h3>
        </div>

        <!-- Affichage de la description du produit -->
        <div class="valueInfosProduct">
            <h3 class="h3infosUniqueProduct"> Description : </h3>
            <h3 class="h3valueUniqueProduct"> <?= $product['description'] ?> </h3>
        </div>

        <!-- Affichage du bouton d'ajout au panier -->
        <section class="sectionButtonaddCartUpdateProfil">
            <button type="submit" class="btnSubmit"> Ajouter au panier </button>
        </section>

    </div>

</section>