<?php
// Database connection
$servername = "localhost";
$username = "root";  // Replace with your MySQL username
$password = "";  // Replace with your MySQL password
$dbname = "gestion_etudiants";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert student data if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Collect form data
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $age = $_POST['age'];
    $filiere = $_POST['filiere'];

    // SQL query to insert data into the "etudiants" table
    $sql = "INSERT INTO etudiants (nom, prenom, email, age, filiere) VALUES ('$nom', '$prenom', '$email', '$age', '$filiere')";

    if ($conn->query($sql) === TRUE) {
        echo "<p>Student added successfully!</p>";
    } else {
        echo "<p>Error: " . $sql . "<br>" . $conn->error . "</p>";
    }
}

// Retrieve all students
$sql = "SELECT * FROM etudiants";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Student Registration</h1>

        <!-- Form to add a student -->
        <form action="index.php" method="POST">
            <div class="form-group">
                <label for="nom">Nom:</label>
                <input type="text" id="nom" name="nom" required>
            </div>
            <div class="form-group">
                <label for="prenom">Prénom:</label>
                <input type="text" id="prenom" name="prenom" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="age">Age:</label>
                <input type="number" id="age" name="age" required>
            </div>
            <div class="form-group">
                <label for="filiere">Filière:</label>
                <input type="text" id="filiere" name="filiere" required>
            </div>
            <button type="submit" name="submit">Add Student</button>
        </form>

        <h2>Students List</h2>

        <!-- Display the list of students in a table -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Age</th>
                    <th>Filière</th>
                    <th>Date de création</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Display all students from the database
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row["id"] . "</td>
                                <td>" . $row["nom"] . "</td>
                                <td>" . $row["prenom"] . "</td>
                                <td>" . $row["email"] . "</td>
                                <td>" . $row["age"] . "</td>
                                <td>" . $row["filiere"] . "</td>
                                <td>" . $row["date_creation"] . "</td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No students found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
// Close connection
$conn->close();
?>
