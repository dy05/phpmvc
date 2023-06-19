<?php
//step1: create a database connection
include ('../dbConn.php');
?>


<!Doctype html>
<html>
<head>
    <title>Document</title>
</head>
<body>

<form action="#" method="get">
    <label for="nom">Nom:</label>
    <input type="text" name="nom" placeholder="Nom">
    
    <label for="prenom">Prénom:</label>
    <input type="text" name="prenom" placeholder="Prénom">
    
    <label for="role">Rôle:</label>
    <select id="" name="role" placeholder="Rôle">
        <option value="">vide</option>
        <option value="administrateur">Administrateur</option>
        <option value="personnel">Personnel</option>
        <option value="professeur">Professeur</option>
        <option value="étudiant">Etudiant</option>
    </select>
    
    <label for="statut">Statut:</label>
    <select id="" name="statut" placeholder="Statut">
        <option value="">vide</option>
        <option value="validé">Validé</option>
        <option value="en attente">En attente</option>
    </select>
    
    <input type="submit" value="filtré" name="btnSend">
    <input type="reset" value="effacer">
</form>

    <h2>Admin Students Details</h2>
    <?php
    //step2: create a database query

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $conditions = array();

        if (!empty($_GET['nom'])) {
            $nom = $_GET['nom'];
            $conditions[] = "nom LIKE '%$nom%'";
        }

        if (!empty($_GET['prenom'])) {
            $prenom = $_GET['prenom'];
            $conditions[] = "prenom LIKE '%$prenom%'";
        }

        if (!empty($_GET['role'])) {
            $role = $_GET['role'];
            $conditions[] = "role = '$role'";
        }

        if (!empty($_GET['statut'])) {
            $statut = $_GET['statut'];
            $conditions[] = "statut = '$statut'";
        }

        // Construire la clause WHERE en combinant les conditions
        $whereClause = "";
        if (!empty($conditions)) {
            $whereClause = "WHERE " . implode(" AND ", $conditions);
        }

        // Exécuter la requête avec la clause WHERE appropriée
        $query = "SELECT * FROM user $whereClause";
        $results = mysqli_query($connection, $query);
    }

            
    //step3: execute the query

    ?>
    <table border="1" cellspacing='10'>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prenom</th>
            <th>Email</th>
            <th>Mot de passe</th>
            <th>Rôle</th>
            <th>Statut</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($results)){
            echo '<tr>';
            echo '<td>'. $row['ID'] . '</td>';
            echo '<td>'. $row['nom'] . '</td>';
            echo '<td>'. $row['prenom'] . '</td>';
            echo '<td>'. $row['email'] . '</td>';
            echo '<td>'. $row['password'] . '</td>';
            echo '<td>'. $row['role'] . '</td>';
            echo '<td>'. $row['statut'] . '</td>';
            echo '<td><a href="../editPage.php?ID=' . $row['ID'] . '">Modifier</a></td>';
            echo '<td><a href="../deletePage.php?ID=' . $row['ID'] . '">Supprimer</a></td>';
            echo '</tr>';
        }
    ?>
    </table>
    </body>
    </html>