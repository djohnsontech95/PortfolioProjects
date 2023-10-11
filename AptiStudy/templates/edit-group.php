<?php
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
    
    $group_id = $_POST['group_id'];
    $group_name = $_POST['group_name'];
    $group_bio = $_POST['group_bio'];
    $total_members = $_POST['total_members'];
    $host_id = $_POST['host_id'];
    $student_id = $_POST['student_id'];

    $announcementSQL = "SELECT a.first_update AS firstUpdate, a.second_update AS secondUpdate, a.third_update AS thirdUpdate
        FROM announcements AS a
        WHERE a.group_id = $group_id";

    $announcementQuery = mysqli_query($connection, $announcementSQL);

    while ($row = mysqli_fetch_assoc($announcementQuery)) {
        $firstUpdate = $row['firstUpdate'];
        $secondUpdate = $row['secondUpdate'];
        $thirdUpdate = $row['thirdUpdate'];
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Group | Aptistudy</title>
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/styles.css">
    <link href="https://fonts.iu.edu/style.css?family=BentonSans:regular,bold|BentonSansCond:regular|GeorgiaPro:regular" media="screen" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://unpkg.com/rivet-core@2.3.1/css/rivet.min.css">
</head>
<body>

    <?php include '../other-assets/navbar-home.php';?>

    <main id="main-content" class="rvt-flex rvt-flex-column rvt-grow-1">
        <div class="profile_header">
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
                            <li><a href="edit-group.php">Edit Study Group</a></li>
                        </ol>
                    </nav>

                    <!-- **************************************************************
                    Page title
                    *************************************************************** -->

                    <h1 class="rvt-m-top-xs">Edit Group</h1>
                </div>
            </div>
        </div>

        <div class="rvt-layout__wrapper [ rvt-p-tb-xxl ]">
            <div class="rvt-container-lg">
                <div class="rvt-row">
                    <div class="rvt-cols-8-md rvt-flow rvt-prose">

                        <!-- ******************************************************
                        Create/edit form
                        ******************************************************* -->

                        <form action="group-home.php" class="form1" method="POST" enctype="multipart/form-data">

                            <!-- ******************************************************
                                Group Image Upload
                            ******************************************************* -->
                            <div class="group_box">
                                <img src="../images/group-upload.png" class="group_upload_2" alt="Group Upload">

                                <div class="rvt-file" data-rvt-file-input="singleFileInput">
                                    <input type="file" name="edit-group-image" 
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
                                <!-- Group Name -->
                                <div class="form_row">
                                    <div class="first_name">
                                        <div class="rvt-m-top-sm">
                                            <label class="rvt-label" for="edit_group_name">Group Name:
                                            </label>
                                            <input class="rvt-input" type="text" name="edit_group_name" id="edit_group_name" minlength="1"
                                                style="width:480px" maxlength="25" pattern="[A-Za-z0-9 ]+"
                                                title="Please enter letters, numbers, or spaces only"
                                                value="<?php
                                                            echo($group_name);
                                                        ?>" 
                                                required>
                                        </div>
                                    </div>
                                </div>
                                <!-- Group Bio -->
                                <div class="rvt-m-top-lg">
                                    <label for="edit-bio" class="rvt-label">Biography: </label>
                                    <textarea name="edit-bio" id="edit-bio" style="width: 480px" class="rvt-textarea"
                                        required><?php echo($group_bio); ?></textarea>
                                </div>
                                <!-- First Announcement -->
                                <div class="form_row">
                                    <div class="first_name">
                                        <div class="rvt-m-top-sm">
                                            <label class="rvt-label" for="edit_announcement1">First Announcement:
                                            </label>
                                            <input class="rvt-input" type="text" name="edit_announcement1" id="edit_announcement1" minlength="1"
                                                style="width:480px" maxlength="50" pattern="[A-Za-z0-9 ]+"
                                                title="Please enter letters, numbers, or spaces only"
                                                value="<?php echo($firstUpdate); ?>">
                                        </div>
                                    </div>
                                </div>
                                <!-- Second Announcement -->
                                <div class="form_row">
                                    <div class="first_name">
                                        <div class="rvt-m-top-sm">
                                            <label class="rvt-label" for="edit_announcement2">Second Announcement:
                                            </label>
                                            <input class="rvt-input" type="text" name="edit_announcement2" id="edit_announcement2" minlength="1"
                                                style="width:480px" maxlength="50" pattern="[A-Za-z0-9 ]+"
                                                title="Please enter letters, numbers, or spaces only"
                                                value="<?php echo($secondUpdate); ?>" >
                                        </div>
                                    </div>
                                </div>
                                <!-- Third Announcement -->
                                <div class="form_row">
                                    <div class="first_name">
                                        <div class="rvt-m-top-sm">
                                            <label class="rvt-label" for="edit_announcement3">Third Announcement:
                                            </label>
                                            <input class="rvt-input" type="text" name="edit_announcement3" id="edit_announcement3" minlength="1"
                                                style="width:480px" maxlength="50" pattern="[A-Za-z0-9 ]+"
                                                title="Please enter letters, numbers, or spaces only"
                                                value="<?php echo($thirdUpdate); ?>" >
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="student_id" value="<?php echo ($student_id); ?>">
                                <input type="hidden" name="host_id" value="<?php echo ($host_id); ?>">
                                <input type="hidden" name="total_members" value="<?php echo ($total_members); ?>">
                                <input type="hidden" name="group_id" value="<?php echo ($group_id); ?>">

                            </fieldset>

                            <!-- **************************************************
                            Create/delete form buttons
                            *************************************************** -->

                            <div class="rvt-button-group [ rvt-m-top-xl ]">
                                <button name="edit_group" class="rvt-button" type="submit">Edit Group</button>
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

    <?php
        mysqli_close($connection);
    ?>
</body>
</html>

