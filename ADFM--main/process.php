<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "adfm";

$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    die("La connexion a échoué: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cin = $_POST['cin'];
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $password = $_POST['password'];

    $errors = [];

    // Vérifier si le CIN existe déjà
    $checkCIN = $conn->prepare("SELECT CIN FROM user WHERE CIN = ?");
    $checkCIN->bind_param("s", $cin);
    $checkCIN->execute();
    $checkCIN->store_result();

    if ($checkCIN->num_rows > 0) {
        $errors[] = "Ce CIN est déjà utilisé. Veuillez en saisir un autre.";
    }
    $checkCIN->close();

    // Validation CIN : 2 lettres majuscules + 5 chiffres
    if (empty($cin)) {
        $errors[] = "Le CIN est obligatoire";
    } elseif (!preg_match("/^[A-Z]{2}\d{5}$/", $cin)) {
        $errors[] = "Le CIN doit contenir 2 lettres majuscules suivies de 5 chiffres (ex: AB12345)";
    }

    // Validation prénom
    if (empty($prenom)) {
        $errors[] = "Le prénom est obligatoire";
    } elseif (!preg_match("/^[a-zA-ZÀ-ÿ\s]+$/", $prenom)) {
        $errors[] = "Le prénom doit contenir uniquement des lettres";
    }

    // Validation nom
    if (empty($nom)) {
        $errors[] = "Le nom est obligatoire";
    } elseif (!preg_match("/^[a-zA-ZÀ-ÿ\s]+$/", $nom)) {
        $errors[] = "Le nom doit contenir uniquement des lettres";
    }

    // Validation email : @gmail.com + au moins 3 caractères avant
    if (empty($email)) {
        $errors[] = "L'email est obligatoire";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format d'email invalide";
    } elseif (!preg_match("/^[a-zA-Z0-9._%+-]{3,}@gmail\.com$/", $email)) {
        $errors[] = "L'email doit être au format quelquechose@gmail.com (au moins 3 caractères avant @)";
    }

    // Validation téléphone
    if (empty($telephone)) {
        $errors[] = "Le téléphone est obligatoire";
    } elseif (!preg_match("/^06\d{8}$/", $telephone)) {
        $errors[] = "Le téléphone doit être au format 06XXXXXXXX";
    }

    // Validation mot de passe
    if (empty($password)) {
        $errors[] = "Le mot de passe est obligatoire";
    } elseif (!preg_match("/^(?=.*[A-Z])(?=.*\d)(?=.*[@\-\/_!]).{8,}$/", $password)) {
        $errors[] = "Le mot de passe doit contenir au moins 8 caractères, une majuscule, un chiffre et un symbole (@ - / _ !)";
    }

    if (!empty($errors)) {
        $error_string = implode("<br>", $errors);
        header("Location: index.php?error=" . urlencode($error_string));
        exit();
    }

    // Insertion
    $stmt = $conn->prepare("INSERT INTO user (CIN, nom, `prénom`, email, `téléphone`, `mot_de_passe`) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $cin, $nom, $prenom, $email, $telephone, $password);

    if ($stmt->execute()) {
        // 🔁 Génération automatique du fichier JSON après insertion

        $sql_json = "SELECT * FROM user";
        $result_json = $conn->query($sql_json);

        if ($result_json->num_rows > 0) {
            $data = [];

            while ($row = $result_json->fetch_assoc()) {
                $data[] = $row;
            }

            $json_data = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

            // 📁 Chemin du fichier JSON (tu peux le changer si tu veux)
            file_put_contents("utilisateurs.json", $json_data);
        }

        // ✅ Redirection vers le tableau
        header("Location: tableau.php");
        exit();
    }

    $stmt->close();
}

$conn->close();

?>