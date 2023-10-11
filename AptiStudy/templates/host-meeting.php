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

$userID = $_SESSION['user_id'];

$connection = mysqli_connect("****", "****", "****", "****");
if (mysqli_connect_errno()) {
    die("Failed to connect to MySQL: " . mysqli_connect_error());
}

$groupID = $_POST['group_id'];
$groupName = $_POST['group_name'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Host Meeting | AptiStudy</title>

    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>

    <?php include '../other-assets/navbar-home.php'; ?>

    <!-- **************************************************************************
    Main content area
    *************************************************************************** -->

    <main id="main-content" class="rvt-flex rvt-flex-column rvt-grow-1">
        <div class="rvt-bg-black-000 rvt-border-bottom rvt-p-top-xl">
            <div class="rvt-container-lg rvt-prose rvt-flow rvt-p-bottom-xl">

                <!-- **************************************************************
                    Breadcrumb navigation
                *************************************************************** -->

                <nav class="rvt-flex rvt-items-center" role="navigation" aria-label="Breadcrumb">
                    <ol class="rvt-breadcrumbs rvt-grow-1">
                        <li>
                            <a href="home.php">
                                <span class="rvt-sr-only">Home</span>
                                <svg width="16" height="16" viewBox="0 0 16 16" id="rvt-icon-home">
                                    <path fill="currentColor"
                                        d="M15.6 6.4l-7-5.19a.76.76 0 0 0-.19-.12A1 1 0 0 0 8 1a1 1 0 0 0-.42.09.76.76 0 0 0-.19.12L.4 6.4a1 1 0 0 0-.4.8 1 1 0 0 0 .2.6 1 1 0 0 0 1.4.2l.4-.3V14a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V7.7l.4.3a1 1 0 0 0 .6.2 1 1 0 0 0 .6-1.8zM12 13H9V9H7v4H4V6.22l4-3 4 3z">
                                    </path>
                                </svg>
                            </a>
                        </li>
                        <li><a href="group-home.php">Study Group</a></li>
                        <li><a href="host-meeting.php">Host Meeting</a></li>
                    </ol>
                </nav>

                <!-- **************************************************************
                    Page title
                *************************************************************** -->

                <h1 class="rvt-m-top-xs">Host a study meeting</h1>
            </div>
        </div>

        <!-- **********************************************************************
            Content
        *********************************************************************** -->

        <div class="rvt-layout__wrapper [ rvt-p-tb-xxl ]">
            <div class="rvt-container-lg">
                <div class="rvt-row">
                    <div class="rvt-cols-8-md rvt-flow rvt-prose">

                        <!-- ******************************************************
                            Alert box
                        ******************************************************* -->

                        <!-- NOT SURE WHAT TO DO WITH THIS YET 

                        <div class="rvt-alert rvt-alert--warning [ rvt-m-bottom-md ]" role="alert" aria-labelledby="list-alert-alert-title" data-rvt-alert="warning">
                            <div class="rvt-alert__title" id="list-alert-alert-title">Alert box</div>
                            <p class="rvt-alert__message">Use this space for error handling, confirmation messages, and warnings.</p>
                            <button class="rvt-alert__dismiss" data-rvt-alert-close>
                                <span class="rvt-sr-only">Dismiss this alert</span>
                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                    <path fill="currentColor" d="M9.41,8l5.29-5.29a1,1,0,0,0-1.41-1.41L8,6.59,2.71,1.29A1,1,0,0,0,1.29,2.71L6.59,8,1.29,13.29a1,1,0,1,0,1.41,1.41L8,9.41l5.29,5.29a1,1,0,0,0,1.41-1.41Z" />
                                </svg>
                            </button>
                        </div>

                        -->

                        <!-- ******************************************************
                            Create/edit form
                        ******************************************************* -->

                        <form action="new-meeting.php" method="POST">

                            <!-- **************************************************
                                Grouped set of fields
                            *************************************************** -->

                            <fieldset class="rvt-fieldset">
                                <div class="meeting_info">
                                    <legend class="rvt-legend [ rvt-ts-18 rvt-border-bottom rvt-p-bottom-xs ]">Meeting
                                        details</legend>
                                    <div class="rvt-m-top-sm">
                                        <label class="rvt-label" for="meeting-name">Meeting name:</label>
                                        <input class="rvt-input" type="text" name="meeting-name" id="meeting-name"
                                            minlength=1 maxlength=20
                                            pattern="^([A-Z]{1,}[a-z]{0,}*'?-?[a-zA-Z]\s?([a-zA-Z])?)"
                                            title="Enter only alphabetic letters with first letter capitalized. Hyphenated meetings are allowed."
                                            required>
                                        </input>
                                    </div>

                                    <div class="rvt-m-top-lg">
                                        <label for="meeting-date">Meeting date:</label>
                                        <!-- FIND A WAY TO MAKE MIN DATE THE CURRENT DATE -->
                                        <input type="date" id="dates" name="meeting-date" min="2023-02-06"
                                            max="2050-11-05" title="Enter a meeting date." required>
                                    </div>
                                    <div class="rvt-m-top-lg">
                                        <label for="meeting-time">Meeting start time:</label>
                                        <input type="time" id="time" name="meeting-time" title="Enter a meeting time." required>
                                    </div>
                                </div>

                                <div class="location_info">
                                    <a href="#" class="map_button" onclick="openMap(); return false;">Map View</a>

                                <div id="mapModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); z-index: 100;">
                                  <div id="mapStyling" style="position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); width:500px; height:333px; background-color:white; z-index: 100;">
                                    <iframe id="mapFrame" src="map.php" style="width:100%; height:100%; border:none;"></iframe>
                                    <button onclick="closeMap();" class="close_map_button">Close</button>
                                  </div>
                                </div>

                                <script>
                                function openMap() {
                                  document.getElementById("mapModal").style.display = "block";
                                }

                                function closeMap() {
                                  document.getElementById("mapModal").style.display = "none";
                                  document.getElementById("mapFrame").src = "about:blank";
                                }
                                </script>


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
                                        required>
                                    </input>
                                </div>
                            </fieldset>



                            <!-- **************************************************
                                Create/edit form buttons
                            *************************************************** -->

                            <div class="rvt-button-group [ rvt-m-top-xl ]">
                                <input type="hidden" name="group_id" value="<?php echo $groupID; ?>">
                                <input type="hidden" name="group_name" value="<?php echo $groupName; ?>">

                                <button type="submit" name="create_meeting" class="rvt-button">Create Meeting</button>
                                <a href="home.php" class="cancel_profile">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include '../other-assets/footer-scrolling.php'; ?>

</body>

</html>
