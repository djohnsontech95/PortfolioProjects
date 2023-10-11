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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendars | AptiStudy</title>

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

    <div class="rvt-bg-black-000 rvt-border-bottom rvt-p-top-xl">
        <div class="rvt-container-lg rvt-prose rvt-flow rvt-p-bottom-xl">

            <!-- **************************************************************
            Page title
            *************************************************************** -->

            <h1 class="rvt-m-top-xs">Meeting Dashboard</h1>
        </div>
    </div>

    <?php

      $conn = mysqli_connect("db.luddy.indiana.edu", "i494f22_team04", "my+sql=i494f22_team04", "i494f22_team04");
      
      if (mysqli_connect_errno()) { 
        die("Failed to connect to MySQL: " . mysqli_connect_error()); 
      }

      if(isset($_SESSION['user_id'])) {
        $UID = $_SESSION['user_id'];
      
        $schedQ = "SELECT sg.group_name as 'Group', sg.id as 'Group ID', m.meeting_name as 'title', m._time as 'time',  m._date as 'date', m.id as 'meetingID'
        from group_members as gm
          join student as s on s.id = gm.member_id
          join study_group as sg on sg.id = gm.group_id
          join meeting as m on m.group_id = sg.id
          join user_authentication as ua on ua.student_id = s.id
        where ua.authenticate_id = '$UID' and m._date >= CURDATE()
        order by m._date, m._time;";

        $events = mysqli_query($conn, $schedQ);
        
        $dated = array();
        
        echo
          "<div class=\" rvt-p-all-lg rvt-p-all-xxl-lg-up\">
            <div class=\" rvt-container-md\">";

        $count = 0;

        while($row = mysqli_fetch_assoc($events)) {
          $count = $count + 1;

          $date = strtotime($row['date']);
          $month = date("M", $date);
          $day = date("d", $date);
          $year = date("Y", $date);

          $meetingID = $row['meetingID'];

          $time = date("g:i a", strtotime($row['time']));

          //TODO README FIXME: The first date grabbed from the database likes to seperately print each event with a calendar tile, FIXME

          // if the date has not already been displayed, add it to an array and populate a calendar tile
          if (!array_search($row['date'], $dated)) {

            // These divs close the divs above this dynamic logic
            if (count($dated) > 0) {
              // row, dashboard container, dahsboard padding div respectively
              echo
                "
                    </div>
                  </div>
                </div>
                <hr class=\"separator\">";
            }

            array_push($dated, $row['date']);
            
            //MAY WANT TO USE DIALOG BOX LATER FOR POP UP MEETING INFO
            echo
              "
              <div class=\"rvt-row rvt-m-top-sm rvt-p-all-sm\">
                <div class=\"rvt-cols-1-md [ rvt-m-bottom-md ]\">
                  <div class=\"rvt-cal rvt-shadow-heavy\">
                    <span class=\"rvt-cal__month\">" . $month . "</span>
                    <span class=\"rvt-cal__day\">" . $day . "</span>
                    <span class=\"rvt-cal__year\">" . $year . "</span>
                  </div>
                </div>
            
                <div class=\"rvt-cols-7 rvt-cols-push-2-md [ rvt-m-bottom-md ]\">
                  <div class=\"rvt-container-md\">
                    <div class=\"rvt-row rvt-m-top-sm rvt-p-all-sm rvt-bg-blue-100\">
                      <a href='view-meeting.php?meetingID=$meetingID'><span class=\"rvt-ts-20 rvt-text-bold\">" . $time . "</span> <span>" . $row['title'] . "</span></a>
                    </div>";
          }
          // displays events on the same day if the dae thas already been displayed
          elseif (array_search($row['date'], $dated)) {
            echo
              "<div class=\"rvt-row rvt-m-top-sm rvt-p-all-sm rvt-bg-blue-100\">
              <a href='view-meeting.php?meetingID=$meetingID'><span class=\"rvt-ts-20 rvt-text-bold\">" . $time . "</span> <span>" . $row['title'] . "</span></a>
            </div>";
          }
        }
      
        echo
          "
                  </div>
                </div>
              </div>
            </div>
          </div>";
      }
      ?>
    
    <script src="https://unpkg.com/rivet-core@2.3.1/js/rivet.min.js"></script>
    <script>Rivet.init()</script>

    <?php
    if ($count <= 2) {
    ?>
      <div class="footer">
        <?php include '../other-assets/footer.php'; ?>
      </div>
    <?php
    }
    else {
    ?>
      <div class="footer_scrolling">
        <?php include '../other-assets/footer-scrolling.php'; ?>
      </div>
    <?php
    }
    ?>

</body>