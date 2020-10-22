# MMP

Site pour la Maintenance Mobile des Pneumatiques,
lien : http://mmp06.fr

## Exigés

'laravel'
'composer'


## Installation

Cloner le dépot : 
https://github.com/mejatojo/MMP.git

Entrer dans le dossier

`cd MMP`

Installation des dépendances

`
    run composer install to generate depedencies in vendor folder
    change .env.example to .env
    run php artisan key:generate
    configure .env`

## Lancement

Lance le serveur

`php artisan serve`

<h2>Menu et fonctionnement</h2>
- Page d'accueil
- Authentification
- Ajout d'une entreprise,modification et suppression
- Ajout d'un véhicule associé à une entreprise, modification et suppression
- Prédiction, prédire quand est-ce qu'un véhicule doit changer ses pneus
- Maintenance, enregistrement des maintenances effectués par véhicule,modification, suppression (pression, changer des pneus, mise à jour des pneus)
- Rendez-vous, ajout d'un rendez-vous par le client; acceptation ou réfus d'un rendez-vous par le superadmin
- Pneu usés, liste des pneu utilisés enregistrés automatiquement pendant la maintenance
- Stock, gestion de stock qui concerne les pneus disponibles, les détails des nombres des pneus
- Facturation, le superadmin facture les maintenances effectuées et l'entreprise appartenant la véhicule facturée peut voir la facture
- Sauvegarde, on peut sauvegarder toutes les données du site, et on peut l'importer à n'importe quel moment
- Ajout, modification et suppression d'un utilisateur (ayant un rôle conducteur, responsable de flotte)
- Alerte, on peut alerter les véhicules qui doivent effectuer une maintenance et qui n' a pas encore pris de rendez-vous (alerte : envoie un mail)
- Alerte automatique qui envoie un mail automatique sur les responsables de flotte qui a des véhicules irréguliers.





Une étoile please :P
