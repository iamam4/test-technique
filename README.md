# Test Technique

## Description
Test recrutement dev Teach'r

## Prérequis
- Node.js
- npm ou yarn

## Installation

1. Cloner le dépôt
```bash
git clone https://github.com/iamam4/test-technique.git
cd test-technique
```

2. Installer les dépendances
```bash
npm install
# ou
yarn install
```

3. Configurer la base de données PostgreSQL

- Créer une base de données PostgreSQL ou utiliser celle envoyé par mail.
- Mettre à jour le fichier .env avec vos informations de connexion PostgreSQL
```bash
DATABASE_URL="postgresql://username:password@127.0.0.1:5432/database_name serverVersion=13&charset=utf8"
```

4. Lancer les migrations pour créer les tables

```bash
php bin/console doctrine:migrations:migrate
```

5. Lancer l'application
```bash
symfony server:start
# et sur un autre terminal
npm run build 
```

## Choix Techniques

### Architecture

- Application Symfony avec frontend React
- Architecture modulaire utilisant Webpack Encore pour la gestion des assets
- Typescript pour un typage statique et une meilleure maintenabilité
- Intégration Symfony UX avec React pour une expérience développeur optimisée

### Technologies Utilisées

1. Frontend

- React 18 pour l'interface utilisateur
- Redux Toolkit pour la gestion d'état (pas eu le temps d'implémenter)
- React Router pour la navigation
- TypeScript pour le typage statique
- TailwindCSS pour le styling

2. Build & Development:

- Webpack Encore pour la compilation des assets
- Babel pour la transpilation JavaScript
- PostCSS pour le processing CSS
- Hot Module Replacement pour le développement

3. Testing:

- Postman pour tester les endpoints de l'API

### Justification des choix

- React + TypeScript: Assure un développement robuste avec typage statique
- TailwindCSS: Framework CSS utilitaire pour un développement rapide
- Symfony UX: Intégration native des composants React avec Symfony
