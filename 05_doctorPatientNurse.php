<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>05 Doctor and patient</title>
    <link rel="stylesheet" href="sidenav.css">
</head>
<body>
    <?php 
        include '00_connect_db.php';
        $query = "SELECT docid, firstname, lastname FROM doctor
            WHERE docid NOT IN (SELECT treatsdocid FROM patient)";
        $result = mysqli_query($connection, $query)
            or die('Query 1 failed: ' . mysqli_error($connection));
        $doctors = mysqli_fetch_all($result, MYSQLI_ASSOC);

        $query2 = "SELECT d.firstname AS d_firstname, d.lastname AS d_lastname, p.firstname AS p_firstname, p.lastname AS p_lastname
            FROM doctor d, patient p
            WHERE p.treatsdocid = d.docid";
        $result2 = mysqli_query($connection, $query2) 
            or die('Query 2 failed: ' . mysqli_error($connection));
        $doctors2 = mysqli_fetch_all($result2, MYSQLI_ASSOC);

        $query3 = 'SELECT nurseid, firstname, lastname FROM nurse';
        $result3 = mysqli_query($connection, $query3)
            or die('Query 3 failed: ' . mysqli_error($connection));
        $nurses = mysqli_fetch_all($result3, MYSQLI_ASSOC);
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
    <h1>Doctors who have no patients</h1>
        <table border="1">
            <tr>
                <th>doctor id</th>
                <th>first name</th>
                <th>last name</th>
            </tr>
            <?php foreach ($doctors as $row){
                echo "<tr>";
                echo "<td>" . $row["docid"] . "</td>";
                echo "<td>" . $row["firstname"] . "</td>";
                echo "<td>" . $row["lastname"] . "</td>";
                echo "<tr>";
            }?>
        </table>

    <h1>Doctors who have patients</h1>
        <table border="1">
            <tr>
                <th>doctor first name</th>
                <th>doctor last name</th>
                <th>patient first name</th>
                <th>patient last name</th>
            </tr>
            <?php foreach ($doctors2 as $row){
                echo "<tr>";
                echo "<td>" . $row["d_firstname"] . "</td>";
                echo "<td>" . $row["d_lastname"] . "</td>";
                echo "<td>" . $row["p_firstname"] . "</td>";
                echo "<td>" . $row["p_lastname"] . "</td>";
                echo "<tr>";

            }?>
        </table>
    
    <h1> Select a nurses and show</h1>
        <form method="POST">
            Please select a nurse: <select name="nurseid">
                <?php foreach ($nurses as $row){
                    echo "<option value=" . $row['nurseid'] . ">" . $row['firstname'] . " " . $row['lastname'] . "</option>";
                }?>
            </select><br>
            <input type="submit">
        </form>
    
    <h2> This nurse's details</h2>
    <?php
        include '00_connect_db.php';
        if (isset($_POST['nurseid'])){
        $nurseid = $_POST['nurseid'];
        $query4 = "
            SELECT n.firstname AS n_firstname, n.lastname AS n_lastname, 
                d.firstname AS d_firstname, d.lastname AS d_lastname, w.hours AS w_hours
            FROM nurse n
            LEFT JOIN workingfor w ON n.nurseid = w.nurseid
            LEFT JOIN doctor d ON w.docid = d.docid
            WHERE n.nurseid = '$nurseid'";
        $result4 = mysqli_query($connection, $query4) 
            or die(mysqli_error($connection));
        $nurses4 = mysqli_fetch_all($result4, MYSQLI_ASSOC);

        $query5 = "
            SELECT n.firstname AS n_firstname, n.lastname AS n_lastname, 
                SUM(w.hours) AS total_hours, 
                s.firstname AS s_firstname, s.lastname AS s_lastname
            FROM nurse n
            LEFT JOIN nurse s ON n.reporttonurseid = s.nurseid
            LEFT JOIN workingfor w ON n.nurseid = w.nurseid
            WHERE n.nurseid = '$nurseid' 
            GROUP BY n.nurseid";
        $result5 = mysqli_query($connection, $query5)
            or die(mysqli_error($connection));
        $nurses5 = mysqli_fetch_all($result5, MYSQLI_ASSOC);
    }
    ?>

    <table border="1">
        <tr>
            <th>nurse first name</th>
            <th>nurse last name</th>
            <th>doctor first name</th>
            <th>doctor last name</th>
            <th>working hours</th>
        </tr>
        <?php 
            if (isset($_POST['nurseid'])){
            foreach ($nurses4 as $row){
            echo "<tr>";
            echo "<td>" . $row["n_firstname"] . "</td>";
            echo "<td>" . $row["n_lastname"] . "</td>";
            echo "<td>" . $row["d_firstname"] . "</td>";
            echo "<td>" . $row["d_lastname"] . "</td>";
            echo "<td>" . $row["w_hours"] . "</td>";
            echo "<tr>";
        }}?>
    </table><br>

    <table border="1">
        <tr>
            <th>nurse first name</th>
            <th>nurse last name</th>
            <th>total working hours</th>
            <th>supervisor first name</th>
            <th>supervisor last name</th>
        </tr>
        <?php 
            if (isset($_POST['nurseid'])){
            foreach ($nurses5 as $row){
            echo "<tr>";
            echo "<td>" . $row["n_firstname"] . "</td>";
            echo "<td>" . $row["n_lastname"] . "</td>";
            echo "<td>" . $row["total_hours"] . "</td>";
            echo "<td>" . $row["s_firstname"] . "</td>";
            echo "<td>" . $row["s_lastname"] . "</td>";
            echo "<tr>";
        }}?>
    </table>
    </div>
            
    <!-- Close the database connection -->
    <?php mysqli_close($connection); ?>
</body>
</html>