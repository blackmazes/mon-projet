<?php
require 'config.php';
if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $c = ['nom','prenom','niveau','naissance','adresse','telephone'];
    foreach ($c as $k) if (empty(trim($_POST[$k] ?? ''))) $message = 'Tous les champs sont requis.';
    if (!$message) {
        $stmt = $conn->prepare("INSERT INTO stagiaires (nom, prenom, niveau, naissance, adresse, telephone) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $_POST['nom'], $_POST['prenom'], $_POST['niveau'], $_POST['naissance'], $_POST['adresse'], $_POST['telephone']);
        $message = $stmt->execute() ? 'Ajouté avec succès.' : 'Erreur : ' . $stmt->error;
        $stmt->close();
    }
}
$res = $conn->query("SELECT * FROM stagiaires ORDER BY created_at DESC LIMIT 6");
$stagiaires = $res->fetch_all(MYSQLI_ASSOC);
$conn->close();
?>
<!DOCTYPE html><html lang="fr"><head><meta charset="UTF‑8"><title>Stagiaires</title>
<style>
body{font-family:Arial;margin:20px;background:#e0f8e0;}
.message{color:#c00;}
form{background:#a0dca0;padding:15px;border-radius:8px;max-width:600px;}
form label{display:block;margin-top:8px;}
form input, form textarea{width:100%;padding:6px;margin-top:4px;border:1px solid #888;border-radius:4px;}
form button{margin-top:10px;padding:8px 16px;background:#4caf50;color:white;border:none;border-radius:4px;cursor:pointer;}
.grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:20px;margin-top:30px;}
.stagiaire{background:#a0dca0;padding:15px;border-radius:6px;box-shadow:1px 1px 4px rgba(0,0,0,0.1);}
.stagiaire h3{margin-top:0;color:#084;}
.logout{position:absolute;top:20px;right:20px;}
</style>
</head><body>
<a class="logout" href="logout.php">Déconnexion</a>
<h1>Ajouter un stagiaire</h1>
<?php if($message):?><div class="message"><?=htmlspecialchars($message)?></div><?php endif;?>
<form method="POST">
  <!-- champs nom,prenom etc identiques à précédemment -->
  <label>Nom <input name="nom" required></label>
  <label>Prénom <input name="prenom" required></label>
  <label>Niveau universitaire <input name="niveau" required></label>
  <label>Date de naissance <input type="date" name="naissance" required></label>
  <label>Adresse <textarea name="adresse" required></textarea></label>
  <label>Téléphone <input name="telephone" required></label>
  <button type="submit">Ajouter</button>
</form>
<h2>Derniers stagiaires</h2>
<div class="grid">
<?php foreach($stagiaires as $s): ?>
  <div class="stagiaire">
    <h3><?=htmlspecialchars("$s[prenom] $s[nom]")?></h3>
    <p><strong>Niveau :</strong> <?=htmlspecialchars($s['niveau'])?></p>
    <p><strong>Naissance :</strong> <?=htmlspecialchars($s['naissance'])?></p>
    <p><strong>Adresse :</strong> <?=htmlspecialchars($s['adresse'])?></p>
    <p><strong>Téléphone :</strong> <?=htmlspecialchars($s['telephone'])?></p>
  </div>
<?php endforeach; ?>
</div>
</body></html>
