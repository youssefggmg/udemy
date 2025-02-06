<?php
include "../rolleValidation/roleValidaiton.php";
include "../instance/instace.php";
include "../class/admine.php";
include "../class/tag.php";

$roleValidaiton = new RoleValidaiton($_COOKIE["userROLE"], "Administrator", "../index.php");
$tag = new tag($pdo);
$tagsList = $tag->listTags()["message"];
?>
<!DOCTYPE html>
<html>

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
    <link rel="stylesheet" href="css/mystyle.css">
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
    <div class="main-content">
        <div class="form-section">
            <h2>Add Tags</h2>
            <form id="tagForm" action="../controllers/admine/addTags.php" method="POST">
                <input type="hidden" id="inputCounter" name="inputCounter" value="1">
                <div class="tag-inputs" id="tagInputs">
                    <div class="input-group">
                        <input type="text" class="tag-input" name="tag1" placeholder="Enter tag name" required>
                        <button type="button" class="btn remove-btn" onclick="removeInput(this)"
                            style="display: none;">Remove</button>
                    </div>
                </div>
                <button type="button" class="btn add-btn" onclick="addNewInput()">Add Another Tag</button>
                <button type="submit" class="btn submit-btn">Save All Tags</button>
            </form>
        </div>

        <div class="table-section">
            <h2>Existing Tags</h2>
            <table id="tagsTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tag Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tagsList as $tag): ?>
                        <tr>
                            <td><?= htmlspecialchars($tag["id"]) ?></td>
                            <td><?= htmlspecialchars($tag["name"]) ?></td>
                            <td>
                                <button class="btn remove-btn" onclick="deleteTag(<?= $tag['id'] ?>)">Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div id="emptyState" class="empty-state" style="display: none;">
                No tags have been added yet. Start by adding some tags above!
            </div>
        </div>
    </div>

    <div id="toast" class="toast">
        <span id="toastMessage"></span>
    </div>

    <script>
        function addNewInput() {
            const counter = document.getElementById('inputCounter');
            const newCount = parseInt(counter.value) + 1;
            counter.value = newCount;
            
            const tagInputs = document.getElementById('tagInputs');
            const newInput = document.createElement('div');
            newInput.className = 'input-group';
            newInput.innerHTML = `
                <input type="text" class="tag-input" name="tag${newCount}" placeholder="Enter tag name" required>
                <button type="button" class="btn remove-btn" onclick="removeInput(this)">Remove</button>
            `;
            tagInputs.appendChild(newInput);
            updateRemoveButtons();
        }

        function removeInput(button) {
            button.parentElement.remove();
            updateRemoveButtons();
            updateCounter();
        }

        function updateCounter() {
            const counter = document.getElementById('inputCounter');
            const inputs = document.querySelectorAll('.tag-input');
            counter.value = inputs.length;
        }

        function updateRemoveButtons() {
            const inputs = document.querySelectorAll('.input-group');
            const removeButtons = document.querySelectorAll('.remove-btn');
            
            removeButtons.forEach(button => {
                button.style.display = inputs.length === 1 ? 'none' : 'inline-block';
            });
        }

        function deleteTag(tagId) {
            if (confirm('Are you sure you want to delete this tag?')) {
                fetch(`../controllers/deleteTag.php?id=${tagId}`, {
                    method: 'DELETE'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const row = event.target.closest('tr');
                        row.remove();
                        showToast('Tag deleted successfully', 'success');
                        updateEmptyState();
                    } else {
                        showToast('Failed to delete tag', 'error');
                    }
                })
                .catch(error => {
                    showToast('Error deleting tag', 'error');
                });
            }
        }

        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toastMessage');
            toast.className = `toast ${type}`;
            toastMessage.textContent = message;
            toast.style.display = 'block';
            
            setTimeout(() => {
                toast.style.display = 'none';
            }, 3000);
        }

        function updateEmptyState() {
            const tbody = document.querySelector('#tagsTable tbody');
            const emptyState = document.getElementById('emptyState');
            emptyState.style.display = tbody.children.length === 0 ? 'block' : 'none';
        }

        // Initialize
        updateEmptyState();
        updateRemoveButtons();
    </script>
</body>

</html>