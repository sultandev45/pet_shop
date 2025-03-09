<!doctype html>
<?php include_once('config.php') ?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $_settings->info('title') != false ? $_settings->info('title') . ' | ' : '' ?><?php echo $_settings->info('name') ?></title>
    <link rel="icon" href="<?php echo validate_image($_settings->info('logo')) ?>" />
    <!-- css -->
    <link rel="stylesheet" href="http://localhost/furever-homes/css/styles.css">

    <link rel="stylesheet" href="http://localhost/furever-homes/css/bootstrap.min.css">
    <!-- FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
    <!-- Unicons -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <!-- js --> 
      <script src="http://localhost/furever-homes/js/jquery.min.js"></script>
       <!-- jQuery Validation Plugin -->
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

    <!-- Toastr JS -->
   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

   
    <!-- plugin js cdn -->
    <script src="http://localhost/furever-homes/js/adopt-form.js"></script>

    <script>
        var _base_url_ = '<?php echo base_url ?>';

        function alert_toast(message, type) {
            // Display toast notification using Toastr.js
            toastr[type](message);
        }
    </script>

</head>

<body class="bg-light">
    <header>
        <nav class="header">
            <div class="nav-bar ">
                <i class='bx bx-menu sidebarOpen'></i>
                <span class="logo navLogo header-logo-holder "><a href="index.php"><img height="80px" width="100px" src="<?php echo validate_image($_settings->info('website-logo')) ?>" alt=""></a></span>

                <div class="menu">
                    <div class="logo-toggle">
                        <span class="logo  "><a href="index.php"><img height="80px" width="100px" src="<?php echo validate_image($_settings->info('website-logo')) ?>" alt=""></a></span>
                        <i class='bx bx-x siderbarClose'></i>
                    </div>
                    <ul class="nav-links">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="./?p=products">Pets</a></li>
                        <li><a href="./?p=blog">Blog</a></li>
                        <li><a href="./?p=about">About</a></li>
                        <li><a href="./?p=contact-us">Contact</a></li>
                    </ul>

                </div>


                <div class="d-flex justify-center nav-user-icons ">
                    <ul style=" margin-bottom: 0px;" class="d-flex justify-center ">
                        <?php
                        if (isset($_SESSION['userdata']['user_id']) && ($_SESSION['userdata']['role'] == 'subscriber')) {
                            $display = 'style="display:none;"';
                            echo '<a href="#" class="text-dark  nav-link" disabled><b style="color:white;"> Hi,' . substr($_SESSION['userdata']['fullname'], 0, 7) . '..!</b></a>';
                            echo '<a href="log_out.php" class="text-dark  nav-link"><i style="color:white;" class="fa fa-sign-out-alt"></i></a>';
                        } else {
                            $display = '';
                        }
                        ?>
                        <li <?php echo $display; ?>><a class="icon mx-4" id="form-open"><i style="color:white;" class=" fa fa-user"></i></a> </li>

                    </ul>
                    <div class="searchBox">
                        <div class="searchToggle">
                            <i class='bx bx-x cancel'></i>
                            <i class='bx bx-search search'></i>
                        </div>

                        <div class="search-field">
                            <input type="text" id="query" name="search" placeholder="Search...">
                            <i id="request" class='bx bx-search'></i>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Script for search form -->
            <script>
                var query = '';
                document.getElementById('query').addEventListener('input', function() {
                    query = this.value.trim();
                });
                document.querySelector('#request').addEventListener('click', function() {
                    if (query !== '') {
                        // Redirect to search page with search query as parameter
                        window.location.href = 'search.php?query=' + encodeURIComponent(query);
                    } else {
                        alert('Please enter a search query.'); // Alert if the input is empty
                    }
                });
                $(document).on('click', '.cancel', function() {
                    $('#query').val('');
                });
            </script>

        </nav>
        <?php include_once('login.php') ?>
    </header>