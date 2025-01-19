<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>02 Add a new patient</title>
    <link rel="stylesheet" href="sidenav.css">
</head>
<body>
    <?php
        include '00_connect_db.php';
        $queryDoc = "SELECT docid, firstname, lastname FROM doctor";
        $resultDoc = mysqli_query($connection, $queryDoc) 
            or die ('Query doctor failed: ' . mysqli_error($connection));
        $doctors = mysqli_fetch_all($resultDoc, MYSQLI_ASSOC);
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
    <h1>Add a new patient here</h1>
    <form action="02_insert.php" method="POST">
        <ol>
            <li>ohip: <input type="text" name="ohip"></li><br>
            <li>first name: <input type="text" name="firstname"></li>
            <li>last name: <input type="text" name="lastname"></li>
            <li>weight in kilograms: <input type="text" name="weight"></li>
            <li>birthdate: <input type="text" name="birthdate"></li> 
            <li>height in meters: <input type="text" name="height"></li><br>
            <li>Select doctor: <select name="treatsdocid">
                <?php
                    foreach ($doctors as $row){
                        /* Each <option> tag is created with the value of docid, 
                        eg, <option value="123">
                        When user selects a doctor in the dropdown, 
                        the browser submits the value of the selected <option> 
                        as part of the form data under the name='treatsdocid' attribute */
                        echo "<option value=" . $row['docid'] . ">" . $row['firstname'] . " " . $row['lastname'] . "</option>";
                    }?>
                </select>
            </li>
        </ol>
        <input type="submit">
    </form>
    </div>

    <!-- Close the database connection -->
    <?php mysqli_close($connection); ?>
</body>
</html>