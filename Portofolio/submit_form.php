<?php
// Informations de connexion à SQL Server en local
$serverName = "DESKTOP-ETHAC5A"; // Nom de l'instance SQL Server
$databaseName = "Portofolio";
$username = "DESKTOP-ETHAC5\J.Ze"; // Utilisateur SQL Server
$password = ""; // Mot de passe de l'utilisateur

try {
    // Connexion à SQL Server avec PDO
    $conn = new PDO("sqlsrv:Server=$serverName;Database=$databaseName", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Récupère les données du formulaire
        $name = htmlspecialchars($_POST['name']);
        $email = htmlspecialchars($_POST['email']);
        $message = htmlspecialchars($_POST['message']);

        // Validation des données
        if (empty($name) || empty($email) || empty($message)) {
            throw new Exception("Tous les champs sont obligatoires.");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("L'adresse email n'est pas valide.");
        }

        // Requête SQL pour insérer les données
        $sql = "INSERT INTO Contacts (Name, Email, Message) VALUES (:name, :email, :message)";
        $stmt = $conn->prepare($sql);

        // Liaison des paramètres
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':message', $message);

        // Exécution de la requête
        $stmt->execute();

        // Redirection en cas de succès
        header("Location: thank_you.html");
        exit();
    } else {
        // Redirection si la méthode n'est pas POST
        header("Location: error.html");
        exit();
    }
} catch (PDOException $e) {
    // En cas d'erreur de connexion ou d'exécution SQL
    error_log("Erreur SQL : " . $e->getMessage());
    header("Location: error.html");
    exit();
} catch (Exception $e) {
    // En cas d'erreur de validation
    error_log("Erreur de validation : " . $e->getMessage());
    header("Location: error.html");
    exit();
}
?>