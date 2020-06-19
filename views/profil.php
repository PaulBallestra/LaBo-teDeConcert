<section>

    <div class="divContentProfilPage">

        <!-- Partie gauche de la page 'Profil' -->
        <div class="divProfilContent">

            <div class="divProfilTitle">
                <h1 class="pageTitle"> Profil </h1>
            </div>

            <div class="divInfosContent">

                <!-- Affichage des infos l'user -->
                <h2> <?= $_SESSION['user']['firstname'] . ' ' . $_SESSION['user']['lastname'] ?> <?php if($_SESSION['user']['is_admin'] == 1)  echo '(Admin)'; ?> </h2>
                <h3> <?= $_SESSION['user']['email'] ?> </h3>
                <h3> <?= !empty($_SESSION['user']['phone']) ? $_SESSION['user']['phone'] : 'Aucun numéro de téléphone.' ?> </h3>
                <h3> <?= !empty($_SESSION['user']['address']) ? $_SESSION['user']['address']['number'] . ' ' . $_SESSION['user']['address']['street'] : 'Aucune adresse.' ?> </h3>
                <?php if(!empty($_SESSION['user']['address'])): //si il a une adresse on l'affiche entièrement ?>
                    <h3> <?= $_SESSION['user']['address']['town'] . ', ' . $_SESSION['user']['address']['postal_code'] ?> </h3>
                    <h3> <?= $_SESSION['user']['address']['country'] ?> </h3>
                <?php endif; ?>

            </div>

            <!-- Div des boutons de modification d'un compte et suppresion -->
            <div class="divButtonsInfos">
                <a href="index.php?page=profile&action=update&id=<?=$_SESSION['user']['id']?>"><input type="submit" value="Modifier" class="btnSubmit"></a> <!-- BtnModification des informations -->
                <a href="index.php?page=profile&action=delete&id=<?=$_SESSION['user']['id']?>"><input type="submit" value="Supprimer" class="btnSubmit"></a> <!-- BtnSuppresion du compte -->
            </div>

        </div>

        <!-- Separateur qui va separer les 2 parties de la page -->
        <div class="divSeparateurHR">
            <hr>
        </div>

        <!-- Partie droite de la page 'Panier' -->
        <div class="divPanierContent">

            <div class="divPanierTitle">
                <h1 class="pageTitle"> Panier (<?= $numberProductsInCart ?>) </h1>
            </div>

            <div class="divInfosContent">

                <?php if(empty($_SESSION['user']['cart'])): //si son panier est vide on lui indique ?>
                    <h2 style="color: white;"> Vous n'avez pas de produit. </h2>
                <?php else: //sinon ?>

                    <?php $i = 0; $totalPrice = 0; for($i = 0; $i < $numberProductsInCart; $i++) : ?>

                        <div class="cartProduct product-<?= $_SESSION['user']['cart'][$i]['id'] ?>>">

                            <div class="cartProductCrossInfos">
                                <!-- Style de la croix du produit -->
                                <a class="cartProductCross" href="index.php?page=profile&action=delete_product&id=<?= $_SESSION['user']['cart'][$i]['id'] ?>"><img src="assets/images/pictos/picto-cross.svg" alt="Croix de suppresion du produit <?= $_SESSION['user']['cart'][$i]['name'] ?>"></a>
                                <!-- Style des infos du produit -->
                                <div class="infosCartProduct infosProduct-number">
                                    <h3> <?= $_SESSION['user']['cart'][$i]['name'] ?> </h3>
                                    <h3> <?= $_SESSION['user']['cart'][$i]['addressNumber'] . ' ' . $_SESSION['user']['cart'][$i]['addressStreet'] . ', ' . $_SESSION['user']['cart'][$i]['addressTown'] ?> </h3>
                                </div>
                            </div>

                            <h2> <?= $_SESSION['user']['cart'][$i]['price'] . '€' ?>  </h2>

                        </div>

                    <?php $totalPrice += $_SESSION['user']['cart'][$i]['price'];  endfor; ?>

                    <div class="cartTotal">

                            <h3> Total </h3>
                            <h3> <?= $totalPrice . '€' ?> </h3>
                    </div>

                <?php endif; ?>

            </div>

            <div class="divPanierBas">

                <?php if(!empty($_SESSION['user']['cart'])) : ?>
                    <div class="divPanierArticles">
                        <!-- Div des boutons de paiement et suppresion du panier -->
                        <div class="divButtonsInfos">
                            <a href="index.php?page=profile&action=pay_cart"><input type="submit" value="Payer" class="btnSubmit"></a> <!-- Btn de paiement du panier -->
                            <a href="index.php?page=profile&action=delete_cart"><input type="submit" value="Supprimer" class="btnSubmit"></a> <!-- btn de suppresion complet du panier -->
                        </div>
                    </div>
                <?php else: ?>

                    <div class="divPanierArticles">
                        <!-- Div des boutons des catégories et produits si le panier est vide -->
                        <div class="divButtonsInfos">
                            <a href="index.php?page=categories&action=list"><input type="submit" value="Voir Catégories" class="btnSubmit"></a>
                            <a href="index.php?page=products&action=list"><input type="submit" value="Voir Produits" class="btnSubmit"></a>
                        </div>
                    </div>

                <?php endif; ?>

                <p> <a href="">Anciennes commandes</a></p>

            </div>

        </div>

    </div>

</section>