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

// Get the ticket ID on the GET request
$ticket_id = $_GET['ticket_id'];
$_SESSION['ticket_id'] = $ticket_id;

$student_tickets = "SELECT ticket.id
                        FROM ticket
                        INNER JOIN student 
                        ON student.id=ticket.student_id
                        INNER JOIN user_authentication
                        ON user_authentication.student_id=student.id
                        WHERE user_authentication.authenticate_id='$authenticate_id'";
$student_tickets_match = mysqli_query($conn, $student_tickets);

// requires GET request to access an individual ticket
if ($ticket_id == '') {
    header("Location: ticket-support.php");
}
else {
    // counts to see if the ticket from the GET request matches a ticket tied to the user
    // in the database; prevents users from being able to search other user's individual tickets
    // in the search bar of the browser using the link path
    $count_student_ticket_matches = 0;

    while ($row = mysqli_fetch_assoc($student_tickets_match)) {
        if ($ticket_id == $row['id']) {
            $count_student_ticket_matches = $count_student_ticket_matches + 1;
        }
    }

    if ($count_student_ticket_matches == 0) {
        header("Location: ticket-support.php");
    }
}

// grabs all ticket information tied to the ticket ID to be able to display
$ticket_search = "SELECT ticket.date_filed, ticket.time_filed, ticket_category.category, ticket.severity, ticket.description
                    FROM ticket
                    INNER JOIN ticket_category 
                    ON ticket.type=ticket_category.id
                    WHERE ticket.id=$ticket_id";
$ticket_match = mysqli_query($conn, $ticket_search);

while ($row = mysqli_fetch_assoc($ticket_match)) {
    $date_filed = $row['date_filed'];
    $time_filed = $row['time_filed'];
    $type_of_assistance = $row['category'];
    $severity = $row['severity'];
    $description = $row['description'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Ticket | AptiStudy</title>

    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/styles.css">

    <link rel="stylesheet" href="https://unpkg.com/rivet-core@2.2.0/css/rivet.min.css">
</head>

<body class="rvt-layout">

    <?php include '../other-assets/navbar-support.php'; ?>

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
                    Breadcrumb navigation
                *************************************************************** -->

                <nav class="rvt-flex rvt-items-center" role="navigation" aria-label="Breadcrumb">
                    <ol class="rvt-breadcrumbs rvt-grow-1">
                        <li>
                            <a href="ticket-support.php">
                                <svg width="16" height="16" viewBox="0 0 16 16" id="rvt-icon-home">
                                    <path fill="currentColor" d="M15.6 6.4l-7-5.19a.76.76 0 0 0-.19-.12A1 1 0 0 0 8 1a1 1 0 0 0-.42.09.76.76 0 0 0-.19.12L.4 6.4a1 1 0 0 0-.4.8 1 1 0 0 0 .2.6 1 1 0 0 0 1.4.2l.4-.3V14a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V7.7l.4.3a1 1 0 0 0 .6.2 1 1 0 0 0 .6-1.8zM12 13H9V9H7v4H4V6.22l4-3 4 3z"></path>
                                </svg><span class="ticket_home_link">Ticket Support</span>
                            </a>
                        </li>
                    </ol>
                </nav>

                <!-- **************************************************************
                Page title
                *************************************************************** -->

                <h1 class="rvt-m-top-xs">Ticket Identification: #<?php echo($ticket_id); ?></h1>
            </div>
        </div>

        <!-- **********************************************************************
        Content
        *********************************************************************** -->

        <!-- Displays ticket information -->
        <div class="rvt-layout__wrapper [ rvt-p-tb-xxl ]">
            <div class="rvt-container-lg">
                <div class="rvt-row">
                    <div class="rvt-cols-8-md rvt-flow rvt-prose">
                        <h4><strong>Date and Time Submitted:</strong></h4>
                        <p class="shift_ticket_info"><?php echo($date_filed . "&emsp; |&emsp; " . $time_filed); ?></p>

                        <h4><strong>Type of Assistance Required:</strong></h4>
                        <p class="shift_ticket_info"><?php echo($type_of_assistance); ?></p>

                        <h4><strong>Severity of Issue:</strong></h4>
                        <p class="shift_ticket_info"><?php echo($severity); ?></p>

                        <h4><strong>Description of Issue:</strong></h4>
                        <p class="shift_ticket_info"><?php echo($description); ?></p>

                        <button type="button" class="delete_ticket_button rvt-button--danger" onclick="warningDeleteTicket()">Delete Ticket</button>
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