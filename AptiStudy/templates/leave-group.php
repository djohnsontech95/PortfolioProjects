<?php 
    //start session
    session_start();

    //connection to database
    $connection = mysqli_connect("****", "****", "****", "****");
    if (mysqli_connect_errno()) {
        die("Failed to connect to MySQL: " . mysqli_connect_error());
    }

    // Code to redirect user if they are not logged in
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
    }

    // redirects the user back to create-profile.php if they attempt to access view-profile, even after
    // being logged (only if they have not created an account)
    if (!isset($_SESSION['user_fname']) && !isset($_SESSION['user_lname']) && !isset($_SESSION['username']) && !isset($_SESSION['college_standing'])) {
        header("Location: create-profile.php");
    }

    //authentication ID
    $userID = $_SESSION['user_id'];

    $groupID = $_POST['group_id'];
    $studentID = $_POST['studentLeave'];
    $hostID = $_POST['host_id'];

    //if loop to handle correct leave query
    if ($studentID == $hostID) {

        $leaveQuery = "UPDATE study_group
            SET host_id=NULL
            WHERE study_group.id=$groupID AND study_group.host_id=$studentID;";
    }
    else {
       
        $leaveQuery = "DELETE FROM group_members
            WHERE group_members.group_id=$groupID AND group_members.member_id=$studentID;";
    }

    $leaveResult = mysqli_query($connection, $leaveQuery);

    if (mysqli_query($connection, $leaveQuery)) {
        echo "";
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Group | Aptistudy</title>
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/styles.css">
    <link href="https://fonts.iu.edu/style.css?family=BentonSans:regular,bold|BentonSansCond:regular|GeorgiaPro:regular" media="screen" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://unpkg.com/rivet-core@2.3.1/css/rivet.min.css">
</head>
<body>
    <!-- **************************************************************************
    ERROR PAGE LAYOUT - SERVER ERROR

    -> rivet.iu.edu/layouts/error-page/
    *************************************************************************** -->

    <?php include '../other-assets/navbar-home.php';?>

    <!-- **************************************************************************
        Main content area
    *************************************************************************** -->

    <main id="main-content" class="rvt-flex rvt-flex-column rvt-grow-1">
        <div class="rvt-bg-black-000 rvt-border-bottom rvt-p-tb-xxl">
            <div class="rvt-container-sm rvt-prose rvt-flow">

                <!-- **************************************************************
                    Page title and icon
                *************************************************************** -->

                <div class="rvt-row">
                    <div class="rvt-cols-9">
                        <h1 class="rvt-m-bottom-md">Group left</h1>
                        <p class="rvt-ts-18 rvt-color-black-500 rvt-width-xxl">You have successfully left the group. Click on the button below to return to your dashboard. </p>
                    </div>
                    <div class="rvt-cols-3 rvt-hide-md-down">
                        <svg width="100%" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M24 48C37.2548 48 48 37.2548 48 24C48 10.7452 37.2548 0 24 0C10.7452 0 0 10.7452 0 24C0 37.2548 10.7452 48 24 48Z" fill="#C9D2D6"/>
                            <path d="M10.4102 36.69H37.6002V16.75H10.4102V36.69ZM22.5602 26.56L18.0802 22.08C17.9902 21.99 17.9902 21.85 18.0802 21.76L19.0402 20.8C19.1302 20.71 19.2702 20.71 19.3602 20.8L23.8402 25.28C23.9302 25.37 24.0702 25.37 24.1602 25.28L28.6402 20.8C28.7302 20.71 28.8702 20.71 28.9602 20.8L29.9202 21.76C30.0102 21.85 30.0102 21.99 29.9202 22.08L25.4402 26.56C25.3502 26.65 25.3502 26.79 25.4402 26.88L29.9202 31.36C30.0102 31.45 30.0102 31.59 29.9202 31.68L28.9602 32.64C28.8702 32.73 28.7302 32.73 28.6402 32.64L24.1602 28.16C24.0702 28.07 23.9302 28.07 23.8402 28.16L19.3602 32.64C19.2702 32.73 19.1302 32.73 19.0402 32.64L18.0802 31.68C17.9902 31.59 17.9902 31.45 18.0802 31.36L22.5602 26.88C22.6502 26.79 22.6502 26.65 22.5602 26.56Z" fill="white"/>
                            <path d="M10.4102 14.9403H37.6002V11.3203H10.4102V14.9403ZM18.5602 12.2203C19.0602 12.2203 19.4702 12.6303 19.4702 13.1303C19.4702 13.6303 19.0602 14.0403 18.5602 14.0403C18.0602 14.0403 17.6502 13.6303 17.6502 13.1303C17.6602 12.6203 18.0602 12.2203 18.5602 12.2203ZM15.8402 12.2203C16.3402 12.2203 16.7502 12.6303 16.7502 13.1303C16.7502 13.6303 16.3402 14.0403 15.8402 14.0403C15.3402 14.0403 14.9302 13.6303 14.9302 13.1303C14.9402 12.6203 15.3402 12.2203 15.8402 12.2203ZM13.1202 12.2203C13.6202 12.2203 14.0302 12.6303 14.0302 13.1303C14.0302 13.6303 13.6202 14.0403 13.1202 14.0403C12.6202 14.0403 12.2102 13.6303 12.2102 13.1303C12.2202 12.6203 12.6202 12.2203 13.1202 12.2203Z" fill="white"/>
                            <path d="M18.0802 31.3599C17.9902 31.4499 17.9902 31.5899 18.0802 31.6799L19.0402 32.6399C19.1302 32.7299 19.2702 32.7299 19.3602 32.6399L23.8402 28.1599C23.9302 28.0699 24.0702 28.0699 24.1602 28.1599L28.6402 32.6399C28.7302 32.7299 28.8702 32.7299 28.9602 32.6399L29.9202 31.6799C30.0102 31.5899 30.0102 31.4499 29.9202 31.3599L25.4402 26.8799C25.3502 26.7899 25.3502 26.6499 25.4402 26.5599L29.9202 22.0799C30.0102 21.9899 30.0102 21.8499 29.9202 21.7599L28.9602 20.7999C28.8702 20.7099 28.7302 20.7099 28.6402 20.7999L24.1602 25.2799C24.0702 25.3699 23.9302 25.3699 23.8402 25.2799L19.3602 20.7999C19.2702 20.7099 19.1302 20.7099 19.0402 20.7999L18.0802 21.7599C17.9902 21.8499 17.9902 21.9899 18.0802 22.0799L22.5602 26.5599C22.6502 26.6499 22.6502 26.7899 22.5602 26.8799L18.0802 31.3599Z" fill="#243142"/>
                            <path d="M38.5001 9.5H9.50009C9.00009 9.5 8.59009 9.91 8.59009 10.41V15.85V37.6C8.59009 38.1 9.00009 38.51 9.50009 38.51H38.5001C39.0001 38.51 39.4101 38.1 39.4101 37.6V15.84V10.4C39.4101 9.91 39.0001 9.5 38.5001 9.5ZM37.5901 36.69H10.4101V16.75H37.6001V36.69H37.5901ZM37.5901 14.94H10.4101V11.32H37.6001V14.94H37.5901Z" fill="#243142"/>
                            <path d="M13.1202 14.03C13.6228 14.03 14.0302 13.6225 14.0302 13.12C14.0302 12.6174 13.6228 12.21 13.1202 12.21C12.6176 12.21 12.2102 12.6174 12.2102 13.12C12.2102 13.6225 12.6176 14.03 13.1202 14.03Z" fill="#243142"/>
                            <path d="M15.8402 14.03C16.3428 14.03 16.7502 13.6225 16.7502 13.12C16.7502 12.6174 16.3428 12.21 15.8402 12.21C15.3376 12.21 14.9302 12.6174 14.9302 13.12C14.9302 13.6225 15.3376 14.03 15.8402 14.03Z" fill="#243142"/>
                            <path d="M18.5601 14.03C19.0627 14.03 19.4701 13.6225 19.4701 13.12C19.4701 12.6174 19.0627 12.21 18.5601 12.21C18.0576 12.21 17.6501 12.6174 17.6501 13.12C17.6501 13.6225 18.0576 14.03 18.5601 14.03Z" fill="#243142"/>
                        </svg>
                    </div>
                </div>
                <div>
                    <center>
                    <button class="rvt-button"><a class="leave_home" href="home.php">Home</a></button>
                    </center>
                </div>
            </div>
        </div>
    </main>

    <?php include '../other-assets/footer-scrolling.php';?>

    <?php
        mysqli_close($connection);
    ?>
</body>
</html>