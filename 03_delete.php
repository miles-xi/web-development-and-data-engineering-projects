<?php

include "00_connect_db.php";

/* collect the ohip number that has been selected */
$patient_ohip = $_POST['patient_ohip'];

/* perform deletion */
$deleteQuery = "DELETE FROM patient WHERE ohip = '$patient_ohip'";
$deleteResult = mysqli_query($connection, $deleteQuery);
if ($deleteResult){
    echo "Patient successfully deleted";
} else {
    echo "Error: " . mysqli_error($connection);
}

?>