<?php
    //start session
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

    //authentication ID
    $userID = $_SESSION['user_id'];

    //Safe data sql clean up function
    function clean_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }    

    //variables to hold status if user is a member, host, or neither
    $host_status = "false";
    $member_status = "false";

    $firstUpdate = "";
    $secondUpdate = "";
    $thirdUpdate = "";

    //If loop to handle if user just created a group
    if (isset($_POST['create_group'])) {
        $group_name = $_POST['group-name'];
        $group_name = clean_input($group_name);
        $total_members = $_POST['total-members'];
        $group_bio = $_POST['textarea-1'];
        $group_bio = clean_input($group_bio);
        $studentID = $_POST['student_id'];
        
       /*  if(isset($_POST['checkbox-1'])) {
            $goal1 = $_POST['checkbox-1'];
        }

        if(isset($_POST['checkbox-2'])) {
            $goal2 = $_POST['checkbox-2'];
        }

        if(isset($_POST['checkbox-3'])) {
            $goal3 = $_POST['checkbox-3'];
        }

        if(isset($_POST['checkbox-4'])) {
            $goal4 = $_POST['checkbox-4'];
        }

        $course_selection = $_POST['course-selection']; */

        // Needed since quotation marks affect the insert statement
        $group_bio = str_replace("'", "\'", $group_bio);

        $groupInsert = "INSERT INTO study_group (host_id, group_name, description, max_members)
            VALUES ($studentID, '$group_name', '$group_bio', $total_members);";

        $newGroup = mysqli_query($connection, $groupInsert);

        // echo "-- (new creation) host view --";
        $host_status = "true";

        $group_query = "SELECT sg.id AS groupID, sg.host_id AS hostID, sg.group_name
                            FROM study_group AS sg
                            WHERE sg.host_id=$studentID AND sg.group_name='$group_name'";

        $group_results = mysqli_query($connection, $group_query);

        while ($row = mysqli_fetch_assoc($group_results)) {
            $group_id = $row['groupID'];
            $host_id = $row['hostID'];
        }

        $hostMemberInsert = "INSERT INTO group_members (group_id, member_id) VALUES ($group_id, $host_id)";
        $hostMemberInject = mysqli_query($connection, $hostMemberInsert);
    
        $_SESSION['temp_group_id'] = $group_id;

        // File upload path
        $targetDir = "../images/";
        $fileName = basename($_FILES["edit-group-image"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
        if (!empty($_FILES["edit-group-image"]["name"])) {
            // Allow certain file formats
            $allowTypes = array('jpg','png','jpeg','webp');   
            if (in_array($fileType, $allowTypes)) {
                // Upload file to server
                if (move_uploaded_file($_FILES["edit-group-image"]["tmp_name"], $targetFilePath)) {
                    // Insert image file name into database

                    $insert_image_sql = "INSERT INTO group_image (group_id, file_name) VALUES ($group_id, '$fileName')";
                    $insert_image_query = mysqli_query($connection, $insert_image_sql);
                }
            }
        }
        else {
            $insert_image_sql = "INSERT INTO group_image (group_id, file_name) VALUES ($group_id, '../images/group-upload.png')";
            $insert_image_query = mysqli_query($connection, $insert_image_sql);
        }

        //add group to announcements
        $insert_announcements_group = "INSERT INTO announcements (group_id) VALUES ($group_id)";
        $announcements_group_query = mysqli_query($connection, $insert_announcements_group);

    //else if the user is selecting group from a view group button
    } elseif (isset($_POST['view_group'])) {
        $group_id = $_POST['group_id'];
        $_SESSION['temp_group_id'] = $group_id;

        $group_name = $_POST['groupName'];
        $host_id = $_POST['host_id'];
        $group_bio = $_POST['groupBio'];
        $total_members = $_POST['totalMembers'];
        $studentID = $_POST['student_id'];

        $memberQuery = "SELECT gm.group_id AS groupID, gm.member_id AS memberID
            FROM group_members AS gm
            INNER JOIN study_group ON study_group.id=gm.group_id
            WHERE study_group.group_name = '$group_name' AND gm.member_id = $studentID;";

        $member_results = mysqli_query($connection, $memberQuery);
        
        while ($row2 = mysqli_fetch_assoc($member_results)) {
            $member_id = $row2['memberID'];
            if ($member_id != false) {
                $member_status = "true";
            }
        }

        $announcementQuery = "SELECT a.first_update AS firstAnn, a.second_update AS secondAnn, a.third_update AS thirdAnn
            FROM announcements AS a
            WHERE a.group_id = $group_id";

        $announcement_results = mysqli_query($connection, $announcementQuery);

        while ($row = mysqli_fetch_assoc($announcement_results)) {
            $firstUpdate = $row['firstAnn'];
            $secondUpdate = $row['secondAnn'];
            $thirdUpdate = $row['thirdAnn'];
        }

        if ($host_id == $studentID) {
            $host_status = "true";
        }
        // elseif ($member_results != false) {
        //     $member_status = "true";
        // }


    } elseif (isset($_POST['edit_group'])) {
        // updated post variables here
        $group_name = $_POST['edit_group_name'];
        $group_id = $_POST['group_id'];
        $group_bio = $_POST['edit-bio'];
        $firstUpdate = $_POST['edit_announcement1'];
        $secondUpdate = $_POST['edit_announcement2'];
        $thirdUpdate = $_POST['edit_announcement3'];
        $studentID = $_POST['student_id'];
        $host_id = $_POST['host_id'];
        $total_members = $_POST['total_members'];
        
        // Needed since quotation marks affect the insert statement
        $group_bio = str_replace("'", "\'", $group_bio);

        //update query here
        $updateGroupSql = "UPDATE study_group
            SET group_name = $group_name, description = $group_bio
            WHERE study_group.id=$group_id";

        //update announcement query here
        $updateAnnouncementSql = "UPDATE announcements
            SET first_update = '$firstUpdate', second_update = '$secondUpdate', third_update = '$thirdUpdate'
            WHERE announcements.group_id = $group_id";

        //update group info in database
        if (mysqli_query($connection, $updateGroupSql)) {
            echo "";
        }

        //update announcements in database
        if (mysqli_query($connection, $updateAnnouncementSql)) {
            echo "";
        }

        //set host status to true
        $host_status = "true";

        // File upload path
        $targetDir = "../images/";
        $fileName = basename($_FILES["edit-group-image"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

        // allow certain file formats
        $allowTypes = array('jpg','png','jpeg','webp');

        if (in_array($fileType, $allowTypes)) {

            // upload file to server
            if (move_uploaded_file($_FILES["edit-group-image"]["tmp_name"], $targetFilePath)) {

                // remove previous image from database so that only one group image is tied
                // to a user; prevents user from uploading multiple images to the server 
                $delete_image_sql = "DELETE group_image 
                                        FROM group_image
                                        WHERE group_id=$group_id";
                $delete_image_query = mysqli_query($connection, $delete_image_sql);

                // Insert image file name into database

                $insert_image_sql = "INSERT INTO group_image (group_id, file_name) VALUES ($group_id, '$fileName')";
                $insert_image_query = mysqli_query($connection, $insert_image_sql);
            }
        }
        else {
            // remove previous image from database so that only one group image is tied
            // to a user; prevents user from uploading multiple images to the server 
            $delete_image_sql = "DELETE group_image 
                                    FROM group_image
                                    WHERE group_id=$group_id";
            $delete_image_query = mysqli_query($connection, $delete_image_sql);

            $insert_image_sql = "INSERT INTO group_image (group_id, file_name) VALUES ($group_id, '../images/group-upload.png')";
            $insert_image_query = mysqli_query($connection, $insert_image_sql);
        }
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Group Home Page | Aptistudy</title>
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/styles.css">
    <link href="https://fonts.iu.edu/style.css?family=BentonSans:regular,bold|BentonSansCond:regular|GeorgiaPro:regular" media="screen" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://unpkg.com/rivet-core@2.3.1/css/rivet.min.css">
</head>
<body>

    <?php

    if (isset($_POST['edit_group'])) {
    ?>
        <div id="confirmation_bar">
            <p id="message">Your group has been sucessfully updated!</p>
            <button id="close_button" onclick="parentNode.remove()">&times;</button>
        </div>

    <?php
    }
    ?>

    <!-- **************************************************************************
    Header

    -> rivet.iu.edu/components/header/
    *************************************************************************** -->

    <?php include '../other-assets/navbar-home.php';?>

    <!-- **************************************************************************
    Main content area
    *************************************************************************** -->

    <main id="main-content" class="rvt-layout__wrapper rvt-container-sm">
        <div class="rvt-layout__content">
            <div class="rvt-button-group [ rvt-m-top-xl ]">
                <!-- Host Meeting Form -->
                <form method="POST" action="host-meeting.php">
                    
                    <?php
                        //if statement to check if user is a host or member of a group
                        if ($host_status == "true" OR $member_status == "true") { 
                            echo "<input type=\"hidden\" name=\"group_id\" value=\"$group_id\">
                                <input type=\"hidden\" name=\"group_name\" value=\"$group_name\">
                                <button type=\"submit\" name=\"meetingBtn\" class=\"rvt-button\">Host Meeting</button>";
                        }
                    
                    ?>

                </form>
                <!-- Edit Study Group Form -->
                <form method="POST" action="edit-group.php">

                <?php
                    //if statement to check if user is host
                    if ($host_status == "true") {

                        //maybe add way to edit announcements 
                        echo "<input type=\"hidden\" name=\"group_id\" value=\"$group_id\">
                            <input type=\"hidden\" name=\"group_name\" value=\"$group_name\">
                            <input type=\"hidden\" name=\"group_bio\" value=\"$group_bio\">
                            <input type=\"hidden\" name=\"total_members\" value=\"$total_members\">
                            <input type=\"hidden\" name=\"student_id\" value=\"$studentID\">
                            <input type=\"hidden\" name=\"host_id\" value=\"$host_id\">
                            <button type=\"submit\" name=\"editGroupBtn\" class=\"rvt-button\">Edit Group</button>";
                    }
                ?>

                </form>
                <!-- Leave Group Form -->
                <form action="leave-group.php" method="POST">

                <?php

                    //if statement to check if user is a host or member of a group
                    if ($host_status == "true" or $member_status == "true") {
                        
                        echo "<input type=\"hidden\" name=\"group_id\" value=\"$group_id\">
                            <input type=\"hidden\" name=\"studentLeave\" value=\"$studentID\">
                            <input type=\"hidden\" name=\"host_id\" value=\"$host_id\">
                            <button type=\"submit\" name=\"leaveBtn\" class=\"leave_group_button\">Leave Group</button>";
                    } 

                ?>

                </form>
                <!-- Join Group Form -->
                <form action="join-group.php" method="POST">
                    
                    <?php
                        
                        if ($host_status == "false" AND $member_status == "false") {
                        
                            echo "<input type=\"hidden\" name=\"group_id\" value=\"$group_id\">
                                <input type=\"hidden\" name=\"student_id\" value=\"$studentID\">
                                <input type=\"hidden\" name=\"group_name\" value=\"$group_name\">
                                <button type=\"submit\" name=\"joinBtn\" class=\"rvt-button\">Join Group</button>";
                        }

                    ?>

                </form>

            </div> 
            

            <!-- ******************************************************************
                Group image, name, and title
            ******************************************************************* -->
            
            <div class="rvt-flex-md-up rvt-items-center-md-up rvt-m-top-xxl rvt-m-top-md-md-up">
                
                <!-- **************************************************************
                    Group Image
                *************************************************************** -->
                
                <div class="group_image">
                    <?php

                    $group_id_image = $_SESSION['temp_group_id'];

                    $group_image_sql = "SELECT group_image.file_name FROM group_image
                                            WHERE group_image.group_id=$group_id_image";
                    $group_image_query = mysqli_query($connection, $group_image_sql);

                    while ($row = mysqli_fetch_assoc($group_image_query)) {
                        $group_image = '../images/'.$row['file_name'];
                    }
                    ?>

                    <img id="img" class="view_group_image" src="<?php echo($group_image); ?>"
                        onerror="this.onerror=null; this.src='../images/group-upload.png'"
                        alt="Study Group Image">
                </div>

                <!-- **************************************************************
                    Name and title
                *************************************************************** -->

                <div class="rvt-prose rvt-flow">
                    
                    <?php
                        //if a user just created a group it displays that
                        //or grabs the information from the database
                        if (isset($_POST['create_group'])) {
                            echo "<h1>$group_name</h1>";

                            echo "<p class='rvt-ts-20 rvt-color-black-500'>$group_bio</p>";

                        } elseif (isset($_POST['view_group'])) {
                            echo "<h1>$group_name</h1>";

                            echo "<p class='rvt-ts-20 rvt-color-black-500'>$group_bio</p>";

                        } elseif (isset($_POST['edit_group'])) {
                            echo "<h1>$group_name</h1>";

                            echo "<p class='rvt-ts-20 rvt-color-black-500'>$group_bio</p>";
                        }
                    ?>

                </div>
            </div>
            <div class="rvt-prose rvt-flow rvt-border-top rvt-p-top-lg rvt-m-top-xl">

                <!-- **************************************************************
                    Contact information card
                *************************************************************** -->
                
                <div class="rvt-layout__feature-slot">
                    <div class="rvt-card rvt-card--raised">
                        <div class="rvt-card__body">
                            <dl class="rvt-list-description rvt-m-all-none">
                                <!-- maybe grab these from the database -->
                                <!-- need new table to hold these in database and a query to grab for specific groups -->
                                <?php 
                                    echo "<dt>Announcements:</dt>
                                          <dd>&nbsp;&nbsp;&nbsp;&nbsp;&bull;&nbsp;&nbsp;&nbsp;$firstUpdate</dd>
                                          <dd>&nbsp;&nbsp;&nbsp;&nbsp;&bull;&nbsp;&nbsp;&nbsp;$secondUpdate</dd>
                                          <dd>&nbsp;&nbsp;&nbsp;&nbsp;&bull;&nbsp;&nbsp;&nbsp;$thirdUpdate</dd>";
                                ?>                            
                            </dl>
                        </div>
                    </div>
                </div>

                <!-- **************************************************************
                    Biography
                *************************************************************** -->

                <h2>Upcoming Meetings</h2>
                <dl class="rvt-list-description">
                    <?php
                    if (isset($_POST['create_group'])) {
                        $group_meetings_sql = "SELECT id, meeting_name FROM meeting WHERE group_id=$group_id AND _date >= CURDATE()";
                        $group_meetings_query = mysqli_query($connection, $group_meetings_sql);

                        while ($row3 = mysqli_fetch_assoc($group_meetings_query)) {
                            $meetingID = $row3['id'];
                            $meeting_name = $row3['meeting_name'];

                            echo("
                                <div class='upcoming'
                                    <span>&nbsp;&nbsp;&nbsp;&nbsp;&bull;&nbsp;&nbsp;&nbsp;</span>
                                    <a class='upcoming_meetings' href='view-meeting.php?meetingID=$meetingID'>$meeting_name</a>
                                </div>
                            ");
                        }


                    } elseif (isset($_POST['view_group'])) {
                        $group_meetings_sql = "SELECT id, meeting_name FROM meeting WHERE group_id=$group_id AND _date >= CURDATE()";
                        $group_meetings_query = mysqli_query($connection, $group_meetings_sql);

                        while ($row3 = mysqli_fetch_assoc($group_meetings_query)) {
                            $meetingID = $row3['id'];
                            $meeting_name = $row3['meeting_name'];

                            echo("
                                <div class='upcoming'
                                    <span>&nbsp;&nbsp;&nbsp;&nbsp;&bull;&nbsp;&nbsp;&nbsp;</span>
                                    <a class='upcoming_meetings' href='view-meeting.php?meetingID=$meetingID'>$meeting_name</a>
                                </div>
                            ");
                        }

                    } elseif (isset($_POST['edit_group'])) {
                        $group_meetings_sql = "SELECT id, meeting_name FROM meeting WHERE group_id=$group_id AND _date >= CURDATE()";
                        $group_meetings_query = mysqli_query($connection, $group_meetings_sql);

                        while ($row3 = mysqli_fetch_assoc($group_meetings_query)) {
                            $meetingID = $row3['id'];
                            $meeting_name = $row3['meeting_name'];

                            echo("
                                <div class='upcoming'
                                    <span>&nbsp;&nbsp;&nbsp;&nbsp;&bull;&nbsp;&nbsp;&nbsp;</span>
                                    <a class='upcoming_meetings' href='view-meeting.php?meetingID=$meetingID'>$meeting_name</a>
                                </div>
                            ");
                        }
                    }
                    ?>
                </dl>
            </div>
        </div>
    </main>

    <!-- **************************************************************************
        Footer: Copyright

        -> rivet.iu.edu/components/footer/
    **************************************************************************** -->


    <script src="https://unpkg.com/rivet-core@2.3.1/js/rivet.min.js"></script>
    <script>
        Rivet.init();
    </script>

    <?php include '../other-assets/footer-scrolling.php';?>

    <?php
        mysqli_close($connection);
    ?>
</body>
</html>