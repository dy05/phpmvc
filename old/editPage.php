<?php
include 'dbConn.php';
$id = $_GET['ID'];

if (isset($_POST['btnUpdate'])){
    $nom = $_POST['txtnom'];
    $prenom = $_POST['txtprenom'];
    $email = $_POST['txtemail'];
    $password = $_POST['txtmdp'];
    $role = $_POST['txtrole'];
    $statut = $_POST['txtstatut'];

    $updateQuery = "UPDATE user SET nom = '$nom', prenom = '$prenom', email = '$email', password = '$password', role= '$role' WHERE statut = '$statut'";
    $resultQuery = mysqli_query($connection, $updateQuery);
    if($resultQuery){
        echo "the user has been updated<br>";
    }
    else{
        echo "the user has not been updated<br>";
    }
}

$query = "SELECT * FROM user WHERE ID = $id";
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
        Nom: <input type='text' name='txtnom' value="<?php echo $row['nom'] ?>" required><br>
        Prénom: <input type='text' name='txtprenom' value="<?php echo $row['prenom'] ?>" required><br>
        Email: <input type='email' name='txtemail' value='<?php echo $row['email'] ?>' required><br>
        Mot de passe: <input type='text' name='txtmdp' value='<?php echo $row['password'] ?>' required><br>
        Role: <select name='txtrole' value='<?php echo $row['role'] ?>'>
            <option value='administrateur'>Administrateur</option>
            <option value='personnel'>Personnel</option>
            <option value='professeur'>Professeur</option>
            <option value='étudiant'>Etudiant</option>
        </select>
        <br>
        Statut: <input type='text' name='txtstatut' value='<?php echo $row['statut'] ?>' required><br>
            
        <br><br>
        <input type='submit' name='btnUpdate' value='Mettre à jour'>
    </form>
    <br><br>
    <a href='Administrateur/liste_utilisateur.php'>Aller à la page principale</a>
</body>
</html>