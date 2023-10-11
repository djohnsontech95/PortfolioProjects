<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="noindex">
  <link rel="stylesheet" href="https://unpkg.com/rivet-core@2.2.0/css/rivet.min.css">
</head>
<body class="rvt-layout">

<!-- **************************************************************************
    Header

    -> rivet.iu.edu/components/header/
*************************************************************************** -->

<header class="rvt-header-wrapper">
    
    <!-- **********************************************************************
        "Skip to main content" link for keyboard users
    *********************************************************************** -->
    
    <a class="rvt-header-wrapper__skip-link" href="#main-content">Skip to main content</a>
    
    <!-- **********************************************************************
        Global header area
    *********************************************************************** -->
    
    <div class="rvt-header-global">
        <div class="rvt-container-lg">
            <div class="rvt-header-global__inner">
                <div class="rvt-header-global__logo-slot">
                    <a class="rvt-lockup" href="home.php">
                        
                        <!-- **************************************************
                            Trident logo
                        *************************************************** -->
                        
                        <div class="rvt-lockup__tab">
                            <svg xmlns="http://www.w3.org/2000/svg" class="rvt-lockup__trident" viewBox="0 0 28 34">
                                <path fill="currentColor" d="M-3.34344e-05 4.70897H8.83308V7.174H7.1897V21.1426H10.6134V2.72321H8.83308V0.121224H18.214V2.65476H16.2283V21.1426H19.7889V7.174H18.214V4.64047H27.0471V7.174H25.0614V23.6761L21.7746 26.8944H16.2967V30.455H18.214V33.8787H8.76463V30.592H10.6819V26.8259H5.20403L1.91726 23.6077V7.174H-3.34344e-05V4.70897Z"></path>
                            </svg>
                        </div>

                        <!-- **************************************************
                            Website or application title 
                        *************************************************** -->
                        
                        <div class="rvt-lockup__body">
                            <span class="rvt-lockup__title">AptiStudy</span>
                            <span class="rvt-lockup__subtitle">Indiana University</span>
                        </div>
                    </a>
                </div>
                <div class="rvt-header-global__controls">
                    <div data-rvt-disclosure="menu" data-rvt-close-click-outside>
                        <button aria-expanded="false" class="rvt-global-toggle rvt-global-toggle--menu rvt-hide-lg-up" data-rvt-disclosure-toggle="menu">
                            <span class="rvt-sr-only">Menu</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="rvt-global-toggle__open" viewBox="0 0 16 16">
                                <g fill="currentColor">
                                    <path d="M15,3H1A1,1,0,0,1,1,1H15a1,1,0,0,1,0,2Z"></path>
                                    <path d="M15,9H1A1,1,0,0,1,1,7H15a1,1,0,0,1,0,2Z"></path>
                                    <path d="M15,15H1a1,1,0,0,1,0-2H15a1,1,0,0,1,0,2Z"></path>
                                </g>
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" class="rvt-global-toggle__close" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8.46954 7.00409L13.7595 1.71409C13.9234 1.52279 14.009 1.27671 13.9993 1.02504C13.9895 0.773362 13.8852 0.534623 13.7071 0.356528C13.529 0.178434 13.2903 0.0741014 13.0386 0.0643803C12.7869 0.0546591 12.5408 0.140265 12.3495 0.304092L7.05954 5.59409L1.76954 0.294092C1.58124 0.105788 1.32585 -3.72428e-09 1.05954 -1.74018e-09C0.793242 2.43924e-10 0.537847 0.105788 0.349544 0.294092C0.16124 0.482395 0.055452 0.73779 0.055452 1.00409C0.055452 1.27039 0.16124 1.52579 0.349544 1.71409L5.64954 7.00409L0.349544 12.2941C0.244862 12.3837 0.159841 12.4941 0.0998179 12.6181C0.0397946 12.7422 0.00606467 12.8773 0.000745174 13.015C-0.00457432 13.1528 0.0186315 13.2901 0.0689061 13.4184C0.119181 13.5467 0.195439 13.6633 0.292893 13.7607C0.390348 13.8582 0.506896 13.9345 0.635221 13.9847C0.763546 14.035 0.900878 14.0582 1.0386 14.0529C1.17632 14.0476 1.31145 14.0138 1.43551 13.9538C1.55958 13.8938 1.6699 13.8088 1.75954 13.7041L7.05954 8.41409L12.3495 13.7041C12.5408 13.8679 12.7869 13.9535 13.0386 13.9438C13.2903 13.9341 13.529 13.8297 13.7071 13.6517C13.8852 13.4736 13.9895 13.2348 13.9993 12.9831C14.009 12.7315 13.9234 12.4854 13.7595 12.2941L8.46954 7.00409Z" fill="currentColor"></path>
                            </svg>
                        </button>

                        <!-- ******************************************************
                            Primary navigation
                        ******************************************************* -->

                        <nav aria-label="Main" class="rvt-header-menu" data-rvt-disclosure-target="menu" hidden>
                            <ul class="rvt-header-menu__list">
                                <li class="rvt-header-menu__item">
                                    <div class="rvt-header-menu__dropdown rvt-dropdown" data-rvt-dropdown="primary-nav-3">
                                        <div class="rvt-header-menu__group">
                                            <a class="rvt-header-menu__link" href="home.php" aria-current="page">Home</a>
                                            <button aria-expanded="false" class="rvt-dropdown__toggle rvt-header-menu__toggle" data-rvt-dropdown-toggle="primary-nav-3">
                                                <span class="rvt-sr-only">Toggle Sub-navigation</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="rvt-global-toggle__open" height="16" viewBox="0 0 16 16" width="16">
                                                    <path d="M8,12.46a2,2,0,0,1-1.52-.7L1.24,5.65a1,1,0,1,1,1.52-1.3L8,10.46l5.24-6.11a1,1,0,0,1,1.52,1.3L9.52,11.76A2,2,0,0,1,8,12.46Z" fill="currentColor"></path>
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="rvt-header-menu__submenu rvt-dropdown__menu rvt-dropdown__menu--right" data-rvt-dropdown-menu="primary-nav-3" hidden>
                                            <ul class="rvt-header-menu__submenu-list">
                                                <li class="rvt-header-menu__submenu-item">
                                                    <a class="rvt-header-menu__submenu-link" href="create-group.php">Create Group</a>
                                                </li>
                                                <li class="rvt-header-menu__submenu-item">
                                                    <a class="rvt-header-menu__submenu-link" href="view-groups.php">Find Groups</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                                <li class="rvt-header-menu__item">
                                    <a class="rvt-header-menu__link" href="view-profile.php">Profile</a>
                                </li>
                                <li class="rvt-header-menu__item">
                                    <a class="rvt-header-menu__link" href="calendar.php">Group Events</a>
                                </li>
                                <li class="rvt-header-menu__item">
                                    <a class="rvt-header-menu__link rvt-header-menu__item--current" href="ticket-support.php">Support</a>
                                </li>
                                <span>
                                    <div class="g_id_signout">
                                        <a href="logout.php" onclick="signOut();" class="logout_button"
                                            style="margin-top: -7px; margin-bottom: -20px; margin-left: 20px">Logout</a>
                                        <script>
                                            function signOut() {
                                                var auth2 = gapi.auth2.getAuthInstance();
                                                auth2.signOut().then(function () {
                                                    console.log('User signed out.');
                                                });
                                            }
                                        </script>
                                    </div>
                                </span>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<script src="https://unpkg.com/rivet-core@2.2.0/js/rivet.min.js"></script>
<script>
    Rivet.init();
</script>
</body>
</html>