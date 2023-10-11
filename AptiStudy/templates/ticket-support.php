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

// Escape variables for security sql injection
$type_of_assistance = $_POST['assistance'];
$current_date = $_POST['current_date'];
$current_time = $_POST['current_time'];
$severity = mysqli_real_escape_string($conn, $_POST['severity']);
$issue_desc = mysqli_real_escape_string($conn, $_POST['description']);

// remove unnecessary chars like tab/newline/space
$severity = trim($severity);
$issue_desc = trim($issue_desc);

// remove backslashes
$severity = stripslashes($severity);
$issue_desc = stripslashes($issue_desc);

// convert problematic chars into entity representation
// prevents injection in the PHP
$severity = htmlspecialchars($severity);
$issue_desc = htmlspecialchars($issue_desc);

// Needed for inserting the student ID into the ticket table
$user_search = "SELECT student.id AS student_id
                    FROM student
                    INNER JOIN user_authentication
                        ON student.id=user_authentication.student_id
                    WHERE user_authentication.authenticate_id='$authenticate_id'";
$student_match = mysqli_query($conn, $user_search);

while ($row = mysqli_fetch_assoc($student_match)) {
    $student_id = $row['student_id'];
}

// Type of assistance is tied to foreign keys; need this query to
// grab names of the type of assistance required
$ticket_category_search = "SELECT ticket_category.id AS category_id
                    FROM ticket_category
                    WHERE ticket_category.category='$type_of_assistance'";
$ticket_category_sql = mysqli_query($conn, $ticket_category_search);

while ($row = mysqli_fetch_assoc($ticket_category_sql)) {
    $ticket_category = $row['category_id'];
}

// Needed since quotation marks affect the insert statement
$issue_desc = str_replace("'", "\'", $issue_desc);

// New tickets are automatically labeled as 'Active'
$sql = "INSERT INTO ticket (student_id, date_filed, time_filed, type, severity, description, ticket_status) VALUES ($student_id, '$current_date', '$current_time', $ticket_category, '$severity', '$issue_desc', 'Active')";
$insert = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex">
    <title>Ticket Support | AptiStudy</title>

    <link rel="stylesheet" href="https://unpkg.com/rivet-core@2.3.1/css/rivet.min.css">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body class="rvt-layout">

    <!-- **************************************************************************
    APP INDEX - SINGLE-COLUMN TABLE
    
    -> rivet.iu.edu/layouts/app-index-page/
    *************************************************************************** -->

    <?php include '../other-assets/navbar-support.php'; ?>

    <!-- **************************************************************************
    Main content area
    *************************************************************************** -->

    <main class="rvt-flex rvt-flex-column rvt-grow-1" id="main-content">
        <div class="rvt-bg-black-000 rvt-border-bottom rvt-p-top-xl">
            <div class="rvt-container-lg rvt-prose rvt-flow rvt-p-bottom-xl">

                <!-- **************************************************************
                Page title
                *************************************************************** -->

                <h1 class="rvt-m-top-xs">Ticket Support</h1>
            </div>
        </div>

        <div class="rvt-layout__wrapper">
            <div class="rvt-container-lg rvt-p-tb-xxl">

                <!-- **************************************************************
                Filters and actions
                *************************************************************** -->

                <!-- <div class="rvt-grow-1 rvt-m-bottom-md">
                    <label class="rvt-label" for="search">Type to filter</label>
                    <input class="rvt-input" type="text" id="search">
                </div> -->

                <!-- Default Description Box -->
                <div class="box_descriptor">
                    <div class="rvt-inline-alert rvt-inline-alert--standalone rvt-inline-alert--info">
                        <span class="rvt-inline-alert__icon">
                            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                viewBox="0 0 16 16">
                                <g fill="currentColor">
                                    <path d="M8,16a8,8,0,1,1,8-8A8,8,0,0,1,8,16ZM8,2a6,6,0,1,0,6,6A6,6,0,0,0,8,2Z" />
                                    <path d="M8,12a1,1,0,0,1-1-1V8A1,1,0,0,1,9,8v3A1,1,0,0,1,8,12Z" />
                                    <circle cx="8" cy="5" r="1" />
                                </g>
                            </svg>
                        </span>
                        <span class="rvt-inline-alert__message" id="first-name-message">
                            Here, you can send our team tickets to describe any issues with functionalities
                            or report misuse of the application by other users.
                        </span>
                    </div>
                </div>
                <span>
                    <!-- **********************************************************
                        "Add new ticket" button
                        *********************************************************** -->

                    <a href="new-ticket.php" class="new_ticket_button">+ New Ticket</a>
                </span>

                <!-- **************************************************************
                Data table
                *************************************************************** -->

                <div class="tickets">
                    <table class="rvt-table" data-rvt-c-select-table>
                        <caption class="rvt-sr-only">Table example one</caption>
                        <thead>
                            <tr>
                                <th scope="col">Ticket Identification</th>
                                <th scope="col">Date & Time Filed</th>
                                <th scope="col">Type of Assistance</th>
                                <th scope="col">Severity</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>

                            <!-- ******************************************************
                            Table row
                            ******************************************************* -->

                            <?php

                            // Grabs all the ticket information to display as individual rows
                            // on the ticket landing page
                            $tickets_retrieval = "SELECT ticket.id AS ticket_id, ticket.student_id, ticket.date_filed, ticket.time_filed, ticket_category.category, ticket.severity, ticket.description, ticket.ticket_status 
                                                  FROM ticket
                                                  INNER JOIN ticket_category
	                                                ON ticket.type=ticket_category.id
                                                  INNER JOIN student
                                                    ON student.id=ticket.student_id
                                                  INNER JOIN user_authentication
                                                    ON student.id=user_authentication.student_id
                                                  WHERE user_authentication.authenticate_id='$authenticate_id'";
                            $tickets_retrieval_query = mysqli_query($conn, $tickets_retrieval);

                            while ($row = mysqli_fetch_assoc($tickets_retrieval_query)) {
                                $ticket_status = $row['ticket_status'];
                                ?>
                                <tr>
                                    <th scope="row">
                                        <form action="view-ticket.php" method="GET">
                                            <!-- Each indivdual ticket can be viewed by
                                            clicking on the link tied to the ticket ID -->
                                            <input class="view_ticket_link" type="submit" name="ticket_id" id="ticket_id"
                                                value="<?php echo ($row['ticket_id']); ?>" />
                                        </form>
                                    </th>
                                    <td>
                                        <?php echo ($row['date_filed']); ?>&emsp;|&emsp;
                                        <?php echo ($row['time_filed']); ?>
                                    </td>
                                    <td>
                                        <?php echo ($row['category']); ?>
                                    </td>
                                    <td>
                                        <?php echo ($row['severity']); ?>
                                    </td>
                                    <td>
                                        <?php

                                        if ($ticket_status == "Active") {
                                            ?>
                                            <span class="rvt-badge rvt-badge--success-secondary">Active</span>
                                            <?php
                                        } else {
                                            ?>
                                            <span class="rvt-badge">Closed</span>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <script src="https://unpkg.com/rivet-core@2.3.1/js/rivet.min.js"></script>
    <script>
        Rivet.init();
    </script>
    <script src="../js/site.js"></script>

    <?php include '../other-assets/footer-scrolling.php'; ?>
    <?php mysqli_close($conn); ?>

</body>

</html>