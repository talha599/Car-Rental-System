<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "car"; // Correct database name

// ✅ Create connection with correct DB name
$conn = new mysqli($servername, $username, $password, $dbname);

// ✅ Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// ✅ Fetch bookings
$sql = "SELECT * FROM bookings";
$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Driver Dashboard</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f2f2f2;
      padding: 20px;
    }
    header {
      background: #333;
      color: white;
      text-align: center;
      padding: 1em;
    }
    nav a {
      color: white;
      margin: 0 10px;
      text-decoration: none;
    }
    table {
      width: 90%;
      margin: 20px auto;
      border-collapse: collapse;
      background: white;
    }
    th, td {
      padding: 12px;
      border: 1px solid #ccc;
      text-align: center;
    }
    th {
      background-color: #333;
      color: white;
    }
  </style>
</head>
<body>
  <header>
    <h1>Driver Dashboard</h1>
    <nav>
      <a href="logout.php">Logout</a>
    </nav>
  </header>

  <main>
    <h2 style="text-align:center;">Booking Records</h2>
    <table>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Number</th>
        <th>Car</th>
        <th>Pickup Date</th>
        <th>Return Date</th>
      </tr>

      <?php
      if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
          echo "<tr>
                  <td>{$row['id']}</td>
                  <td>{$row['name']}</td>
                  <td>{$row['number']}</td>
                  <td>{$row['car']}</td>
                  <td>{$row['pickup']}</td>
                  <td>{$row['return_date']}</td>
                </tr>";
        }
      } else {
        echo "<tr><td colspan='5'>No bookings found</td></tr>";
      }

      $conn->close();
      ?>
    </table>
  </main>
</body>
</html>
