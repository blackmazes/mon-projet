<?php
require 'config.php';
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['username']) || empty($_POST['password'])) {
        $msg = 'Remplissez tous les champs.';
    } else {
        $stmt = $conn->prepare('SELECT id, password FROM users WHERE username = ?');
        $stmt->bind_param('s', $_POST['username']);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($id, $hash);
            $stmt->fetch();
            if (password_verify($_POST['password'], $hash)) {
                session_regenerate_id();
                $_SESSION['user_id'] = $id;
                header('Location: index.php');
                exit;
            } else {
                $msg = 'Mot de passe incorrect.';
            }
        } else {
            $msg = 'Utilisateur introuvable.';
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html><html lang="fr"><head><meta charset="UTF‑8"><title>Connexion</title>
<style>body{background:#e0f8e0;font-family:Arial;padding:50px;}form{background:#a0dca0;padding:20px;border-radius:8px;max-width:300px;margin:auto;}input{width:100%;padding:8px;margin:8px 0;border:1px solid #888;border-radius:4px;}button{background:#4caf50;color:#fff;padding:10px;border:none;border-radius:4px;cursor:pointer;} .msg{color:#c00;}</style>
</head><body>
<h2>Connexion</h2>
<?php if($msg): ?><p class="msg"><?=htmlspecialchars($msg)?></p><?php endif; ?>
<form method="POST">
  <input name="username" placeholder="Nom d’utilisateur" required>
  <input type="password" name="password" placeholder="Mot de passe" required>
  <button type="submit">Se connecter</button>
</form>
</body></html>
