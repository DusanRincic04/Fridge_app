# 🧊 Fridge App — AI Recipe Assistant
A Laravel + React (Inertia) application that helps you manage ingredients and generate AI-powered recipes.  
Focus is on **backend functionality**: clean CRUD for ingredients & recipes, OpenAI integration, recipe emailing, and voice playback.

> Portfolio note: this app showcases full-stack skills (Laravel, Inertia, React, OpenAI, mailing, CRUD).

---

## ✨ Features

- **Ingredients CRUD**  
  Add, view, edit, and delete ingredients. Manage your pantry list.

- **AI Recipe Generation (two modes, via OpenAI):**  
  1) **From your saved ingredients** – click “Generate recipes” to create a recipe using items in the list.  
  2) **From manual input** – type ingredients + **email address** → the generated recipe is sent to that email.

- **Recipes CRUD**  
  View, edit, and delete generated recipes.

- **Voice reading (TTS)**  
  “Read Recipe” button reads the generated recipe out loud (browser speech synthesis / voice helper).

- **Email delivery**  
  Sends generated recipes to a provided email (configurable SMTP / Mailpit / Mailhog).

---

## 🧱 Tech Stack

- **Backend:** Laravel (PHP), Eloquent ORM, Mailer
- **Frontend:** React + Inertia.js, TailwindCSS (utility classes)
- **AI:** OpenAI API (text generation for recipes)
- **DB:** MySQL / SQLite (choose in `.env`)
- **Build:** Vite, NPM
- **Auth:** (if enabled) Laravel Breeze 

---

## 🧭 App Flows (How it works)

1. **Manage ingredients**  
   - Add items to your *Ingredients list* (name, optional details).  
   - Edit or delete as needed.

2. **Generate a recipe**  
   - **Mode A: From saved ingredients** → click **Generate recipes** to call OpenAI using your current list.  
   - **Mode B: From input & email** → type a comma-separated list + email, submit → recipe is generated and **emailed**.

3. **Work with recipes**  
   - Open a generated recipe → **Read Recipe** (voice), **Edit** text, or **Delete** if not needed.

---
## 🚀 Quick Start

```bash
git clone https://github.com/DusanRincic04/Fridge_app.git
cd Fridge_app

# Backend
cp .env.example .env
composer install
php artisan key:generate
# configure DB in .env, then:
php artisan migrate

# Frontend
npm install
npm run dev   # dev build; use `npm run build` for prod

# Run the app
php artisan serve
```

---

## 📄 License

This project is licensed under the MIT License – see the [LICENSE](LICENSE) file for details.
