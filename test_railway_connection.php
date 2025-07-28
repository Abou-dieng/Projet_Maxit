<?php

// Script de test de connexion à Railway PostgreSQL

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/app/config/env.php';

use App\Core\Database;

try {
    echo "=== Test de connexion à Railway PostgreSQL ===\n\n";

    echo "Configuration chargée :\n";
    echo "- DB_DRIVER: " . DB_CONNECTION . "\n";
    echo "- DB_DSN_POSTGRES: " . DSN . "\n";
    echo "- DB_USER_POSTGRES: " . DB_USER . "\n";
    echo "- Mot de passe: " . (DB_PASSWORD ? "***configuré***" : "NON CONFIGURÉ") . "\n\n";

    echo "Tentative de connexion...\n";
    $pdo = Database::getInstance();

    if ($pdo) {
        echo "✅ Connexion réussie!\n\n";

        // supprimer les anciennes tables si elles existent
        $pdo->exec("DROP TABLE IF EXISTS users, compte, role, transaction CASCADE");

        // Test d'une requête simple
        echo "Test d'une requête SELECT...\n";
        $stmt = $pdo->query("SELECT version() as version");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "✅ Version PostgreSQL: " . $result['version'] . "\n\n";

        // Lister les tables existantes
        echo "Tables existantes dans la base :\n";
        $stmt = $pdo->query("SELECT tablename FROM pg_tables WHERE schemaname = 'public'");
        $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);

        if (empty($tables)) {
            echo "- Aucune table trouvée (base vide)\n";
        } else {
            foreach ($tables as $table) {
                echo "- $table\n";
            }
        }

        echo "\n=== Connexion Railway réussie! ===\n";
    } else {
        echo "❌ Échec de la connexion\n";
    }
} catch (Exception $e) {
    echo "❌ Erreur de connexion: " . $e->getMessage() . "\n";
    echo "Vérifiez vos paramètres de connexion Railway dans le fichier .env\n";
}
