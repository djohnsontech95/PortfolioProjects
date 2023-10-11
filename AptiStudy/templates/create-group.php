<?php 
    // Start session
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

    //Connection to database (needs adjusted)
    $connection = mysqli_connect("****", "****", "****", "****");
    if (mysqli_connect_errno()) {
        die("Failed to connect to MySQL: " . mysqli_connect_error());
    }

    $studentQuery = "SELECT student.id AS studentID
        FROM student
        INNER JOIN user_authentication ON student.id=user_authentication.student_id
        WHERE user_authentication.authenticate_id='$userID'";

    $studentResults = mysqli_query($connection, $studentQuery);

    while ($row = mysqli_fetch_assoc($studentResults)) {
        $studentID = $row['studentID'];
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Group | AptiStudy</title>
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/styles.css">
    <link href="https://fonts.iu.edu/style.css?family=BentonSans:regular,bold|BentonSansCond:regular|GeorgiaPro:regular" media="screen" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://unpkg.com/rivet-core@2.2.0/css/rivet.min.css">
</head>
<body>

    <?php include '../other-assets/navbar-home.php';?>

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
                        <li><a href="create-group.php">Create Group</a></li>
                    </ol>
                </nav>

                <!-- **************************************************************
                    Page title
                *************************************************************** -->
                
                <h1 class="rvt-m-top-xs">New Study Group</h1>
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
                            Create Group form
                        ******************************************************* -->

                        <form action="group-home.php" method="POST" enctype="multipart/form-data">

                            <!-- ******************************************************
                                Group Image Upload
                            ******************************************************* -->
                            <div class="group_box">
                                <img src="../images/group-upload.png" class="group_upload" alt="Group Upload">

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
                                Group Description
                            *************************************************** -->

                            <fieldset class="rvt-fieldset">
                                <legend class="rvt-legend [ rvt-ts-18 rvt-border-bottom rvt-p-bottom-xs ]">Group Description</legend>
                                <div class="rvt-m-top-sm">
                                    <label class="rvt-label" for="group-name">Group name:</label>
                                    <input class="rvt-input" type="text" name="group-name" id="group-name" minlength="1"
                                        style="width:480px" maxlength="50" pattern="[A-Za-z0-9 ]+"
                                        title="Please enter letters, numbers, or spaces only"
                                        required>
                                    </input>
                                </div>
                                <div class="rvt-m-top-lg">
                                    <label class="rvt-label" for="total-members">Members allowed:</label>
                                    <select class="rvt-select" name="total-members" id="total-members" aria-describedby="select-option-message">
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                        <option value="13">13</option>
                                        <option value="14">14</option>
                                        <option value="15">15</option>
                                    </select>
                                </div>
                                <div class="rvt-m-top-lg">
                                    <label for="textarea-1" class="rvt-label">Group bio:</label>
                                    <textarea id="bio" name="textarea-1" style="width: 480px" class="rvt-textarea"></textarea>
                                </div>
                            </fieldset>

                            <!-- **************************************************
                                Goals
                            *************************************************** -->

                            <fieldset class="rvt-fieldset rvt-m-top-xxl">
                                <legend class="rvt-legend [ rvt-ts-18 rvt-border-bottom rvt-p-bottom-xs ]">Goals</legend>
                                <ul class="rvt-list-plain rvt-width-xl rvt-m-top-sm">
                                    <li>
                                        <div class="rvt-checkbox">
                                            <input type="checkbox" name="checkbox-1" id="checkbox-1">
                                            <input type="hidden">
                                            <label for="checkbox-1">Make friends</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="rvt-checkbox">
                                            <input type="checkbox" name="checkbox-2" id="checkbox-2">
                                            <label for="checkbox-2">Get better grades</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="rvt-checkbox">
                                            <input aria-describedby="checkbox-description" type="checkbox" name="checkbox-3" id="checkbox-3">
                                            <label for="checkbox-3">Eager to learn more</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="rvt-checkbox">
                                            <input type="checkbox" name="checkbox-4" id="checkbox-4">
                                            <label for="checkbox-4">Practicing leadership skills</label>
                                        </div>
                                    </li>
                                </ul>
                            </fieldset>

                            <!-- **************************************************
                                Group Courses
                            *************************************************** -->
                            
                            <fieldset class="rvt-fieldset rvt-m-top-xxl">
                                <legend class="rvt-legend [ rvt-ts-18 rvt-border-bottom rvt-p-bottom-xs ]">Courses:</legend>
                                <div class="rvt-m-top-lg">
                                    <!-- dynamic php statement needed here to grab classes -->
                                    <label class="rvt-label" for="course-selection">Select a course:</label>
                                    <select class="rvt-select" name="course-selection" id="course-selection" aria-describedby="select-option-message">
                                        <?php
                                            $class_query = mysqli_query($connection, "SELECT course.course_title AS title FROM course");

                                            while ($row = $class_query->fetch_assoc()){

                                        ?>

                                        <option value=<?php echo $row['title']; ?>><?php echo $row['title']; ?></option>

                                        <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                            </fieldset>

                            <!-- User Id to set as Host ID -->
                            <input type="hidden" name="student_id" value="<?php echo($studentID); ?>">

                            <!-- **************************************************
                                Create Group form buttons
                            *************************************************** -->
                            
                            <div class="rvt-button-group [ rvt-m-top-xl ]">
                                <button class="rvt-button" name="create_group" type="submit">Create Group</button>
                                <a href="home.php" class="cancel_profile">Cancel</a>
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
    
    
    <?php include '../other-assets/footer-scrolling.php';?>

    <?php
        mysqli_close($connection);
    ?>

</body>
</html>