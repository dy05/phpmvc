<?php 
include 'dbConn.php';
$id = $_GET['ID'];
$query = "DELETE FROM formation WHERE ID = $id";
if(mysqli_query($connection, $query)){
    header("Location: Administrateur/list_formation.php");
}
else{
    echo "Error: " . $query . "<br>" . mysqli_error($conn);
}
mysql_close($connection);
?>