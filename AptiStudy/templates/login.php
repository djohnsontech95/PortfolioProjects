<?php
session_start();

$now = time();
if (isset($_SESSION['discard_after']) && $now > $_SESSION['discard_after']) {
    // discard & reset session
    session_unset();
    session_destroy();
    session_start();
}

// session length
$_SESSION['discard_after'] = $now + 3600;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration and Login | AptiStudy</title>

    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/styles.css">

    <link rel="stylesheet" href="https://unpkg.com/rivet-core@2.2.0/css/rivet.min.css">
</head>

<body class="rvt-layout">
    <?php include '../other-assets/navbar-login.php'; ?>

    <!-- Registration / Login Page utilizing IU login integration -->

    <main id="main-content" class="rvt-layout__wrapper">

        <!-- **********************************************************************
        Title and Image
        *********************************************************************** -->

        <div class="rvt-hero">
            <div class="rvt-container-lg">
                <div class="rvt-hero__inner">
                    <div class="rvt-hero__body [ rvt-flow ]">
                        <h1 class="rvt-hero__title">AptiStudy</h1>
                        <div class="rvt-hero__teaser">
                            <p>Augment your social opportunities and develop a more rewarding way to study for
                                cultivating success within your courses. Find your social groups, your friends, and your
                                academic goals within the IU community.</p>
                        </div>

                        <!-- **********************************************************************
                        GOOGLE SIGN IN AUTHENTICATION
                        *********************************************************************** -->

                        <div id="g_id_onload"
                            data-client_id="755042091046-e4957aueunb75p1tsf734vfs5tgvibl7.apps.googleusercontent.com"
                            data-context="signin" data-ux_mode="popup"
                            data-state_cookie_domain="https://cgi.luddy.indiana.edu/~team04"
                            data-login_uri="https://cgi.luddy.indiana.edu/~team04/templates/backend-token-handler.php"
                            data-auto_select="true" data-auto_prompt="false">
                        </div>

                        <div class="g_id_signin" data-type="standard" data-shape="rectangular" data-theme="outline"
                            data-text="signin_with" data-size="large" data-logo_alignment="left">
                        </div>

                        <script>
                            function onSignIn(googleUser) {
                                // obfuscated JSON user token generated based on profile
                                // information from Google
                                var credential = googleUser.getAuthResponse().id_token;
                            }

                            // HTTP POST request with header and payload required
                            var xhr = new XMLHttpRequest();

                            // CHANGE TO backend-token-handler.php
                            // HTTP POST request destination
                            xhr.open('POST', 'https://cgi.luddy.indiana.edu/~team04/templates/backend-token-handler.php');

                            // HTTP POST request header
                            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                            xhr.onload = function () {
                                console.log('Signed in as: ' + xhr.responseText);
                            };

                            // HTTP POST request payload (obfuscated JSON user token)
                            xhr.send(credential);
                        </script>

                    </div>
                    <div class="rvt-hero__media">
                        <div class="login-page__img">
                            <img src="../images/landing-page-img.jpeg"
                                alt="College students studying together in library">
                        </div>
                        <div class="rvt-hero__media-caption">
                            &#169; Rido / Adobe Stock
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="item_boxes">
            <!-- **********************************************************************
            Stats
            *********************************************************************** -->

            <div class="rvt-border-bo">
                <div class="rvt-container-lg rvt-p-top-xxl">
                    <div class="rvt-stat-group">

                        <!-- ******************************************************
                        Stat
                        ******************************************************* -->

                        <a id="comp_quest" href="" disabled="disabled" class="rvt-stat">
                            <div class="rvt-stat__content [ rvt-flow ]">
                                <div class="rvt-stat__image">
                                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M24 48C37.2548 48 48 37.2548 48 24C48 10.7452 37.2548 0 24 0C10.7452 0 0 10.7452 0 24C0 37.2548 10.7452 48 24 48Z"
                                            fill="#FFCDC0" />
                                        <path
                                            d="M13 19C14.1046 19 15 18.1046 15 17C15 15.8954 14.1046 15 13 15C11.8954 15 11 15.8954 11 17C11 18.1046 11.8954 19 13 19Z"
                                            fill="white" />
                                        <path
                                            d="M9 28V32H13V28.41C13 27.18 13.31 26.02 13.84 25H12C10.35 25 9 26.35 9 28Z"
                                            fill="white" />
                                        <path
                                            d="M24 17C26.2091 17 28 15.2091 28 13C28 10.7909 26.2091 9 24 9C21.7909 9 20 10.7909 20 13C20 15.2091 21.7909 17 24 17Z"
                                            fill="white" />
                                        <path
                                            d="M35 19C36.1046 19 37 18.1046 37 17C37 15.8954 36.1046 15 35 15C33.8954 15 33 15.8954 33 17C33 18.1046 33.8954 19 35 19Z"
                                            fill="white" />
                                        <path
                                            d="M36 25H34.16C34.69 26.02 35 27.18 35 28.41V32H39V28C39 26.35 37.65 25 36 25Z"
                                            fill="white" />
                                        <path
                                            d="M27.59 23H20.42C17.43 23 15.01 25.43 15.01 28.41V37H33.01V28.41C33.01 25.42 30.58 23 27.6 23H27.59ZM29 31.9C29 31.97 28.97 32.03 28.93 32.08L28.08 32.93C28.08 32.93 27.97 33 27.9 33H25.25C25.11 33 25 33.11 25 33.25V34.75C25 34.89 24.89 35 24.75 35H23.25C23.11 35 23 34.89 23 34.75V33.25C23 33.11 22.89 33 22.75 33H20.1C20.03 33 19.97 32.97 19.92 32.93L19.07 32.08C19.07 32.08 19 31.97 19 31.9V27.25C19 27.11 19.11 27 19.25 27H20.75C20.89 27 21 27.11 21 27.25V30.75C21 30.89 21.11 31 21.25 31H22.75C22.89 31 23 30.89 23 30.75V25.25C23 25.11 23.11 25 23.25 25H24.75C24.89 25 25 25.11 25 25.25V30.75C25 30.89 25.11 31 25.25 31H26.75C26.89 31 27 30.89 27 30.75V27.25C27 27.11 27.11 27 27.25 27H28.75C28.89 27 29 27.11 29 27.25V31.9Z"
                                            fill="white" />
                                        <path
                                            d="M28.75 27H27.25C27.11 27 27 27.11 27 27.25V30.75C27 30.89 26.89 31 26.75 31H25.25C25.11 31 25 30.89 25 30.75V25.25C25 25.11 24.89 25 24.75 25H23.25C23.11 25 23 25.11 23 25.25V30.75C23 30.89 22.89 31 22.75 31H21.25C21.11 31 21 30.89 21 30.75V27.25C21 27.11 20.89 27 20.75 27H19.25C19.11 27 19 27.11 19 27.25V31.9C19 31.97 19.03 32.03 19.07 32.08L19.92 32.93C19.92 32.93 20.03 33 20.1 33H22.75C22.89 33 23 33.11 23 33.25V34.75C23 34.89 23.11 35 23.25 35H24.75C24.89 35 25 34.89 25 34.75V33.25C25 33.11 25.11 33 25.25 33H27.9C27.97 33 28.03 32.97 28.08 32.93L28.93 32.08C28.93 32.08 29 31.97 29 31.9V27.25C29 27.11 28.89 27 28.75 27Z"
                                            fill="#990000" />
                                        <path
                                            d="M24 19C27.31 19 30 16.31 30 13C30 9.69 27.31 7 24 7C20.69 7 18 9.69 18 13C18 16.31 20.69 19 24 19ZM24 9C26.21 9 28 10.79 28 13C28 15.21 26.21 17 24 17C21.79 17 20 15.21 20 13C20 10.79 21.79 9 24 9Z"
                                            fill="#990000" />
                                        <path
                                            d="M35 21C37.21 21 39 19.21 39 17C39 14.79 37.21 13 35 13C32.79 13 31 14.79 31 17C31 19.21 32.79 21 35 21ZM35 15C36.1 15 37 15.9 37 17C37 18.1 36.1 19 35 19C33.9 19 33 18.1 33 17C33 15.9 33.9 15 35 15Z"
                                            fill="#990000" />
                                        <path
                                            d="M36 23H34C33.59 23 33.2 23.06 32.81 23.16C31.47 21.83 29.62 21 27.59 21H20.42C18.38 21 16.54 21.83 15.2 23.16C14.81 23.06 14.42 23 14.01 23H12.01C9.25001 23 7.01001 25.24 7.01001 28V33C7.01001 33.55 7.46001 34 8.01001 34H13.01V38C13.01 38.55 13.46 39 14.01 39H34.01C34.56 39 35.01 38.55 35.01 38V34H40.01C40.56 34 41.01 33.55 41.01 33V28C41.01 25.24 38.77 23 36.01 23H36ZM13 28.41V32H9.00001V28C9.00001 26.35 10.35 25 12 25H13.84C13.31 26.02 13 27.18 13 28.41ZM33 37H15V28.41C15 25.42 17.43 23 20.41 23H27.58C30.57 23 32.99 25.43 32.99 28.41V37H33ZM39 32H35V28.41C35 27.18 34.69 26.02 34.16 25H36C37.65 25 39 26.35 39 28V32Z"
                                            fill="#990000" />
                                        <path
                                            d="M13 21C15.21 21 17 19.21 17 17C17 14.79 15.21 13 13 13C10.79 13 9 14.79 9 17C9 19.21 10.79 21 13 21ZM13 15C14.1 15 15 15.9 15 17C15 18.1 14.1 19 13 19C11.9 19 11 18.1 11 17C11 15.9 11.9 15 13 15Z"
                                            fill="#990000" />
                                    </svg>
                                </div>
                                <div class="rvt-stat__number" style="font-size: 36px">Compatibility Questionnaire</div>
                                <div class="rvt-stat__description">
                                    <p>Complete a questionnaire to match with similar students
                                        in your courses in terms of study habits, hobbies, and interests</p>
                                </div>
                            </div>
                        </a>

                        <!-- ******************************************************
                        Stat
                        ******************************************************* -->

                        <a id="study_groups" href="" style="cursor:default" disabled="disabled" class="rvt-stat">
                            <div class="rvt-stat__content [ rvt-flow ]">
                                <div class="rvt-stat__image">
                                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none">
                                        <path
                                            d="M24 48C37.2548 48 48 37.2548 48 24C48 10.7452 37.2548 0 24 0C10.7452 0 0 10.7452 0 24C0 37.2548 10.7452 48 24 48Z"
                                            fill="#FFCDC0" />
                                        <path
                                            d="M38.95 19.56L24.06 11.05C24.04 11.04 24.03 11.04 24.01 11.04C23.99 11.04 23.97 11.04 23.96 11.05L9.06 19.56C9.04 19.57 9 19.59 9 19.65C9 19.71 9.04 19.73 9.05 19.74L23.95 28.25C23.98 28.27 24.02 28.27 24.06 28.25L34.67 22.19C34.06 21.26 33.01 20.65 31.82 20.65H24C23.45 20.65 23 20.2 23 19.65C23 19.1 23.45 18.65 24 18.65H31.82C33.75 18.65 35.44 19.67 36.4 21.2L38.95 19.74C38.97 19.73 39 19.71 39 19.65C39 19.59 38.96 19.57 38.95 19.56Z"
                                            fill="white" />
                                        <path
                                            d="M24 30.27C23.64 30.27 23.28 30.18 22.96 30L12.77 24.18V30C12.77 30.04 12.79 30.07 12.82 30.09L23.94 36.77C23.97 36.79 24.01 36.79 24.05 36.77L35.23 30.06V24.17L25.04 29.99C24.72 30.18 24.36 30.27 24 30.27Z"
                                            fill="white" />
                                        <path
                                            d="M39.94 17.83L25.04 9.31C24.4 8.94 23.59 8.94 22.95 9.31L8.05 17.82C7.4 18.2 7 18.89 7 19.65C7 20.41 7.4 21.1 8.06 21.48L10.77 23.03V30C10.77 30.73 11.16 31.43 11.79 31.8L22.91 38.48C23.24 38.68 23.62 38.78 23.99 38.78C24.37 38.78 24.74 38.68 25.07 38.48L35.22 32.39V37.96C35.22 38.51 35.67 38.96 36.22 38.96C36.77 38.96 37.22 38.51 37.22 37.96V30.62V24.06V23.02L39.93 21.47C40.6 21.1 41 20.42 41 19.65C41 18.88 40.6 18.2 39.94 17.83ZM35.23 30.06L24.05 36.77C24.02 36.79 23.98 36.79 23.94 36.77L12.82 30.09C12.79 30.07 12.77 30.04 12.77 30V24.17L22.96 29.99C23.28 30.17 23.64 30.26 24 30.26C24.36 30.26 24.72 30.17 25.04 29.98L35.23 24.16V30.06ZM38.95 19.74L36.4 21.2C35.44 19.67 33.75 18.65 31.82 18.65H24C23.45 18.65 23 19.1 23 19.65C23 20.2 23.45 20.65 24 20.65H31.82C33.01 20.65 34.06 21.26 34.67 22.19L24.06 28.25C24.02 28.27 23.98 28.27 23.95 28.25L9.05 19.74C9.04 19.74 9 19.71 9 19.65C9 19.59 9.04 19.57 9.05 19.56L23.95 11.05C23.97 11.04 23.98 11.04 24 11.04C24.02 11.04 24.04 11.04 24.05 11.05L38.94 19.56C38.96 19.57 38.99 19.59 38.99 19.65C38.99 19.71 38.96 19.74 38.95 19.74Z"
                                            fill="#990000" />
                                    </svg>
                                </div>
                                <div class="rvt-stat__number" style="font-size: 36px">Study Groups</div>
                                <div class="rvt-stat__description">
                                    <p>Host or join study groups based on your study needs and
                                        goals. Create study groups from matches or manually with various options</p>
                                </div>
                            </div>
                        </a>

                        <!-- ******************************************************
                        Stat
                        ******************************************************* -->

                        <a id="classroom_booking" href="" disabled="disabled" class="rvt-stat">
                            <div class="rvt-stat__content [ rvt-flow ]">
                                <div class="rvt-stat__image">
                                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none">
                                        <path
                                            d="M24 48C37.2548 48 48 37.2548 48 24C48 10.7452 37.2548 0 24 0C10.7452 0 0 10.7452 0 24C0 37.2548 10.7452 48 24 48Z"
                                            fill="#FFCDC0" />
                                        <path
                                            d="M15.62 33.14V36.34L16.83 35.54C17.19 35.29 17.68 35.29 18.05 35.55L19.24 36.35V33.15C18.68 33.38 18.07 33.51 17.43 33.51C16.8 33.5 16.18 33.37 15.62 33.14Z"
                                            fill="white" />
                                        <path
                                            d="M10 33.38H13.62V31.56C13.04 30.77 12.68 29.81 12.68 28.75C12.68 26.13 14.81 24 17.43 24C20.05 24 22.18 26.13 22.18 28.75C22.18 29.8 21.82 30.77 21.24 31.56V33.38H38V12.88H10V33.38ZM34.31 27.62C34.31 27.76 34.2 27.87 34.06 27.87H25.18C25.04 27.87 24.93 27.76 24.93 27.62V26.12C24.93 25.98 25.04 25.87 25.18 25.87H34.06C34.2 25.87 34.31 25.98 34.31 26.12V27.62ZM13.69 16.75C13.69 16.61 13.8 16.5 13.94 16.5H34.06C34.2 16.5 34.31 16.61 34.31 16.75V18.25C34.31 18.39 34.2 18.5 34.06 18.5H13.94C13.8 18.5 13.69 18.39 13.69 18.25V16.75ZM13.69 20.5C13.69 20.36 13.8 20.25 13.94 20.25H34.06C34.2 20.25 34.31 20.36 34.31 20.5V22C34.31 22.14 34.2 22.25 34.06 22.25H13.94C13.8 22.25 13.69 22.14 13.69 22V20.5Z"
                                            fill="white" />
                                        <path
                                            d="M17.44 31.5C18.9588 31.5 20.19 30.2688 20.19 28.75C20.19 27.2312 18.9588 26 17.44 26C15.9212 26 14.69 27.2312 14.69 28.75C14.69 30.2688 15.9212 31.5 17.44 31.5Z"
                                            fill="white" />
                                        <path
                                            d="M39 10.88H9C8.45 10.88 8 11.33 8 11.88V34.38C8 34.93 8.45 35.38 9 35.38H13.62V37.56C13.62 38.06 13.89 38.51 14.33 38.75C14.77 38.99 15.3 38.96 15.72 38.68L17.43 37.54L19.15 38.68C19.38 38.83 19.64 38.91 19.9 38.91C20.12 38.91 20.34 38.86 20.54 38.75C20.98 38.51 21.25 38.06 21.25 37.56V35.38H39C39.55 35.38 40 34.93 40 34.38V11.88C40 11.32 39.55 10.88 39 10.88ZM19.25 36.34L18.06 35.54C17.69 35.29 17.19 35.29 16.84 35.53L15.63 36.33V33.13C16.19 33.36 16.8 33.49 17.44 33.49C18.08 33.49 18.69 33.36 19.25 33.13V36.34V36.34ZM17.44 31.5C15.92 31.5 14.69 30.27 14.69 28.75C14.69 27.23 15.92 26 17.44 26C18.96 26 20.19 27.23 20.19 28.75C20.19 30.27 18.95 31.5 17.44 31.5ZM38 33.38H21.25V31.56C21.83 30.77 22.19 29.81 22.19 28.75C22.19 26.13 20.06 24 17.44 24C14.82 24 12.69 26.13 12.69 28.75C12.69 29.8 13.05 30.77 13.63 31.56V33.38H10V12.88H38V33.38Z"
                                            fill="#990000" />
                                        <path
                                            d="M13.94 22.25H34.06C34.2 22.25 34.31 22.14 34.31 22V20.5C34.31 20.36 34.2 20.25 34.06 20.25H13.94C13.8 20.25 13.69 20.36 13.69 20.5V22C13.69 22.14 13.8 22.25 13.94 22.25Z"
                                            fill="#990000" />
                                        <path
                                            d="M13.94 18.5H34.06C34.2 18.5 34.31 18.39 34.31 18.25V16.75C34.31 16.61 34.2 16.5 34.06 16.5H13.94C13.8 16.5 13.69 16.61 13.69 16.75V18.25C13.69 18.39 13.8 18.5 13.94 18.5Z"
                                            fill="#990000" />
                                        <path
                                            d="M34.06 25.88H25.18C25.04 25.88 24.93 25.99 24.93 26.13V27.63C24.93 27.77 25.04 27.88 25.18 27.88H34.06C34.2 27.88 34.31 27.77 34.31 27.63V26.13C34.31 25.99 34.2 25.88 34.06 25.88Z"
                                            fill="#990000" />
                                    </svg>
                                </div>
                                <div class="rvt-stat__number" style="font-size: 36px">Classroom Booking</div>
                                <div class="rvt-stat__description">
                                    <p>Book classrooms located on campus based on your study
                                        groups needs. Filter using map functionalities, classroom tools, and meeting
                                        times
                                    </p>
                                </div>
                            </div>
                        </a>

                        <!-- ******************************************************
                        Stat
                        ******************************************************* -->

                        <a id="calendar_features" href="" disabled="disabled" class="rvt-stat">
                            <div class="rvt-stat__content [ rvt-flow ]">
                                <div class="rvt-stat__image">
                                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none">
                                        <path
                                            d="M24 48C37.2548 48 48 37.2548 48 24C48 10.7452 37.2548 0 24 0C10.7452 0 0 10.7452 0 24C0 37.2548 10.7452 48 24 48Z"
                                            fill="#FFCDC0" />
                                        <path
                                            d="M20.94 10.8799H19.53C19.4 10.8799 19.29 10.9899 19.29 11.1199V18.1799C19.29 18.3099 19.18 18.4199 19.05 18.4199H17.64C17.51 18.4199 17.4 18.3099 17.4 18.1799V11.1199C17.4 10.9899 17.29 10.8799 17.16 10.8799H15.75C15.62 10.8799 15.51 10.9899 15.51 11.1199V18.1799C15.51 18.3099 15.4 18.4199 15.27 18.4199H13.86C13.73 18.4199 13.62 18.3099 13.62 18.1799V11.1199C13.62 10.9899 13.51 10.8799 13.38 10.8799H12C11.87 10.8799 11.76 10.9899 11.76 11.1199V20.7899C11.76 21.8599 12.36 22.8399 13.32 23.3199L13.89 23.5999C14.91 24.1099 15.52 25.1699 15.44 26.2999L14.76 37.1399C14.73 37.6599 14.91 38.1799 15.25 38.5599C15.55 38.8999 15.95 39.0899 16.38 39.1099C16.89 39.1299 17.34 38.9499 17.68 38.5999C18.02 38.2499 18.2 37.7899 18.17 37.2999L17.48 26.2999C17.41 25.1699 18.02 24.1099 19.04 23.5999L19.61 23.3199C20.57 22.8399 21.17 21.8599 21.17 20.7899V11.1199C21.18 10.9899 21.07 10.8799 20.94 10.8799Z"
                                            fill="white" />
                                        <path
                                            d="M29.65 13.7099V24.0599C29.65 24.5799 30.07 24.9999 30.59 24.9999C32.15 24.9999 33.41 26.2699 33.41 27.8199V37.6999C33.41 38.4799 34.04 39.1099 34.82 39.1099C35.6 39.1099 36.23 38.4799 36.23 37.6999V10.8799H32.47C30.91 10.8799 29.65 12.1499 29.65 13.7099Z"
                                            fill="white" />
                                        <path
                                            d="M37.18 9H32.47C29.88 9 27.76 11.11 27.76 13.71V24.06C27.76 25.62 29.03 26.88 30.58 26.88C31.1 26.88 31.52 27.3 31.52 27.82V37.7C31.52 39.52 33 40.99 34.81 40.99C36.63 40.99 38.1 39.51 38.1 37.7V9.94C38.12 9.42 37.7 9 37.18 9ZM36.24 37.71C36.24 38.49 35.61 39.12 34.83 39.12C34.05 39.12 33.42 38.49 33.42 37.71V27.83C33.42 26.27 32.15 25.01 30.6 25.01C30.08 25.01 29.66 24.59 29.66 24.07V13.71C29.66 12.15 30.93 10.89 32.48 10.89H36.24V37.71Z"
                                            fill="#990000" />
                                        <path
                                            d="M22.12 9H10.82C10.3 9 9.88 9.42 9.88 9.94V20.79C9.88 22.58 10.88 24.2 12.48 25L13.05 25.28C13.39 25.45 13.59 25.8 13.57 26.18L12.89 37.02C12.83 38.04 13.18 39.06 13.86 39.82C14.5 40.54 15.37 40.95 16.31 40.99C16.36 40.99 16.41 40.99 16.46 40.99C17.42 40.99 18.35 40.6 19.03 39.91C19.74 39.18 20.11 38.18 20.05 37.17L19.36 26.17C19.34 25.79 19.54 25.44 19.88 25.27L20.46 25C22.06 24.2 23.06 22.58 23.06 20.79V9.94C23.06 9.42 22.64 9 22.12 9ZM21.18 20.78C21.18 21.85 20.58 22.83 19.62 23.31L19.05 23.59C18.03 24.1 17.42 25.16 17.49 26.29L18.18 37.29C18.21 37.78 18.04 38.24 17.69 38.59C17.35 38.94 16.9 39.13 16.39 39.1C15.96 39.08 15.56 38.89 15.26 38.55C14.91 38.17 14.73 37.65 14.77 37.13L15.45 26.29C15.52 25.16 14.91 24.09 13.9 23.59L13.33 23.31C12.37 22.83 11.77 21.85 11.77 20.78V11.11C11.77 10.98 11.88 10.87 12.01 10.87H13.42C13.55 10.87 13.66 10.98 13.66 11.11V18.17C13.66 18.3 13.77 18.41 13.9 18.41H15.31C15.44 18.41 15.55 18.3 15.55 18.17V11.11C15.55 10.98 15.66 10.87 15.79 10.87H17.2C17.33 10.87 17.44 10.98 17.44 11.11V18.17C17.44 18.3 17.55 18.41 17.68 18.41H19.09C19.22 18.41 19.33 18.3 19.33 18.17V11.11C19.33 10.98 19.44 10.87 19.57 10.87H20.98C21.11 10.87 21.22 10.98 21.22 11.11V20.78H21.18Z"
                                            fill="#990000" />
                                    </svg>
                                </div>
                                <div class="rvt-stat__number" style="font-size: 36px">Calendar Features</div>
                                <div class="rvt-stat__description">
                                    <p>Apply responsive notification options across group calendars</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>


    </main>

    <!-- **************************************************************************
    Footer: Social media

    -> rivet.iu.edu/components/footer/
    *************************************************************************** -->

    <div aria-labelledby="social-heading" class="rvt-footer-social" role="complementary">
        <div class="rvt-container-lg">
            <h2 class="rvt-sr-only" id="social-heading">Social media</h2>
            <ul class="rvt-footer-social__list">
                <li>
                    <a href="https://www.facebook.com/IndianaUniversity">
                        <span class="rvt-sr-only rvt-color-white">Facebook for IU</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" height="40" viewBox="0 0 40 40" width="40">
                            <path
                                d="M20 40C31.0457 40 40 31.0457 40 20C40 8.9543 31.0457 0 20 0C8.9543 0 0 8.9543 0 20C0 31.0457 8.9543 40 20 40Z"
                                fill="#7A1705"></path>
                            <path
                                d="M24.8996 9.99982V13.1998H23.0996C23.0996 13.1998 21.4996 12.9998 21.4996 14.4998V16.9998H24.7996L24.3996 20.3998H21.4996V29.9998H17.6996V20.2998H15.0996V16.9998H17.7996V14.0998C17.7996 14.0998 17.4996 12.4998 18.8996 11.1998C20.2996 9.89982 22.1996 9.99982 22.1996 9.99982H24.8996Z"
                                fill="#F7F7F8"></path>
                        </svg>
                    </a>
                </li>
                <li>
                    <a href="https://www.linkedin.com/company/indiana-university/">
                        <span class="rvt-sr-only rvt-color-white">Linkedin for IU</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" height="40" viewBox="0 0 40 40" width="40">
                            <path
                                d="M20 40C31.0457 40 40 31.0457 40 20C40 8.9543 31.0457 0 20 0C8.9543 0 0 8.9543 0 20C0 31.0457 8.9543 40 20 40Z"
                                fill="#7A1705"></path>
                            <path
                                d="M11.3 16H15V28H11.3V16ZM13.2 10C14.4 10 15.4 11 15.4 12.2C15.4 13.4 14.4 14.4 13.2 14.4C12 14.4 11 13.4 11 12.2C11 11 12 10 13.2 10Z"
                                fill="#F7F7F8"></path>
                            <path
                                d="M17.3999 16.0002H20.9999V17.6002C21.4999 16.7002 22.6999 15.7002 24.4999 15.7002C28.2999 15.7002 28.9999 18.2002 28.9999 21.4002V28.0002H25.2999V22.2002C25.2999 20.8002 25.2999 19.0002 23.3999 19.0002C21.4999 19.0002 21.1999 20.5002 21.1999 22.1002V28.0002H17.4999V16.0002H17.3999Z"
                                fill="#F7F7F8"></path>
                        </svg>
                    </a>
                </li>
                <li>
                    <a href="https://twitter.com/IndianaUniv">
                        <span class="rvt-sr-only rvt-color-white">Twitter for IU</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" height="40" viewBox="0 0 40 40" width="40">
                            <path
                                d="M20 40C31.0457 40 40 31.0457 40 20C40 8.9543 31.0457 0 20 0C8.9543 0 0 8.9543 0 20C0 31.0457 8.9543 40 20 40Z"
                                fill="#7A1705"></path>
                            <path
                                d="M30.0002 13.7998C29.3002 14.0998 28.5002 14.2998 27.6002 14.3998C28.4002 13.8998 29.1002 13.0998 29.4002 12.0998C28.6002 12.5998 27.7002 12.8998 26.8002 13.0998C26.1002 12.2998 25.0002 11.7998 23.8002 11.7998C21.5002 11.7998 19.7002 13.5998 19.7002 15.8998C19.7002 16.1998 19.7002 16.4998 19.8002 16.7998C16.4002 16.5998 13.4002 14.9998 11.3002 12.4998C10.9002 13.0998 10.7002 13.7998 10.7002 14.5998C10.7002 15.9998 11.4002 17.2998 12.5002 17.9998C11.8002 17.9998 11.2002 17.7998 10.6002 17.4998C10.6002 17.4998 10.6002 17.4998 10.6002 17.5998C10.6002 19.5998 12.0002 21.1998 13.9002 21.5998C13.6002 21.6998 13.2002 21.6998 12.8002 21.6998C12.5002 21.6998 12.3002 21.6998 12.0002 21.5998C12.5002 23.1998 14.0002 24.3998 15.8002 24.3998C14.4002 25.4998 12.6002 26.1998 10.7002 26.1998C10.4002 26.1998 10.0002 26.1998 9.7002 26.0998C11.5002 27.2998 13.7002 27.8998 16.0002 27.8998C23.5002 27.8998 27.7002 21.5998 27.7002 16.1998C27.7002 15.9998 27.7002 15.7998 27.7002 15.6998C28.8002 15.2998 29.4002 14.5998 30.0002 13.7998Z"
                                fill="#F7F7F8"></path>
                        </svg>
                    </a>
                </li>
                <li>
                    <a href="https://www.instagram.com/iubloomington/">
                        <span class="rvt-sr-only rvt-color-white">Instagram for IU</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" height="40" viewBox="0 0 40 40" width="40">
                            <path
                                d="M20 40C31.0457 40 40 31.0457 40 20C40 8.9543 31.0457 0 20 0C8.9543 0 0 8.9543 0 20C0 31.0457 8.9543 40 20 40Z"
                                fill="#7A1705"></path>
                            <path
                                d="M24.3004 29.9999H15.6004C12.5004 29.9999 9.90039 27.4999 9.90039 24.2999V15.5999C9.90039 12.4999 12.4004 9.8999 15.6004 9.8999H24.3004C27.4004 9.8999 30.0004 12.3999 30.0004 15.5999V24.2999C30.0004 27.4999 27.5004 29.9999 24.3004 29.9999ZM24.3004 28.4999C25.4004 28.4999 26.5004 28.0999 27.2004 27.2999C27.9004 26.4999 28.4004 25.4999 28.4004 24.3999V15.6999C28.4004 14.5999 28.0004 13.4999 27.2004 12.7999C26.4004 11.9999 25.4004 11.5999 24.3004 11.5999H15.6004C14.5004 11.5999 13.4004 11.9999 12.7004 12.7999C11.9004 13.5999 11.5004 14.5999 11.5004 15.6999V24.3999C11.5004 25.4999 11.9004 26.5999 12.7004 27.2999C13.5004 27.9999 14.5004 28.4999 15.6004 28.4999H24.3004Z"
                                fill="#F7F7F8"></path>
                            <path
                                d="M25.4006 19.9C25.4006 22.9 23.0006 25.3 20.0006 25.3C17.0006 25.3 14.6006 22.9 14.6006 19.9C14.6006 16.9 17.0006 14.5 20.0006 14.5C23.0006 14.5 25.4006 17 25.4006 19.9ZM20.0006 16.4C18.1006 16.4 16.5006 18 16.5006 19.9C16.5006 21.8 18.1006 23.4 20.0006 23.4C21.9006 23.4 23.5006 21.8 23.5006 19.9C23.5006 18 21.9006 16.4 20.0006 16.4Z"
                                fill="#F7F7F8"></path>
                            <path
                                d="M25.5002 15.8002C26.2182 15.8002 26.8002 15.2182 26.8002 14.5002C26.8002 13.7822 26.2182 13.2002 25.5002 13.2002C24.7822 13.2002 24.2002 13.7822 24.2002 14.5002C24.2002 15.2182 24.7822 15.8002 25.5002 15.8002Z"
                                fill="#F7F7F8"></path>
                        </svg>
                    </a>
                </li>
                <li>
                    <a href="https://www.youtube.com/user/iu">
                        <span class="rvt-sr-only rvt-color-white">Youtube for IU</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" height="40" viewBox="0 0 40 40" width="40">
                            <path d="M20,40A20,20,0,1,0,0,20,20,20,0,0,0,20,40Z" fill="#7A1705"></path>
                            <path
                                d="M29.58,15.17a2.49,2.49,0,0,0-1.77-1.78C26.25,13,20,13,20,13s-6.25,0-7.81.42a2.49,2.49,0,0,0-1.77,1.78A26.26,26.26,0,0,0,10,20a26.23,26.23,0,0,0,.42,4.84,2.47,2.47,0,0,0,1.77,1.75C13.75,27,20,27,20,27s6.25,0,7.81-.42a2.47,2.47,0,0,0,1.77-1.75A26.23,26.23,0,0,0,30,20,26.26,26.26,0,0,0,29.58,15.17ZM18,23V17l5.23,3Z"
                                fill="#F7F7F8"></path>
                        </svg>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- **************************************************************************
    Footer: Resource links

    -> rivet.iu.edu/components/footer/
    *************************************************************************** -->

    <div aria-labelledby="resources-heading" class="rvt-footer-resources" role="complementary">
        <h2 class="rvt-sr-only" id="resources-heading">Additional resources</h2>
        <div class="rvt-container-lg">
            <div class="rvt-row">
                <div class="rvt-cols-3-md">
                    <h3 class="rvt-footer-resources__heading">Indiana University</h3>
                    <div class="rvt-footer-resources__text-block">
                        107 S. Indiana Avenue
                        <br />
                        Bloomington, IN
                        <br />
                        47405-7000
                    </div>
                </div>
                <div class="rvt-cols-3-md">
                    <h3 class="rvt-footer-resources__heading">Services</h3>
                    <ul class="rvt-footer-resources__list">
                        <li class="rvt-footer-resources__list-item">
                            <a href="https://canvas.iu.edu">Canvas</a>
                        </li>
                        <li class="rvt-footer-resources__list-item">
                            <a href="https://one.iu.edu">One.IU</a>
                        </li>
                    </ul>
                </div>
                <div class="rvt-cols-3-md">
                    <h3 class="rvt-footer-resources__heading">Email</h3>
                    <ul class="rvt-footer-resources__list">
                        <li class="rvt-footer-resources__list-item">
                            <a href="https://uits.iu.edu/exchange">Outlook Web Access</a>
                        </li>
                        <li class="rvt-footer-resources__list-item">
                            <a href="https://google.iu.edu">Gmail at IU</a>
                        </li>
                    </ul>
                </div>
                <div class="rvt-cols-3-md">
                    <h3 class="rvt-footer-resources__heading">Find</h3>
                    <ul class="rvt-footer-resources__list">
                        <li class="rvt-footer-resources__list-item">
                            <a href="https://directory.iu.edu/">People Directory</a>
                        </li>
                        <li class="rvt-footer-resources__list-item">
                            <a href="https://jobs.iu.edu/">Jobs at IU</a>
                        </li>
                        <li class="rvt-footer-resources__list-item">
                            <a href="https://www.iu.edu/nondiscrimination/index.html">Non-discrimination Notice</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- **************************************************************************
    Footer: Copyright

    -> rivet.iu.edu/components/footer/
    **************************************************************************** -->

    <footer class="rvt-footer-base" style="bottom:0; position:relative">
        <div class="rvt-container-lg">
            <div class="rvt-footer-base__inner">
                <div class="rvt-footer-base__logo">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <polygon fill="currentColor"
                            points="15.3 3.19 15.3 5 16.55 5 16.55 15.07 13.9 15.07 13.9 1.81 15.31 1.81 15.31 0 8.72 0 8.72 1.81 10.12 1.81 10.12 15.07 7.45 15.07 7.45 5 8.7 5 8.7 3.19 2.5 3.19 2.5 5 3.9 5 3.9 16.66 6.18 18.98 10.12 18.98 10.12 21.67 8.72 21.67 8.72 24 15.3 24 15.3 21.67 13.9 21.67 13.9 18.98 17.82 18.98 20.09 16.66 20.09 5 21.5 5 21.5 3.19 15.3 3.19"
                            fill="#231f20" />
                    </svg>
                </div>
                <ul class="rvt-footer-base__list">
                    <li class="rvt-footer-base__item">
                        <a class="rvt-footer-base__link"
                            href="https://accessibility.iu.edu/assistance/">Accessibility</a>
                    </li>
                    <li class="rvt-footer-base__item">
                        <a class="rvt-footer-base__link" href="https://protect.iu.edu/privacy/index.html">Privacy
                            Notice</a>
                    </li>
                    <li class="rvt-footer-base__item">
                        <a class="rvt-footer-base__link" href="https://www.iu.edu/copyright/index.html">Copyright</a>
                        &#169; 2021 The Trustees of <a class="rvt-footer-base__link" href="https://www.iu.edu">Indiana
                            University</a>
                    </li>
                </ul>
            </div>
        </div>
    </footer>

    <script src="../js/site.js"></script>
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <script src="https://unpkg.com/rivet-core@2.2.0/js/rivet.min.js"></script>
    <script>
        Rivet.init();
    </script>
</body>

</html>