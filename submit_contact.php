<?php
// Conectarea la baza de date
$servername = "localhost";  // Adresa serverului de baza de date
$username = "username";     // Numele de utilizator pentru accesul la baza de date
$password = "password";     // Parola pentru accesul la baza de date
$dbname = "mydatabase";     // Numele bazei de date

// Crearea unei conexiuni noi la baza de date
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificarea conexiunii
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Verificarea dacă formularul a fost trimis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']); // Protejează împotriva atacurilor XSS
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Validarea datelor introduse
    $errors = [];
    if (empty($name)) {
        $errors[] = "Numele este obligatoriu.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Adresa de email nu este validă.";
    }
    if (empty($message)) {
        $errors[] = "Mesajul nu poate fi gol.";
    }

    // Procesarea și inserarea datelor în baza de date dacă nu există erori
    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $message);
        if ($stmt->execute()) {
            echo "Mesajul a fost trimis cu succes!";
        } else {
            echo "Eroare la inserarea datelor: " . $stmt->error;
        }
        $stmt->close();
    } else {
        // Afișarea mesajelor de eroare
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
    }
}

// Închiderea conexiunii la baza de date
$conn->close();
?>
