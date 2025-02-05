<?php
include "../rolleValidation/roleValidaiton.php";
include "../instance/instace.php";
include "../helper/isAccountvalidated.php";
include "../class/catigory.php";
include "../class/tag.php";


$roleValidaiton = new RoleValidaiton($_COOKIE["userROLE"], "Teacher", "../index.php");

$validateStatus = new IsAccountvalidated($pdo);
$validateStatus->validateAccount($_COOKIE["userID"]);

$accountstatus = $validateStatus->getAccountStatus();
if ($accountstatus == "Inactive") {
    header("Location: inactive.php");
}
$catigory = new Category($pdo);
$tag = new tag($pdo);
$listTags = $tag->listTags();
$catigorylist = $catigory->listCategories();
if ($catigorylist['status'] == 1) {
    $catigorylist = $catigorylist['categories'];
}
if ($listTags['status'] == 1) {
    $listTags = $listTags['message'];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Course</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const contentTypeRadios = document.querySelectorAll('input[name="content_type"]');
            const videoUrlField = document.getElementById('videoUrlField');
            const textContentField = document.getElementById('textContentField');

            // Hide both initially
            videoUrlField.style.display = 'none';
            textContentField.style.display = 'none';

            contentTypeRadios.forEach(radio => {
                radio.addEventListener('change', () => {
                    if (radio.value === 'Video') {
                        videoUrlField.style.display = 'block';
                        textContentField.style.display = 'none';
                    } else if (radio.value === 'Text') {
                        videoUrlField.style.display = 'none';
                        textContentField.style.display = 'block';
                    }
                });
            });
        });
    </script>
</head>

<body class="bg-gradient-to-r from-blue-50 to-blue-100 min-h-screen flex flex-col items-center justify-center">
    <div class="container-fluid mx-auto justify-center  w-full">
        <div class="flex flex-wrap border-t px-4 xl:px-5">
            <div class="w-full lg:w-1/4 hidden lg:block">
                <input type="text" placeholder="Search Something..." id="searchInput"
                    class="w-full outline-none bg-white text-gray-600 text-sm px-4 py-3" />
                <div id="searchResults"
                    class="absolute z-10 bg-white border border-gray-300 w-full max-h-72 overflow-y-auto hidden">
                    <!-- Search results will be appended here -->
                </div>
            </div>
            <div class="w-full lg:w-3/4">
                <nav class="bg-light py-3 px-0">
                    <a href="" class="block lg:hidden text-decoration-none">
                        <h1 class="m-0"><span class="text-blue-500">E</span>COURSES</h1>
                    </a>
                    <button type="button" class="navbar-toggler lg:hidden" data-toggle="collapse"
                        data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="hidden lg:block" id="navbarCollapse">
                        <div class="flex justify-between items-center">
                            <div class="flex space-x-4 py-0">
                                <a href="index.php" class="nav-item text-gray-700 hover:text-blue-500 active">Home</a>
                                <a href="about.php" class="nav-item text-gray-700 hover:text-blue-500">About</a>
                                <a href="createCourse.php" class="nav-item text-gray-700 hover:text-blue-500">Add
                                    Cours</a>
                                <a href="teacher.php" class="nav-item text-gray-700 hover:text-blue-500">Teachers</a>
                                <a href="myCourses.php"
                                    class="nav-item text-gray-700 hover:text-blue-500">MyCourse's</a>
                                <a href="contact.php" class="nav-item text-gray-700 hover:text-blue-500">Contact</a>
                            </div>
                            <a class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded hidden lg:block"
                                href="../controllers/logout.php">Logout</a>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-2xl overflow-hidden max-w-3xl w-full">
        <div class="bg-blue-600 text-white p-6 text-center">
            <h1 class="text-3xl font-bold">Create a New Course</h1>
            <p class="text-sm mt-2">Fill in the details below to add a new course to the platform.</p>
        </div>
        <div class="p-8">
            <form action="../controllers/teacher/createCourse.php" method="POST" class="space-y-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Course Title</label>
                    <input type="text" id="title" name="title"
                        class="block w-full border border-gray-300 rounded-md px-4 py-2 text-sm shadow focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea id="description" name="description" rows="4"
                        class="block w-full border border-gray-300 rounded-md px-4 py-2 text-sm shadow focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"></textarea>
                </div>

                <!-- Content Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Content Type</label>
                    <div class="flex items-center space-x-6">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="radio" name="content_type" value="Video"
                                class="form-radio h-4 w-4 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Video</span>
                        </label>
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="radio" name="content_type" value="Text"
                                class="form-radio h-4 w-4 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Text</span>
                        </label>
                    </div>
                </div>

                <!-- Video URL -->
                <div id="videoUrlField">
                    <label for="video_url" class="block text-sm font-medium text-gray-700 mb-2">Video URL</label>
                    <input type="url" id="video_url" name="video_url"
                        class="block w-full border border-gray-300 rounded-md px-4 py-2 text-sm shadow focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                </div>

                <!-- Text Content -->
                <div id="textContentField">
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Content</label>
                    <textarea id="content" name="content" rows="4"
                        class="block w-full border border-gray-300 rounded-md px-4 py-2 text-sm shadow focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"></textarea>
                </div>

                <!-- Teacher ID -->
                <div class="hiddenn" style="display:none">
                    <label for="teacher_id" class=" text-sm font-medium text-gray-700 mb-2">Teacher ID</label>
                    <input type="number" id="teacher_id" name="teacher_id" value="<?php echo $_COOKIE["userID"] ?>"
                        class="block w-full border border-gray-300 rounded-md px-4 py-2 text-sm shadow focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                </div>
                <!-- Category Selection - New Addition -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                    <select id="category" name="category"
                        class="block w-full border border-gray-300 rounded-md px-4 py-2 text-sm shadow focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                        <option value="">Select a category</option>
                        <?php foreach ($catigorylist as $category): ?>
                            <option value="<?php echo $category['id']; ?>">
                                <?php echo $category['name']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tags</label>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <?php foreach ($listTags as $tag): ?>
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="tags[]" value="<?php echo htmlspecialchars($tag['id']); ?>"
                                    class="form-checkbox h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                <span
                                    class="ml-2 text-sm text-gray-700"><?php echo htmlspecialchars($tag['name']); ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div id="errorDiv"
                    class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6">
                    <?php echo '<span class="block sm:inline" id="errorMessage">'.$_GET["message"].'</span>' ?>
                </div>
                <!-- Submit Button -->
                <div class="text-center mt-6">
                    <button type="submit"
                        class="bg-blue-600 text-white font-medium py-3 px-8 rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50 transition-all duration-300 shadow-lg transform hover:scale-105">
                        Create Course
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>