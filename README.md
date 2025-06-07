
# 🎓 Plateforme de gestion des séminaires — IMSP

Ce projet a été développé dans le cadre du **projet de fin de cours en conception web** (Licence 3) à l’**Institut de Mathématiques et de Sciences Physiques (IMSP)**.  
Il permet la gestion complète des séminaires scientifiques organisés par les entités de recherche de l’Institut.

## 📄 Rapport du projet

Vous pouvez consulter ou télécharger le rapport ici :  
👉 [Télécharger le rapport de projet (PDF)](rapport/rapport-seminaire.pdf)


## 🧾 Résumé du projet

- Application web développée avec **Symfony 6**.
- Utilisation de **PostgreSQL** pour la base de données.
- Envoi de mails via **Symfony Mailer**.
- Interface claire pour visiteurs, organisateurs et administrateurs.

---

## 🎯 Fonctionnalités principales

- **Inscription intelligente** : mot de passe spécial pour créer un compte administrateur, sinon rôle organisateur.
- **Soumission de séminaires** : formulaire accessible aux organisateurs.
- **Validation par l’administrateur** avec affectation de date.
- **Soumission du résumé** 10 jours avant la présentation.
- **Publication automatique** 7 jours avant.
- **Téléchargement des fichiers** après la présentation.
- **Abonnement aux notifications email** (sans compte).
- **Tableaux de bord** pour admin et organisateurs.

---

## ✅ Prérequis

Avant d’installer le projet, assurez-vous d’avoir les éléments suivants installés :

- PHP ≥ 8.1
- Composer
- Symfony CLI
- PostgreSQL (et un utilisateur configuré)
- Node.js + npm (si assets compilés)
- Un serveur mail local ou une configuration SMTP pour les emails

---

## ⚙️ Installation et exécution du projet

1. **Cloner le dépôt**

```bash
git clone https://github.com/TON_PSEUDO/gestion-seminaires.git
cd gestion-seminaires
```

2. **Installer les dépendances PHP**

```bash
composer install
```

3. **Configurer l’environnement**

Copier le fichier `.env` et adapter les variables :

```bash
cp .env .env.local
```

Dans `.env.local`, modifier la connexion à PostgreSQL :

```
DATABASE_URL="postgresql://votre_user:motdepasse@127.0.0.1:5432/nom_de_la_base"
```

4. **Créer la base de données**

```bash
php bin/console doctrine:database:create
```

5. **Exécuter les migrations**

```bash
php bin/console doctrine:migrations:migrate
```

6. **(Optionnel) Charger des données de test**

```bash
php bin/console doctrine:fixtures:load
```

7. **Lancer le serveur de développement**

```bash
symfony server:start
```

---

## 📨 Envoi d’emails

Configurer dans `.env.local` un transport mail compatible (Mailtrap, Gmail SMTP, etc.) :

```bash
MAILER_DSN=smtp://your-smtp-user:your-password@smtp.mailtrap.io:2525
```

---

## 🧪 Exportation et réutilisation du projet

Après avoir exporté le projet :
- Reconfigurez `.env.local` avec **vos propres identifiants PostgreSQL et SMTP**.
- Assurez-vous d’avoir un **fichier SQL vide**, ou une base PostgreSQL vierge.
- Refaire `composer install`, `migrate` et démarrer le serveur.

---

## 👤 Auteur

**OGAWIN Rabiou**  
Licence 3 – IMSP  
Projet encadré par **Dr. SANDA MAHAMA AMADOU TIDJANI**

---

## 🗂️ Contenu du dépôt GitHub

- `src/` : contrôleurs, entités et services Symfony
- `templates/` : fichiers Twig (vues)
- `migrations/` : fichiers de migration Doctrine
- `public/` : ressources statiques
- `.env`, `.env.local` : configuration d’environnement
- `composer.json` : dépendances PHP
- `README.md` : ce fichier

---

## 📷 Exemple d'interface

### 🏠 Page d’accueil (publique)

![Accueil](screenshots/accueil.jpg)  
*Figure 1 – Page d’accueil avec liste des séminaires à venir et formulaire d’abonnement email.*

---

### 📝 Formulaire d’inscription

![Inscription](screenshots/inscription.jpg)  
*Figure 2 – Formulaire d’inscription avec mot de passe spécial pour les administrateurs.*

---

### 📋 Tableau de bord Administrateur

![Admin Dashboard](screenshots/admin-dashboard.jpg)  
*Figure 3 – Tableau de bord de l’administrateur : accès à la gestion des séminaires, utilisateurs et statistiques.*

---

### 👤 Tableau de bord Organisateur

![Organisateur Dashboard](screenshots/organisateur-dashboard.jpg)  
*Figure 4 – Tableau de bord de l’organisateur : consultation des séminaires et soumission de nouvelles demandes.*

---

### 📨 Formulaire de demande de séminaire

![Demande Séminaire](screenshots/demande-seminaire.jpg)  
*Figure 5 – Formulaire permettant à un organisateur de proposer un nouveau séminaire.*

---

### 📚 Séminaires passés

![Archives](screenshots/seminaires-passes.jpg)  
*Figure 7 – Page publique affichant les anciens séminaires avec lien de téléchargement des fichiers.*

---

## 🔗 Lien du projet GitHub

👉 [https://github.com/git-ogawin/seminaireImsp](https://github.com/git-ogawin/seminaireImsp)
