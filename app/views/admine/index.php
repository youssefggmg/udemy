<?php
include "../rolleValidation/roleValidaiton.php";
include "../instance/instace.php";
include "../class/catigory.php";
include "../class/cours.php";
include "../class/admine.php";

$roleValidaiton = new RoleValidaiton($_COOKIE["userROLE"], "Administrator", "../index.php");

$cours = new Cours();
$cours->getConnection($pdo);
$category = new Category($pdo);
$admine = new Admine($pdo);
$allCourses = $cours->listAllCourses()["courses"];
$results = $category->getCategoryCourseCounts()["categories"];
$platformStatistics = $admine->generatePlatformStatistics()["message"];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>ECOURSES - Online Courses HTML Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Topbar Start -->
    <div class="container-fluid d-none d-lg-block">
        <div class="row align-items-center py-4 px-xl-5">
            <div class="col-lg-3">
                <a href="" class="text-decoration-none">
                    <h1 class="m-0"><span class="text-primary">E</span>COURSES</h1>
                </a>
            </div>
            <div class="col-lg-3 text-right">
                <div class="d-inline-flex align-items-center">
                    <i class="fa fa-2x fa-map-marker-alt text-primary mr-3"></i>
                    <div class="text-left">
                        <h6 class="font-weight-semi-bold mb-1">Our Office</h6>
                        <small>123 Street, New York, USA</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 text-right">
                <div class="d-inline-flex align-items-center">
                    <i class="fa fa-2x fa-envelope text-primary mr-3"></i>
                    <div class="text-left">
                        <h6 class="font-weight-semi-bold mb-1">Email Us</h6>
                        <small>info@example.com</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 text-right">
                <div class="d-inline-flex align-items-center">
                    <i class="fa fa-2x fa-phone text-primary mr-3"></i>
                    <div class="text-left">
                        <h6 class="font-weight-semi-bold mb-1">Call Us</h6>
                        <small>+012 345 6789</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Topbar End -->

    <!-- Navbar Start -->
    <div class="container-fluid">
        <div class="row border-top px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <input type="text" placeholder="Search Something..." id="searchInput"
                    class="w-full outline-none bg-white text-gray-600 text-sm px-4 py-3" />
                <div id="searchResults"
                    style="position: absolute; z-index: 10; background: white; border: 1px solid #ddd; width: 100%; max-height: 300px; overflow-y: auto; display: none;">
                    <!-- Search results will be appended here -->
                </div>
            </div>
            <div class="col-lg-9">
                <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
                    <a href="" class="text-decoration-none d-block d-lg-none">
                        <h1 class="m-0"><span class="text-primary">E</span>COURSES</h1>
                    </a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav py-0">
                            <a href="index.php" class="nav-item nav-link active">Home</a>
                            <a href="tags.php" class="nav-item nav-link">tags</a>
                            <a href="users.php" class="nav-item nav-link">Users</a>
                            <a href="teacher.php" class="nav-item nav-link">Teachers</a>
                            <a href="courses.php" class="nav-item nav-link">course's</a>
                            
                        </div>
                        <a class="btn btn-primary py-2 px-4 ml-auto d-none d-lg-block"
                            href="../controllers/logout.php">Logout</a>
                    </div>
                </nav>
            </div>
        </div>
    </div>
    <!-- Navbar End -->
    <div class="container py-5">
        <div class="row g-4">
            <!-- Total Students Card -->
            <div class="col-md-6 col-lg-3">
                <div class="card h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded-circle p-3 bg-primary bg-opacity-10 text-primary">
                            <svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                </path>
                            </svg>
                        </div>
                        <div class="ms-4">
                            <p class="text-muted mb-0">Total Users</p>
                            <h3 class="fw-bold mb-0"><?php echo $platformStatistics['totalUsers']; ?></h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active Teachers Card -->
            <div class="col-md-6 col-lg-3">
                <div class="card h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded-circle p-3 bg-success bg-opacity-10 text-success">
                            <svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                </path>
                            </svg>
                        </div>
                        <div class="ms-4">
                            <p class="text-muted mb-0">Active Teachers</p>
                            <h3 class="fw-bold mb-0"><?php echo $platformStatistics['activeTeachers']; ?></h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Inactive Teachers Card -->
            <div class="col-md-6 col-lg-3">
                <div class="card h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded-circle p-3 bg-warning bg-opacity-10 text-warning">
                            <svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                                </path>
                            </svg>
                        </div>
                        <div class="ms-4">
                            <p class="text-muted mb-0">Inactive Teachers</p>
                            <h3 class="fw-bold mb-0"><?php echo $platformStatistics['inactiveTeachers']; ?></h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Courses Card -->
            <div class="col-md-6 col-lg-3">
                <div class="card h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded-circle p-3 bg-info bg-opacity-10 text-info">
                            <svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                </path>
                            </svg>
                        </div>
                        <div class="ms-4">
                            <p class="text-muted mb-0">Total Courses</p>
                            <h3 class="fw-bold mb-0"><?php echo $platformStatistics['totalCourses']; ?></h3>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Total Approved Courses Card -->
            <div class="col-md-6 col-lg-3">
                <div class="card h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded-circle p-3 bg-success bg-opacity-10 text-success">
                            <svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6l8 8 8-8M4 18l8-8 8 8">
                                </path>
                            </svg>
                        </div>
                        <div class="ms-4">
                            <p class="text-muted mb-0">Approved Courses</p>
                            <h3 class="fw-bold mb-0"><?php echo $platformStatistics['totalApprovedCourses']; ?></h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Rejected Courses Card -->
            <div class="col-md-6 col-lg-3">
                <div class="card h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded-circle p-3 bg-danger bg-opacity-10 text-danger">
                            <svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v12m6-6H6">
                                </path>
                            </svg>
                        </div>
                        <div class="ms-4">
                            <p class="text-muted mb-0">Rejected Courses</p>
                            <h3 class="fw-bold mb-0"><?php echo $platformStatistics['totalRejectedCourses']; ?></h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Pending Courses Card -->
            <div class="col-md-6 col-lg-3">
                <div class="card h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded-circle p-3 bg-warning bg-opacity-10 text-warning">
                            <svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                                </path>
                            </svg>
                        </div>
                        <div class="ms-4">
                            <p class="text-muted mb-0">Pending Courses</p>
                            <h3 class="fw-bold mb-0"><?php echo $platformStatistics['totalPendingCourses']; ?></h3>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- Most Enrolled Course Card Section -->
    <div class="course-highlight-section"
        style="font-family: Arial, sans-serif; background-color: #f1f3f5; padding: 30px; text-align: center;">
        <h2 style="color: #495057; margin-bottom: 10px;">Explore Our Top Course</h2>


        <!-- Most Enrolled Course Card -->
        <div class="most-enrolled-card"
            style="margin: 0 auto; max-width: 500px; padding: 20px; background-color: #ffffff; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
            <div class="card-container" style="display: flex; align-items: center;">
                <div class="icon-wrapper"
                    style="background-color: #d4edda; padding: 20px; border-radius: 50%; display: flex; justify-content: center; align-items: center; margin-right: 20px;">
                    <svg width="50" height="50" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="icon"
                        style="color: #28a745;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </path>
                    </svg>
                </div>
                <div class="text-wrapper" style="display: flex; flex-direction: column; text-align:center; width:100%">
                    <h4 class="course-name" style="font-size: 22px; font-weight: bold; color: #212529; margin: 5px 0; text-align:center">
                    <?php 
                    echo $platformStatistics['mostEnrolledCourse']['title']; ?></h4>
                    
                </div>
            </div>
            <p style="margin-top: 15px; color: #868e96; font-size: 14px;"><?php 
                    echo $platformStatistics['mostEnrolledCourse']['description']; ?>
                </p>
        </div>
    </div>



    <!-- Category Start -->
    <div class="container-fluid py-5">
        <div class="container pt-5 pb-3">
            <div class="text-center mb-5">
                <h5 class="text-primary text-uppercase mb-3" style="letter-spacing: 5px;">Subjects</h5>
                <h1>Explore Top Subjects</h1>
            </div>
            <div class="row">
                <?php
                foreach ($results as $result) {
                    echo "<div class='col-lg-3 col-md-6 mb-4'>
                            <div class='cat-item position-relative overflow-hidden rounded mb-2'>
                                <img class='img-fluid' src='" . $result["category_image"] . "' alt='categoryImage'>
                                <a class='cat-overlay text-white text-decoration-none' href=''>
                                    <h4 class='text-white font-weight-medium'>" . $result["category_name"] . "</h4>
                                    <span>" . $result["course_count"] . " Courses</span>
                                </a>
                            </div>
                        </div>";
                }
                ?>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="cat-item position-relative overflow-hidden rounded mb-2">
                        <img class="img-fluid" src="img/cat-1.jpg" alt="">
                        <a class="cat-overlay text-white text-decoration-none" href="">
                            <h4 class="text-white font-weight-medium">Web Design</h4>
                            <span>100 Courses</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Category Start -->
    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-white py-5 px-sm-3 px-lg-5" style="margin-top: 90px;">
        <div class="row pt-5">
            <div class="col-lg-7 col-md-12">
                <div class="row">
                    <div class="col-md-6 mb-5">
                        <h5 class="text-primary text-uppercase mb-4" style="letter-spacing: 5px;">Get In Touch</h5>
                        <p><i class="fa fa-map-marker-alt mr-2"></i>123 Street, New York, USA</p>
                        <p><i class="fa fa-phone-alt mr-2"></i>+012 345 67890</p>
                        <p><i class="fa fa-envelope mr-2"></i>info@example.com</p>
                        <div class="d-flex justify-content-start mt-4">
                            <a class="btn btn-outline-light btn-square mr-2" href="#"><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-outline-light btn-square mr-2" href="#"><i
                                    class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-outline-light btn-square mr-2" href="#"><i
                                    class="fab fa-linkedin-in"></i></a>
                            <a class="btn btn-outline-light btn-square" href="#"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                    <div class="col-md-6 mb-5">
                        <h5 class="text-primary text-uppercase mb-4" style="letter-spacing: 5px;">Our Courses</h5>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-white mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Web Design</a>
                            <a class="text-white mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Apps Design</a>
                            <a class="text-white mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Marketing</a>
                            <a class="text-white mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Research</a>
                            <a class="text-white" href="#"><i class="fa fa-angle-right mr-2"></i>SEO</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-md-12 mb-5">
                <h5 class="text-primary text-uppercase mb-4" style="letter-spacing: 5px;">Newsletter</h5>
                <p>Rebum labore lorem dolores kasd est, et ipsum amet et at kasd, ipsum sea tempor magna tempor. Accu
                    kasd sed ea duo ipsum. Dolor duo eirmod sea justo no lorem est diam</p>
                <div class="w-100">
                    <div class="input-group">
                        <input type="text" class="form-control border-light" style="padding: 30px;"
                            placeholder="Your Email Address">
                        <div class="input-group-append">
                            <button class="btn btn-primary px-4">Sign Up</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid bg-dark text-white border-top py-4 px-sm-3 px-md-5"
        style="border-color: rgba(256, 256, 256, .1) !important;">
        <div class="row">
            <div class="col-lg-6 text-center text-md-left mb-3 mb-md-0">
                <p class="m-0 text-white">&copy; <a href="#">Domain Name</a>. All Rights Reserved. Designed by <a
                        href="https://htmlcodex.com">HTML Codex</a>
                </p>
            </div>
            <div class="col-lg-6 text-center text-md-right">
                <ul class="nav d-inline-flex">
                    <li class="nav-item">
                        <a class="nav-link text-white py-0" href="#">Privacy</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white py-0" href="#">Terms</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white py-0" href="#">FAQs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white py-0" href="#">Help</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    <script src="js/special.js"></script>
</body>

</html>