# Music Event Management - Symfony Project
# A project by Corentin DETOURNAY, Enzo BORDET, Virgile MARION

## 📌 Project Overview

This is a **Symfony-based application** for managing **music events**. It includes both **fullstack** and **API** functionalities. Users can register, manage events, and view artists, while an admin has additional management capabilities. The API provides endpoints for retrieving artist and event details.

## 🚀 Features

### 🎵 Fullstack Application

- Public **homepage**.
- **User authentication** (Register/Login).
- **User roles**:
  - **Admin**: Manage artists, view users.
  - **User**: Create, edit, delete their own events, register for events.
- **Artists**:
  - Name, description, image.
  - View events they participate in.
- **Events**:
  - Name, date, linked artist.
  - List of registered users.
- **Search & Filtering**:
  - Search artists by name.
  - Filter events by date.

### 🌐 REST API (with Swagger UI)

Accessible at ``.

- `GET /api/artists` - List all artists.
- `GET /api/artists/{id}` - Get a specific artist.
- `GET /api/events` - List all events.
- `GET /api/events/{id}` - Get a specific event.

## 🛠️ Installation Guide

### **1️⃣ Clone the repository**

```sh
git clone https://github.com/enzB29/ProjetMusique.git
cd proj/ProjetMusique
```

### **2️⃣ Install dependencies**

```sh
composer install
```

If the API is not working for you:
```sh
composer require nelmio/api-doc-bundle
```

### **3️⃣ Configure environment**

Create a `.env.local` file and configure the database:

```env
DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"
```

### **4️⃣ Set up the database**

```sh
symfony console doctrine:database:create
symfony console make:migration
symfony console doctrine:migrations:migrate
```

### **5️⃣ Run the Symfony server**

```sh
symfony serve
```

Visit: [http://127.0.0.1:8000](http://127.0.0.1:8000)


## 🔐 Authentication & Security

- First registered user is assigned **ROLE\_ADMIN**.
- Other users get **ROLE\_USER**.
- **Admin-only** actions:
  - Managing artists.
  - Viewing user list.
- **User-only** actions:
  - Creating/modifying/deleting their own events.
  - Registering for events.

## ⚙️ API & Circular Reference Fix

The API uses **serialization groups** to avoid circular reference errors. Example:

```php
#[Groups(['artist:read'])]
private ?string $name;
```
