<?php
    //Session Start
    session_start();

    //Code to redirect user if they are not logged in
    // if (!isset($_SESSION['user_id'])) {
    //     header("Location: login.php");
    // }

    $userID = $_SESSION['user_id'];

    $connection = mysqli_connect("****", "****", "****", "****");
    if (mysqli_connect_errno()) {
        die("Failed to connect to MySQL: " . mysqli_connect_error());
    }


    // $connection = mysqli_connect("127.0.0.1", "root", "", "team04");
    // if (mysqli_connect_errno()) {
    //     die("Failed to connect to MySQL: " . mysqli_connect_error());
    // }

    $group_query = "SELECT sg.id AS groupID, sg.host_id AS hostID, sg.group_name AS groupName, sg.description AS bio, sg.max_members AS totalMembers, gm.group_id AS groupID, gm.member_id AS memberID
                    FROM study_group AS sg
                    INNER JOIN group_members AS gm ON study_group.id=group_members.group_id
                    WHERE gm.member_id = $userID OR sg.host_id = $userID";

    $group_info = mysqli_query($connection, $group_query);
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

    <?php include '../other-assets/navbar-home.php';?>

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
                                    <path fill="currentColor" d="M15.6 6.4l-7-5.19a.76.76 0 0 0-.19-.12A1 1 0 0 0 8 1a1 1 0 0 0-.42.09.76.76 0 0 0-.19.12L.4 6.4a1 1 0 0 0-.4.8 1 1 0 0 0 .2.6 1 1 0 0 0 1.4.2l.4-.3V14a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V7.7l.4.3a1 1 0 0 0 .6.2 1 1 0 0 0 .6-1.8zM12 13H9V9H7v4H4V6.22l4-3 4 3z"></path>
                                </svg>
                            </a>
                        </li>
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
                                <legend class="rvt-legend [ rvt-ts-18 rvt-border-bottom rvt-p-bottom-xs ]">Meeting details</legend>
                                <div class="rvt-m-top-sm">
                                    <label class="rvt-label" for="meeting-name">Meeting name:</label>
                                    <input class="rvt-input" type="text" name="meeting-name" id="meeting-name" minlength=1 maxlength=20
                                        pattern="^([A-Z]{1,}[a-z]{0,}*'?-?[a-zA-Z]\s?([a-zA-Z])?)"
                                        title="Enter only alphabetic letters with first letter capitalized. Hyphenated names are allowed."
                                        required>
                                    </input>
                                </div>
                                <div class="rvt-m-top-lg">
                                    <label class="rvt-label" for="selected-group">For which study group:</label>
                                    <select class="rvt-select" name="selected-group" id="selected-group" aria-describedby="select-option-message">
                                        <?php 
                                        
                                        while ($row = mysqli_fetch_assoc($group_info)) {

                                        ?>

                                        <option value="<?php echo $row['groupName']; ?>"><?php echo $row['groupName']; ?></option>

                                        <?php
                                            }
                                        ?>

                                    </select>
                                </div>
                                <div class="rvt-m-top-lg">
                                    <label for="meeting-date">Meeting date:</label>
                                    <!-- FIND A WAY TO MAKE MIN DATE THE CURRENT DATE -->
                                    <input type="date" id="dates" name="meeting-date" min="2023-02-06" max="2050-11-05">
                                </div>
                                <div class="rvt-m-top-lg">
                                    <!-- INSERT A PHP STATEMENT OR SOMETHING TO GRAB MAP INTEGRATION -->
                                    <label for="select-input-default" class="rvt-label">Location:</label>
                                <select id="select-input-default" class="rvt-select" onchange="showDropdown()">
                                    <option value="Indiana Memorial Union">Indiana Memorial Union</option>
                                    <option value="Herman B Wells Library">Herman B Wells Library</option>
                                    <option value="Luddy Hall">Luddy Hall</option>
                                    <option value="Kelley School of Business">Kelley School of Business</option>
                                    <option value="Teter Quad">Teter Quad</option>
                                    <option value="Forest Quad">Forest Quad</option>
                                    <option value="Wright Education Building">Wright Education Building</option>
                                    <option value="School of Public Health">School of Public Health</option>
                                    <option value="Other">Other</option>
                                </select>

                                <div id="dropdown1" style="display:none;">
                                    <label for="dropdown1" class="rvt-label">Dropdown 1:</label>
                                    <select id="dropdown1-select" class="rvt-select">
                                        <option value="option one">Option One</option>
                                        <option value="option two">Option Two</option>
                                        <option value="option three">Option Three</option>
                                    </select>
                                </div>

                                <div id="dropdown2" style="display:none;">
                                    <label for="dropdown2" class="rvt-label">Dropdown 2:</label>
                                    <select id="dropdown2-select" class="rvt-select">
                                        <option value="option one">Option One</option>
                                        <option value="option two">Option Two</option>
                                        <option value="option three">Option Three</option>
                                    </select>
                                </div>

                                <div id="dropdown3" style="display:none;">
                                    <label for="dropdown3" class="rvt-label">Dropdown 3:</label>
                                    <select id="dropdown3-select" class="rvt-select">
                                        <option value="option one">Option One</option>
                                        <option value="option two">Option Two</option>
                                        <option value="option three">Option Three</option>
                                    </select>
                                </div>

                                <div id="dropdown4" style="display:none;">
                                    <label for="dropdown4" class="rvt-label">Dropdown 4:</label>
                                    <select id="dropdown4-select" class="rvt-select">
                                        <option value="option one">Option One</option>
                                        <option value="option two">Option Two</option>
                                        <option value="option three">Option Three</option>
                                    </select>
                                </div>

                                <div id="dropdown5" style="display:none;">
                                    <label for="dropdown5" class="rvt-label">Dropdown 5:</label>
                                    <select id="dropdown5-select" class="rvt-select">
                                        <option value="option one">Option One</option>
                                        <option value="option two">Option Two</option>
                                        <option value="option three">Option Three</option>
                                    </select>
                                </div>

                                <div id="dropdown6" style="display:none;">
                                    <label for="dropdown6" class="rvt-label">Dropdown 6:</label>
                                    <select id="dropdown6-select" class="rvt-select">
                                        <option value="option one">Option One</option>
                                        <option value="option two">Option Two</option>
                                        <option value="option three">Option Three</option>
                                    </select>
                                </div>

                                <div id="dropdown7" style="display:none;">
                                    <label for="dropdown7" class="rvt-label">Dropdown 7:</label>
                                    <select id="dropdown7-select" class="rvt-select">
                                        <option value="option one">Option One</option>
                                        <option value="option two">Option Two</option>
                                        <option value="option three">Option Three</option>
                                    </select>
                                </div>

                                <div id="dropdown8" style="display:none;">
                                    <label for="dropdown8" class="rvt-label">Dropdown 8:</label>
                                    <select id="dropdown8-select" class="rvt-select">
                                        <option value="option one">Option One</option>
                                        <option value="option two">Option Two</option>
                                        <option value="option three">Option Three</option>
                                    </select>
                                </div>

                                <script>
                                    function showDropdown() {
                                        var location = document.getElementById("select-input-default").value;
                                        var dropdown1 = document.getElementById("dropdown1");
                                        var dropdown2 = document.getElementById("dropdown2");
                                        var dropdown3 = document.getElementById("dropdown3");
                                        var dropdown3 = document.getElementById("dropdown4");
                                        var dropdown3 = document.getElementById("dropdown5");
                                        var dropdown3 = document.getElementById("dropdown6");
                                        var dropdown3 = document.getElementById("dropdown7");
                                        var dropdown3 = document.getElementById("dropdown8");
                                        
                                        if (location == "Indiana Memorial Union") {
                                            dropdown1.style.display = "block";
                                            dropdown2.style.display = "none";
                                            dropdown3.style.display = "none";
                                        }
                                        else if (location == "Herman B Wells Library") {
                                            dropdown1.style.display = "none";
                                            dropdown2.style.display = "block";
                                            dropdown3.style.display = "none";
                                        }
                                        else if (location == "Luddy Hall") {
                                            dropdown1.style.display = "none";
                                            dropdown2.style.display = "none";
                                            dropdown3.style.display = "block";
                                        }
                                        else if (location == "Kelley School of Business") {
                                            dropdown1.style.display = "none";
                                            dropdown2.style.display = "none";
                                            dropdown3.style.display = "block";
                                        }
                                        else if (location == "Teter Quad") {
                                            dropdown1.style.display = "none";
                                            dropdown2.style.display = "none";
                                            dropdown3.style.display = "block";
                                        }
                                        else if (location == "Forest Quad") {
                                            dropdown1.style.display = "none";
                                            dropdown2.style.display = "none";
                                            dropdown3.style.display = "block";
                                        }
                                        else if (location == "Luddy Hall") {
                                            dropdown1.style.display = "none";
                                            dropdown2.style.display = "none";
                                            dropdown3.style.display = "block";
                                        }
                                        else {
                                            dropdown1.style.display = "none";
                                            dropdown2.style.display = "none";
                                            dropdown3.style.display = "none";
                                        }
                                    }
                                </script>
                                    
                                </div>
                                <div class="rvt-m-top-lg">
                                    <label class="rvt-label" for="description">Description:</label>
                                    <input class="rvt-input" type="text" name="description" id="description" minlength=1 maxlength=20
                                        pattern="^([A-Z]{1,}[a-z]{0,}*'?-?[a-zA-Z]\s?([a-zA-Z])?)"
                                        title="Enter only alphabetic letters with first letter capitalized. Hyphenated names are allowed."
                                        required>
                                    </input>
                                </div>                                
                            </fieldset>

                    

                            <!-- **************************************************
                                Create/edit form buttons
                            *************************************************** -->
                            
                            <div class="rvt-button-group [ rvt-m-top-xl ]">
                                <button type="submit" class="rvt-button">Create Meeting</button>
                                <a href="home.php">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include '../other-assets/footer-scrolling.php';?>

    <!-- *************************************
                DYLAN - SPRINT 10
    ************************************** -->
    
</body>
</html>