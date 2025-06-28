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

// Get login data from form
$email = $_POST['email'];
$password = $_POST['password'];

// Check for match in the users table
$sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
  // Login successful
  echo "<script>
          alert('✅ Login successful!');
          window.location.href = 'booking.html';
        </script>";
} else {
  // Login failed
  echo "<script>
          alert('❌ Invalid email or password!');
          window.location.href = 'login.html';
        </script>";
}

$conn->close();
?>
