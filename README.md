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

# Mise en oeuvre

## I- Initialisation du projet : du projet git modèle vers un projet git équipe - initialisation par l'étudiant propriétaire du projet git
* Créer un nouveau projet git équipe avec le slug du projet : 2020-2021-INFO2-MPAPWS-lenomduprojet (un étudiant de l’équipe créé le projet)
* Cloner la stack modèle depuis le git du projet modèle    
https://forge.iut-larochelle.fr/jmalki/2020-2021-info2-mpapws-project-template.git
``` 
git clone https://forge.iut-larochelle.fr/jmalki/2020-2021-info2-mpapws-project-template.git
```
* Renommer le dossier avec le nom de votre projet : 
```
2020-2021-info2-mpapws-lenomduprojet  
```

* Positionner vous dans le dossier de votre projet et débrancher ce projet du dépôt git cloné   
``` 
git remote set-url origin URL-HTTP-GIT-VOTRE-PROJET
```  
* Pour vérifier cela, faire :
```
less .git/config
```
* Monter le projet modèle dans le git étudiant

```
git add .
git commit -m 'initial commit'
git push -u origin master
```

* Et voilà votre projet est prêt

## II- Configurer votre docker compose avec le nom de votre projet symfony 
* remplacer mpapws par le nom de votre projet dans le fichier docker-compose.yml uniquement sur les deux lignes suivantes
```
args: 
        APP_DOCUMENT_ROOT: /var/www/html/mpapws/public
```
et 
```
volumes:
      - ./mpapws:/var/www/html/mpapws:delegated  
```
* pousser cette mise à jour sur votre dépôt distant

## III - Avant de continuer : on sait lancer et arrêter la stack docker
**Pré-requis**

* Ouvrir un terminal 
* Se positionner dans le dossier du projet 
* Vérifier qu’il n’y a pas de conteneurs docker démarrés

Pour voir les processus docker qui tournent:
``` 
docker ps
```  
Pour arrêter les conteneurs démarrés
``` 
docker stop $(docker ps -a -q)
```  

Pour supprimer tous les conteneurs, pour éviter des conflits de nommage
``` 
docker rm $(docker ps -a -q)
``` 
Attention: ces deux commandes peuvent envoyer une erreur argument manquant s'il n'y a pas de conteneurs qui tournent, normal car **docker ps -a -q** ne renvoit rien     

**Démarrage de la stack**
* Construire et démarrer les conteneurs déclarés dans le docker-compose.yml du projet
``` 
docker-compose up --build  
``` 
Remarque : ne pas fermer ce terminal après le démarrage des conteneurs 
* Dans un nouveau terminal, positionné dans le dossier du projet inspecter l’état des conteneurs démarrés
``` 
docker-compose ps 
``` 
**Arrêt de la stack**

Equivalent à : arrêter et supprimer les conteneurs du projet  en cours d'exécution
``` 
docker-compose down
```   
Tester que vous savez arrêter la stack proprement

## IV - initialiser le projet symfony

**Pré-requis :**

* Penser à relancer votre stack docker du projet 

**Initialisation** 
* Relancer votre stack docker
* Dans un nouveau terminal, se connecter au terminal du conteneur app : 
``` 
docker-compose exec app bash 
``` 

ou

```
docker exec -it (nom du conteneur ou id) bash 
```
* Utiliser composer pour récupérer un skeleton symfony
``` 
composer create-project symfony/website-skeleton nomProjet
``` 
* Vérifier que localhost:9999 affiche la page d’accueil par défaut de symfony

* Sinon relancer une mise à jour composer
```
composer install
```
* Ouvrir le projet dans phpstorm
* Noter la presence d'un fichier .gitignore à la racine du dossier de la stack qui montre que le répertoire mysql n'est pas mis à jour sur le dépôt distant

* Pousser les modifications sur votre dépôt distant
```
git add .
git commit -m 'init projet mpapws symfony'
git push
```


## V- Initialisation du projet :  un projet git équipe - initialisation par les autres membres de l'équipe

* Inviter les membres de l'équipe en tant que développeur
* Ils vont recevoir une invitation avec l'URL du git
* Chacun clone le projet
* Comme le .gitignore du projet symfony ne monte pas sur le dépôt distant des dossiers comme var ou vendor, il vous faut finaliser la récupération des dépendances symfony. A faire dans un terminal connecté au conteneur app, en vous plaçant dans le dossier de votre projet :
```
composer install
```
* Vérifier que localhost:9999 affiche la page d’accueil par défaut de symfony

## VI- Mise en place de la connexion à la bd db-mpapws

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

# Accéder à la base de données à partir de PhpStorm 

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

**Et voilà vous êtes prêts à développer votre application !**


