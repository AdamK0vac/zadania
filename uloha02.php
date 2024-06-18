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

$sql = "SELECT orders.OrderID, customers.CustomerID, customers.CompanyName 
        FROM orders 
        JOIN customers ON orders.CustomerID = customers.CustomerID 
        WHERE YEAR(orders.OrderDate) = 1996";
displayQueryResults($conn, $sql, "...");

// ------------------------------------------------------------- Poziadavka 02
echo "<h1> Poziadavka 02 </h1>";

$sql = "SELECT city, 
        (SELECT COUNT(*) FROM employees WHERE employees.City = e.City) AS Employees, 
        (SELECT COUNT(*) FROM customers WHERE customers.City = e.City) AS Customers 
        FROM employees e 
        GROUP BY city";
displayQueryResults($conn, $sql, "...");

// ------------------------------------------------------------- Poziadavka 03
echo "<h1> Poziadavka 03 </h1>";

$sql = "SELECT city, 
        (SELECT COUNT(*) FROM employees WHERE employees.City = c.City) AS Employees, 
        (SELECT COUNT(*) FROM customers WHERE customers.City = c.City) AS Customers 
        FROM customers c 
        GROUP BY city";
displayQueryResults($conn, $sql, "...");

// ------------------------------------------------------------- Poziadavka 04
echo "<h1> Poziadavka 04 </h1>";

$sql = "SELECT city, 
        (SELECT COUNT(*) FROM employees WHERE employees.City = ec.City) AS Employees, 
        (SELECT COUNT(*) FROM customers WHERE customers.City = ec.City) AS Customers 
        FROM (
        SELECT City FROM employees 
        UNION 
        SELECT City FROM customers
        ) ec 
        GROUP BY city";
displayQueryResults($conn, $sql, "...");


// ------------------------------------------------------------- Poziadavka 05
echo "<h1> Poziadavka 05 </h1>";

$sql = "SELECT orders.OrderID, CONCAT(employees.FirstName, ' ', employees.LastName) AS EmployeeName
        FROM orders
        JOIN employees ON orders.EmployeeID = employees.EmployeeID
        WHERE orders.ShippedDate > orders.RequiredDate";
displayQueryResults($conn, $sql, "...");

// ------------------------------------------------------------- Poziadavka 06
echo "<h1> Poziadavka 06 </h1>";

$sql = "SELECT ProductID, SUM(Quantity) AS TotalQuantity
        FROM `order details`
        GROUP BY ProductID
        HAVING TotalQuantity < 200";
displayQueryResults($conn, $sql, "...");

// ------------------------------------------------------------- Poziadavka 07
echo "<h1> Poziadavka 07 </h1>";

$sql = "SELECT CustomerID, COUNT(OrderID) AS TotalOrders
        FROM orders
        WHERE OrderDate > '1994-12-31'
        GROUP BY CustomerID
        HAVING TotalOrders > 15";
displayQueryResults($conn, $sql, "...");

$conn->close();

?>
