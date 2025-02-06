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
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-family: Arial, sans-serif;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f4f4f4;
            font-weight: bold;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        button {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .view-btn {
            background-color: #4CAF50;
            color: white;
        }

        .delete-btn {
            background-color: #f44336;
            color: white;
        }

        select {
            padding: 6px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: white;
            margin: 15% auto;
            padding: 20px;
            width: 70%;
            max-width: 700px;
            border-radius: 8px;
        }

        .close {
            float: right;
            cursor: pointer;
            font-size: 24px;
        }
    </style>
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
    <table id="courseTable">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Content Type</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Sample data -->
            <?php
            foreach ($allCourses as $acours):
                ?>
                <tr>
                    <td><?= $acours->__get("title") ?></td>
                    <td><?= $acours->__get("description") ?></td>
                    <td><?= $acours->__get("contentType") ?></td>
                    <td>
                        <select onchange="updateStatus(this, <?= $acours->__get('id') ?>)">
                            <option value="pending" <?= $acours->__get('status') == 'pending' ? 'selected' : '' ?>>Pending
                            </option>
                            <option value="accepted" <?= $acours->__get('status') == 'accepted' ? 'selected' : '' ?>>Accepted
                            </option>
                            <option value="rejected" <?= $acours->__get('status') == 'rejected' ? 'selected' : '' ?>>Rejected
                            </option>
                        </select>
                    </td>
                    <td><?= $acours->__get('creation_date') ?></td>
                    <td>
                        <div class="action-buttons">
                            <button class="view-btn"><a href="single.php?courseID=<?= $acours->__get("id") ?>">View
                                    Content</a></button>
                            <button class="delete-btn"><a
                                    href="../controllers/admine/deletecourse.php?courseID=<?= $acours->__get("id") ?>">Delete</a></button>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <script>
        function updateStatus(selectElement, courseId) {
            const newStatus = selectElement.value;
            fetch(`../controllers/admine/changeCoursStatus.php?id=${courseId}&status=${newStatus}`)
        }
    </script>


</body>

</html>