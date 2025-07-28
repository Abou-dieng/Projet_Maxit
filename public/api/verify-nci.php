<?php
// Fichier : public/api/verify-nci.php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Méthode non autorisée']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$nci = $input['nci'] ?? null;
if (!$nci) {
    http_response_code(400);
    echo json_encode(['error' => 'NCI manquant']);
    exit;
}

// Appel distant à l'API onrender
$url = 'https://application-daf.onrender.com/api/v1/citoyens/' . urlencode($nci);
$options = [
    'http' => [
        'method' => 'GET',
        'header' => [
            'Accept: application/json',
        ],
        'timeout' => 10
    ]
];
$context = stream_context_create($options);
$response = @file_get_contents($url, false, $context);

if ($response === false) {
    http_response_code(502);
    echo json_encode(['error' => "Erreur de connexion à l'API distante"]);
    exit;
}

// Retourne la réponse brute de l'API
http_response_code(200);
echo $response;
