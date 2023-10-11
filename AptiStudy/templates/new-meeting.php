<?php
    //Session Start
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

    //Connection to database 
    $connection = mysqli_connect("****", "****", "****", "****");
    if (mysqli_connect_errno()) {
        die("Failed to connect to MySQL: " . mysqli_connect_error());
    }

    function clean_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }    

    $userID = $_SESSION['user_id'];

    $meeting_name = clean_input($_POST['meeting-name']);
    $location = clean_input($_POST['location']);
    $meeting_time = $_POST['meeting-time'];
    $meeting_date = $_POST['meeting-date'];
    $group_id = $_POST['group_id'];
    $groupName = $_POST['group_name'];
    $description = $_POST['description'];

    if ($location == 'Hodge Hall') {
        $roomDropDownName = 'dropdown1';
    }

    if ($location == 'Luddy Hall') {
        $roomDropDownName = 'dropdown2';
    } 
    else if ($location == 'Herman B Wells Library') {
        $roomDropDownName = 'dropdown3';
    }
    else if ($location == 'Global and International Studies Building') {
        $roomDropDownName = 'dropdown4';
    }
    else if ($location == 'Indiana Memorial Union') {
        $roomDropDownName = 'dropdown5';
    }

    $selectedRoom = clean_input($_POST[$roomDropDownName]);

    $room_id_sql = "SELECT room.id, room.building_id, room.room_num, building.id, building.name
                    FROM room
                    INNER JOIN building
                    ON building.id=room.building_id
                    WHERE room.room_num=$selectedRoom AND building.name='$location'";
    $room_id_query = mysqli_query($connection, $room_id_sql);

    while ($row = mysqli_fetch_assoc($room_id_query)) {
        $room_id = $row['id'];
    }  

    if (isset($_POST['create_meeting'])) {
        $new_meeting = "INSERT INTO meeting (group_id, location, meeting_name, _time, _date) VALUES ($group_id, $room_id, '$meeting_name', '$meeting_time', '$meeting_date')";
    } 
    else if (isset($_POST['edit_meeting'])) {
        $new_meeting = "UPDATE meeting
            SET location = $room_id, meeting_name = '$meeting_name', _time = '$meeting_time', _date = '$meeting_date'
            WHERE meeting.group_id = $group_id";
    }

    if (mysqli_query($connection, $new_meeting))  {
        echo "";
    }
 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Meeting | AptiStudy</title>
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/styles.css">
    <link href="https://fonts.iu.edu/style.css?family=BentonSans:regular,bold|BentonSansCond:regular|GeorgiaPro:regular" media="screen" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://unpkg.com/rivet-core@2.2.0/css/rivet.min.css">
</head>
<body>

    <?php include '../other-assets/navbar-home.php';?>

    <!-- **************************************************************************
    CONFIRMATION PAGE LAYOUT
    
    -> rivet.iu.edu/layouts/confirmation-page/
    *************************************************************************** -->

    <main id="main-content" class="rvt-layout__wrapper rvt-layout__wrapper--single rvt-container-sm">
        <div class="rvt-layout__content">

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
                <h2 class="rvt-ts-32 rvt-text-center rvt-text-medium rvt-color-green-500">Meeting Scheduled</h2>
                <p class="rvt-ts-18 rvt-text-center rvt-color-green-500">Don't forget to put a notification in your calendar</p>
            </div>

            <!-- Post meeting details here so the user can see what they just scheduled -->
            <div class="meeting_info_posted">
                <div class="rvt-prose rvt-flow rvt-border-top rvt-p-top-lg rvt-m-top-xl">
                    <h1>Meeting Details</h1>
                    <?php
                        echo "<h3>Meeting Name: <em>$meeting_name</em></h3>";
                        echo "<h3>Study Group: <em>$groupName</em></h3>";
                        echo "<h3>Location: <em>$location</em></h3>";
                        echo "<h3>Room: <em>$selectedRoom</em></h3>";
                        echo "<h3>Meeting Date: <em>$meeting_date</em></h3>";
                        echo "<h3>Meeting Time: <em>$meeting_time</em></h3>";

                        /// echo "SQL: $new_meeting";
                    ?>
                </div>
            </div>

            <!-- ******************************************************************
                "Get help" callout
            ******************************************************************* -->

            <div class="rvt-flex rvt-justify-center rvt-p-tb-xxl rvt-flow rvt-prose rvt-bg-black-000 rvt-border-radius ">
                <div class="rvt-container-sm rvt-flex rvt-items-center rvt-p-lr-xxl">
                    <svg class="rvt-hide-md-down" width="120" height="120" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="40" cy="40" r="40" fill="#E2E7E9"/>
                        <path d="M15.9994 25C15.9994 22.2386 18.2379 20 20.9994 20H40.9994C43.7608 20 45.9994 22.2386 45.9994 25V35H58.9994C61.7608 35 63.9994 37.2386 63.9994 40V52C63.9994 54.7614 61.7608 57 58.9994 57H58.4136L53.9994 61.4142L49.5851 57H38.9994C36.2379 57 33.9994 54.7614 33.9994 52V42H30.4136L25.9994 46.4142L21.5851 42H20.9994C18.2379 42 15.9994 39.7614 15.9994 37V25Z" fill="white"/>
                        <path d="M25.9994 31C25.9994 32.1046 25.1039 33 23.9994 33C22.8948 33 21.9994 32.1046 21.9994 31C21.9994 29.8954 22.8948 29 23.9994 29C25.1039 29 25.9994 29.8954 25.9994 31Z" fill="#243142"/>
                        <path d="M32.9994 31C32.9994 32.1046 32.1039 33 30.9994 33C29.8948 33 28.9994 32.1046 28.9994 31C28.9994 29.8954 29.8948 29 30.9994 29C32.1039 29 32.9994 29.8954 32.9994 31Z" fill="#243142"/>
                        <path d="M37.9994 33C39.1039 33 39.9994 32.1046 39.9994 31C39.9994 29.8954 39.1039 29 37.9994 29C36.8948 29 35.9994 29.8954 35.9994 31C35.9994 32.1046 36.8948 33 37.9994 33Z" fill="#243142"/>
                        <path d="M55.9994 48C54.8948 48 53.9994 47.1046 53.9994 46C53.9994 44.8954 54.8948 44 55.9994 44C57.1039 44 57.9994 44.8954 57.9994 46C57.9994 47.1046 57.1039 48 55.9994 48Z" fill="#243142"/>
                        <path d="M46.9994 46C46.9994 47.1046 47.8948 48 48.9994 48C50.1039 48 50.9994 47.1046 50.9994 46C50.9994 44.8954 50.1039 44 48.9994 44C47.8948 44 46.9994 44.8954 46.9994 46Z" fill="#243142"/>
                        <path d="M41.9994 48C40.8948 48 39.9994 47.1046 39.9994 46C39.9994 44.8954 40.8948 44 41.9994 44C43.1039 44 43.9994 44.8954 43.9994 46C43.9994 47.1046 43.1039 48 41.9994 48Z" fill="#243142"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M15.9994 25C15.9994 22.2386 18.2379 20 20.9994 20H40.9994C43.7608 20 45.9994 22.2386 45.9994 25V35H58.9994C61.7608 35 63.9994 37.2386 63.9994 40V52C63.9994 54.7614 61.7608 57 58.9994 57H58.4136L53.9994 61.4142L49.5851 57H38.9994C36.2379 57 33.9994 54.7614 33.9994 52V42H30.4136L25.9994 46.4142L21.5851 42H20.9994C18.2379 42 15.9994 39.7614 15.9994 37V25ZM33.9994 40C33.9994 37.2386 36.2379 35 38.9994 35H43.9994V25C43.9994 23.3431 42.6562 22 40.9994 22H20.9994C19.3425 22 17.9994 23.3431 17.9994 25V37C17.9994 38.6569 19.3425 40 20.9994 40H22.4136L25.9994 43.5858L29.5851 40H33.9994ZM38.9994 37C37.3425 37 35.9994 38.3431 35.9994 40V52C35.9994 53.6569 37.3425 55 38.9994 55H50.4136L53.9994 58.5858L57.5851 55H58.9994C60.6562 55 61.9994 53.6569 61.9994 52V40C61.9994 38.3431 60.6562 37 58.9994 37H38.9994Z" fill="#243142"/>
                    </svg>
                    <div class="rvt-p-left-xl-md-up rvt-flow rvt-prose">
                        <h2>Need to edit or reschedule something?</h2>
                        <p>Click the button below to edit your meeting details</p>
                        <!-- Send user to another page that looks exactly like host-meeting
                            with all of the meeting details that will spark an update query
                            on this page or that page -->
                        <form action="edit-meeting.php" method="POST">
                            <input type="hidden" name="group_id" value="<?php echo ($group_id); ?>">
                            <input type="hidden" name="location" value="<?php echo ($location); ?>">
                            <input type="hidden" name="meeting_name" value="<?php echo ($meeting_name); ?>">
                            <input type="hidden" name="meeting_time" value="<?php echo ($meeting_time); ?>">
                            <input type="hidden" name="meeting_date" value="<?php echo ($meeting_date); ?>">
                            <input type="hidden" name="description" value="<?php echo ($description); ?>">
                            <button class="rvt-button">Edit Details</button>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://unpkg.com/rivet-core@2.2.0/js/rivet.min.js"></script>
    <script>
        Rivet.init();
    </script>
    
    <?php include '../other-assets/footer-scrolling.php';?>
    
    <?php mysqli_close($connection); ?>

</body>
</html>
