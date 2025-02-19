<?php
include "00_connect_db.php";

/* collect the the values that has been submitted */
$newWeight = $_POST['newWeight'];
$unit = $_POST['unit'];
$patient_ohip = $_POST['patient_ohip'];

/* convert weight to kilograms */
if ($unit == 'lb') {
    $newWeight = $newWeight * 0.4535;
    $newWeight = round($newWeight, 2);
}

$modifyQuery = "UPDATE patient SET weight='$newWeight' WHERE ohip = '$patient_ohip'";
$modifyResult = mysqli_query($connection, $modifyQuery);
if ($modifyResult){
    echo "Patient weight successfully modified";
} else {
    echo "Error: " . mysqli_error($connection);
}

mysqli_close($connection);
?>