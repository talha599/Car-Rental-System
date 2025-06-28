<?php
session_start();
session_unset();  // Clear all session variables
session_destroy();  // Destroy the session

// Show alert and redirect to login page
echo "<script>
        alert('🚪 You have been logged out.');
        window.location.href = 'index.html';
      </script>";
exit;
?>