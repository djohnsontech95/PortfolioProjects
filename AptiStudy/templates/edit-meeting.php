<?php
    // Session Start
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

    //update this with host meeting post variables
    //figure out if we even need to set values for date and time in this. might cause issues and have to make user reset this
    $groupID = $_POST['group_id'];
    $meetingName = $_POST['meeting_name'];
    $meetingDate = $_POST['meeting_date'];
    $meetingTime = $_POST['meeting_time'];
    $description = $_POST['description'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Meeting | AptiStudy</title>
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/styles.css">
    <link href="https://fonts.iu.edu/style.css?family=BentonSans:regular,bold|BentonSansCond:regular|GeorgiaPro:regular" media="screen" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://unpkg.com/rivet-core@2.2.0/css/rivet.min.css">
</head>
<body>

    <?php include '../other-assets/navbar-home.php';?>

    <main id="main-content" class="rvt-layout__wrapper rvt-container-sm">
        <div class="rvt-layout__wrapper [ rvt-p-tb-xxl ]">
            <div class="rvt-container-lg">
                <div class="rvt-row">
                    <div class="rvt-cols-8-md rvt-flow rvt-prose">

                        <!-- ******************************************************
                        Create/edit form
                        ******************************************************* -->

                        <form action="new-meeting.php" class="form1" method="POST" enctype="multipart/form-data">

                            <fieldset class="rvt-fieldset">
                                <div class="meeting_info">
                                    <legend class="rvt-legend [ rvt-ts-18 rvt-border-bottom rvt-p-bottom-xs ]">Edit Meeting details</legend>
                                    <div class="rvt-m-top-sm">
                                        <label class="rvt-label" for="meeting-name">Meeting name:</label>
                                        <input class="rvt-input" type="text" name="meeting-name" id="meeting-name"
                                            minlength=1 maxlength=20
                                            pattern="^([A-Z]{1,}[a-z]{0,}*'?-?[a-zA-Z]\s?([a-zA-Z])?)"
                                            title="Enter only alphabetic letters with first letter capitalized. Hyphenated meetings are allowed."
                                            value="<?php 
                                                        echo ($meetingName);
                                                    ?>"
                                            required>
                                        </input>
                                    </div>

                                    <div class="rvt-m-top-lg">
                                        <label for="meeting-date">Meeting date:</label>
                                        <!-- FIND A WAY TO MAKE MIN DATE THE CURRENT DATE -->
                                        <input type="date" id="dates" name="meeting-date" min="2023-02-06"
                                            max="2050-11-05" title="Enter a meeting date." value="<?php echo ($meetingDate); ?>" required>
                                    </div>
                                    <div class="rvt-m-top-lg">
                                        <label for="meeting-time">Meeting start time:</label>
                                        <input type="time" id="time" name="meeting-time" title="Enter a meeting time." value="<?php echo ($MeetingTime); ?>" required>
                                    </div>
                                </div>

                                    <div class="location_info">
                                        <a href="map.php" class="map_button">Map View</a>

                                        <div class="rvt-m-top-lg">
                                            <div class="location">
                                                <!-- INSERT A PHP STATEMENT OR SOMETHING TO GRAB MAP INTEGRATION -->
                                                <label for="select-input-default" class="rvt-label">Location:</label>
                                                <select id="select-input-default" name="location" class="rvt-select"
                                                    onchange="showDropdown()" required>

                                                    <?php
                                                    // grabs buildings from database
                                                    $building_sql = "SELECT name FROM building";
                                                    $building_query = mysqli_query($connection, $building_sql);

                                                    while ($row = mysqli_fetch_assoc($building_query)) {
                                                        $building = $row['name'];
                                                    ?>
                                                        <option value="<?php echo($building); ?>"><?php echo($building); ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <div id="dropdown1" style="display:block;">
                                                <label for="dropdown1" class="rvt-label">Room:</label>
                                                <select id="dropdown1-select" name='dropdown1' class="rvt-select" required>
                                                <?php
                                                // grabs rooms pertaining to building from database
                                                $room_sql = "SELECT id, building_id, room_num
                                                                FROM room
                                                                WHERE building_id=1";
                                                $room_query = mysqli_query($connection, $room_sql);

                                                while ($row = mysqli_fetch_assoc($room_query)) {
                                                    $room = $row['room_num'];
                                                ?>
                                                    <option value="<?php echo($room); ?>"><?php echo($room); ?></option>
                                                <?php
                                                }
                                                ?>
                                                </select>
                                            </div>

                                            <div id="dropdown2" style="display:none;">
                                                <label for="dropdown2" class="rvt-label">Room:</label>
                                                <select id="dropdown2-select" name='dropdown2' class="rvt-select">
                                                <?php
                                                // grabs rooms pertaining to building from database
                                                $room_sql = "SELECT id, building_id, room_num
                                                                FROM room
                                                                WHERE building_id=2";
                                                $room_query = mysqli_query($connection, $room_sql);

                                                while ($row = mysqli_fetch_assoc($room_query)) {
                                                    $room = $row['room_num'];
                                                ?>
                                                    <option value="<?php echo($room); ?>"><?php echo($room); ?></option>
                                                <?php
                                                }
                                                ?>
                                                </select>
                                            </div>

                                            <div id="dropdown3" style="display:none;">
                                                <label for="dropdown3" class="rvt-label">Room:</label>
                                                <select id="dropdown3-select" name='dropdown3' class="rvt-select">
                                                <?php
                                                // grabs rooms pertaining to building from database
                                                $room_sql = "SELECT id, building_id, room_num
                                                                FROM room
                                                                WHERE building_id=3";
                                                $room_query = mysqli_query($connection, $room_sql);

                                                while ($row = mysqli_fetch_assoc($room_query)) {
                                                    $room = $row['room_num'];
                                                ?>
                                                    <option value="<?php echo($room); ?>"><?php echo($room); ?></option>
                                                <?php
                                                }
                                                ?>
                                                </select>
                                            </div>

                                            <div id="dropdown4" style="display:none;">
                                                <label for="dropdown4" class="rvt-label">Room:</label>
                                                <select id="dropdown4-select" name='dropdown4' class="rvt-select">
                                                <?php
                                                // grabs rooms pertaining to building from database
                                                $room_sql = "SELECT id, building_id, room_num
                                                                FROM room
                                                                WHERE building_id=4";
                                                $room_query = mysqli_query($connection, $room_sql);

                                                while ($row = mysqli_fetch_assoc($room_query)) {
                                                    $room = $row['room_num'];
                                                ?>
                                                    <option value="<?php echo($room); ?>"><?php echo($room); ?></option>
                                                <?php
                                                }
                                                ?>
                                                </select>
                                            </div>

                                            <div id="dropdown5" style="display:none;">
                                                <label for="dropdown5" class="rvt-label">Room:</label>
                                                <select id="dropdown5-select" name='dropdown5' class="rvt-select">
                                                <?php
                                                // grabs rooms pertaining to building from database
                                                $room_sql = "SELECT id, building_id, room_num
                                                                FROM room
                                                                WHERE building_id=5";
                                                $room_query = mysqli_query($connection, $room_sql);

                                                while ($row = mysqli_fetch_assoc($room_query)) {
                                                    $room = $row['room_num'];
                                                ?>
                                                    <option value="<?php echo($room); ?>"><?php echo($room); ?></option>
                                                <?php
                                                }
                                                ?>
                                                </select>
                                            </div>
                                            
                                            <script>
                                                function showDropdown() {
                                                    var location = document.getElementById("select-input-default").value;
                                                    var dropdown1 = document.getElementById("dropdown1");
                                                    dropdown1.style.display = "none";
                                                    var dropdown2 = document.getElementById("dropdown2");
                                                    dropdown2.style.display = "none";
                                                    var dropdown3 = document.getElementById("dropdown3");
                                                    dropdown3.style.display = "none";
                                                    var dropdown4 = document.getElementById("dropdown4");
                                                    dropdown4.style.display = "none";
                                                    var dropdown5 = document.getElementById("dropdown5");
                                                    dropdown5.style.display = "none";

                                                    if (location == "Hodge Hall") {
                                                        dropdown1.style.display = "block";
                                                    }
                                                    else if (location == "Luddy Hall") {
                                                        dropdown2.style.display = "block";
                                                    }
                                                    else if (location == "Herman B Wells Library") {
                                                        dropdown3.style.display = "block";
                                                    }
                                                    else if (location == "Global and International Studies Building") {
                                                        dropdown4.style.display = "block";
                                                    }
                                                    else if (location == "Indiana Memorial Union") {
                                                        dropdown5.style.display = "block";
                                                    }
                                                }
                                            </script>
                                        </div>

                                    </div>
                                    <div class="rvt-m-top-lg">
                                        <label class="rvt-label" for="description">Description:</label>
                                        <input class="rvt-input" type="text" name="description" id="description" minlength=1
                                            maxlength=256 pattern="^([A-Z]{1,}[a-z]{0,}*'?-?[a-zA-Z]\s?([a-zA-Z])?)"
                                            title="Enter only alphabetic letters with first letter capitalized. Hyphenated descriptions are allowed."
                                            value="<?php echo ($description); ?>" required>
                                        </input>
                                    </div>
                                </fieldset>



                                <!-- **************************************************
                                    Create/edit form buttons
                                *************************************************** -->

                            <div class="rvt-button-group [ rvt-m-top-xl ]">
                                <input type="hidden" name="group_id" value="<?php echo $groupID; ?>">
                                <input type="hidden" name="group_name" value="<?php echo $groupName; ?>">

                                <button type="submit" name="edit_meeting" class="rvt-button">Edit Meeting</button>
                                <a href="home.php" class="cancel_profile">Cancel</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </main>

    <script src="https://unpkg.com/rivet-core@2.3.1/js/rivet.min.js"></script>
    <script>
        Rivet.init();
    </script>

    <?php include '../other-assets/footer-scrolling.php';?>

    <?php mysqli_close($connection); ?>
</body>
</html>
