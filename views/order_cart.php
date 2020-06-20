<section class="mainAccroche">
    <h1 class="pageTitle"> Paiement </h1>
    <h3> Récapitulatif </h3>
</section>

<div class="divInfosContentRecap">

    <?php $totalPrice = 0; for($i = 0; $i < $numberProductsInCart; $i++) : ?>

        <div class="cartProduct product-<?= $_SESSION['user']['cart'][$i]['id'] ?>>">
            <!-- Style des infos du produit -->
            <div class="infosCartProduct infosProduct-number">
                <h3> <?= $_SESSION['user']['cart'][$i]['name'] ?> </h3>
                <h3> <?= $_SESSION['user']['cart'][$i]['addressNumber'] . ' ' . $_SESSION['user']['cart'][$i]['addressStreet'] . ', ' . $_SESSION['user']['cart'][$i]['addressTown'] ?> </h3>
            </div>

            <div class="" style="display: flex; flex-direction: row; justify-content: center;">
                <h3 style="color: white;"> <?= $_SESSION['user']['cart'][$i]['quantity'] ?> </h3>

                <h2> <?= $_SESSION['user']['cart'][$i]['price'] . '€' ?>  </h2>
            </div>


        </div>

        <?php
            $totalPrice += $_SESSION['user']['cart'][$i]['price']; //maj du prix total
            $_SESSION['user']['cart']['price'] = $totalPrice; //on stocke le prix total en session
        endfor; ?>

    <div class="cartTotal">

        <h3> Total </h3>
        <h3> <?= $totalPrice . '€' ?> </h3>

    </div>

</div>

<section class="mainAccroche">
    <h3> Informations Bancaires </h3>
</section>


<section class="mainFormulaire">

    <section class="emptySection"></section>

    <section class="sectionFormulaire">

        <!-- Formulaire d'inscription -->
        <form action="index.php?page=profile&action=paid&id=<?= $_SESSION['user']['id'] ?>" method="post">

            <section class="sectionInput">
                <!-- Numéro de carte de l'user -->
                <label for="cardNumber" class="labelName"> Numéro de carte * </label>
                <input id="cardNumber" type="text" name="cardNumber" class="inputForm" value="<?= isset($_SESSION['old_inputs']) ? $_SESSION['old_inputs']['cardNumber'] : '' ?>" required>
            </section>

            <section class="sectionInput">
                <!-- Date d'expiration de la carte de l'user -->
                <label for="cardExpiration" class="labelName"> Expire en * </label>
                <input id="cardExpiration" type="text" name="cardExpiration" class="inputForm" value="<?= isset($_SESSION['old_inputs']) ? $_SESSION['old_inputs']['cardExpiration'] : '' ?>" required>
            </section>

            <section class="sectionInput">
                <!-- Cryptogramme de la carte de l'user -->
                <label for="cardCrypto" class="labelName"> Cryptogramme * </label>
                <input id="cardCrypto" type="number" name="cardCrypto" class="inputForm" value="<?= isset($_SESSION['old_inputs']) ? $_SESSION['old_inputs']['cardCrypto'] : '' ?>" required>
            </section>

            <p> * : Champs obligatoires. </p>

            <!-- Bouton submit qui va envoyer le formulaire -->
            <button type="submit" class="btnSubmit"> Valider </button>

        </form>

    </section>

    <section class="emptySection"></section>

</section>