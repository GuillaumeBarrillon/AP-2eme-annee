# Site restaurant 


Le client arrive sur la page d'accueil du site du restaurant il s'inscrit sur le site, se connecte, arrive sur la page où il peut commander sa nourriture une fois cela fait il indique s'il veut consommer sur place ou emporter et valide sa commande. Une fois cela fait il entre ses coordonnées bancaire et attend l'envoie d'un mail de validation pour recevoir sa commande.

# Installation :

    - Installer projet resto dans le dossier xampp/htdocs/projet/
    - Créer la base de données 'ap3' dans xampp


# Pour se connecter :

    Login        : bob
    Mot de passe : bob

# Description des valeurs possibles :

    Type de consommation:

        Sur place : id = 0
        A emporter : id = 1

    Etat de la commande:

        En attente : id=0
        Terminer : id=2
        Refuser : id=3
        Accepter : id=1

# Navigation dans le projet :

index.php -> connexion.php -> liste_commande.php -> payer.php -> info.php -> liste_commande.php -> déconnexion

On se connecte puis on fait sa commande on paye on est informer que l'on va recevoir un mail et que la commande a bien été prise en compte 
puis on peut retourner sur la liste des commandes et se déconnecter.

# Document d'exploiation :

Se connecter: Pour se connecter il est obigatoir d'entre un identifient et un mot de passe 
S'inscrire  : Pour s'inscrire il est obligatoir d'entre un identifien et un mot de passe le mail est optionnel
Commander   : Pour commader il est obligatoir d'entrer des quantités aux différentes commamndes et d'attribuer un type de consomation a         
              la commande
Payer       : Pour payer il faut antre les code d'une carte bancaire c'est a dire les 16 chifres de la carte  les 3 chifres CVC et             
              la date d'expiration de la carte bancaire.
Info        : Info donne le numéro de commande et le prix

# Localisation du fichier exemple JSON :

AP-2EME-ANNEE/exemple.JSON

# Documentation technique des echanges :

Quand on envoie une requête <http://localhost/projet/AP-2eme-annee/api/commandes_en_attente.php> le serveur renvoi sous format JSON la liste des commandes en attente dans la base de données.

Quand on envoie une requête <http://localhost/projet/AP-2eme-annee/api/commande_accepter.php?id_commande=1> d'acceptation de la commande. Le serveur modifie l'état de la commande dans la base de donnée en 'accepter'.

Quand on envoie une requête <http://localhost/projet/AP-2eme-annee/api/commande_refuser.php?id_commande=1> qui refuse la commande. Le serveur modifie l'état de la commande dans la base de donnée en 'refuser'.


Quand on envoie une requête de changement d'état <http://localhost/projet/AP-2eme-annee/api/commande_refuser.php?id_commande=1>. Le serveur doit changer l'état de la commande dans la base de données en 'prêt'.