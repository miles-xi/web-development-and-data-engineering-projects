<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>03 delete a patient</title>
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
    <h1>Delete a patient here</h1>
    <form action="03_delete.php" method="POST">
        Select patient: <select name="patient_ohip">
                <?php
                    foreach ($patients as $row){
                        echo "<option value=" . $row['ohip'] . ">" . $row['firstname'] . " " . $row['lastname'] . "</option>";
                    }
                ?>
        <input type="submit">
    </form>

    <!-- Asking for confirmation to delete -->
    <!-- https://stackoverflow.com/questions/7410063/how-can-i-listen-to-the-form-submit-event-in-javascript-->
    <script>
        document.querySelector('form').addEventListener('submit', function(event){
            const response = confirm('Are you sure you want to delete this patient?')
            if (!response){
                event.preventDefault();
            }
        })
    </script>

    <!-- Refresh the page if uses uses 'back' button in the browser -->
    <!--https://stackoverflow.com/questions/43043113/how-to-force-reloading-a-page-when-using-browser-back-button-->
    <script>
        window.addEventListener("pageshow", function (event){
            var historyTraversal = event.persisted || 
                (typeof window.performance != "undefined" && 
                window.performance.navigation.type === 2 );
            if (historyTraversal) {
                // Handle page restore.
                window.location.reload();
            }
        });
    </script>
    </div>

    <!-- Close the database connection -->
    <?php mysqli_close($connection); ?>
</body>
</html>

