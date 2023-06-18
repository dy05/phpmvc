<?php
//step1: create a database connection
include('../dbConn.php');



if(isset($_POST['btnRegister'])){
    $nom = $_POST['txtnom'];


    


 // Check if user already exists
 $querysame = "SELECT * FROM formation WHERE nom_formation = '$nom'";
 $resultsame = mysqli_query($connection, $querysame);
 $count = mysqli_num_rows($resultsame);
 
  // Check if user already exists
    if ($count > 0) {
        echo "Un compte avec cet email existe déjà.";
    }
    else {
        $query = "INSERT INTO formation(nom_formation) VALUES('$nom')";
        $results = mysqli_query($connection, $query);
        if ($results) {
            echo "Création de fomation.";
            echo "<a href='index.php'>Aller à la page principale</a>";
        } else {
            echo "Échec de la création de fomation.";
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
        <input type='submit' name='btnRegister' value='Register'>
    </form>
</body>
</html>

