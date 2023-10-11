<?php 
    // Start session
    session_start();

    //Connection to database
    $connection = mysqli_connect("****", "****", "****", "****");
    if (mysqli_connect_errno()) {
        die("Failed to connect to MySQL: " . mysqli_connect_error());
    }

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

    $studentQuery = "SELECT student.id AS studentID
        FROM student
        INNER JOIN user_authentication ON student.id=user_authentication.student_id
        WHERE user_authentication.authenticate_id='$userID'";

    $studentResults = mysqli_query($connection, $studentQuery);

    while ($row = mysqli_fetch_assoc($studentResults)) {
        $studentID = $row['studentID'];
    }

    $groupQueries = "SELECT sg.id AS groupID, sg.host_id AS hostID, sg.group_name AS groupName, sg.description AS bio, sg.max_members AS totalMembers
        FROM study_group AS sg";

    $random_groups = mysqli_query($connection, $groupQueries);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Groups | AptiStudy</title>

    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/styles.css">

    <style>
      .search {
        padding: 8px;
        float: right;
      }
    </style>

</head>
<body>
    <?php include '../other-assets/navbar-home.php';?>

    <!-- **************************************************************************
    CARD LIST - SINGLE-COLUMN LAYOUT

    -> rivet.iu.edu/layouts/card-list-page/
    *************************************************************************** -->

    <main id="main-content" class="rvt-layout__wrapper" id="main-content">

    <!-- **********************************************************************
        Page title and summary
    *********************************************************************** -->

    <div class="fade_animation">
        <div class="rvt-bg-crimson rvt-p-tb-xl rvt-p-tb-xxl-md-up">
            <div class="rvt-container-sm rvt-prose rvt-flow rvt-text-center">
                <h1 class="rvt-color-white">Find new study groups for you at IU</h1>
                <p class="rvt-ts-20 rvt-color-white ">Discover new groups on campus and explore a whole new world of networking and resources. Whether your looking for friends or academic study partners, Aptistudy has you covered.</p>
            </div>
        </div>
    </div>

    <div class="outer">
        <div class="search_bar">
            <form method="GET" class = "search">
                <input class="search_field" type='text' name='group_name' placeholder='Search by group name' required>
                <input class="search_button" type='submit' value="Search">
            </form>
        </div>
    </div>
    
    <!-- **********************************************************************
        Card list

        -> rivet.iu.edu/components/card/
    *********************************************************************** -->

    <div class="rvt-container-lg rvt-p-tb-xl">
        <ul class="rvt-row rvt-row--loose">

            <!-- **************************************************************
                Card
            *************************************************************** -->

            <!-- query and loop to produce limited amount of random groups -->

            <!-- repeat this card -->
            <?php

                function display($info) {
                    if (mysqli_num_rows($info) == 0) {
                        echo "No results matching \"" . $_GET['group_name'] , "\". Sorry ):";
                    }
                    while ($row = mysqli_fetch_assoc($info)) {
                        
                        ?>
                        <li class="rvt-cols-6-md rvt-cols-4-lg [ rvt-flex rvt-m-bottom-xxl ]">
                            <div class="rvt-card rvt-card--clickable">
                                <div class="group_image">
                                    <?php

                                    //Connection to database
                                    $connection = mysqli_connect("db.luddy.indiana.edu", "i494f22_team04", "my+sql=i494f22_team04", "i494f22_team04");
                                    if (mysqli_connect_errno()) {
                                        die("Failed to connect to MySQL: " . mysqli_connect_error());
                                    }
            
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
                                    <!-- php to grab group name here -->
                                    <h2 class="rvt-card__title"><?php echo $row["groupName"]; ?></h2>
                                    <div class="rvt-card__content [ rvt-flow ]">
                                        <!-- php to grab group description -->
                                        <p><?php echo $row["bio"]; ?></p>
                                    </div>
                                    <div class="rvt-card__meta">

                                        <?php
                                        $userID = $_SESSION['user_id'];

                                         $studentQuery = "SELECT student.id AS studentID
                                         FROM student
                                         INNER JOIN user_authentication ON student.id=user_authentication.student_id
                                         WHERE user_authentication.authenticate_id='$userID'";
                                 
                                        $studentResults = mysqli_query($connection, $studentQuery);
                                    
                                        while ($row5 = mysqli_fetch_assoc($studentResults)) {
                                            $studentID = $row5['studentID'];
                                        }
                                        ?>

                                        <form action="group-home.php" method="POST">
                                            <input type="hidden" name="group_id" value="<?php echo $row['groupID']; ?>">
                                            <input type="hidden" name="host_id" value="<?php echo $row['hostID']; ?>">
                                            <input type="hidden" name="groupName" value="<?php echo $row['groupName']; ?>">
                                            <input type="hidden" name="groupBio" value="<?php echo $row['bio']; ?>">
                                            <input type="hidden" name="totalMembers" value="<?php echo $row['totalMembers']; ?>">
                                            <input type="hidden" name="student_id" value="<?php echo ($studentID); ?>">
                                            <button class="rvt-button" name="view_group" type="submit">View Group</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <?php    
                    }
                    ?>    
                    </ul>
                    <?php
                }
                
                if ($_SERVER['REQUEST_METHOD'] == 'GET' && count($_GET) > 0) {

                    $sangroup = trim(strtolower(mysqli_real_escape_string($connection, $_GET['group_name'])));
            
                    $searchQ = "SELECT sg.id AS groupID, sg.host_id AS hostID, sg.group_name AS groupName, sg.description AS bio, sg.max_members AS totalMembers
                    FROM study_group AS sg WHERE lower(sg.group_name) = '$sangroup';";
            
                    $results = mysqli_query($connection, $searchQ);
                    display($results);
                }
                else {
                    display($random_groups);
                }
            ?>
    </div>
    
</main>

    <?php include '../other-assets/footer-scrolling.php';?>
    <?php mysqli_close($conn); ?>
    
</body>
</html>