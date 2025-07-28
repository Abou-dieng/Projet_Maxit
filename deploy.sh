#!/bin/bash

# Script de déploiement pour Render
set -e

echo "🚀 Déploiement de l'application MAXITSA sur Render..."

# Vérifier que les variables d'environnement sont définies
if [ -z "$DB_HOST" ]; then
    echo "❌ Variable DB_HOST non définie"
    exit 1
fi

if [ -z "$DB_PORT" ]; then
    echo "❌ Variable DB_PORT non définie"
    exit 1
fi
if [ -z "$DB_NAME" ]; then
    echo "❌ Variable DB_NAME non définie"
    exit 1
fi
if [ -z "$DB_USER" ]; then
    echo "❌ Variable DB_USER non définie"
    exit 1
fi
if [ -z "$DB_PASSWORD" ]; then
    echo "❌ Variable DB_PASSWORD non définie"
    exit 1
fi
if [ -z "$DB_CONNECTION" ]; then
    echo "❌ Variable DB_CONNECTION non définie"
    exit 1
fi


echo "✅ Variables d'environnement validées"

# Créer le répertoire uploads s'il n'existe pas
mkdir -p /var/www/html/public/uploads/images
chmod -R 755 /var/www/html/public/uploads

# Exécuter les migrations si nécessaire
echo "📊 Exécution des migrations..."
if [ -f "bin/migrate" ]; then
    php bin/migrate
else
    echo "⚠️  Fichier de migration non trouvé, exécution directe du script SQL"
    # Vous pouvez ajouter ici l'exécution directe de votre script SQL
fi

echo "🎉 Déploiement terminé avec succès!"
echo "🌐 Application disponible sur le port 80"
