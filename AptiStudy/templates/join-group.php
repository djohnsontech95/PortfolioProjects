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

    //connection to database
    $connection = mysqli_connect("****", "****", "****", "****");
    if (mysqli_connect_errno()) {
        die("Failed to connect to MySQL: " . mysqli_connect_error());
    }

    //session ID
    $userID = $_SESSION['user_id'];

    $groupID = $_POST['group_id'];
    $studentID = $_POST['student_id'];
    $group_name = $_POST['group_name'];

    //Query to insert user into group
    $joinQuery = "INSERT INTO group_members (group_id, member_id)
        VALUES ($groupID, $studentID);";

    $joinResult = mysqli_query($connection, $joinQuery);

    if ($joinResult == "True" OR $joinResult == "true") {
        echo "";
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Group | AptiStudy</title>

    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <?php include '../other-assets/navbar-home.php';?>

    <!-- **************************************************************************
    CONFIRMATION PAGE LAYOUT
    
    -> rivet.iu.edu/layouts/confirmation-page/
    *************************************************************************** -->

    <!-- **************************************************************************
        Main content area
    *************************************************************************** -->

    <main id="main-content" class="rvt-layout__wrapper rvt-layout__wrapper--single rvt-container-sm">
        
        <div class='rvt-layout__content'>
            
            <!-- ******************************************************************
                Success message
            ******************************************************************* -->
                    
            <div class="rvt-p-all-xl rvt-color-white rvt-bg-green-000 rvt-border-all rvt-border-radius rvt-border-color-green">
                <div class="rvt-text-center">
                    <svg width="40" height="48" viewBox="0 0 40 48" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M20 0C20.6162 0.544682 21.2362 1.06588 21.9102 1.53864C22.0151 1.61221 22.1263 1.68894 22.2437 1.76843C23.0656 2.32485 24.1921 3.01661 25.5899 3.70947C25.9895 3.90752 26.411 4.10553 26.8536 4.30041C29.9518 5.66457 34.0862 6.87545 39 6.87545H40V23.8354C40 31.6275 37.1229 36.6487 33.162 40.1474C29.6467 43.2526 25.2923 45.135 21.5796 46.74C21.547 46.7541 21.5144 46.7682 21.4819 46.7823C21.4457 46.7979 21.4095 46.8135 21.3735 46.8291C21.0934 46.9503 20.8171 47.0699 20.5453 47.1885L20.5435 47.1893C20.4958 47.2101 20.4482 47.2309 20.4008 47.2516L20 47.427L19.5992 47.2516C19.215 47.0835 18.8214 46.9134 18.4204 46.74C14.7077 45.135 10.3533 43.2526 6.83797 40.1474C2.87714 36.6487 0 31.6275 0 23.8354V6.87545H1C5.91383 6.87545 10.0482 5.66457 13.1464 4.30041C13.589 4.10553 14.0105 3.90752 14.4101 3.70947C15.8079 3.01661 16.9344 2.32485 17.7563 1.76843C17.8737 1.68894 17.9849 1.61222 18.0898 1.53865C18.7639 1.06584 19.3841 0.54512 20 0Z" fill="white"/>
                        <path d="M26.8243 20.7497L17.3536 30.2204L13 25.1412L14.5185 23.8396L17.4665 27.279L25.41 19.3354L26.8243 20.7497Z" fill="#056E41"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M20 12.3354C13.3726 12.3354 8 17.708 8 24.3354C8 30.9629 13.3726 36.3354 20 36.3354C26.6274 36.3354 32 30.9629 32 24.3354C32 17.708 26.6274 12.3354 20 12.3354ZM10 24.3354C10 18.8126 14.4772 14.3354 20 14.3354C25.5228 14.3354 30 18.8126 30 24.3354C30 29.8583 25.5228 34.3354 20 34.3354C14.4772 34.3354 10 29.8583 10 24.3354Z" fill="#056E41"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M19.0371 0.833992C18.827 1.0012 18.5092 1.2445 18.0898 1.53865C17.2507 2.12724 16.0076 2.91763 14.4101 3.70947C11.2135 5.29389 6.6158 6.87545 1 6.87545H0V23.8354C0 31.6275 2.87714 36.6487 6.83797 40.1474C10.3533 43.2526 14.7077 45.135 18.4204 46.74C18.8214 46.9134 19.215 47.0835 19.5992 47.2516L20 47.427L20.4008 47.2516C20.785 47.0835 21.1786 46.9134 21.5796 46.74C25.2923 45.135 29.6467 43.2526 33.162 40.1474C37.1229 36.6487 40 31.6275 40 23.8354V6.87545H39C33.3842 6.87545 28.7865 5.29389 25.5899 3.70947C23.9924 2.91763 22.7493 2.12723 21.9102 1.53864C21.4908 1.24449 21.173 1.0012 20.9629 0.833992C20.6303 0.569381 20.3181 0.281467 20 0C19.682 0.281344 19.3695 0.569512 19.0371 0.833992ZM2 8.85976V23.8354C2 31.0433 4.62286 35.5222 8.16203 38.6485C11.4241 41.5299 15.4802 43.2866 19.2297 44.9104C19.488 45.0223 19.7449 45.1335 20 45.2445C20.2551 45.1335 20.512 45.0223 20.7703 44.9104C24.5198 43.2866 28.5759 41.5299 31.838 38.6485C35.3771 35.5222 38 31.0433 38 23.8354V8.85976C32.4586 8.68575 27.9114 7.09232 24.7017 5.50143C23.0007 4.65827 21.6708 3.81367 20.7617 3.17601C20.4617 2.96556 20.2072 2.77746 20 2.61912C19.7928 2.77746 19.5383 2.96556 19.2383 3.17601C18.3292 3.81367 16.9993 4.65827 15.2983 5.50143C12.0886 7.09232 7.54138 8.68575 2 8.85976Z" fill="#056E41"/>
                    </svg>
                </div>
                <h2 class="rvt-ts-32 rvt-text-center rvt-text-medium rvt-color-green-500">Thanks for joining!</h2>
                <p class="rvt-ts-18 rvt-text-center rvt-color-green-500">You can find recent notifications below or on the home page</p>
                    
                    <!-- **************************************************************
                        Confirmation box
                    *************************************************************** -->

                <p class="rvt-flex rvt-items-center rvt-justify-center rvt-p-tb-sm rvt-m-top-xl rvt-m-bottom-none rvt-ts-23 rvt-text-center rvt-text-uppercase rvt-bg-green-600 rvt-border-radius">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                        <g fill="currentColor">
                            <path d="M4,10.23H1.92V2H8V3h2V2A2,2,0,0,0,8,0H1.92a2,2,0,0,0-2,2v8.23a2,2,0,0,0,2,2H4Z"/>
                            <path d="M14,16H8a2,2,0,0,1-2-2V7A2,2,0,0,1,8,5h6a2,2,0,0,1,2,2v7A2,2,0,0,1,14,16ZM8,7v7h6V7Z"/>
                        </g>
                    </svg>
                    <p class="rvt-p-left-sm rvt-font-mono">You are now a member of <?php echo $group_name; ?></p>
                </p>
            </div>

            <!-- Location for random notifications or events specific to group -->
            <div class="rvt-cols-6-md" style="margin-top: 20px;">
                <div class="rvt-card rvt-card--clickable rvt-card--raised [ rvt-m-bottom-lg ]">
                    <div class="rvt-card__body">
                        <h2 class="rvt-card__title">
                            <a href="#0">Late Night I495 Quiz Review</a>
                        </h2>
                        <div class="rvt-card__content [ rvt-flow ]">
                            <p>Starts at 6 PM for anyone insterested</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="rvt-cols-6-md">
                <div class="rvt-card rvt-card--clickable rvt-card--raised [ rvt-m-bottom-lg ]">
                    <div class="rvt-card__body">
                        <h2 class="rvt-card__title">
                            <a href="#0">I365 Help Session</a>
                        </h2>
                        <div class="rvt-card__content [ rvt-flow ]">
                            <p>Peer reviewers here to help with any homework questions</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>


    <?php include '../other-assets/footer-scrolling.php';?>

    <!-- *************************************
                DYLAN - SPRINT 09
    ************************************** -->

    
</body>
</html>