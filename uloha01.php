<?php

function displayQueryResults($conn, $sql, $tableName) {
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h2>$tableName</h2>";
        echo "<table border='1'><tr>";
        while ($fieldinfo = $result->fetch_field()) {
            echo "<th>{$fieldinfo->name}</th>";
        }
        echo "</tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $cell) {
                echo "<td>{$cell}</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "0 results for $tableName";
    }
}

// ------------------------------------------------------------- Connection

$conn = require __DIR__ . "/php/connect.php";

// ------------------------------------------------------------- Poziadavka 01
echo "<h1> Poziadavka 01 </h1>";

$sql = "SELECT * FROM customers ORDER BY Country, ContactName";
displayQueryResults($conn, $sql, "Customers");

$sql = "SELECT * FROM orders";
displayQueryResults($conn, $sql, "Orders");

$sql = "SELECT * FROM suppliers";
displayQueryResults($conn, $sql, "Suppliers");

// ------------------------------------------------------------- Poziadavka 02
echo "<h1> Poziadavka 02 </h1>";

$sql = "SELECT * FROM Customers ORDER BY Country, ContactName;";
displayQueryResults($conn, $sql, "Customers by Country, Name");

// ------------------------------------------------------------- Poziadavka 03
echo "<h1> Poziadavka 03 </h1>";

$sql = "SELECT * FROM Orders ORDER BY OrderDate;";
displayQueryResults($conn, $sql, "Order by OrderDate");

// ------------------------------------------------------------- Poziadavka 04
echo "<h1> Poziadavka 04 </h1>";

$sql = "SELECT COUNT(*) AS `Objednavky 1997` FROM Orders WHERE YEAR(OrderDate) = 1997";
displayQueryResults($conn, $sql, "Pocet objednavok 1997");


// ------------------------------------------------------------- Poziadavka 05
echo "<h1> Poziadavka 05 </h1>";

$sql = "SELECT ContactName FROM Customers WHERE ContactName LIKE '%Manager%' ORDER BY ContactName;";
displayQueryResults($conn, $sql, "Manager");

// ------------------------------------------------------------- Poziadavka 06
echo "<h1> Poziadavka 06 </h1>";

$sql = "SELECT * FROM Orders WHERE OrderDate = '1997-09-19';";
displayQueryResults($conn, $sql, "Objednavky september");

$conn->close();

?>
