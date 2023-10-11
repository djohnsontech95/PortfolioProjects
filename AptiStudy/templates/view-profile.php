<?php
session_start();

$authenticate_id = $_SESSION['user_id'];

// Code to redirect user if they are not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}

$conn = mysqli_connect("****", "****", "****", "****");

// Check connection
if (mysqli_connect_errno()) {
    die("Failed to connect to MySQL: " . mysqli_connect_error());
}

// Escape variables for security sql injection
$edit_fname = mysqli_real_escape_string($conn, $_POST['edit-fname']);
$edit_lname = mysqli_real_escape_string($conn, $_POST['edit-lname']);
$edit_username = mysqli_real_escape_string($conn, $_POST['edit-username']);
$edit_college_standing = $_POST['edit-college-standing'];
$edit_bio = mysqli_real_escape_string($conn, $_POST['edit-bio']);

// remove unnecessary chars like tab/newline/space
$edit_fname = trim($edit_fname);
$user_lname = trim($edit_lname);
$username = trim($edit_username);
$edit_college_standing = trim($edit_college_standing);
$edit_bio = trim($edit_bio);

// remove backslashes
$edit_fname = stripslashes($edit_fname);
$edit_lname = stripslashes($edit_lname);
$edit_username = stripslashes($edit_username);
$edit_college_standing = stripslashes($edit_college_standing);
$edit_bio = stripslashes($edit_bio);

// convert problematic chars into entity representation
// prevents injection in the PHP
$edit_fname = htmlspecialchars($edit_fname);
$edit_lname = htmlspecialchars($edit_lname);
$edit_username = htmlspecialchars($edit_username);
$edit_college_standing = htmlspecialchars($edit_college_standing);
$edit_bio = htmlspecialchars($edit_bio);

// Needed since quotation marks affect the insert statement
$edit_bio = str_replace("'", "\'", $edit_bio);

// Condition for editing existing database entries
if ($edit_fname != '' && $edit_lname != '' && $edit_username != '' && $edit_college_standing != '') {
    $edit = "UPDATE student
        INNER JOIN user_authentication
        ON student.id=user_authentication.student_id
        SET fname='$edit_fname', lname='$edit_lname', username='$edit_username', college_standing='$edit_college_standing', user_bio='$edit_bio'
        WHERE user_authentication.authenticate_id='$authenticate_id'";

    $edit_query = mysqli_query($conn, $edit);
}

// deletes empty entries that would occur on refresh
$delete_empty1 = "DELETE FROM user_authentication WHERE authenticate_id=''";
$delete_empty1_query = mysqli_query($conn, $delete_empty1);

// deletes empty entries that would occur on refresh
$delete_empty2 = "DELETE FROM student WHERE fname=''";
$delete_empty2_query = mysqli_query($conn, $delete_empty2);

$sql3 = "SELECT student.id AS id, student.fname AS fname, student.lname AS lname, student.username AS username, student.college_standing AS college_standing, student.user_bio AS bio, user_authentication.authenticate_id AS authenticate_id, user_authentication.student_id AS student_id 
        FROM student 
        INNER JOIN user_authentication
        ON id=student_id";
$retrieve1 = mysqli_query($conn, $sql3);

// deletes empty entries that would occur on refresh
$delete_empty1 = "DELETE FROM user_authentication WHERE authenticate_id=''";
$delete_empty1_query = mysqli_query($conn, $delete_empty1);

// deletes empty entries that would occur on refresh
$delete_empty2 = "DELETE FROM student WHERE fname=''";
$delete_empty2_query = mysqli_query($conn, $delete_empty2);

// Escape variables for security sql injection
$user_fname = mysqli_real_escape_string($conn, $_POST['fname']);
$user_lname = mysqli_real_escape_string($conn, $_POST['lname']);
$username = mysqli_real_escape_string($conn, $_POST['username']);
$college_standing = $_POST['college-standing'];
$bio = mysqli_real_escape_string($conn, $_POST['bio']);

// remove unnecessary chars like tab/newline/space
$user_fname = trim($user_fname);
$user_lname = trim($user_lname);
$username = trim($username);
$college_standing = trim($college_standing);
$bio = trim($bio);

// remove backslashes
$user_fname = stripslashes($user_fname);
$user_lname = stripslashes($user_lname);
$username = stripslashes($username);
$college_standing = stripslashes($college_standing);
$bio = stripslashes($bio);

// convert problematic chars into entity representation
// prevents injection in the PHP
$user_fname = htmlspecialchars($user_fname);
$user_lname = htmlspecialchars($user_lname);
$username = htmlspecialchars($username);
$college_standing = htmlspecialchars($college_standing);
$bio = htmlspecialchars($bio);

// Needed since quotation marks affect the insert statement
$bio = str_replace("'", "\'", $bio);

// Condition for inserting database entries
if ($user_fname != '') {
    $sql = "INSERT INTO student (fname, lname, username, college_standing, user_bio) VALUES ('$user_fname', '$user_lname', '$username', '$college_standing', '$bio')";
    $insert = mysqli_query($conn, $sql);

    // Needed to determine the student ID to then add into the user authentication table, matching
    // a user with their Google login authentication
    $user_id = "SELECT student.id AS student_id
                    FROM student
                    WHERE student.fname='$user_fname' AND student.lname='$user_lname' AND student.username='$username' AND student.college_standing='$college_standing' AND student.user_bio='$bio'";
    $result = mysqli_query($conn, $user_id);

    while ($row = mysqli_fetch_assoc($result)) {
        $student_id = $row['student_id'];
    }

    $sql2 = "INSERT INTO user_authentication VALUES ('$authenticate_id', $student_id)";
    $insert2 = mysqli_query($conn, $sql2);
}

$sql_select1 = "SELECT user_authentication.authenticate_id AS user_match
                    FROM user_authentication";
$sql_q1 = mysqli_query($conn, $sql_select1);

// deletes empty entries that would occur on refresh
$delete_empty1 = "DELETE FROM user_authentication WHERE authenticate_id=''";
$delete_empty1_query = mysqli_query($conn, $delete_empty1);

// deletes empty entries that would occur on refresh
$delete_empty2 = "DELETE FROM student WHERE fname=''";
$delete_empty2_query = mysqli_query($conn, $delete_empty2);

$sql3 = "SELECT student.id AS id, student.fname AS fname, student.lname AS lname, student.username AS username, student.college_standing AS college_standing, student.user_bio AS bio, user_authentication.authenticate_id AS authenticate_id, user_authentication.student_id AS student_id 
                FROM student 
                INNER JOIN user_authentication
                ON id=student_id";
$retrieve1 = mysqli_query($conn, $sql3);

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
                        WHERE user_authentication.authenticate_id='$authenticate_id'";
$student_id_query = mysqli_query($conn, $student_id_sql);

while ($row = mysqli_fetch_assoc($student_id_query)) {
    $student_id = $row['student'];
}

// grabs major information for each major selected by the user on create-profile.php
foreach ($_POST['major'] as $major) {
    $major_id_sql = "SELECT majors.id AS major_id, majors.major_name
                        FROM majors
                        WHERE majors.major_name='$major'";
    $major_id_query = mysqli_query($conn, $major_id_sql);
    
    while ($row = mysqli_fetch_assoc($major_id_query)) {
        $major_id = $row['major_id'];
    }

    // inserts these values into the student_majors table
    $sql3 = "INSERT INTO student_majors VALUES ($student_id, $major_id)";
    $insert3 = mysqli_query($conn, $sql3);    
}

// Needed since any edits would keep previous selected majors still in the database
if ($_POST['edit-major']) {
    $count_majors = 0;
    foreach ($_POST['edit-major'] as $edit_major) {
        $count_majors = $count_majors + 1;

        // resets majors
        if ($count_majors > 0) {
            $reset_majors = "DELETE student_majors
                                FROM student_majors 
                                INNER JOIN student
                                ON student.id=student_majors.student_id
                                INNER JOIN user_authentication
                                ON user_authentication.student_id=student.id
                                WHERE user_authentication.authenticate_id='$authenticate_id'";
            $reset_majors_query = mysqli_query($conn, $reset_majors);
        }
    }
}

// grabs major information for each major selected by the user on edit-profile.php
foreach ($_POST['edit-major'] as $edit_major) {
    $major_id_sql = "SELECT majors.id AS major_id, majors.major_name
                        FROM majors
                        WHERE majors.major_name='$edit_major'";
    $major_id_query = mysqli_query($conn, $major_id_sql);
    
    while ($row = mysqli_fetch_assoc($major_id_query)) {
        $major_id = $row['major_id'];
    }

    // inserts these values into the student_majors table
    $sql3 = "INSERT INTO student_majors VALUES ($student_id, $major_id)";
    $insert3 = mysqli_query($conn, $sql3);
}

// grabs course information for each course selected by the user on create-profile.php
foreach ($_POST['enrolled-courses'] as $course) {
    $courses_sql = "SELECT course.id, course.course_title, course.subject
                        FROM course
                        WHERE course.course_title='$course'";
    $courses_query = mysqli_query($conn, $courses_sql);
    
    while ($row = mysqli_fetch_assoc($courses_query)) {
        $course_id = $row['id'];
    }

    $sql4 = "INSERT INTO enrolled_courses VALUES ($student_id, $course_id)";
    $insert4 = mysqli_query($conn, $sql4);
}

// Needed since any edits would keep previous selected courses still in the database
if ($_POST['edit-enrolled-courses']) {
    $count_courses = 0;
    foreach ($_POST['edit-enrolled-courses'] as $edit_course) {
        $count_courses = $count_courses + 1;

        if ($count_courses > 0) {
            $reset_courses = "DELETE enrolled_courses
                                FROM enrolled_courses
                                INNER JOIN student
                                ON student.id=enrolled_courses.student_id
                                INNER JOIN user_authentication
                                ON user_authentication.student_id=student.id
                                WHERE user_authentication.authenticate_id='$authenticate_id'";
            $reset_courses_query = mysqli_query($conn, $reset_courses);
        }
    }
}

// grabs course information for each course selected by the user on edit-profile.php
foreach ($_POST['edit-enrolled-courses'] as $edit_course) {
    $courses_sql = "SELECT course.id, course.course_title, course.subject
                        FROM course
                        WHERE course.course_title='$edit_course'";
    $courses_query = mysqli_query($conn, $courses_sql);
    
    while ($row = mysqli_fetch_assoc($courses_query)) {
        $course_id = $row['id'];
    }

    $sql4 = "INSERT INTO enrolled_courses VALUES ($student_id, $course_id)";
    $insert4 = mysqli_query($conn, $sql4);
}

// File upload path
$targetDir = "../images/";
$fileName = basename($_FILES["edit-profile-image"]["name"]);
$targetFilePath = $targetDir . $fileName;
$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

if (isset($_POST["create-profile"]) && !empty($_FILES["edit-profile-image"]["name"])) {
    // allow certain file formats
    $allowTypes = array('jpg','png','jpeg','webp');

    if (in_array($fileType, $allowTypes)) {

        // upload file to server
        if (move_uploaded_file($_FILES["edit-profile-image"]["tmp_name"], $targetFilePath)) {

            // insert image file name into database
            $insert_image_sql = "INSERT INTO profile_image (student_id, file_name) VALUES ('$student_id', '$fileName')";
            $insert_image_query = mysqli_query($conn, $insert_image_sql);
        }
    }
}

if (isset($_POST["edit-profile"]) && !empty($_FILES["edit-profile-image"]["name"])) {
    // allow certain file formats
    $allowTypes = array('jpg','png','jpeg','webp');

    if (in_array($fileType, $allowTypes)) {

        // upload file to server
        if (move_uploaded_file($_FILES["edit-profile-image"]["tmp_name"], $targetFilePath)) {

            // remove previous image from database so that only one profile image is tied
            // to a user; prevents user from uploading multiple images to the server 
            $delete_image_sql = "DELETE profile_image 
                                    FROM profile_image
                                    INNER JOIN student 
                                    ON student.id=profile_image.student_id
                                    INNER JOIN user_authentication
                                    ON user_authentication.student_id=student.id
                                    WHERE authenticate_id='$authenticate_id'";
            $delete_image_query = mysqli_query($conn, $delete_image_sql);

            // insert image file name into database
            $insert_image_sql = "INSERT INTO profile_image (student_id, file_name) VALUES ('$student_id', '$fileName')";
            $insert_image_query = mysqli_query($conn, $insert_image_sql);
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile | AptiStudy</title>

    <link rel="stylesheet" href="https://unpkg.com/rivet-core@2.3.1/css/rivet.min.css">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body class="rvt-layout">

    <?php

    if (isset($_POST['edit-profile'])) {
    ?>
        <div id="confirmation_bar">
            <p id="message">Your profile has been sucessfully updated!</p>
            <button id="close_button" onclick="parentNode.remove()">&times;</button>
        </div>

    <?php
    }
    ?>

    <?php include '../other-assets/navbar-profile.php'; ?>

    <!-- **************************************************************************
    PROFILE - SINGLE-COLUMN LAYOUT
    
    -> rivet.iu.edu/layouts/profile-page/
    *************************************************************************** -->

    <!-- **************************************************************************
    Main content area
    *************************************************************************** -->

    <main id="main-content" class="rvt-flex rvt-flex-column rvt-grow-1">
        <div class="profile_header">
            <div class="rvt-bg-black-000 rvt-border-bottom rvt-p-top-xl">
                <div class="rvt-container-lg rvt-prose rvt-flow rvt-p-bottom-xl">

                    <!-- **************************************************************
                    Page title
                    *************************************************************** -->

                    <h1 class="rvt-m-top-xs">User Profile <a href="edit-profile.php" class="edit_profile_button">Edit
                            Profile</a></h1>
                </div>
            </div>
        </div>

        <main id="main-content" class="rvt-layout__wrapper rvt-container-sm">
            <div class="rvt-layout__content">
                <div class="profile_picture">
                    <!-- ******************************************************************
                    Headshot, name, and title
                    ******************************************************************* -->

                    <div class="rvt-flex-md-up rvt-items-center-md-up rvt-m-top-xxl rvt-m-top-md-md-up">

                        <!-- **************************************************************
                        Headshot
                        *************************************************************** -->

                        <div class="profile_image">
                            <?php

                            // grabs profile image path tied to a user
                            $profile_image_sql = "SELECT profile_image.file_name FROM profile_image
                                                        INNER JOIN student
                                                        ON student.id=profile_image.student_id
                                                        INNER JOIN user_authentication
                                                        ON user_authentication.student_id=student.id
                                                        WHERE user_authentication.authenticate_id='$authenticate_id'";
                            $profile_image_query = mysqli_query($conn, $profile_image_sql);

                            while ($row = mysqli_fetch_assoc($profile_image_query)) {
                                $profile_image = '../images/'.$row['file_name'];
                            }
                            ?>

                            <!-- displays the image stored on the server -->
                            <img id="img" class="view_profile_image" src="<?php echo($profile_image); ?>"
                                onerror="this.onerror=null; this.src='../images/profile-upload.png'"
                                alt="">
                        </div>

                        <!-- **************************************************************
                        Name and title
                        *************************************************************** -->

                        <div class="rvt-prose rvt-flow">
                            <h1 class="profile_name_h1">
                                <?php echo ($_SESSION['user_fname']) . " " . $_SESSION['user_lname']; ?>
                            </h1>
                            <p class="rvt-ts-20 rvt-color-black-500">
                                <?php echo ($_SESSION['college_standing']); ?>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="rvt-prose rvt-flow rvt-p-top-lg rvt-m-top-xl">

                    <!-- **************************************************************
                    Contact information card
                    *************************************************************** -->

                    <div class="rvt-layout__feature-slot">
                        <div class="rvt-card rvt-card--raised">
                            <div class="rvt-card__body">
                                <dl class="rvt-list-description rvt-m-all-none">
                                    <dt>Major(s):</dt>
                                    <dd>
                                        <ul style="margin-top: 2px">
                                            <?php
                                            $major_name_sql = "SELECT majors.major_name
                                                                    FROM majors
                                                                    INNER JOIN student_majors ON majors.id=student_majors.major_id
                                                                    INNER JOIN student ON student_majors.student_id=student.id
                                                                    INNER JOIN user_authentication ON user_authentication.student_id=student.id
                                                                    WHERE user_authentication.authenticate_id='$authenticate_id'";
                                            $major_name_query = mysqli_query($conn, $major_name_sql);
                                            
                                            while ($row = mysqli_fetch_assoc($major_name_query)) {
                                                $major_name = $row['major_name'];
                                            ?>
                                                <li><?php echo($major_name); ?></li>
                                            <?php
                                            }
                                            ?>
                                        </ul>
                                    </dd>
                                    <dt>Email:</dt>
                                    <dd><a href="mailto: <?php echo ($_SESSION['username']); ?>@iu.edu"><?php
                                       echo ($_SESSION['username']); ?>@iu.edu</a></dd>
                                    <dt>Campus:</dt>
                                    <dd>IU Bloomington</dd>
                                </dl>
                            </div>
                        </div>
                    </div>

                    <!-- **************************************************************
                    Biography
                    *************************************************************** -->

                    <h2>Current Courses</h2>
                    <ul>
                        <?php
                        $course_name_sql = "SELECT course.course_title, course.subject
                                                FROM course
                                                INNER JOIN enrolled_courses ON enrolled_courses.course_id=course.id
                                                INNER JOIN student ON student.id=enrolled_courses.student_id
                                                INNER JOIN user_authentication ON user_authentication.student_id=student.id
                                                WHERE user_authentication.authenticate_id='$authenticate_id'";
                        $course_name_query = mysqli_query($conn, $course_name_sql);
                        
                        while ($row = mysqli_fetch_assoc($course_name_query)) {
                            $course_title = $row['course_title'];
                            $subject = $row['subject'];
                        ?>
                            <li><?php echo($course_title); ?>&nbsp;&nbsp;(<em><?php echo($subject); ?></em>)</li>
                        <?php
                        }
                        ?>
                    </ul>

                    <h2>About</h2>
                    <p>
                        <?php echo ($_SESSION['bio']); ?>
                    </p>

                    <h2 class="matches_profile">Matches</h2>
                    <a href="comp-quest.php" class="comp_quest_button">Compatibility Questionnaire</a>
                    <p class="comp_quest_p">This questionnaire intends to match you with similar students in terms of
                        study group and/or academic goals!</p>
                </div>

                <!-- ******************************************************************
                Series navigation: Previous and next person in directory
                ******************************************************************* -->

                <nav class="rvt-seriesnav rvt-m-top-xxl">
                    <a class="rvt-seriesnav__previous" href="#0">
                        <div class="rvt-seriesnav__text">
                            <span class="rvt-seriesnav__label">Previous:</span>
                            <span class="rvt-seriesnav__item">Kendall Cristal</span>
                        </div>
                        <span class="rvt-seriesnav__icon" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                <path fill="currentColor"
                                    d="M15,7H3.41L5.71,4.71A1,1,0,0,0,4.29,3.29l-4,4a1,1,0,0,0,0,1.42l4,4a1,1,0,0,0,1.41-1.41L3.41,9H15a1,1,0,1,0,0-2Z" />
                            </svg>
                        </span>
                    </a>
                    <a class="rvt-seriesnav__next" href="#0">
                        <div class="rvt-seriesnav__text">
                            <span class="rvt-seriesnav__label">Next:</span>
                            <span class="rvt-seriesnav__item">Norval Ashton</span>
                        </div>
                        <span class="rvt-seriesnav__icon" aria-hidden="true">
                            <svg width="16" height="16" viewBox="0 0 16 16">
                                <path fill="currentColor"
                                    d="M15.92,8.38a1,1,0,0,0-.22-1.09l-4-4a1,1,0,0,0-1.41,1.41L12.59,7H1A1,1,0,0,0,1,9H12.59l-2.29,2.29a1,1,0,1,0,1.41,1.41l4-4A1,1,0,0,0,15.92,8.38Z" />
                            </svg>
                        </span>
                    </a>
                </nav>
            </div>
        </main>

        <script src="https://unpkg.com/rivet-core@2.3.1/js/rivet.min.js"></script>
        <script>
            Rivet.init();
        </script>

        <?php include '../other-assets/footer-scrolling.php'; ?>
        <?php mysqli_close($conn); ?>
</body>

</html>