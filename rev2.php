<?php
// 1. Créer un tableau associatif pour les employés et calculer le salaire moyen
$employees = [
    ['nom' => 'rim', 'poste' => 'Développeur', 'salaire' => 5000],
    ['nom' => 'mouad', 'poste' => 'Designer', 'salaire' => 4000],
    ['nom' => 'Charlie', 'poste' => 'Manager', 'salaire' => 6000],
    ['nom' => 'Diana', 'poste' => 'Analyste', 'salaire' => 4500],
    ['nom' => 'Eve', 'poste' => 'HR', 'salaire' => 3500],
];

function calculerSalaireMoyen($employes) {
    $total = array_sum(array_column($employes, 'salaire'));
    return $total / count($employes);
}

// 2. Recherche dynamique d'un employé par nom
$searchResult = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nomRecherche'])) {
    $nomRecherche = $_POST['nomRecherche'];
    foreach ($employees as $employee) {
        if (strtolower($employee['nom']) == strtolower($nomRecherche)) {
            $searchResult = "Nom: {$employee['nom']}, Poste: {$employee['poste']}, Salaire: {$employee['salaire']} €";
            break;
        }
    }
    if (!$searchResult) {
        $searchResult = "Employé non trouvé.";
    }
}

// 3. Formulaire de connexion (email et mot de passe)
$users = [
    ['email' => 'user@example.com', 'password' => 'password123'],
    ['email' => 'admin@example.com', 'password' => 'adminpass'],
];
$loginMessage = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email'])) {
    $email = $_POST['email'];
    $password = $_POST['motdepasse'];
    foreach ($users as $user) {
        if ($user['email'] == $email && $user['password'] == $password) {
            $loginMessage = "Connexion réussie.";
            break;
        }
    }
    if (!$loginMessage) {
        $loginMessage = "Identifiants incorrects.";
    }
}

// 4. Panier et calcul du total
$panier = [
    ['produit' => 'Produit 1', 'quantite' => 2, 'prix' => 15],
    ['produit' => 'Produit 2', 'quantite' => 1, 'prix' => 30],
    ['produit' => 'Produit 3', 'quantite' => 3, 'prix' => 20],
];

function calculerTotalPanier($panier) {
    $total = 0;
    foreach ($panier as $item) {
        $total += $item['quantite'] * $item['prix'];
    }
    return $total;
}

// 5. Soumettre un commentaire
$comments = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['commentaire'])) {
    $commentaire = $_POST['commentaire'];
    $timestamp = date('Y-m-d H:i:s');
    $comments[] = ['commentaire' => $commentaire, 'timestamp' => $timestamp];
}

// 6. Ville avec la température la plus élevée
$villes = [
    'Paris' => 15,
    'Lyon' => 22,
    'Marseille' => 28,
    'Nice' => 26,
];

$villeMaxTemperature = array_search(max($villes), $villes);

// 7. Lecture et affichage d'un fichier CSV
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['csvFile'])) {
    $file = $_FILES['csvFile']['tmp_name'];
    if (($handle = fopen($file, "r")) !== FALSE) {
        $produits = [];
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $produits[] = ['nom' => $data[0], 'prix' => $data[1], 'quantite' => $data[2]];
        }
        fclose($handle);
    }
}

// 8. Sélection de produits via des cases à cocher
$produitsSelectionnes = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['produits'])) {
    $produitsSelectionnes = $_POST['produits'];
}

// 9. Moyenne des notes des étudiants
$students = [
    'rim' => ['Math' => 15, 'Anglais' => 14, 'Physique' => 18],
    'mouad' => ['Math' => 12, 'Anglais' => 10, 'Physique' => 14],
];
function calculerMoyenne($notes) {
    return array_sum($notes) / count($notes);
}

// 10. Gestion des utilisateurs
$utilisateurs = [
    ['nom' => 'rim', 'email' => 'alice@example.com'],
    ['nom' => 'mouad', 'email' => 'bob@example.com'],
];

function ajouterUtilisateur($nom, $email) {
    global $utilisateurs;
    $utilisateurs[] = ['nom' => $nom, 'email' => $email];
}

function supprimerUtilisateur($email) {
    global $utilisateurs;
    foreach ($utilisateurs as $key => $user) {
        if ($user['email'] == $email) {
            unset($utilisateurs[$key]);
            break;
        }
    }
}

?>

<!-- Formulaire pour la recherche d'employé -->
<form method="POST">
    <input type="text" name="nomRecherche" placeholder="Nom de l'employé" required>
    <button type="submit">Rechercher</button>
</form>
<p><?php echo $searchResult; ?></p>

<!-- Formulaire de connexion -->
<form method="POST">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="motdepasse" placeholder="Mot de passe" required>
    <button type="submit">Se connecter</button>
</form>
<p><?php echo $loginMessage; ?></p>

<!-- Affichage du salaire moyen -->
<p>Salaire moyen des employés : <?php echo calculerSalaireMoyen($employees); ?> €</p>

<!-- Affichage des produits du panier et calcul du total -->
<p>Total du panier : <?php echo calculerTotalPanier($panier); ?> €</p>

<!-- Affichage de la ville avec la température la plus élevée -->
<p>La ville avec la température la plus élevée est : <?php echo $villeMaxTemperature; ?></p>

<!-- Soumettre un commentaire -->
<form method="POST">
    <textarea name="commentaire" placeholder="Laissez un commentaire"></textarea>
    <button type="submit">Soumettre</button>
</form>

<h3>Commentaires :</h3>
<ul>
    <?php foreach ($comments as $comment) : ?>
        <li><?php echo $comment['timestamp']; ?> - <?php echo $comment['commentaire']; ?></li>
    <?php endforeach; ?>
</ul>

<!-- Affichage des étudiants et de leurs moyennes -->
<h3> Moyennes des étudiants :</h3>
<?php foreach ($students as $nom => $notes) : ?>
    <p><?php echo $nom; ?> : Moyenne = <?php echo calculerMoyenne($notes); ?></p>
<?php endforeach; ?>

<!-- Formulaire pour télécharger un fichier CSV -->
<form method="POST" enctype="multipart/form-data">
    <input type="file" name="csvFile" required>
    <button type="submit">Télécharger CSV</button>
</form>
<h3>Produits importés du CSV :</h3>
<?php if (isset($produits)) : ?>
    <table>
        <tr>
            <th>Nom</th>
            <th>Prix</th>
            <th>Quantité</th>
        </tr>
        <?php foreach ($produits as $produit) : ?>
            <tr>
                <td><?php echo $produit['nom']; ?></td>
                <td><?php echo $produit['prix']; ?> €</td>
                <td><?php echo $produit['quantite']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<!-- Sélection de produits via cases à cocher -->
<form method="POST">
    <input type="checkbox" name="produits[]" value="Produit 1"> Produit 1 (15 €)<br>
    <input type="checkbox" name="produits[]" value="Produit 2"> Produit 2 (30 €)<br>
    <input type="checkbox" name="produits[]" value="Produit 3"> Produit 3 (20 €)<br>
    <button type="submit">Valider</button>
</form>

<h3>Produits sélectionnés :</h3>
<ul>
    <?php foreach ($produitsSelectionnes as $produit) : ?>
        <li><?php echo $produit; ?></li>
    <?php endforeach; ?>
</ul>

</body>
</html>
