<?php
session_start();

$authenticate_id = $_SESSION['user_id'];

// Code to redirect user if they are not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}

// redirects the user back to create-profile.php if they attempt to access view-profile, even after
// being logged (only if they have not created an account)
if (!isset($_SESSION['user_fname']) && !isset($_SESSION['user_lname']) && !isset($_SESSION['username']) && !isset($_SESSION['college_standing'])) {
    header("Location: create-profile.php");
}

$conn = mysqli_connect("****", "****", "****", "****");

// Check connection
if (mysqli_connect_errno()) {
    die("Failed to connect to MySQL: " . mysqli_connect_error());
}

// deletes empty entries that would occur on refresh
$delete_empty1 = "DELETE FROM user_authentication WHERE authenticate_id=''";
$delete_empty1_query = mysqli_query($conn, $delete_empty1);

// deletes empty entries that would occur on refresh
$delete_empty2_query = "DELETE FROM student WHERE fname=''";
$delete_empty2_query = mysqli_query($conn, $delete_empty2);

$sql_select1 = "SELECT user_authentication.authenticate_id AS user_match
                    FROM user_authentication";
$sql_q1 = mysqli_query($conn, $sql_select1);

// selects all the user information to populate the input fields to be able to edit
$sql3 = "SELECT student.id AS id, student.fname AS fname, student.lname AS lname, student.username AS username, student.college_standing AS college_standing, student.user_bio AS bio, user_authentication.authenticate_id AS authenticate_id, user_authentication.student_id AS student_id 
                FROM student 
                INNER JOIN user_authentication
                ON id=student_id
                WHERE authenticate_id='$authenticate_id'";
$retrieve1 = mysqli_query($conn, $sql3);

while ($row = mysqli_fetch_assoc($retrieve1)) {
    $fname = $row['fname'];
    $lname = $row['lname'];
    $username = $row['username'];
    $college_standing = $row['college_standing'];
    $bio = $row['bio'];
}

// grabs majors from the database
$sql = "SELECT majors.major_name AS majors
FROM majors";

$result = mysqli_query($conn, $sql);

// grabs majors tied to a user in the database
$major_name_sql = "SELECT majors.major_name
                        FROM majors
                        INNER JOIN student_majors ON majors.id=student_majors.major_id
                        INNER JOIN student ON student_majors.student_id=student.id
                        INNER JOIN user_authentication ON user_authentication.student_id=student.id
                        WHERE user_authentication.authenticate_id='$authenticate_id'";
$major_name_query = mysqli_query($conn, $major_name_sql);

while ($row = mysqli_fetch_assoc($result)) {
    $all_majors_array[] = $row['majors'];
}

while ($row2 = mysqli_fetch_assoc($major_name_query)) {
    $selected_majors_array[] = $row2['major_name'];
}

foreach ($all_majors_array as $row1) {
    foreach ($selected_majors_array as $row2) {
        if ($row1 = $row2) {
            // echo ($row1);
        }
    }
    break;
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User Profile | AptiStudy</title>

    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/styles.css">

    <link rel="stylesheet" href="https://unpkg.com/rivet-core@2.2.0/css/rivet.min.css">
</head>

<body class="rvt-layout">
    <?php include '../other-assets/navbar-profile.php'; ?>

    <!-- **************************************************************************
    APP CREATE/EDIT RESOURCE - SINGLE-COLUMN LAYOUT
    
    -> rivet.iu.edu/layouts/app-create-or-edit-resource-page/
    *************************************************************************** -->

    <!-- **************************************************************************
    Main content area
    *************************************************************************** -->

    <main id="main-content" class="rvt-flex rvt-flex-column rvt-grow-1">
        <div class="rvt-bg-black-000 rvt-border-bottom rvt-p-top-xl">
            <div class="rvt-container-lg rvt-prose rvt-flow rvt-p-bottom-xl">

                <!-- **************************************************************
                Page title
                *************************************************************** -->

                <h1 class="rvt-m-top-xs">Edit Profile <button type="button" class="delete_profile_button rvt-button--danger" onclick="warningDeleteProfile()">Delete Profile</button></h1>
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
                        Create/edit form
                        ******************************************************* -->

                        <form action="view-profile.php" class="form1" method="POST" enctype="multipart/form-data">

                            <div class="profile_box">
                                <img src="../images/profile-upload.png" class="profile_upload" alt="Profile Upload">

                                <!-- File upload parameters -->
                                <div class="rvt-file" data-rvt-file-input="singleFileInput">
                                    <input type="file" name="edit-profile-image" 
                                        data-rvt-file-input-button="singleFileInput" id="singleFileInput"
                                        aria-describedby="file-description"
                                        accept="image/jpeg, image/jpg, image/png, image/webp">
                                    <label for="singleFileInput" class="rvt-button">
                                        <span>Upload a profile picture</span>
                                        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="16"
                                            height="16" viewBox="0 0 16 16">
                                            <path fill="currentColor"
                                                d="M10.41,1H3.5A1.3,1.3,0,0,0,2.2,2.3V13.7A1.3,1.3,0,0,0,3.5,15h9a1.3,1.3,0,0,0,1.3-1.3V4.39ZM11.8,5.21V6H9.25V3h.34ZM4.2,13V3h3V6.75A1.25,1.25,0,0,0,8.5,8h3.3v5Z" />
                                        </svg>
                                    </label>
                                    <!-- Adds a label for displaying which image was uploaded -->
                                    <div class="rvt-file__preview" data-rvt-file-input-preview="singleFileInput"
                                        id="file-description">
                                        No file selected
                                    </div>
                                </div>
                            </div>

                            <!-- **************************************************
                            Grouped set of fields
                            *************************************************** -->
                            <fieldset class="rvt-fieldset">
                                <div class="form_row">
                                    <div class="first_name">
                                        <div class="rvt-m-top-sm">
                                            <label class="rvt-label" for="fname">First Name:
                                            </label>
                                            <!-- Input field with validations in check -->
                                            <input class="rvt-input" type="text" name="edit-fname" id="edit-fname" minlength="1"
                                                style="width:480px" maxlength="20" pattern="^([A-Z][a-z]{0,})"
                                                title="Enter only alphabetic letters with first letter capitalized."
                                                value="<?php
                                                            echo($fname);
                                                        ?>" 
                                                required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form_row">
                                    <div class="last_name">
                                        <div class="rvt-m-top-sm">
                                            <label class="rvt-label" for="text-two">Last Name:
                                            </label>
                                            <!-- Input field with validations in check -->
                                            <input class="rvt-input" type="text" name="edit-lname" id="edit-lname" minlength=1
                                                style="width:480px" maxlength=20
                                                pattern="^([A-Z]{1,}[a-z]{0,}*'?-?[a-zA-Z]\s?([a-zA-Z])?)"
                                                title="Enter only alphabetic letters with first letter capitalized. Hyphenated names are allowed."
                                                value="<?php
                                                            echo($lname);
                                                        ?>" 
                                                required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form_row">
                                    <div class="user_name">
                                        <div class="rvt-m-top-sm">
                                            <label class="rvt-label" for="text-three">IU Username: </label>
                                            <!-- Input field with validations in check -->
                                            <input class="rvt-input" type="text" name="edit-username" id="edit-username"
                                                maxlength=10 style="width: 480px; margin-bottom: -15px"
                                                pattern="^([a-z]{0,})" title="Enter only lowercase alphabetic letters."
                                                value="<?php
                                                            echo($username);
                                                        ?>" 
                                                required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form_row">
                                    <div class="major">
                                        <div class="rvt-m-top-lg">
                                            <label class="rvt-label" style="padding-top: -40px" for="select-one"
                                                required>Major: </label>
                                        </div>

                                        <div class="select select-multiple">
                                            <select name="edit-major[]" style="width: 480px" id="multi-select" multiple>
                                                <?php
                                                // ******* CHANGE BACK TO TEAM DATABASE AFTER TESTING ********
                                                $conn = mysqli_connect("db.luddy.indiana.edu", "i494f22_team04", "my+sql=i494f22_team04", "i494f22_team04");

                                                // Check connection
                                                if (mysqli_connect_errno()) {
                                                    die("Failed to connect to MySQL: " . mysqli_connect_error());
                                                }

                                                $sql = "SELECT majors.major_name AS majors
                                                            FROM majors";

                                                $result = mysqli_query($conn, $sql);

                                                $major_name_sql = "SELECT majors.major_name
                                                                        FROM majors
                                                                        INNER JOIN student_majors ON majors.id=student_majors.major_id
                                                                        INNER JOIN student ON student_majors.student_id=student.id
                                                                        INNER JOIN user_authentication ON user_authentication.student_id=student.id
                                                                        WHERE user_authentication.authenticate_id='$authenticate_id'";
                                                $major_name_query = mysqli_query($conn, $major_name_sql);

                                                while ($row1 = mysqli_fetch_assoc($result)) {
                                                    $all_majors_array[] = $row['majors'];
                                                }

                                                while ($row2 = mysqli_fetch_assoc($major_name_query)) {
                                                    $selected_majors_array[] = $row2['major_name'];
                                                }

                                                foreach ($all_majors_array as $row_entry1) {
                                                    foreach ($selected_majors_array as $row_entry2) {
                                                        if ($row_entry1 == $row_entry2) {
                                                        ?>
                                                            <option selected value="<?php echo ($row_entry1); ?>">
                                                            <?php echo ($row_entry1); ?></option>
                                                        <?php
                                                            break;
                                                        }
                                                        else if ($row_entry1 != '' && $row_entry2 != '') {
                                                        ?>
                                                            <option value="<?php echo ($row_entry1); ?>">
                                                            <?php echo ($row_entry1); ?></option>
                                                <?php
                                                            break;
                                                        }
                                                    }
                                                }

                                                mysqli_close($conn);
                                                ?>
                                            </select>
                                            <span class="focus"></span>
                                        </div>
                                    </div>
                                </div>

                                <fieldset class="rvt-fieldset rvt-m-top-xxl" style="margin-bottom: -15px">
                                    <div class="college_standing">
                                        <label class="rvt-label" for="text-one">College Standing: </label>
                                        <ul class="rvt-list-inline">
                                            <li>
                                                <div class="rvt-radio">
                                                    <input type="radio" name="edit-college-standing" id="edit-college-standing"
                                                        value="Freshman" 
                                                        <?php
                                                            echo($college_standing == 'Freshman') ? "checked" : "" ;
                                                        ?>
                                                        aria-describedby="radio-list-message" required>
                                                    <label for="radio-1">Freshman</label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="rvt-radio">
                                                    <input type="radio" name="edit-college-standing" id="edit-college-standing"
                                                        value="Sophomore" 
                                                        <?php
                                                            echo($college_standing == 'Sophomore') ? "checked" : "" ;
                                                        ?>
                                                        aria-describedby="radio-list-message">
                                                    <label for="radio-2">Sophomore</label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="rvt-radio">
                                                    <input type="radio" name="edit-college-standing" id="edit-college-standing"
                                                        value="Junior" 
                                                        <?php
                                                            echo($college_standing == 'Junior') ? "checked" : "" ;
                                                        ?>
                                                        aria-describedby="radio-list-message">
                                                    <label for="radio-3">Junior</label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="rvt-radio">
                                                    <input type="radio" name="edit-college-standing" id="edit-college-standing"
                                                        value="Senior" 
                                                        <?php
                                                            echo($college_standing == 'Senior') ? "checked" : "" ;
                                                        ?>
                                                        aria-describedby="radio-list-message">
                                                    <label for="radio-4">Senior</label>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </fieldset>

                                <div class="form_row" style="margin-bottom: -15px">
                                    <div class="major">
                                        <div class="rvt-m-top-lg">
                                            <label class="rvt-label" style="padding-top: -40px" for="select-one"
                                                required>Enrolled Courses: </label>
                                        </div>

                                        <div class="select select-multiple">
                                            <select name="edit-enrolled-courses[]" style="width: 480px" id="multi-select" multiple>
                                                <?php
                                                
                                                $conn = mysqli_connect("db.luddy.indiana.edu", "i494f22_team04", "my+sql=i494f22_team04", "i494f22_team04");

                                                // Check connection
                                                if (mysqli_connect_errno()) {
                                                    die("Failed to connect to MySQL: " . mysqli_connect_error());
                                                }

                                                $sql = "SELECT course.course_title AS courses
                                                            FROM course";

                                                $result = mysqli_query($conn, $sql);

                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    ?>
                                                    <option value="<?php echo ($row['courses']); ?>"><?php
                                                      echo ($row['courses']); ?></option>
                                                    <?php
                                                }
                                                mysqli_close($conn);
                                                ?>
                                            </select>
                                            <span class="focus"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="rvt-m-top-lg">
                                    <label for="textarea-1" class="rvt-label">Biography: </label>
                                    <!-- Input field with validations in check -->
                                    <textarea name="edit-bio" id="edit-bio" style="width: 480px" class="rvt-textarea"
                                        required><?php echo($bio); ?></textarea>
                                </div>
                            </fieldset>

                            <!-- **************************************************
                            Create/delete form buttons
                            *************************************************** -->

                            <div class="rvt-button-group [ rvt-m-top-xl ]">
                                <!-- Buttons for submitting or canceling profile edits -->
                                <button name="edit-profile" class="rvt-button" type="submit">Edit Profile</button>
                                <a href="view-profile.php" class="cancel_profile">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="../js/site.js"></script>
    <script src="https://unpkg.com/rivet-core@2.2.0/js/rivet.min.js"></script>
    <script>
        Rivet.init();
    </script>

    <?php include '../other-assets/footer-scrolling.php'; ?>
    <?php mysqli_close($conn); ?>
</body>

</html>