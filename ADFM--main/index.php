<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire d'Inscription</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    ]



    <div class="container">
        <div class="theme-buttons">
            <button class="theme-icon" data-theme="violet" style="background-color: #8a2be2;"></button>
            <button class="theme-icon" data-theme="rose" style="background-color: #ff69b4;"></button>
            <button class="theme-icon" data-theme="vert" style="background-color: #32cd32;"></button>
            <button class="theme-icon" data-theme="orange" style="background-color:rgb(255, 72, 0);"></button>
            <button class="theme-icon" data-theme="jaune" style="background-color: #ffd700;"></button>
            <button class="theme-icon" data-theme="bleu" style="background-color: #007bff;"></button>
            <button class="theme-icon" data-theme="cyan" style="background-color:rgb(255, 0, 0);"></button>
            <button class="theme-icon" data-theme="magenta" style="background-color:rgb(180, 4, 103);"></button>
            <button class="theme-icon" data-theme="blanc" style="background-color: #ffffff;"></button>
            <button class="theme-icon" data-theme="noir" style="background-color: #000000;"></button>
        </div>
        <h2>Formulaire d'Inscription</h2>

        <?php
        // Afficher les messages d'erreur ou de succès
        if (isset($_GET['error'])) {
            echo '<div class="error-message">' . htmlspecialchars($_GET['error']) . '</div>';
        }
        if (isset($_GET['success'])) {
            echo '<div class="success-message">' . htmlspecialchars($_GET['success']) . '</div>';
        }
        ?>

        <form id="registrationForm" action="process.php" method="POST" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="cin">CIN:</label>
                <input type="text" id="cin" name="cin" placeholder="Entrez votre CIN">
                <span class="error" id="cinError"></span>
            </div>

            <div class="form-group">
                <label for="prenom">Prénom:</label>
                <input type="text" id="prenom" name="prenom" placeholder="Entrez votre prénom">
                <span class="error" id="prenomError"></span>
            </div>

            <div class="form-group">
                <label for="nom">Nom:</label>
                <input type="text" id="nom" name="nom" placeholder="Entrez votre nom">
                <span class="error" id="nomError"></span>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Entrez votre email">
                <span class="error" id="emailError"></span>
            </div>

            <div class="form-group">
                <label for="telephone">Téléphone:</label>
                <input type="text" id="telephone" name="telephone" placeholder="Entrez votre numéro de téléphone">
                <span class="error" id="telephoneError"></span>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe:</label>
                <input type="password" id="password" name="password" placeholder="Entrez votre mot de passe">
                <span class="error" id="passwordError"></span>
            </div>

            <button type="submit" class="submit-btn">S'inscrire</button>
        </form>
    </div>


    <script>
        function validateForm() {
            let isValid = true;

            // Réinitialiser les messages d'erreur
            document.querySelectorAll('.error').forEach(el => el.textContent = '');

            // Validation CIN
            const cin = document.getElementById('cin').value.trim();
            if (cin === '') {
                document.getElementById('cinError').textContent = 'Le CIN est obligatoire';
                isValid = false;
            }

            // Validation prénom
            const prenom = document.getElementById('prenom').value.trim();
            if (prenom === '') {
                document.getElementById('prenomError').textContent = 'Le prénom est obligatoire';
                isValid = false;
            } else if (!/^[a-zA-ZÀ-ÿ\s]+$/.test(prenom)) {
                document.getElementById('prenomError').textContent = 'Le prénom doit contenir uniquement des lettres';
                isValid = false;
            }

            // Validation nom
            const nom = document.getElementById('nom').value.trim();
            if (nom === '') {
                document.getElementById('nomError').textContent = 'Le nom est obligatoire';
                isValid = false;
            } else if (!/^[a-zA-ZÀ-ÿ\s]+$/.test(nom)) {
                document.getElementById('nomError').textContent = 'Le nom doit contenir uniquement des lettres';
                isValid = false;
            }

            // Validation email
            const email = document.getElementById('email').value.trim();
            if (email === '') {
                document.getElementById('emailError').textContent = 'L\'email est obligatoire';
                isValid = false;
            } else if (!email.endsWith('@gmail.com')) {
                document.getElementById('emailError').textContent = 'L\'email doit être au format @gmail.com';
                isValid = false;
            }

            // Validation téléphone
            const telephone = document.getElementById('telephone').value.trim();
            if (telephone === '') {
                document.getElementById('telephoneError').textContent = 'Le téléphone est obligatoire';
                isValid = false;
            } else if (!/^\d+$/.test(telephone)) {
                document.getElementById('telephoneError').textContent = 'Le téléphone doit contenir uniquement des chiffres';
                isValid = false;
            }

            // Validation mot de passe
            const password = document.getElementById('password').value;
            if (password === '') {
                document.getElementById('passwordError').textContent = 'Le mot de passe est obligatoire';
                isValid = false;
            }

            return isValid;
        }
    </script>


    <script src="theme.js"></script>
</body>

</html>