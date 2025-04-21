<?php
// Chemin vers ton fichier JSON
$json = file_get_contents('utilisateurs.json');

// Décoder les données
$data = json_decode($json, true);

// API URL dyalek
$api_url = 'https://api.sheetbest.com/sheets/387f5ae0-22ea-4bfa-b3a1-012da0aebfd1';

foreach ($data as $utilisateur) {
    // Convertir chaque ligne en JSON
    $postData = json_encode($utilisateur);

    // Envoyer la donnée à Google Sheet via Sheet.best API
    $ch = curl_init($api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json'
    ]);

    $response = curl_exec($ch);
    curl_close($ch);
}

echo "✅ Les données ont été envoyées avec succès à Google Sheet!";
?>