<?php
session_start();

// Code to redirect user if they are not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
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

$select1 = "SELECT authenticate_id AS user_match 
                FROM user_authentication";
$query1 = mysqli_query($conn, $select1);

while ($row = mysqli_fetch_assoc($query1)) {
    $user_match = $row['user_match'];

    // redirects to view-profile.php if initial conditions are met
    if ($_SESSION['user_id'] == $user_match && $_SESSION['user_fname'] != '') {
        header("Location: view-profile.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User Profile | AptiStudy</title>

    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/styles.css">

    <link rel="stylesheet" href="https://unpkg.com/rivet-core@2.2.0/css/rivet.min.css">
</head>

<body class="rvt-layout">
    <?php include '../other-assets/navbar-login.php'; ?>

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

                <h1 class="rvt-m-top-xs">Create Profile</h1>
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
                                            <input class="rvt-input" type="text" name="fname" id="fname" minlength="1"
                                                style="width:480px" maxlength="20" pattern="^([A-Z][a-z]{0,})"
                                                title="Enter only alphabetic letters with first letter capitalized."
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
                                            <input class="rvt-input" type="text" name="lname" id="text-two" minlength=1
                                                style="width:480px" maxlength=20
                                                pattern="^([A-Z]{1,}[a-z]{0,}*'?-?[a-zA-Z]\s?([a-zA-Z])?)"
                                                title="Enter only alphabetic letters with first letter capitalized. Hyphenated names are allowed."
                                                required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form_row">
                                    <div class="user_name">
                                        <div class="rvt-m-top-sm">
                                            <label class="rvt-label" for="text-three">IU Username: </label>
                                            <!-- Input field with validations in check -->
                                            <input class="rvt-input" type="text" name="username" id="text-three"
                                                maxlength=10 style="width: 480px; margin-bottom: -15px"
                                                pattern="^([a-z]{0,})" title="Enter only lowercase alphabetic letters."
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
                                            <select name="major[]" style="width: 480px" id="multi-select" multiple>
                                                <?php
                                                
                                                $conn = mysqli_connect("db.luddy.indiana.edu", "i494f22_jhatfie", "my+sql=i494f22_jhatfie", "i494f22_jhatfie");

                                                // Check connection
                                                if (mysqli_connect_errno()) {
                                                    die("Failed to connect to MySQL: " . mysqli_connect_error());
                                                }

                                                // select majors from database
                                                $sql = "SELECT majors.major_name AS majors
                                                            FROM majors";

                                                $result = mysqli_query($conn, $sql);

                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    ?>
                                                    <!-- display selected majors from database -->
                                                    <option value="<?php echo ($row['majors']); ?>"><?php
                                                      echo ($row['majors']); ?></option>
                                                    <?php
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
                                                    <input type="radio" name="college-standing" id="radio-1"
                                                        value="Freshman" aria-describedby="radio-list-message" required>
                                                    <label for="radio-1">Freshman</label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="rvt-radio">
                                                    <input type="radio" name="college-standing" id="radio-2"
                                                        value="Sophomore" aria-describedby="radio-list-message">
                                                    <label for="radio-2">Sophomore</label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="rvt-radio">
                                                    <input type="radio" name="college-standing" id="radio-3"
                                                        value="Junior" aria-describedby="radio-list-message">
                                                    <label for="radio-3">Junior</label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="rvt-radio">
                                                    <input type="radio" name="college-standing" id="radio-4"
                                                        value="Senior" aria-describedby="radio-list-message">
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
                                            <select name="enrolled-courses[]" style="width: 480px" id="multi-select" multiple>
                                                <?php
                                                $conn = mysqli_connect("db.luddy.indiana.edu", "i494f22_jhatfie", "my+sql=i494f22_jhatfie", "i494f22_jhatfie");

                                                // Check connection
                                                if (mysqli_connect_errno()) {
                                                    die("Failed to connect to MySQL: " . mysqli_connect_error());
                                                }

                                                $sql = "SELECT course.course_title AS courses
                                                            FROM course";

                                                $result = mysqli_query($conn, $sql);

                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    ?>
                                                    <!-- displays selected courses from database -->
                                                    <option value="<?php echo ($row['courses']); ?>"><?php
                                                      echo ($row['courses']); ?></option>
                                                    <?php
                                                }
                                                // Close the connection
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
                                    <textarea name="bio" id="textarea-1" style="width: 480px" class="rvt-textarea"
                                        required></textarea>
                                </div>
                            </fieldset>

                            <!-- **************************************************
                            Create/delete form buttons
                            *************************************************** -->

                            <div class="rvt-button-group [ rvt-m-top-xl ]">
                                <!-- Buttons for submitting or canceling profile creation -->
                                <button class="rvt-button" type="submit">Create Profile</button>
                                <a href="login.php" class="cancel_profile">Cancel</a>
                            </div>
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
    <script src="../js/site.js"></script>

    <?php include '../other-assets/footer-scrolling.php'; ?>
    <?php mysqli_close($conn); ?>
</body>

</html>