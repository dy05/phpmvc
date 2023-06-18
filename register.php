<?php
//step1: create a database connection
include('dbConn.php');

if(isset($_POST['btnRegister'])){
    $nom = $_POST['txtnom'];
    $prenom = $_POST['txtprenom'];
    $email = $prenom . "." . $nom . "@efrei.fr";
    $mdp = $_POST['txtmdp'];
    
    // Check if password and confirmation are the same
    if ($_POST['txtmdp'] != $_POST['txtmdp2']) {
        echo "Les mots de passe ne correspondent pas.";
        exit();
    }

    // Check if user already exists
    $querysame = "SELECT * FROM user WHERE email = '$email'";
    $resultsame = mysqli_query($connection, $querysame);
    $count = mysqli_num_rows($resultsame);

    // Check if user already exists
    if ($count > 0) {
        echo "Un compte avec cet email existe déjà.";
    } else {
        $query = "INSERT INTO user(nom,prenom,email,password,role,statut) VALUES('$nom','$prenom','$email','$mdp','étudiant','en attente')";
        $results = mysqli_query($connection, $query);
        if ($results) {
            $_SESSION['txtemail'] = $email;
            //include('email\awpreg.php');
            echo "Inscription réussie, nous vous avons envoyé un email de confirmation.";
            echo "<a href='index.php'>Aller à la page principale</a>";
        } else {
            echo "Échec de l'inscription.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Document</title>
</head>

<body>
    <h2>Registration page</h2>
    <form action='' method='post'>
        Nom: <input type='text' name='txtnom' required><br>
        Prenom: <input type='text' name='txtprenom' required><br>
        mot de passe: <input type='password' name='txtmdp' required><br>
        Confirmation: <input type='password' name='txtmdp2' required><br>
        <input type='submit' name='btnRegister' value='Register'>
    </form>
</body>
</html>

