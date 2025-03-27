# Application de Gestion d'Événements Musicaux - Symfony

## Description

Ce projet consiste en une application Symfony de gestion d'événements musicaux. Elle comporte une partie **fullstack** et une partie **API**. L'application permet de consulter et gérer des artistes, des événements musicaux, et de s'inscrire à ceux-ci.

L'application est divisée en deux parties distinctes, à savoir :
- **Partie Fullstack (Backend + Frontend)** : Gère les utilisateurs, les artistes, et les événements.
- **Partie API** : Permet de récupérer des informations sur les artistes et les événements au format JSON.

## Technologies

- Symfony 6.x
- React (avec ViteJs pour la gestion des builds)
- SQLite (pour la base de données)
- Swagger UI pour la documentation de l'API

### **2️⃣ Install dependencies**
```sh
composer install
```

If the API doesn't work for you:
```sh
composer require nelmio/api-doc-bundle
```

### Prérequis

- PHP >= 8.1
- Composer
- Node.js >= 16
- SQLite

### **5️⃣ Run the Symfony server**
```sh
symfony serve
```
Visit: [http://127.0.0.1:8000](http://127.0.0.1:8000)

1. **Clonez les repositories**

   Etant donné que la partie Symfony et la partie React sont deux projets différents veuillez faire la partie symfony
   git clone <url_du_repository_backend>
   git clone <url_du_repository_frontend>

