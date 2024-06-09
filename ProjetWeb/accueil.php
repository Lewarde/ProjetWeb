<?php
  session_start(); // Assurez-vous que les sessions sont démarrées

  // Connexion à la base de données
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "projetweb";

  // Créer la connexion
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Vérifier la connexion
  if ($conn->connect_error) {
      die("Connexion échouée: " . $conn->connect_error);
  }

  // Récupérer l'id de l'utilisateur de la session
  $idUser = $_SESSION['idUsers'];

  // Préparer et exécuter la requête SQL
  $sql = "SELECT titre FROM notes WHERE idUsers = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $idUser);
  $stmt->execute();
  $result = $stmt->get_result();

  // Fermer la connexion
  $stmt->close();
  $conn->close();
?>


<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <title>Accueil</title>
    <link rel="stylesheet" href="style/styleAccueil.css" />
  </head>
  <body>
  
    <div class="titreAccueil">
      <p>Bienvenue dans votre espace! Vous pouvez y retrouver vos notes :</p>
    </div>

    <div class="zoneActions">
      <button class="btnCreerPage">Créer une nouvelle page</button>
    </div>

    <div class="zoneChoixFormulaire">
      <?php while ($row = $result->fetch_assoc()): ?>
        <div class="pageItem">
          <span><?php echo htmlspecialchars($row['titre']); ?></span>
          <button class="btnAcceder">Accéder</button>
          <button class="btnSupprimer">Supprimer</button>
        </div>
      <?php endwhile; ?>
    </div>


  </body>
</html>