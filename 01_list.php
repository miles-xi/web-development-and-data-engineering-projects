<?php
/* 01_list all the patients */
include "00_connect_db.php";

$orderBy = $_POST['order_by'];
$order = $_POST['order'];

$query = "
    SELECT ohip, p.firstname AS p_firstname, p.lastname AS p_lastname, weight, p.birthdate As p_birthdate, height, treatsdocid, d.firstname AS d_firstname, d.lastname AS d_lastname
    FROM patient As p
    LEFT JOIN doctor d ON p.treatsdocid=d.docid
    ORDER BY $orderBy $order";

$result = mysqli_query($connection, $query)
    or die ('Query failed: ' . mysqli_error($connection));
$data = mysqli_fetch_all($result, MYSQLI_ASSOC);


if ($data) {
    echo "<table border='1'>";
    echo "<tr>
        <th>ohip</th>
        <th>patient firstname</th>
        <th>patient lastname</th>
        
        <th>weight (kilogram)</th>
        <th>weight (pounds)</th>

        <th>birthdate</th>

        <th>height (meter)</th>
        <th>height (feet and inches)</th>

        <th>treatsdocid</th>
        <th>doctor firstname</th>
        <th>doctor lastname</th>

        </tr>";
    foreach ($data as $row) {
        /* var_dump($row);*/
        echo "<tr>";
        echo "<td>" . $row["ohip"] . "</td>";
        echo "<td>" . $row["p_firstname"] . "</td>";
        echo "<td>" . $row["p_lastname"] . "</td>";

        echo "<td>" . $row["weight"] . "</td>";
        echo "<td>" . $row["weight"] * 2.2 . "</td>";

        echo "<td>" . $row["p_birthdate"] . "</td>";
        
        echo "<td>" . $row["height"] . "</td>";
       	$heightFt = floor($row["height"] * 3.28084);
        $heightIn = round(($row["height"] * 3.28084 - $heightFt) * 12);
        echo "<td>" . $heightFt . " feet " . $heightIn . " inches </td>";

        echo "<td>" . $row["treatsdocid"] . "</td>";
        echo "<td>" . $row["d_firstname"] . "</td>";
        echo "<td>" . $row["d_lastname"] . "</td>";

        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No patients found.";
}

mysqli_close($connection);

/* https://stackoverflow.com/questions/17902483/show-values-from-a-mysql-database-table-inside-a-html-table-on-a-webpage*/

?>
