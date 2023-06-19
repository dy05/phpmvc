<?php
//step1: create a database connection
include ('../dbConn.php');
// Exécuter la requête avec la clause WHERE appropriée
        $query = "SELECT * FROM formation";
        $results = mysqli_query($connection, $query);      
    //step3: execute the query

    ?>
    <table border="1" cellspacing='10'>
        <tr>
            <th>ID</th>
            <th>Nom</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($results)){
            echo '<tr>';
            echo '<td>'. $row['ID'] . '</td>';
            echo '<td>'. $row['nom_formation'] . '</td>';
            echo '<td><a href="../editPageformation.php?ID=' . $row['ID'] . '">Modifier</a></td>';
            echo '<td><a href="../deletePageformation.php?ID=' . $row['ID'] . '">Supprimer</a></td>';
            echo '</tr>';
        }
    ?>
    </table>
    </body>
    </html>