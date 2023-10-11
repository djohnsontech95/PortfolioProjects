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

$servername = "****";
$username = "****";
$password = "****";
$dbname = "****";

$student_id = $_SESSION['user_id'];

// For local testing 
// $servername = "127.0.0.1";
// $username = "root";
// $password = "";
// $dbname = "team04";

//Create connection 
$conn = mysqli_connect($servername, $username, $password, $dbname);

//echo ('Connect success');

// echo ('Connect success');

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {


        if (isset($_POST['resetBtn'])) {
            $sql = "DELETE FROM quiz_answers WHERE student_id = '$student_id'";
            mysqli_query($conn, $sql);
        } else {

            //Question 1
            $question_num = 1;
            $value_arr = explode('^', $_POST["radio-group-1-time"]);
            $answer_num = $value_arr[0];
            $answer_text = $value_arr[1];

            $sql = "INSERT INTO `quiz_answers` ( `student_id`, `question_num`, `answer_num`, `answer`) 
            VALUES ('$student_id', '$question_num', '$answer_num', '$answer_text')
            ON DUPLICATE KEY UPDATE `answer_num` = '$answer_num', `answer` = '$answer_text'";

            mysqli_query($conn, $sql);

            


            //Question 2 
            $question_num = 2;
            $value_arr = explode('^', $_POST["radio-group-2-place"]);
            $answer_num = $value_arr[0];
            $answer_text = $value_arr[1];

            $sql = "INSERT INTO `quiz_answers` ( `student_id`, `question_num`, `answer_num`, `answer`) 
            VALUES ('$student_id', '$question_num', '$answer_num', '$answer_text')
            ON DUPLICATE KEY UPDATE `answer_num` = '$answer_num', `answer` = '$answer_text'";

            mysqli_query($conn, $sql);


            //Question 3 
            $question_num = 3;
            $value_arr = explode('^', $_POST["radio-group-3-place"]);
            $answer_num = $value_arr[0];
            $answer_text = $value_arr[1];

            $sql = "INSERT INTO `quiz_answers` ( `student_id`, `question_num`, `answer_num`, `answer`) 
            VALUES ('$student_id', '$question_num', '$answer_num', '$answer_text')
            ON DUPLICATE KEY UPDATE `answer_num` = '$answer_num', `answer` = '$answer_text'";

            mysqli_query($conn, $sql);


            //Question 4 
            $question_num = 4;
            $value_arr = explode('^', $_POST["radio-group-4-place"]);
            $answer_num = $value_arr[0];
            $answer_text = $value_arr[1];

            $sql = "INSERT INTO `quiz_answers` ( `student_id`, `question_num`, `answer_num`, `answer`) 
            VALUES ('$student_id', '$question_num', '$answer_num', '$answer_text')
            ON DUPLICATE KEY UPDATE `answer_num` = '$answer_num', `answer` = '$answer_text'";

            mysqli_query($conn, $sql);


            //Question 5 
            $question_num = 5;
            $value_arr = explode('^', $_POST["radio-group-5-place"]);
            $answer_num = $value_arr[0];
            $answer_text = $value_arr[1];

            $sql = "INSERT INTO `quiz_answers` ( `student_id`, `question_num`, `answer_num`, `answer`) 
            VALUES ('$student_id', '$question_num', '$answer_num', '$answer_text')
            ON DUPLICATE KEY UPDATE `answer_num` = '$answer_num', `answer` = '$answer_text'";

            mysqli_query($conn, $sql);
        }



    }
    

?>

<?php include '../other-assets/navbar-profile.php';?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compatibility Questionnaire | AptiStudy</title>

    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/styles.css">
    


</head>
<body>
    
    <!-- *************************************
                ALEX - SPRINT 09
    ************************************** -->

    <!-- This contains a question-by-question questionnaire based on study habits -->
    <!-- May want to look online for example HTML quiz templates -->
    
    <div class="rvt-billboard rvt-billboard--center">
  <div class="rvt-billboard__body">
    <h2 class="rvt-billboard__title">Compatibility Quiz</h2>
  </div>
</div>



<div class="parent-element">
<form action="comp-quest.php" method="POST">
  <fieldset class="rvt-fieldset">

<div class="question1">
    <legend class="rvt-text-bold">What time do you generally prefer to study during the day?</legend>
    <ul class="rvt-list-plain">
      <li>
        <div class="rvt-radio">
          <input type="radio" name="radio-group-1-time" id="radio-1-1-time" value="1^Morning">
          <label for="radio-1-1-time">Morning</label>
        </div>
      </li>
      <li>
        <div class="rvt-radio">
          <input type="radio" name="radio-group-1-time" id="radio-1-2-time" value="2^Afternoon">
          <label for="radio-1-2-time">Afternoon</label>
        </div>
      </li>
      <li>
        <div class="rvt-radio">
          <input type="radio" name="radio-group-1-time" id="radio-1-3-time" value="3^After dinner">
          <label for="radio-1-3-time"> After dinner</label>
        </div>
      </li>
      <li>
        <div class="rvt-radio">
          <input type="radio" name="radio-group-1-time" id="radio-1-4-time" value="4^Late night" aria-describedby="radio-1-4-time-description">
          <label for="radio-1-4-time">Late night</label>
          <div id="radio-1-4-time-description" class="rvt-radio__description"> </div>
        </div>
      </li>
    </ul>
</div>

<div class="question2">
    <legend class="rvt-text-bold">Where is your favorite place to study on campus?</legend>
    <ul class="rvt-list-plain">
      <li>
        <div class="rvt-radio">
          <input type="radio" name="radio-group-2-place" id="radio-2-1-place" value="1^Wells library">
          <label for="radio-2-1-place">Wells library</label>
        </div>
      </li>
      <li>
        <div class="rvt-radio">
          <input type="radio" name="radio-group-2-place" id="radio-2-2-place" value="2^Memorial Union">
          <label for="radio-2-2-place">Memorial Union</label>
        </div>
      </li>
      <li>
        <div class="rvt-radio">
          <input type="radio" name="radio-group-2-place" id="radio-2-3-place" value="3^IU dorm/lounge">
          <label for="radio-2-3-place">IU dorm/lounge</label>
        </div>
      </li>
      <li>
        <div class="rvt-radio">
          <input type="radio" name="radio-group-2-place" id="radio-2-4-place" value="4^Other/off" aria-describedby="radio-2-4-place-description">
          <label for="radio-2-4-place">Other/Off </label> 
        </div>
        </li>
        </ul>
</div>




<div class="question3">
    <legend class="rvt-text-bold">What do you seek most when working in study groups or groups in general?</legend>
    <ul class="rvt-list-plain">
      <li>
        <div class="rvt-radio">
          <input type="radio" name="radio-group-3-place" id="radio-3-1-place" value="1^Improving grades">
          <label for="radio-3-1-place">Improving grades</label>
        </div>
      </li>
      <li>
        <div class="rvt-radio">
          <input type="radio" name="radio-group-3-place" id="radio-3-2-place" value="2^Creating better study habits">
          <label for="radio-3-2-place">creating better study habits</label>
        </div>
      </li>
      <li>
        <div class="rvt-radio">
          <input type="radio" name="radio-group-3-place" id="radio-3-3-place" value="3^Making friends and building better social skills">
          <label for="radio-3-3-place">Making friends and building better social skills</label>
        </div>
      </li>
      <li>
        <div class="rvt-radio">
          <input type="radio" name="radio-group-3-place" id="radio-3-4-place" value="4^Effective resource and information sharing" aria-describedby="radio-2-4-place-description">
          <label for="radio-3-4-place">Effective resource and information sharing </label> 
          </div>
        </li>
        </ul>
</div>


<div class="question4">
        <legend class="rvt-text-bold">Do you prefer to study with others within the same major?'</legend>
    <ul class="rvt-list-plain">
      <li>
        <div class="rvt-radio">
          <input type="radio" name="radio-group-4-place" id="radio-4-1-place" value="1^As long as they are taking the same class">
          <label for="radio-4-1-place">As long as they are taking the same class</label>
        </div>
      </li>
      <li>
        <div class="rvt-radio">
          <input type="radio" name="radio-group-4-place" id="radio-4-2-place" value="2^Yes only my same major or majors">
          <label for="radio-4-2-place"> Yes only my same major or majors</label>
        </div>
      </li>
      <li>
        <div class="rvt-radio">
          <input type="radio" name="radio-group-4-place" id="radio-4-3-place" value="3^I can study with anyone">
          <label for="radio-4-3-place">I can study with anyone</label>
        </div>
      </li>
        </ul>
</div>


<div class="question5">
      <legend class="rvt-text-bold">Roughly How much time do you spend studying per week?</legend>
    <ul class="rvt-list-plain">
      <li>
        <div class="rvt-radio">
          <input type="radio" name="radio-group-5-place" id="radio-5-1-place" value="1^7 hours or less">
          <label for="radio-5-1-place">7 hours or less</label>
        </div>
      </li>
      <li>
        <div class="rvt-radio">
          <input type="radio" name="radio-group-5-place" id="radio-5-2-place" value="2^10-15 hours">
          <label for="radio-5-2-place">10-15 hours</label>
        </div>
      </li>
      <li>
        <div class="rvt-radio">
          <input type="radio" name="radio-group-5-place" id="radio-5-3-place" value="3^15-20 hours">
          <label for="radio-5-3-place">15-20 hours</label>
        </div>
      </li>
      <li>
        <div class="rvt-radio">
          <input type="radio" name="radio-group-5-place" id="radio-5-4-place" value="4^20 hours plus" aria-describedby="radio-2-4-place-description">
          <label for="radio-5-4-place"> 20 hours plus </label> 
          </div>
        </li>
        </ul>
</div> 

<script>
  function confirmSubmit() {
    if (confirm("Are you sure you want to submit your quiz answers?")) {
      return true;
    }
    return false;
  }

  function confirmDelete() {

    if (confirm("Are you sure you want to delete your quiz answers?")) {

    if (confirm("Are you sure you want to delete your quiz answers? You will no longer be matched with other students")) {

      return true;
    }
    return false;
  }
</script>

        <div class="rvt-button-groupquiz">

            

            <input type="submit" name="submitBtn" onclick="return confirmSubmit()" class="rvt-button" value="Submit quiz">
            <input type="submit" name="resetBtn" onclick="return confirmDelete()" class="rvt-button rvt-button--danger" value="Delete quiz answers" >

        </div>    
          
           
</fieldset>   
</form> 
</div>


<?php include '../other-assets/footer-scrolling.php'; ?>
</body>


</html>