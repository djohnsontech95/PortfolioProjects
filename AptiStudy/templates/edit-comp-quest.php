<?php 
    // Start session
    session_start();

    // Code to redirect user if they are not logged in
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
    }

    // redirects the user back to create-profile.php if they attempt to access view-profile, even after
    // being logged (only if they have not created an account)
    if (!isset($_SESSION['user_fname']) && !isset($_SESSION['user_lname']) && !isset($_SESSION['username']) && !isset($_SESSION['college_standing'])) {
        header("Location: create-profile.php");
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Compatibility Questionnaire | AptiStudy</title>

    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <?php include '../other-assets/navbar-profile.php';?>
    <?php include '../other-assets/footer.php';?>

    <!-- *************************************
                ALEX - SPRINT 09
    ************************************** -->

    
</body>
</html>