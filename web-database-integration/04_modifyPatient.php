<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>04 Modify a patient</title>
    <link rel="stylesheet" href="sidenav.css">
</head>
<body>
    <?php 
        include '00_connect_db.php';
        $query = "SELECT ohip, firstname, lastname FROM patient";
        $result = mysqli_query($connection, $query)
            or die('Query patients failed: ' . mysqli_error($connection));
        $patients = mysqli_fetch_all($result, MYSQLI_ASSOC);
    ?>

    <!-- Side navigation-->
    <!-- https://www.w3schools.com/howto/howto_css_fixed_sidebar.asp -->
    <div class="sidenav">
        <a href="mainmenu.php">Main Menu</a><br>
        <a href="01_listPatients.html">List all patients</a><br>
        <a href="02_addNewPatient.php">Add a new patient</a><br>
        <a href="03_deletePatient.php">Remove a patient</a><br>
        <a href="04_modifyPatient.php">Modify a patient</a><br>
        <a href="05_doctorPatientNurse.php">Our staff</a><br>
    </div>

    <!-- Main content-->
    <div class="main">
    <h1>Modify a patient here</h1>
    <form action="04_modify.php" method="POST">
        <h2>New weight: </h2> 
        <input type="text" name="newWeight"> 
        <input type="radio" name="unit" value="kg" checked> kilograms
        <input type="radio" name="unit" value="lb"> pounds
        <h2>Select patient: </h2> 
        <select name="patient_ohip">
            <?php
                foreach ($patients as $row){
                    echo "<option value=" . $row['ohip'] . ">" . $row['firstname'] . " " . $row['lastname'] . "</option>";
                }
            ?>
        </select><br>
        <input type="submit">
    </form>
    </div>
        
    <!-- Close the database connection -->
    <?php mysqli_close($connection); ?>
</body>
</html>