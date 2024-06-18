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

$sql = "SELECT SUM(UnitPrice * Quantity) AS TotalRevenueFrom1994 FROM `order details` od 
        JOIN orders o ON od.OrderID = o.OrderID 
        WHERE YEAR(o.OrderDate) = 1994";
displayQueryResults($conn, $sql, "...");

// ------------------------------------------------------------- Poziadavka 02
echo "<h1> Poziadavka 02 </h1>";

$sql = "SELECT c.CustomerID, c.CompanyName, SUM(od.UnitPrice * od.Quantity) as TotalPaid
        FROM customers c
        JOIN orders o ON c.CustomerID = o.CustomerID
        JOIN `order details` od ON o.OrderID = od.OrderID
        GROUP BY c.CustomerID, c.CompanyName";
displayQueryResults($conn, $sql, "...");

// ------------------------------------------------------------- Poziadavka 03
echo "<h1> Poziadavka 03 </h1>";

$sql = "SELECT p.ProductID, p.ProductName, SUM(od.Quantity) as TotalSold
        FROM products p
        JOIN `order details` od ON p.ProductID = od.ProductID
        GROUP BY p.ProductID, p.ProductName
        ORDER BY TotalSold DESC
        LIMIT 10";
displayQueryResults($conn, $sql, "...");

// ------------------------------------------------------------- Poziadavka 04
echo "<h1> Poziadavka 04 </h1>";

$sql = "SELECT c.CustomerID, c.CompanyName, SUM(od.UnitPrice * od.Quantity) as TotalRevenue
        FROM customers c
        JOIN orders o ON c.CustomerID = o.CustomerID
        JOIN `order details` od ON o.OrderID = od.OrderID
        GROUP BY c.CustomerID, c.CompanyName";
displayQueryResults($conn, $sql, "...");


// ------------------------------------------------------------- Poziadavka 05
echo "<h1> Poziadavka 05 </h1>";

$sql = "SELECT c.CustomerID, c.CompanyName, SUM(od.UnitPrice * od.Quantity) as TotalPaid
        FROM customers c
        JOIN orders o ON c.CustomerID = o.CustomerID
        JOIN `order details` od ON o.OrderID = od.OrderID
        WHERE c.Country = 'UK'
        GROUP BY c.CustomerID, c.CompanyName
        HAVING TotalPaid > 1000";
displayQueryResults($conn, $sql, "...");

// ------------------------------------------------------------- Poziadavka 06
echo "<h1> Poziadavka 06 </h1>";

$sql = "SELECT c.CustomerID, c.CompanyName, c.Country,
           SUM(od.UnitPrice * od.Quantity) as TotalPaid,
           SUM(CASE WHEN YEAR(o.OrderDate) = 1995 THEN od.UnitPrice * od.Quantity ELSE 0 END) as TotalPaid1995
        FROM customers c
        JOIN orders o ON c.CustomerID = o.CustomerID
        JOIN `order details` od ON o.OrderID = od.OrderID
        GROUP BY c.CustomerID, c.CompanyName, c.Country";
displayQueryResults($conn, $sql, "...");

// ------------------------------------------------------------- Poziadavka 07
echo "<h1> Poziadavka 07 </h1>";

$sql = "SELECT COUNT(DISTINCT CustomerID) as TotalCustomers
        FROM orders";
displayQueryResults($conn, $sql, "...");

// ------------------------------------------------------------- Poziadavka 07
echo "<h1> Poziadavka 07 </h1>";

$sql = "SELECT COUNT(DISTINCT o.CustomerID) as TotalCustomers1997
        FROM orders o
        WHERE YEAR(o.OrderDate) = 1997";
displayQueryResults($conn, $sql, "...");

$conn->close();

?>
