**Etudiants à l'IUT La Rochelle**   
**DUT Informatique 2020-2021**

**Projet MPAPWS**   
---
> Remi MIGNON, Nicolas FIDEL, Louis GUILLET, Mathieu LUCAS, Mathis DEVIGNE  
> Nous sommes l'équipe Z-3-1
--- 

# Architecture

## Images docker du projet 

L'architecture du projet **MPAPWS** est basée sur 4 images docker :  

* **iutlr-info-apache-symfony5-mpapws** : fournit un serveur web apache et un interprèteur php, il gère le code source Symfony5 de l'application, qui se trouve dans dans le dossier « **mpapws** »

* **iutlr-info-mysql-mpapws** : gère la base de données mysql du projet, qui se trouve dans le dossier « **mysql** »

* **phpmyadmin/phpmyadmin** : application Web qui permet la gestion la base de données MySQL avec un affichage graphique pratique.

* **mailhog/mailhog** : mail-catcher pour tester et gerer l'envoi/reception de courrier électronique grâce à un faux serveur SMTP. Pratique pour la phase de dev.

Ces quatres images docker sont instanciées pour démarrer quatres conteneurs respectivement :    
* **iutlr-info2-symfony5-mpapws** : conteneur exécutant le code source du projet 

Le service correspondant est app 
* **iutlr-info2-mysql-mpapws** : conteneur exécutant la base de données du projet 

Le service correspondant est mysql
* **phpmyadmin** : conteneur exécutant l'appli web de gestion de bd

Le service correspondant est phpmyadmin
* **mailhog** : conteneur exécutant le mail-catcher

Le service correspondant est mail

## Archiecture physique du projet

**projet_mpapws/**  
├── README.md     
├── mpapws/     
├── mysql/   
├── build/  
└── docker-compose.yml  

* **mpapws** : le projet MPAPWS en Symfony5, avec :
    * url d'accès : "http://localhost:9999" 
    * les fronts en twig
    * les données gérées par doctrine à partir du serveur **mysql**

* **mysql** : le serveur mysql gérant la base de données : 
    * url d'accès : en JDBC sur localhost:3307
    * MYSQL_DATABASE: db-mpapws
    * MYSQL_USER: mpapws
    * MYSQL_PASSWORD: mpapws
    * MYSQL_ROOT_PASSWORD: mpapws

* **phpmyadmin** : le serveur mysql gérant la base de données : 
    * url d'accès : "http://localhost:2000"
    * ID: mpapws
    * PASSWORD: mpapws

* **mailhog** : le mail : 
    * url d'accès : "http://localhost:1080"

* **build** : les fichiers dockerfile pour construire les images nécessaires à partir du registry public de l'IUT : 
    * url du registry : http://registry.univ-lr.fr:80 

    * url du registry : http://registry.univ-lr.fr:81
    
# Mise en place de l'environement Architecture
 pensez à compléter votre README avec la procédure pour être opérationnel en tant que nouveau développeur (il y a 5 étapes, ça dure 2 minutes pas plus...), ça va vous permettre de valider que ça fonctionne
(les 5 étapes : clone - démarrer les containers - .env.local (et .env.test) - composer install - migrations - fixtures)

