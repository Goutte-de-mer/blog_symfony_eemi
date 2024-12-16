# Lancer la Web App Blog

## Prérequis

- PHP 8.0 ou plus
- Composer
- Symfony CLI

## Installation

### 1. Installer les dépendances

Installez les dépendances PHP avec Composer :

```bash
composer install
```

### 2. Configurer la base de données

Modifier le fichier `.env` à la racine du projet et configurez les identifiants de votre base de données :

```
DATABASE_URL="mysql://utilisateur:motdepasse@127.0.0.1:3306/nom_de_la_base"
```

### 3. Générer le schéma de la base de données

Exécutez la commande suivante pour créer le schéma de la base :

```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

### 4. Charger les données initiales (fixtures)

Ajoutez des données de départ avec les fixtures :

```bash
php bin/console doctrine:fixtures:load
```

**Note :** Tous les mots de passe utilisateurs sont configurés sur : `User_password123`.

### 5. Lancer le serveur de développement

Démarrez le serveur de développement Symfony :

```bash
symfony serve
```

## Fonctionnalités

### Navigation

- Le **logo** en haut de la page permet de revenir à la page d'accueil.

### Articles et commentaires

- Sur la **page d'accueil**, les **trois derniers articles** sont affichés.
- Les articles et les commentaires sont affichés **du plus récent au plus ancien** sur toutes les pages.
- Une **pagination** est présente sur la page affichant tous les articles.

### Formulaires

- Validation stricte des données dans les formulaires :
  - Adresse email et mot de passe pour l'inscription et la connexion.
  - Contenu du commentaire lors de sa création.

### Gestion des commentaires

- Les utilisateurs connectés peuvent **ajouter des commentaires**.
- Les utilisateurs peuvent **supprimer leurs propres commentaires**.

---
