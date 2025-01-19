<?php
/* 02_insert a new patient */

include "00_connect_db.php";

/* collect the values of the form submitted */
$ohip = $_POST['ohip'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$weight = $_POST['weight'];
$height = $_POST['height'];
$birthdate = $_POST['birthdate'];
$treatsdocid = $_POST['treatsdocid'];

/* check duplicate rows by checking the submitted ohip number against the database*/
$queryCheck = "SELECT * FROM patient WHERE ohip='$ohip'";
$resultCheck = mysqli_query($connection, $queryCheck);

if (mysqli_num_rows($resultCheck) > 0) {
    echo "Duplicate OHIP numbers. Enter again.";
} else {
    $queryInsert = "INSERT INTO patient 
        VALUES ('$ohip', '$firstname', '$lastname', $weight, '$birthdate', $height, '$treatsdocid')";
    $resultInsert = mysqli_query($connection, $queryInsert);
    if ($resultInsert){
        echo "New patient successfully added";
    } else {
        echo "Error: " . mysqli_error($connection);
    }
}

?>