<?php
include 'dbConn.php';
$id = $_GET['ID'];
// Récupérer l'ancien nom de formation

if (isset($_POST['btnUpdate'])){
    $nom = $_POST['txtnom'];

    $updateQuery = "UPDATE formation SET nom_formation = '$nom' WHERE nom_formation = '$nom'";
    $resultQuery = mysqli_query($connection, $updateQuery);

    if($resultQuery){
        echo "the user has been updated<br>";

        // Mettre à jour le nom_formation dans la table cours

        // Valider la transaction
        mysqli_commit($connection);

        if ($resultCoursQuery) {
            echo "Les cours correspondants ont été mis à jour<br>";
        } else {
            echo "Erreur lors de la mise à jour des cours<br>";
        }

    }
    else{
        echo "the user has not been updated<br>";
    }
}

$query = "SELECT * FROM formation WHERE ID = $id";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($result);
$count = mysqli_num_rows($result);


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
    <h1>Page de modification</h1>
    <form action='' method='post'>
        Nom: <input type='text' name='txtnom' value="<?php echo $row['nom_formation'] ?>" required><br>
        <br><br>
        <input type='submit' name='btnUpdate' value='Mettre à jour'>
    </form>
    <br><br>
    <a href='Administrateur/list_formation.php'>Aller à la liste formation</a>
</body>
</html>

