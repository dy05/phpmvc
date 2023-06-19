<?php
//step1: create a database connection
include('../dbConn.php');



if(isset($_POST['btnRegister'])){
    $nom = $_POST['txtnom'];
    $prenom = $_POST['txtprenom'];
    $email = $prenom . "." . $nom . "@efrei.fr";
    $mdp = $_POST['txtmdp'];
    $role = $_POST['txtrole'];

    
 // Check if user already exists
$querysame = "SELECT * FROM user WHERE email = '$email'";
$resultsame = mysqli_query($connection, $querysame);
$count = mysqli_num_rows($resultsame);

 // Check if user already exists
    if ($count > 0) {
        echo "Un compte avec cet email existe déjà.";
    }
    else {
        $query = "INSERT INTO user(nom,prenom,email,password,role,statut) VALUES('$nom','$prenom','$email','$mdp','$role','validé')";
        $results = mysqli_query($connection, $query);
        if ($results) {
            $_SESSION['txtemail'] = $email;
            //include('email\awpreg.php');
            echo "Succès réussie.";
            echo "<a href='absences.php'>Aller à la page principale</a>";
        } else {
            echo "Échec de la création de compte.";
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
        Mot de passe: <input type='password' name='txtmdp' required><br>
        Role : <select name='txtrole'>
            <option value='administrateur'>Administrateur</option>
            <option value='personnel'>Personnel</option>
            <option value='professeur'>Professeur</option>
            <option value='étudiant'>Etudiant</option>
        <input type='submit' name='btnRegister' value='Register'>
    </form>
</body>
</html>

