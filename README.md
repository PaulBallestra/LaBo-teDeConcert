# LaBo-teDeConcert

Bienvenue sur mon site : La Boîte de Concert !

Sur ce site vous pourrez parcourir de nombreuses salles de concert et ce dans plusieurs catégories.

Vous pouvez parcourir les catégories ainsi que leurs produits.
Lorsque qu'un utilisateur commande son panier, j'ai fait un formulaire de saisie d'informations bancaire, en revanche celui-ci n'est pas sécurisé.
Par conséquent, il y aura juste une vérification des champs non vide. La commande sera ensuite passée automatiquement.

Je n'ai pas le besoin de stocker l'adresse de l'user dans une commande puisque celui-ci ne reçoit pas le produit chez lui, il devra aller sur place pour voir son achat.

Une attention particulière a été donné sur les adresses. En effet, celles-ci sont une entités a part entiere de l'user, puisqu'elles seront également utilisées pour les produits.

La page d'accueil est moin stylé que dans le design mais je n'ai pas réussi à faire ce que je voulais :'(.

INSTRUCTIONS SUR LA CRÉATION D'ENTITÉS

Intégration d'une catégorie :
  
    - Utiliser un profil d'administrateur.
    - Aller dans la section d'administration puis gestion des catégories.
    - Cliquez sur ajouter pour créer une nouvelle catégories.
    - Le formulaire doit maintenant être rempli :
        - Un nom de catégorie
        - Une description de la catégorie
        - Une image (au format 1920*1200)
        
  Intégration d'un produit :
   
    - Utiliser un profil d'administrateur.
    - Aller dans la section d'administration puis gestion des produits
    - Cliquez sur ajouter pour créer un nouveau produit.
    - Le formulaire doit maintenant être rempli :
        - Un nom de produit
        - Une description de produit
        - La capacité du produit (nombre de personne autorisées)
        - Le prix du produit
        - Les 3 images du produit (au format 800*600 - oui)
        - Un selecteur de une ou plusieurs catégories
        - Puis l'adresse du produit (Numéro, Rue, Ville, Code Postal, Pays)
        
Les inputs de type file pour les images ne gèrent pas le cas ou l'image est supérieure à 2Mo (j'ai pô trouvé)

Mais sinon profitez bien de ce site j'ai kiffé !
       
