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

$conn = mysqli_connect("db.luddy.indiana.edu", "i494f22_team04", "my+sql=i494f22_team04", "i494f22_team04");

// Check connection
if (mysqli_connect_errno()) {
    die("Failed to connect to MySQL: " . mysqli_connect_error());
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send New Ticket | AptiStudy</title>

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
                                <span class="rvt-sr-only">Home</span>
                                <svg width="16" height="16" viewBox="0 0 16 16" id="rvt-icon-home">
                                    <path fill="currentColor"
                                        d="M15.6 6.4l-7-5.19a.76.76 0 0 0-.19-.12A1 1 0 0 0 8 1a1 1 0 0 0-.42.09.76.76 0 0 0-.19.12L.4 6.4a1 1 0 0 0-.4.8 1 1 0 0 0 .2.6 1 1 0 0 0 1.4.2l.4-.3V14a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V7.7l.4.3a1 1 0 0 0 .6.2 1 1 0 0 0 .6-1.8zM12 13H9V9H7v4H4V6.22l4-3 4 3z">
                                    </path>
                                </svg>
                            </a>
                        </li>
                        <li><a href="new-ticket.php">New Ticket</a></li>
                    </ol>
                </nav>

                <!-- **************************************************************
                Page title
                *************************************************************** -->

                <h1 class="rvt-m-top-xs">New Ticket</h1>
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

                        <form action="ticket-support.php" class="form1" method="POST">

                            <!-- **************************************************
                            Grouped set of fields
                            *************************************************** -->

                            <div class="type_of_assistance">
                                <div class="form_row">
                                    <div class="first_name">
                                        <div class="rvt-m-top-sm">
                                            <label class="rvt-label" style="font-size:16px">
                                                Type of Assistance Required:</label>
                                        </div>
                                    </div>
                                </div>
                                <ul class="rvt-list-plain">
                                    <?php

                                    $conn = mysqli_connect("****", "****", "****", "****");

                                    // Check connection
                                    if (mysqli_connect_errno()) {
                                        die("Failed to connect to MySQL: " . mysqli_connect_error());
                                    }

                                    $sql = "SELECT ticket_category.category AS categories
                                                FROM ticket_category";

                                    $result = mysqli_query($conn, $sql);

                                    while ($row = mysqli_fetch_assoc($result)) {
                                        ?>
                                        <li>
                                            <div class="rvt-radio">
                                                <input type="radio" name="assistance" id="radio-2-1-place"
                                                    value="<?php echo ($row['categories']); ?>"
                                                    title="Select a Type of Assistance" required>
                                                <label for="radio-2-1-place">
                                                    <?php echo ($row['categories']); ?>
                                                </label>
                                            </div>
                                        </li>
                                        <?php
                                    }
                                    mysqli_close($conn);
                                    ?>
                                </ul>
                            </div>

                            <div class="type_of_assistance">
                                <div class="form_row">
                                    <div class="first_name">
                                        <div class="rvt-m-top-sm">
                                            <label class="rvt-label" style="font-size:16px">
                                                Severity:</label>
                                        </div>
                                    </div>
                                </div>
                                <ul class="rvt-list-plain">
                                    <li>
                                        <div class="rvt-radio">
                                            <input type="radio" name="severity" id="radio-4-1-place"
                                                value="Low Severity"
                                                title="Select a Severity of the Issue" required>
                                            <label for="radio-4-1-place">Low Severity</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="rvt-radio">
                                            <input type="radio" name="severity" id="radio-4-2-place"
                                                value="Medium Severity"
                                                title="Select a Severity of the Issue" required>
                                            <label for="radio-4-2-place"> Medium Severity</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="rvt-radio">
                                            <input type="radio" name="severity" id="radio-4-3-place"
                                                value="High Severity"
                                                title="Select a Severity of the Issue" required>
                                            <label for="radio-4-3-place">High Severity</label>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            <div class="rvt-m-top-lg">
                                <label for="textarea-1" class="rvt-label" style="font-size:16px">Description of
                                    Issue: </label>
                                <!-- Input field with validations in check -->
                                <textarea name="description" id="description" style="width: 480px" class="rvt-textarea"
                                    title="Enter a description of the issue." maxlength="256" required></textarea>
                            </div>
                            </fieldset>

                            <!-- **************************************************
                            Create/delete form buttons
                            *************************************************** -->

                            <!-- sends hidden variables in correspondence to the current date and time -->
                            <input type="hidden" name="current_date" value="<?php echo (date("Y-m-d")); ?>">
                            <input type="hidden" name="current_time" value="<?php echo (date("h:i:s")); ?>">

                            <div class="rvt-button-group [ rvt-m-top-xl ]">
                                <!-- Buttons for either submitting or canceling the new ticket -->
                                <button class="rvt-button" type="submit">Send Ticket</button>
                                <a href="ticket-support.php" class="cancel_profile">Cancel</a>
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