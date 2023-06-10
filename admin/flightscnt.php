<?php

require '../helpers/init_conn_db.php';

if(!$conn){
    die("Connection Failed");
}

$sql = "SELECT * FROM flight";
                $query = $conn->query($sql);

                echo "$query->num_rows";
?>