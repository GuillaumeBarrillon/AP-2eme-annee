# Site restaurant 


Le client arrive sur la page d'accueil du site du restaurant il s'inscrit sur le site, se connecte, arrive sur la page où il peut commander sa nourriture une fois cela fait il indique s'il veut consommer sur place ou emporter et valide sa commande. Une fois cela fait il entre ses coordonnées bancaire et attend l'envoie d'un mail de validation pour recevoir sa commande.

# Installation :

    - Installer projet resto dans le dossier xampp/htdocs/projet/
    - Créer la base de données 'ap3' dans xampp


# Pour se connecter :

    Login        : bob
    Mot de passe : bob

# Navigation dans le projet :

index.php -> connexion.php -> liste_commande.php -> payer.php -> info.php -> liste_commande.php -> déconnexion

On se connecte puis on fait sa commande on paye on est informer que l'on va recevoir un mail et que la commande a bien été prise en compte 
puis on peut retourner sur la liste des commandes et se déconnecter.

# Documentation technique des echanges :

Quand on envoie une requête qui demande au serveur renvoyer sous la forme d'un fichier JSON la liste des commandes en attente dans la base de données.

Quand on envoie une requête d'acceptation la commande le serveur modifie l'état de la commande de la base de donnée  en 'accepter'.

Quand on envoie une requête de refus de la commande le serveur modifie l'état de la commande de la base de donnée en 'refuser'.


Quand on envoie une requête de changement d'état en 'prête' le serveur doit changer l'état de la commande dans la base de données en 'prêt'.