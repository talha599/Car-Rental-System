<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "car";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Collect form data
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];

// Insert into users table
$sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";

if ($conn->query($sql) === TRUE) {
  // Show popup and redirect
  echo "<script>
          alert('✅ Registration successful!');
          window.location.href = 'login.html';
        </script>";
} else {
  echo "❌ Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
