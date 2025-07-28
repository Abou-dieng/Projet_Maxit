<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAX IT - Connexion</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .gradient-bg {
            background: black;
        }
        .glass-effect {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.1);
        }
        /* .upload-zone {
            border: 2px dashed #6b7280;
            background: #f3f4f6;
            transition: all 0.3s ease;
        } */
        /* .upload-zone:hover {
            border-color: #ef4444;
            background: #fef2f2;
        } */
    </style>
</head>

<body class="min-h-screen flex items-center justify-center bg-black">

    <main class="w-full max-w-4xl mx-auto">
        <?php echo $content; ?>
    </main>

</body>
</html>
<?php
// PHP pour la gestion des erreurs et des requêtes
if (isset($_POST['submit'])) {
    // Vérifier les données de connexion
    $username = $_POST['username'];
    $password = $_POST['password'];
}