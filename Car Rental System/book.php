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
$number= $_POST['number'];
$car = $_POST['car'];
$pickup = $_POST['pickup'];
$return = $_POST['return'];

// Insert into bookings table
$sql = "INSERT INTO bookings (name, car, number, pickup, return_date) 
        VALUES ('$name', $number, '$car', '$pickup', '$return')";

if ($conn->query($sql) === TRUE) {
  // Booking success: show popup and redirect
  echo "<script>
          alert('✅ Booking successful!');
          window.location.href = 'booking.html';
        </script>";
} else {
  echo "❌ Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
