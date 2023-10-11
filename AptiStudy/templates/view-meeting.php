<?php
session_start();

// redirects the user back to create-profile.php if they attempt to access view-profile, even after
// being logged (only if they have not created an account)
if (!isset($_SESSION['user_fname']) && !isset($_SESSION['user_lname']) && !isset($_SESSION['username']) && !isset($_SESSION['college_standing'])) {
    header("Location: create-profile.php");
}

// Code to redirect user if they are not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}
else if (isset($_SESSION['user_id'])) {

    $UID = $_SESSION['user_id'];
    $conn = mysqli_connect("****", "****", "****", "****");

    if (mysqli_connect_errno()) {
        die("Failed to connect to MySQL: " . mysqli_connect_error());
    }

    $mID = intval($_GET['meetingID']);

    $groupAssocMeeting = "SELECT sg.id as 'GroupID'
                            from group_members as gm
                            join student as s on s.id = gm.member_id
                            join study_group as sg on sg.id = gm.group_id
                            join meeting as m on m.group_id = sg.id
                            join user_authentication as ua on ua.student_id = s.id
                            where m.id= $mID";
    $group = mysqli_query($conn, $groupAssocMeeting);

    while ($row = mysqli_fetch_assoc($group)) {
        $verify_id = $row['GroupID'];
    }

    $verifyGroup = "SELECT sg.id as 'Group'
                        from group_members as gm
                        join student as s on s.id = gm.member_id
                        join study_group as sg on sg.id = gm.group_id
                        join user_authentication as ua on ua.student_id = s.id
                        where ua.authenticate_id = '$UID' and gm.member_id = ua.student_id and sg.id = $verify_id";
    $verifiedGroup = mysqli_query($conn, $verifyGroup);

    if (mysqli_num_rows($verifiedGroup) == 0 ) {
        header("Location: calendar.php");
    }
}

if (!isset($_GET['meetingID'])) {
    header("Location: calendar.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Meeting | AptiStudy</title>

    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/styles.css">

    <style>
      hr.separator {
        border-top: 2px solid;
        color: rgba(0, 0, 0, 0.124);
        border-radius: 2px;
      }
    </style>

</head>
<body>

    <?php include '../other-assets/navbar-calendar.php';?>
    
    <div class="rvt-p-all-lg rvt-p-all-xl-lg-up">
        <div class="rvt-container-md">
            
        
            <?php

            if (isset($mID)) {
                $meetingQ = "SELECT sg.group_name as 'Group', sg.id as 'Group ID', m.meeting_name as 'title', m._time as 'time',  date_format(m._date, \"%M %d, %Y\") as 'date', m.id as 'meetingID', CONCAT(b.name, ' ', r.room_num, ', ', b.street, ', ', b.city, ', ', b.state, ' ', b.area_code) as local, sg.description as 'description'
                                from group_members as gm
                                join student as s on s.id = gm.member_id
                                join study_group as sg on sg.id = gm.group_id
                                join meeting as m on m.group_id = sg.id
                                join room as r on r.id = m.location
                                join building as b on b.id = r.building_id
                                where $mID = m.id
                                group by m.id;";
                
                $meeting = mysqli_query($conn, $meetingQ);
                
                if (mysqli_num_rows($meeting) > 0) {

                    while ($row = mysqli_fetch_assoc($meeting)) {
                        $group = $row['Group'];
                        $meeting = $row['title'];
                        $time = date("g:i a", strtotime($row['time']));
                        $date = $row['date'];
                        $local = $row['local'];
                        $desc = $row['description'];
                    
                        echo "<p class='rvt-text-medium rvt-ts-xxl'> $meeting </p>";
                        echo "<p class='rvt-ts-lg'>Meeting Details:</p>";
                        echo "<hr class='separator'>";

                        echo "<p><strong class='rvt-text-bold'>Group:</strong> $group </p>";
                
                        echo "<p><strong class='rvt-text-bold'>Date Time:</strong> $date, $time </p>";

                        echo "<p> <strong class='rvt-text-bold'>Location:</strong> $local </p>";

                        echo "<p> <strong class='rvt-text-bold'>Description:</strong> $desc </p>";

                    }
                }
                else {
                    echo "Oops! Something went wrong! This meeting might not exist!";
                }
            }
            ?>
        </div>
    </div>
    <script src="https://unpkg.com/rivet-core@2.3.1/js/rivet.min.js"></script>
    <script>Rivet.init()</script>

    <div class="meeting_footer">
        <?php include '../other-assets/footer.php'; ?>
    </div>
    <div class="meeting_footer_scrolling">
        <?php include '../other-assets/footer-scrolling.php'; ?>
    </div>
    
</body>
</html>