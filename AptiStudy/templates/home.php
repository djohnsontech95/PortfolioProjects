<?php
session_start();

    // Code to redirect user if they are not logged in
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
    }

    //Connection to database
    $connection = mysqli_connect("****", "****", "****", "****");
    if (mysqli_connect_errno()) {
        die("Failed to connect to MySQL: " . mysqli_connect_error());
    }

    $userID = $_SESSION['user_id'];

    $sql3 = "SELECT student.id AS id, student.fname AS fname, student.lname AS lname, student.username AS username, student.college_standing AS college_standing, student.user_bio AS bio, user_authentication.authenticate_id AS authenticate_id, user_authentication.student_id AS student_id 
                FROM student 
                INNER JOIN user_authentication
                ON id=student_id";
    $retrieve1 = mysqli_query($connection, $sql3);

    // sets the session user information, which allows a user to access the view-profile.php page
    // every time they navigate there
    while ($row = mysqli_fetch_assoc($retrieve1)) {
        if ($_SESSION['user_id'] == $row['authenticate_id']) {
            $_SESSION['user_fname'] = $row['fname'];
            $_SESSION['user_lname'] = $row['lname'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['college_standing'] = $row['college_standing'];
            $_SESSION['bio'] = $row['bio'];

            // redirects the user back to create-profile.php if they attempt to access view-profile, even after
            // being logged (only if they have not created an account)
            if (!isset($_SESSION['user_fname']) && !isset($_SESSION['user_lname']) && !isset($_SESSION['username']) && !isset($_SESSION['college_standing'])) {
                header("Location: create-profile.php");
            }
        }
    }

    $student_id_sql = "SELECT student.id AS student, user_authentication.authenticate_id
                            FROM student
                            INNER JOIN user_authentication ON student.id=user_authentication.student_id
                            WHERE user_authentication.authenticate_id='$userID'";
    $student_id_query = mysqli_query($connection, $student_id_sql);

    while ($row = mysqli_fetch_assoc($student_id_query)) {
        $student_id = $row['student'];
    }

    //query to grab all study group ids and host ids
    // (I think this query is part of the problem. Its trying to grab host ids and group member ids. Host id can be null but group member id cannot. Maybe this is breaking this query?)
    $host_group_query = "SELECT sg.id AS groupID, sg.host_id AS hostID, sg.group_name AS groupName, sg.description AS bio, sg.max_members AS totalMembers, gm.member_id AS memberID
    FROM study_group AS sg
    LEFT JOIN group_members AS gm ON sg.id=gm.group_id
    WHERE gm.member_id = $student_id OR sg.host_id = $student_id";

    $group_info = mysqli_query($connection, $host_group_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | AptiStudy</title>

    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/styles.css">
    <link href="https://fonts.iu.edu/style.css?family=BentonSans:regular,bold|BentonSansCond:regular|GeorgiaPro:regular" media="screen" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://unpkg.com/rivet-core@2.2.0/css/rivet.min.css">
</head>
<body>
    <?php include '../other-assets/navbar-home.php';?>

    <main id="main-content" class="rvt-layout__wrapper" id="main-content">

    <!-- **********************************************************************
        Page title and summary
    *********************************************************************** -->

        <div class="fade_animation">
            <div class="rvt-bg-crimson rvt-p-tb-xl rvt-p-tb-xxl-md-up">
                <div class="rvt-container-sm rvt-prose rvt-flow rvt-text-center">
                    <h1 class="rvt-color-white">Welcome Back!</h1>
                    <p class="rvt-ts-20 rvt-color-white">View your groups and schedule a meeting.</p>
                </div>
            </div>
        </div>

        <!-- **********************************************************************
            People list
        *********************************************************************** -->

        <div class="rvt-container-lg rvt-p-tb-xl">
            <ul class="rvt-row rvt-row--loose">

                <!-- **************************************************************
                    Person
                *************************************************************** -->
                <?php 
                    while ($row = mysqli_fetch_assoc($group_info)) {
                ?>

                <li class="rvt-cols-6-md rvt-cols-4-lg [ rvt-flex rvt-m-bottom-xxl ]">
                    <div class="rvt-card">
                        <div class="group_image">
                            <?php

                            $group_id = $row['groupID'];
                        
                            $group_image_sql = "SELECT group_image.file_name FROM group_image
                                                    WHERE group_image.group_id=$group_id";
                            $group_image_query = mysqli_query($connection, $group_image_sql);

                            while ($row2 = mysqli_fetch_assoc($group_image_query)) {
                                $group_image = '../images/'.$row2['file_name'];
                            }
                            
                            ?>

                            <img id="img" class="home_group_image" src="<?php echo($group_image); ?>"
                                onerror="this.onerror=null; this.src='../images/group-upload.png'"
                                alt="Study Group Image">
                        </div>
                        <div class="rvt-card__body">
                            <h2 class="rvt-card__title">
                                <?php echo $row["groupName"]; ?>
                            </h2>
                            <div class="rvt-card__content [ rvt-flow ]">
                                <p>Max Members Allowed: <?php echo $row["totalMembers"]; ?></p>
                            </div>
                            <!-- View button -->
                            <!-- Form with hidden inputs for each group instance to link to group-home page -->
                            <div class="rvt-card__meta">
                                <div class="rvt-flex rvt-items-center rvt-m-top-xs">
                                    <svg class="rvt-color-black-400 rvt-m-right-xs" aria-hidden="true" width="16" height="16" viewBox="0 0 16 16">
                                        <path fill="currentColor" d="M13.5,3H2.5A1.5,1.5,0,0,0,1,4.5v8A1.5,1.5,0,0,0,2.5,14h11A1.5,1.5,0,0,0,15,12.5v-8A1.5,1.5,0,0,0,13.5,3ZM11.41,5,8,7.77,4.59,5ZM3,12V6.29L7.11,9.62l.12.08a1.5,1.5,0,0,0,1.54,0L13,6.29V12Z" />
                                    </svg>
                                    <!-- Form is only sending host id and not member id???? -->
                                    <!-- Thinking about not sending host_id and only student id -->
                                    <!-- other pages can use student id with a query to find if user is host or member -->
                                    <form action="group-home.php" method="POST">
                                        <input type="hidden" name="group_id" value="<?php echo $row['groupID']; ?>">
                                        <input type="hidden" name="host_id" value="<?php echo $row['hostID']; ?>">
                                        <input type="hidden" name="groupName" value="<?php echo $row['groupName']; ?>">
                                        <input type="hidden" name="groupBio" value="<?php echo $row['bio']; ?>">
                                        <input type="hidden" name="totalMembers" value="<?php echo $row['totalMembers']; ?>">
                                        <input type="hidden" name="member_id" value="<?php echo $row['memberID']; ?>">
                                        <input type="hidden" name="student_id" value="<?php echo ($student_id); ?>">
                                        <button class="rvt-button" name="view_group" type="submit">View Group</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                
                <?php
                    }
                ?>
            </ul>
        </div>
    </main>

    <?php include '../other-assets/footer-scrolling.php';?>

    <?php
        mysqli_close($connection);
    ?>

    <!-- If we decide to include notifications, likely don't need to worry about this
    until calendar notifications have been completed -->
    
</body>
</html>