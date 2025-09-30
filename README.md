# Radio4You — Backend (Symfony)

Plateforme backend de Radio4You (API + backoffice).

---

## 🧰 Prérequis

- Avoir **PHP** installé
- Avoir **Symfony** (Symfony CLI) installé

---

## 📦 Installation

```bash
composer install
```

Téléchargez et installez aussi le dépôt **front-end** pour accéder à l’interface :
- Front repo : https://github.com/Thomas-Gambin/Radio4You_Front

---

## ⚙️ Configuration (.env)

Créez un fichier **`.env`** à la racine du projet avec :

```ini
APP_ENV=dev
APP_SECRET=Nl63VHNpJGESnnCG10EMiQnPdwOZVNB2PBI9FFkfyeua3XvxabDYCoeld4gEfQmFzG0jmSd7ZJUPGoEf3mt
DATABASE_URL="mysql://radio:password@127.0.0.1:3306/radio4you?serverVersion=mariadb-8.0.35&charset=utf8mb4"

###> nelmio/cors-bundle ###
CORS_ALLOW_ORIGIN='^https?://(localhost|127\.0\.0\.1)(:[0-9]+)?$'
###< nelmio/cors-bundle ###
```

---

## 🗄️ Base de données

Initialisez la base (drop, create, migrate, fixtures) :

```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load
```
Si jamais il y a un bug durant la procédure :

```bash
php bin/console doctrine:database:drop --force --if-exists
php bin/console make:migration
```
Puis refaire l'étape initale.
---

## ▶️ Lancer le serveur

Avec la **Symfony CLI** :

```bash
symfony server:start
```

---

## 🧭 Routes disponibles

| Route      | Description                                                                                               |
|------------|-----------------------------------------------------------------------------------------------------------|
| `/api`     | Vous avez toutes les routes API et la possibilité de les tester avec **API Platform**.                    |
| `/login`   | Se connecter à la BDD (utilisateur : **admin**, mot de passe : **password**).                             |
| `/admin`   | Accueil du backoffice.                                                                                    |
| `/articles`| Page de gestion des **articles**.                                                                         |
| `/podcasts`| Page de gestion des **podcasts**.                                                                         |
| `/user`    | Page de gestion des **utilisateurs**.                                                                     |

---


test
