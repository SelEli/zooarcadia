# Zoo Arcadia

Bienvenue dans le dépôt du projet **Zoo Arcadia**. Ce projet a pour objectif de développer une application web robuste et facile d'utilisation, mettant en valeur le zoo Arcadia et ses nombreux habitants.

## Table des matières

- [Introduction](#introduction)
- [Technologies Utilisées](#technologies-utilisées)
- [Installation et Configuration](#installation-et-configuration)
- [Utilisation](#utilisation)
- [Structure du Projet](#structure-du-projet)
- [Déploiement](#déploiement)
- [Licence](#licence)

## Introduction

L'application web Zoo Arcadia permet aux visiteurs de visualiser les animaux, leurs états, et les services offerts par le zoo. Elle dispose également d'une interface administrateur pour la gestion des contenus et des utilisateurs.

## Technologies Utilisées

- **Front-End** : HTML5, CSS3 (Bootstrap), JavaScript
- **Back-End** : PHP (Symfony)
- **Base de données** : MySQL pour la base de données relationnelle, MongoDB pour la base de données NoSQL
- **Déploiement** : Heroku

## Installation et Configuration

### Prérequis

Assurez-vous d'avoir les outils suivants installés sur votre machine :
- [WAMP](https://www.wampserver.com/en/)
- [Node.js](https://nodejs.org/)
- [Symfony CLI](https://symfony.com/download)

### Installation

1. Clonez le dépôt GitHub :
   ```cmd
   git clone https://github.com/votre-utilisateur/zoo-arcadia.git
   cd zoo-arcadia


2. Installez les dépendances PHP et JavaScript :

cmd
composer install
npm install

3. Configurez les fichiers d'environnement :

Dupliquez le fichier .env en .env.local et configurez les variables d'environnement pour la base de données MySQL.

4. Installez les assets avec Webpack Encore :

cmd
npm run dev
C

### Configuration de la base de données

1. Créez la base de données :

cmd
php bin/console doctrine:database:create

2. Appliquez les migrations :

cmd
php bin/console doctrine:migrations:migrate

3. Chargez les fixtures (données de test) si besoin:

cmd
php bin/console doctrine:fixtures:load

## Utilisation

### Démarrer le serveur local

Pour démarrer le serveur local Symfony, exécutez la commande suivante :

symfony serve

Accédez à l'application via http://localhost:8000.

### Identifiants de Test

Utilisez les identifiants suivants pour accéder aux différentes interfaces :

Administrateur :
Email : admin@zoo-arcadia.com
Mot de passe : admin123

Employé :
Email : employe@zoo-arcadia.com
Mot de passe : employe123

Vétérinaire :
Email : veterinaire@zoo-arcadia.com
Mot de passe : vet123

## Structure du Projet

La structure du projet est organisée comme suit :


/racineServeur/
├── assets          # Fichiers CSS, JavaScript et SASS
├── bin             # Fichiers exécutables
├── config          # Fichiers de configuration
├── public          # Répertoire public (root du serveur web)
├── src             # Code source PHP (contrôleurs, entités, repositories, services)
├── templates       # Templates Twig
├── translations    # Fichiers de traduction
├── var             # Fichiers temporaires (logs, cache)
├── vendor          # Dépendances PHP
├── README.md       # Documentation du projet
└── .env            # Fichier d'environnement

### Déploiement

Pour déployer l'application sur Heroku, suivez les étapes ci-dessous :

1. Initialisez un dépôt Git et créez une nouvelle application sur Heroku :

git init
heroku create nom_de_votre_application
git add .
git commit -m "Initial commit"
git push heroku main

2. Configurez les variables d'environnement sur Heroku :

heroku config:set DATABASE_URL=mysql://user:password@hostname:port/dbname

3. Exécutez les migrations de la base de données sur Heroku :

heroku run php bin/console doctrine:migrations:migrate

## Licence
Ne pas réutiliser sans préciser l'auteur.