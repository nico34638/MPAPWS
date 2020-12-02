**IUT La Rochelle**   
**Département Informatique**   
**2020-2021**

**Projet MPAPWS**   
--- 
--- 
# Objectif 

Ce document fournit une architecture type pour votre projet MPAPWS. Cette architecture se base sur une conception basée sur des images logicielles de type docker gérées par le programme de composition des services, nommé « docker-compose ». 

Nous considérons alors un projet nommé **MPAPWS**. 

**Ce nom doit être remplacé par le nom de votre projet réel.** 


# Architecture

## Images docker du projet 

L'architecture du projet **MPAPWS** est basée sur 2 images docker :
* **iutlr-info2-symfony5-mpapws** : fournit un serveur web apache et un interprèteur php, il gère le code source Symfony5 de l'application, qui se trouve dans dans le dossier « **mpapws** »

* **iutlr-info2-mysql-mpapws** : gère la base de données mysql du projet, qui se trouve dans le dossier « **mysql** »

Ces deux images docker sont instanciées pour démarrer deux conteneurs respectivement :    
* **iutlr-info2-symfony5-mpapws** : conteneur exécutant le code source du projet 

Le service correspondant est app 
* **iutlr-info2-mysql-mpapws** : conteneur exécutant la base de données du projet 

Le service correspondant est bd

## Archiecture physique 

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
    * url d'accès : en JDBC sur localhost:3306
    * MYSQL_DATABASE: db-mpapws
    * MYSQL_USER: mpapws
    * MYSQL_PASSWORD: mpapws
    * MYSQL_ROOT_PASSWORD: mpapws

* **build** : les fichiers dockerfile pour construire les images nécessaires à partir du registry public de l'IUT : 
    * url du registry : http://registry.univ-lr.fr:80 

    * url du registry : http://registry.univ-lr.fr:81
    * **IMPORTANT** : ajouter ce registry dans la config du deamon docker, exemple voir, la capture ci-dessous pour la config de docker sous OSX : 
    <div align="center" ><img alt="config registry docker OSX" src="ressources/osx-docker-registry-config.png" width="500" height="(500" /></div>


## Rappels : Connexion à la bd db-mpapws

* Configuer le ".env.local" pour accéder à la base de données du projet **mpapws**

Dans le ficher "docker-compose" nous avons mis la configuration suivante : 
```
mysql:
    environnement :
    MYSQL_DATABASE: db-mpapws
    MYSQL_USER: mpapws
    MYSQL_PASSWORD: mpapws
```
Dans ce cas, l'URL JDBC pour se connecter à cette base de données à partir du projet Symfony (fichier ".env.local") est : 
```
DATABASE_URL=mysql://mpapws:mpapws@iutlr-info2-mysql-mpapws:3306/db-mpapws
```
* Attention ne pas changer mpapws par votre nom de projet ici ;-)

### Accéder à la base de données à partir de PhpStorm 

- Etape (1) :
  <div align="center" ><img alt="config registry docker OSX" src="ressources/dbconfig01.png" width="600" height="300" /></div>

- Etape (2)
    - Name : Donner un nom à la connexion
    - Host : localhost 
    - Port : 3306 
    - Database : le nom de votre BD (voir docker-compose.yml)
    - User : login de votre utilisateur (voir docker-compose.yml)
    - Password : mot de passe de votre utilisateur (voir docker-compose.yml)
    - Driver : télécharger le driver s'il n'est pas indiqué
    - Tester la connexion 
<div align="center" ><img alt="config registry docker OSX" src="ressources/dbconfig02.png" width="650" height="300" /></div>



