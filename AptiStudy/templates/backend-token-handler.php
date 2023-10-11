<?php
session_start();

// store generated user token after authentication is verified
$id_token = $_POST['credential'];

// decode obfuscated token to JSON equivalent with authentication parameters
// need to divide header and payload
$token_info = "https://oauth2.googleapis.com/tokeninfo?id_token=" . $id_token;

// store payload of user token
$token_response = file_get_contents($token_info);

// convert JSON string to PHP variable
$php_object = json_decode($token_response);

// store unique user identifier to track users logged in to site
$_SESSION['user_id'] = $php_object->{'sub'};

// ---------------------------------------------------------------------------------

$conn = mysqli_connect("****", "****", "****", "****");

// Check connection
if (mysqli_connect_errno()) {
  die("Failed to connect to MySQL: " . mysqli_connect_error());
}

// determines if a user has created a profile yet
if (isset($_SESSION['user_id'])) {
  $sql_query = "SELECT user_authentication.authenticate_id AS user_match
                  FROM user_authentication";
  $result = mysqli_query($conn, $sql_query);

  while ($row = mysqli_fetch_assoc($result)) {
    $user_match = $row['user_match'];

    // if profile has been created, send user to homepage
    if ($_SESSION['user_id'] == $user_match) {
      header("Location: home.php");
      exit();
    }
  }
  header("Location: create-profile.php");
} 
// else send the user to the login page so that this page is inaccessible
else {
  header("Location: login.php");
}

// close the connection
mysqli_close($conn);
?>