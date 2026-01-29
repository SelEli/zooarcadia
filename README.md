# Zoo Arcadia — Application Web (Symfony)

Projet réalisé en autonomie complète dans le cadre d’un Bac+2.  
Objectif : développer une application web permettant la gestion des animaux, habitats, services et utilisateurs du zoo Arcadia, avec une interface administrateur et une architecture claire.

---

## 🎯 Objectifs du projet
- Appliquer les bases du développement web (MVC, CRUD, validation, sécurité).
- Concevoir une architecture propre et maintenable.
- Gérer un volume fonctionnel important (30+ entités).
- Produire une documentation complète (schémas, PDF fournis dans le dépôt).
- Réaliser l’ensemble du projet seul, à distance.

---

## 🚀 Fonctionnalités principales
- Gestion des animaux, habitats, services et états.
- Interface administrateur sécurisée (rôles et permissions).
- CRUD complets avec validation.
- Double base de données :
  - MySQL (relationnel)
  - MongoDB (contenus non structurés)
- Authentification Symfony.
- Gestion des utilisateurs (admin, employé, vétérinaire).

---

## 🧱 Architecture & Structure du projet

### Structure principale du dépôt
- `src/` — contrôleurs, entités, services  
- `templates/` — vues Twig  
- `public/` — assets publics  
- `config/` — configuration Symfony  
- `migrations/` — migrations Doctrine  
- `assets/` — JS/CSS (Webpack Encore)  
- `docker-compose.yml` — environnement Docker  
- `Documentation Technique du Projet ECF – Zoo Arcadia.pdf` — documentation technique  
- `Diagramme sans nom.drawio` — schémas d’architecture  
- `Gestion de Projet du Zoo Arcadia.pdf` — organisation et planning  
- `Manuel d'Utilisation de l'Application Zoo Arcadia.pdf` — guide utilisateur  

Ces fichiers montrent la structure du projet, la conception fournie et la documentation associée.

---

## 🛠️ Stack technique
- Back-End : PHP 8 · Symfony  
- Front-End : HTML5 · CSS3 (Bootstrap) · JavaScript  
- Bases de données : MySQL · MongoDB  
- Outils : Composer · Webpack Encore · Symfony CLI  
- Déploiement : Heroku  
- Environnement : Docker (optionnel)

---

## ⚙️ Installation & exécution

### 1. Installer les dépendances
```
composer install
npm install
```

### 2. Configurer l’environnement
Créer un fichier `.env.local` et renseigner les accès MySQL.

### 3. Compiler les assets
```
npm run dev
```

### 4. Créer la base et appliquer les migrations
```
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

### 5. Lancer le serveur
```
symfony serve
```

---

## 👤 Rôle & responsabilités
Projet réalisé seul, à distance :
- Compréhension et application de l’énoncé fourni.
- Conception de l’architecture (schémas, organisation).
- Développement complet (front + back).
- Gestion des données (MySQL + MongoDB).
- Documentation (PDF, schémas, manuel utilisateur).
- Déploiement Heroku.

Ce projet montre ma capacité à suivre une architecture, à structurer un projet complet et à livrer une application fonctionnelle en autonomie.

---

## 📄 Licence
Ne pas réutiliser sans préciser l’auteur.
