<?php
include "../rolleValidation/roleValidaiton.php";
include "../instance/instace.php";
include "../class/student.php";
include "../helper/isAccountvalidated.php";
$roleValidaiton = new RoleValidaiton($_COOKIE["userROLE"], "Student", "../index.php");
$student = new Student($pdo);
$myCourses = $student->viewMyCourses($_COOKIE["userROLE"]);
if ($myCourses["status"] == 1) {
    $results = $myCourses["data"];
}
$validateStatus = new IsAccountvalidated($pdo);
$validateStatus->validateAccount($_COOKIE["userID"]);
$accountstatus=$validateStatus->getAccountStatus();
if ($accountstatus=="Inactive") {
    header("Location: inactive.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Courses</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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

<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
    <!-- Topbar -->
    <div class="hidden lg:block bg-white">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between py-4">
                <!-- Logo -->
                <div class="w-1/4">
                    <a href="#" class="text-decoration-none">
                        <h1 class="text-2xl font-bold"><span class="text-blue-600">E</span>COURSES</h1>
                    </a>
                </div>

                <!-- Office Location -->
                <div class="flex items-center">
                    <i class="fas fa-map-marker-alt text-2xl text-blue-600 mr-3"></i>
                    <div>
                        <h6 class="font-semibold mb-1">Our Office</h6>
                        <small class="text-gray-600">123 Street, New York, USA</small>
                    </div>
                </div>

                <!-- Email -->
                <div class="flex items-center">
                    <i class="fas fa-envelope text-2xl text-blue-600 mr-3"></i>
                    <div>
                        <h6 class="font-semibold mb-1">Email Us</h6>
                        <small class="text-gray-600">info@example.com</small>
                    </div>
                </div>

                <!-- Phone -->
                <div class="flex items-center">
                    <i class="fas fa-phone text-2xl text-blue-600 mr-3"></i>
                    <div>
                        <h6 class="font-semibold mb-1">Call Us</h6>
                        <small class="text-gray-600">+012 345 6789</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navbar -->
    <div class="border-t">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap">
                <!-- Search Bar (Desktop) -->
                <div class="hidden lg:block w-1/4 py-4">
                    <input type="email" placeholder="Search Something..."
                        class="w-full px-4 py-3 border rounded focus:outline-none focus:border-blue-500 text-sm text-gray-600">
                    <div id="searchResults"
                        style="position: absolute; z-index: 10; background: white; border: 1px solid #ddd; width: 100%; max-height: 300px; overflow-y: auto; display: none;">
                        <!-- Search results will be appended here -->
                    </div>
                </div>

                <!-- Navigation -->
                <div class="w-full lg:w-3/4">
                    <nav class="bg-white">
                        <div class="container mx-auto">
                            <!-- Mobile Logo -->
                            <div class="lg:hidden flex items-center justify-between py-4">
                                <a href="#" class="text-xl font-bold">
                                    <span class="text-blue-600">E</span>COURSES
                                </a>
                                <button id="menu-toggle" class="lg:hidden focus:outline-none">
                                    <i class="fas fa-bars text-xl"></i>
                                </button>
                            </div>

                            <!-- Navigation Links -->
                            <div id="menu"
                                class="hidden lg:flex flex-col lg:flex-row justify-between items-center py-4">
                                <div class="flex flex-col lg:flex-row space-y-2 lg:space-y-0 lg:space-x-6">
                                    <a href="index.php" class="text-gray-800 hover:text-blue-600 font-medium">Home</a>
                                    <a href="about.php" class="text-gray-800 hover:text-blue-600 font-medium">About</a>
                                    <a href="course.php"
                                        class="text-gray-800 hover:text-blue-600 font-medium">Courses</a>
                                    <a href="teacher.php"
                                        class="text-gray-800 hover:text-blue-600 font-medium">Teachers</a>
                                    <a href="myCourses.php"
                                        class="text-gray-800 hover:text-blue-600 font-medium">MyCourse's</a>
                                    <a href="contact.php"
                                        class="text-gray-800 hover:text-blue-600 font-medium">Contact</a>
                                </div>
                                <a href="../controllers/logout.php"
                                    class="hidden lg:inline-block bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition duration-200">
                                    Logout
                                </a>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Navbar End -->
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-20">
        <div class="container mx-auto px-4">
            <div class="text-center max-w-3xl mx-auto">
                <h5 class="text-blue-200 uppercase tracking-[0.5em] mb-4 text-sm font-semibold">Expand Your Knowledge
                </h5>
                <h1 class="text-5xl font-bold mb-6">Our Featured Courses</h1>
                <p class="text-blue-100 text-lg">Discover our selection of professionally crafted courses designed to
                    help you achieve your goals.</p>
            </div>
        </div>
    </div>

    <!-- Courses Section -->
    <div class="py-16 px-4 -mt-10">
        <div class="max-w-7xl mx-auto">
            <!-- Course Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Course Card 1 -->
                <?php
                foreach ($results as $result) {
                    echo '<div
                    class="bg-white rounded-2xl overflow-hidden shadow-lg transform hover:-translate-y-1 transition-all duration-300">
                    <div class="relative">
                        <img src="/api/placeholder/400/250" alt="Course Image" class="w-full h-48 object-cover">
                    </div>
                    <div class="p-6">
                        <a href="#" class="block text-xl font-bold text-gray-800 hover:text-blue-600 mb-3">
                            ' . $result["title"] . '
                        </a>
                        <p class="' . $result["description"] . '.</p>
                        <div class="border-t pt-4">
                            <div class="flex justify-between items-center">
                                <button
                                    class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transform hover:scale-105 transition-all duration-200">
                                    <a href="./single.php?courseID=' . $result["id"] . '">view Course</a>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>';
                }
                ?>
            </div>
        </div>
    </div>
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
    <script src="js/special.js"></script>
</body>

</html>