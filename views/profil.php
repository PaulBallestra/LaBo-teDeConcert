<section>

    <div class="divContentProfilPage">

        <!-- Partie gauche de la page 'Profil' -->
        <div class="divProfilContent">

            <div class="divProfilTitle">
                <h1 class="pageTitle"> Profil </h1>
            </div>

            <div class="divInfosContent">

                <!-- Affichage des infos l'user -->
                <h2> <?= $_SESSION['user']['firstname'] . ' ' . $_SESSION['user']['lastname'] ?> </h2>
                <h3> <?= $_SESSION['user']['email'] ?> </h3>
                <h3> <?= !empty($_SESSION['user']['phone']) ? $_SESSION['user']['phone'] : 'Aucun numéro de téléphone.' ?> </h3>
                <h3> <?= !empty($_SESSION['user']['address']) ? $_SESSION['user']['address'] : 'Aucune adresse.' ?> </h3>

            </div>

            <!-- Div des boutons de modification d'un compte et suppresion -->
            <div class="divButtonsInfos">
                <a href="index.php?page=profil&action=update&id=<?=$_SESSION['user']['id']?>"><input type="submit" value="Modifier mon compte" class="btnSubmit"></a> <!-- BtnModification des informations -->
                <a href="index.php?page=profil&action=delete&id=<?=$_SESSION['user']['id']?>"><input type="submit" value="Supprimer mon compte" class="btnSubmit"></a> <!-- BtnSuppresion du compte -->
            </div>

        </div>

        <!-- Separateur qui va separer les 2 parties de la page -->
        <div class="divSeparateurHR">
            <hr>
        </div>

        <!-- Partie droite de la page 'Panier' -->
        <div class="divPanierContent">

            <div class="divPanierTitle">
                <h1 class="pageTitle"> Panier (0) </h1>
            </div>

            <div class="divInfosContent">

                <!-- Affichage des infos l'user -->
                <h2> <?= $_SESSION['user']['firstname'] . ' ' . $_SESSION['user']['lastname'] ?> </h2>
                <h3> <?= $_SESSION['user']['email'] ?> </h3>
                <h3> <?= !empty($_SESSION['user']['phone']) ? $_SESSION['user']['phone'] : 'Aucun numéro de téléphone.' ?> </h3>
                <h3> <?= !empty($_SESSION['user']['address']) ? $_SESSION['user']['address'] : 'Aucune adresse.' ?> </h3>

            </div>

            <div class="divPanierArticles">
                <!-- Div des boutons de modification d'un compte et suppresion -->
                <div class="divButtonsInfos">
                    <a href="index.php?page=profil&action=update&id=<?=$_SESSION['user']['id']?>"><input type="submit" value="Modifier mon compte" class="btnSubmit"></a> <!-- BtnModification des informations -->
                    <a href="index.php?page=profil&action=delete&id=<?=$_SESSION['user']['id']?>"><input type="submit" value="Supprimer mon compte" class="btnSubmit"></a> <!-- BtnSuppresion du compte -->
                </div>
            </div>

        </div>

    </div>

</section>