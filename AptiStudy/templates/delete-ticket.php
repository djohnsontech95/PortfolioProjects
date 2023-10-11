<?php
session_start();

$ticket_id = $_SESSION['ticket_id'];

// ******* CHANGE BACK TO TEAM DATABASE AFTER TESTING ********
$conn = mysqli_connect("****", "****", "****", "****");

// Delete query that removes a ticket from the database if it exists
$delete_ticket = "DELETE ticket
                   FROM ticket
                   WHERE ticket.id='$ticket_id'";
$delete_tickets_query = mysqli_query($conn, $delete_ticket);

// unsets the ticket ID used to identify individual tickets on the GET request
unset($_SESSION['ticket_id']);

mysqli_close($conn);

// sends the user back to the ticket landing page
header("Location: ticket-support.php");
die();

?>