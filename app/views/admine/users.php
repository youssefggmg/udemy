<?php
include "../rolleValidation/roleValidaiton.php";
include "../instance/instace.php";
include "../class/admine.php";

$roleValidaiton = new RoleValidaiton($_COOKIE["userROLE"], "Administrator", "../index.php");
$admine = new Admine($pdo);
$allStudents = $admine->getAllStudents()["message"];
$allTeachers = $admine->getTeachersAccount()["message"];
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>User Management - ECOURSES</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/userPgae.css">
</head>

<body>
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
                            <a href="course.php" class="nav-item nav-link">Courses</a>
                            <a href="teacher.php" class="nav-item nav-link">Teachers</a>
                            <a href="users.php" class="nav-item nav-link">Users</a>
                            <a href="contact.php" class="nav-item nav-link">Contact</a>
                        </div>
                        <a class="btn btn-primary py-2 px-4 ml-auto d-none d-lg-block"
                            href="../controllers/logout.php">Logout</a>
                    </div>
                </nav>
            </div>
        </div>
    </div>
    <!-- Navbar End -->
    <div class="container">
        <!-- Students Section -->
        <div class="section">
            <h2>Students</h2>
            <div class="table-container">
                <table id="studentsTable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($allStudents as $student): ?>

                            <tr>
                                <td><?= $student["name"] ?></td>
                                <td class="user-email"><?= $student["email"] ?></td>
                                <td>
                                    <span class="status-badge status-active">
                                        <?= $student["account_status"] ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <?php if ($student["account_status"] == "Inactive"): ?>
                                            <button class="btn btn-activate">
                                                <a href="../controllers/activate.php?userID=<?= $student["id"] ?>">Activate</a>
                                            </button>
                                        <?php else: ?>
                                            <button class="btn btn-deactivate">
                                                <a
                                                    href="../controllers/disActivate.php?userID=<?= $student["id"] ?>">Deactivate</a>
                                            </button>
                                        <?php
                                        endif; ?>
                                        <button class="btn btn-delete">
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Teachers Section -->
        <div class="section">
            <h2>Teachers</h2>
            <div class="table-container">
                <table id="teachersTable">
                    <thead>
                        <?php foreach ($allTeachers as $teacher): ?>
                            <tr>
                                <td><?= $teacher["name"] ?></td>
                                <td class="user-email"><?= $teacher["email"] ?></td>
                                <td>
                                    <span class="status-badge status-active">
                                        <?= $teacher["account_status"] ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <?php if ($teacher["account_status"] == "Inactive"): ?>
                                            <button class="btn btn-activate">
                                                Activate
                                            </button>
                                        <?php else: ?>
                                            <button class="btn btn-deactivate">
                                                Deactivate
                                            </button>
                                        <?php
                                        endif ?>
                                        <button class="btn btn-delete">
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="toast" class="toast">
        <span id="toastMessage"></span>
    </div>
</body>

</html>