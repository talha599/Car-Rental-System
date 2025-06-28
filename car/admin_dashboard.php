<?php
// DB Connection
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "car";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle Deletion
if (isset($_GET['delete'])) {
    $table = $_GET['table'];
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM `$table` WHERE id = $id");
    header("Location: admin_dashboard.php");
    exit();
}

// Handle Insert/Update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $table = $_POST['table'];
    $isEdit = isset($_POST['id']) && $_POST['id'] !== "";

    $columns = [];
    $values = [];

    foreach ($_POST as $key => $value) {
        if ($key === 'table' || $key === 'id') continue;
        $columns[] = "`$key`";
        $values[] = "'" . $conn->real_escape_string($value) . "'";
    }

    if ($isEdit) {
        $id = (int)$_POST['id'];
        $updates = [];
        foreach ($_POST as $key => $value) {
            if ($key === 'table' || $key === 'id') continue;
            $updates[] = "`$key` = '" . $conn->real_escape_string($value) . "'";
        }
        $sql = "UPDATE `$table` SET " . implode(",", $updates) . " WHERE id = $id";
    } else {
        $sql = "INSERT INTO `$table` (" . implode(",", $columns) . ") VALUES (" . implode(",", $values) . ")";
    }

    $conn->query($sql);
    header("Location: admin_dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background:rgb(241, 255, 131);
      padding: 20px;
    }
    h1, h2 {
      text-align: center;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 40px;
      background: #fff;
    }
    th, td {
      border: 1px solid #ddd;
      padding: 10px;
      text-align: center;
    }
    th {
      background-color: #333;
      color: white;
    }
    a.button {
      padding: 5px 10px;
      margin: 0 2px;
      background: #007BFF;
      color: white;
      text-decoration: none;
      border-radius: 4px;
    }
    a.delete {
      background: red;
    }
    form {
      margin: 20px auto;
      background: #fff;
      padding: 15px;
      border-radius: 8px;
      width: 80%;
    }
    form input, form select {
      padding: 8px;
      margin: 5px;
    }
    form input[type="submit"] {
      background: green;
      color: white;
      border: none;
    }

  </style>
</head>
<body>

<h1>Admin Dashboard</h1>
    <nav>
      <h4><a href="logout.php">Logout</a></h4>
    </nav>
<?php
$tables = ['admins', 'bookings', 'drivers', 'users'];

foreach ($tables as $table) {
    echo "<h2>$table</h2>";

    // If editing
    $editData = null;
    if (isset($_GET['edit']) && $_GET['table'] === $table) {
        $id = (int)$_GET['edit'];
        $res = $conn->query("SELECT * FROM `$table` WHERE id = $id");
        $editData = $res->fetch_assoc();
    }

    // Fetch structure
    $columns = [];
    $result = $conn->query("SHOW COLUMNS FROM `$table`");
    while ($row = $result->fetch_assoc()) {
        $columns[] = $row['Field'];
    }

    // Insert/Edit form
    echo "<form method='POST'>";
    foreach ($columns as $col) {
        $value = $editData[$col] ?? "";
        $readonly = ($col === 'id') ? 'readonly' : '';
        echo "<label>$col: <input type='text' name='$col' value='$value' $readonly></label>";
    }
    echo "<input type='hidden' name='table' value='$table'>";
    echo "<input type='submit' value='" . ($editData ? "Update" : "Add New") . "'>";
    echo "</form>";

    // Show table data
    $res = $conn->query("SELECT * FROM `$table`");
    if ($res->num_rows > 0) {
        echo "<table><tr>";
        foreach ($columns as $col) echo "<th>$col</th>";
        echo "<th>Actions</th></tr>";

        while ($row = $res->fetch_assoc()) {
            echo "<tr>";
            foreach ($columns as $col) echo "<td>{$row[$col]}</td>";
            echo "<td>
                <a class='button' href='?edit={$row['id']}&table=$table'>Edit</a>
                <a class='button delete' href='?delete={$row['id']}&table=$table' onclick=\"return confirm('Are you sure?')\">Delete</a>
            </td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No records found in <strong>$table</strong>.</p>";
    }
}
?>

</body>
</html>
