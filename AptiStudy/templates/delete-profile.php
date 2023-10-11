<?php
session_start();

$authenticate_id = $_SESSION['user_id'];

$conn = mysqli_connect("****", "****", "****", "****");

// Cascading delete queries that remove a user entirely from the database

$delete_tickets = "DELETE ticket
                        FROM ticket
                        INNER JOIN student 
                        ON ticket.student_id=student.id
                        INNER JOIN user_authentication
                        ON user_authentication.student_id=student.id
                        WHERE authenticate_id='$authenticate_id'";
$delete_tickets_query = mysqli_query($conn, $delete_tickets);

$delete_group_member = "DELETE group_members
                            FROM group_members 
                            INNER JOIN student
                            ON student.id=group_members.member_id
                            INNER JOIN user_authentication
                            ON student.id=user_authentication.student_id
                            WHERE user_authentication.authenticate_id='$authenticate_id'";
$delete_group_member_query = mysqli_query($conn, $delete_group_member);

$delete_quiz_answers = "DELETE quiz_answers
                            FROM quiz_answers 
                            INNER JOIN student
                            ON student.id=quiz_answers.student_id
                            INNER JOIN user_authentication
                            ON student.id=user_authentication.student_id
                            WHERE user_authentication.authenticate_id='$authenticate_id'";
$delete_quiz_answers_query = mysqli_query($conn, $delete_quiz_answers);

$delete_comp_quiz = "DELETE comp_quiz
                        FROM comp_quiz 
                        INNER JOIN student
                        ON student.id=comp_quiz.student_id
                        INNER JOIN user_authentication
                        ON student.id=user_authentication.student_id
                        WHERE user_authentication.authenticate_id='$authenticate_id'";
$delete_comp_quiz_query = mysqli_query($conn, $delete_comp_quiz);

$delete_enrolled_courses = "DELETE enrolled_courses
                                FROM enrolled_courses 
                                INNER JOIN student
                                ON student.id=enrolled_courses.student_id
                                INNER JOIN user_authentication
                                ON student.id=user_authentication.student_id
                                WHERE user_authentication.authenticate_id='$authenticate_id'";
$delete_enrolled_courses_query = mysqli_query($conn, $delete_enrolled_courses);

$delete_student_majors = "DELETE student_majors
                                FROM student_majors 
                                INNER JOIN student
                                ON student.id=student_majors.student_id
                                INNER JOIN user_authentication
                                ON student.id=user_authentication.student_id
                                WHERE user_authentication.authenticate_id='$authenticate_id'";
$delete_student_majors_query = mysqli_query($conn, $delete_student_majors);

$update_host_id = "UPDATE study_group
                        INNER JOIN student
                        ON student.id=study_group.host_id
                        INNER JOIN user_authentication
                        ON student.id=user_authentication.student_id
                        SET host_id=NULL
                        WHERE user_authentication.authenticate_id='$authenticate_id'";
$update_host_id_query = mysqli_query($conn, $update_host_id);

$delete_profile_image = "DELETE profile_image
                         FROM profile_image
                         INNER JOIN student
                         ON profile_image.student_id=student.id
                         INNER JOIN user_authentication
                         ON student.id=user_authentication.student_id
                         WHERE user_authentication.authenticate_id='$authenticate_id'";
$delete_profile_image_query = mysqli_query($conn, $delete_profile_image);

$select_student_id = "SELECT student_id FROM user_authentication
                      WHERE user_authentication.authenticate_id='$authenticate_id'";
$select_student_id_query = mysqli_query($conn, $select_student_id);

while ($row = mysqli_fetch_assoc($select_student_id_query)) {
     $student_id = $row['student_id'];
}

$delete_user_authentication = "DELETE user_authentication
                                    FROM user_authentication 
                                    INNER JOIN student
                                    ON student.id=user_authentication.student_id
                                    WHERE user_authentication.authenticate_id='$authenticate_id'";
$delete_user_authentication_query = mysqli_query($conn, $delete_user_authentication);

$delete_student = "DELETE student
                   FROM student 
                   WHERE student.id=$student_id";
$delete_student_query = mysqli_query($conn, $delete_student);

mysqli_close($conn);

// sends the user back to the login page after deletion has occurred
header("Location: logout.php");
die();

?>