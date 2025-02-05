<?php
include "../rolleValidation/roleValidaiton.php";
include "../instance/instace.php";
include "../helper/isAccountvalidated.php";
include "../class/catigory.php";
include "../class/tag.php";
include "../class/cours.php";


$roleValidaiton = new RoleValidaiton($_COOKIE["userROLE"], "Teacher", "../index.php");

$validateStatus = new IsAccountvalidated($pdo);
$validateStatus->validateAccount($_COOKIE["userID"]);

$accountstatus = $validateStatus->getAccountStatus();
if ($accountstatus == "Inactive") {
    header("Location: inactive.php");
}
$catigory = new Category($pdo);
$tag = new tag($pdo);
$cours = new Cours();
$cours->getConnection($pdo);
$coursinfo = $cours->getCourseDetails($_GET["courseID"])['course'];
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
            const videoUrlField = document.getElementById('video_url');
            const textContentField = document.getElementById('content');

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

            // Show initial content field based on saved content type
            const initialContentType = '<?php echo $coursinfo['content_type']; ?>';
            if (initialContentType === 'Video') {
                videoUrlField.style.display = 'block';
                textContentField.style.display = 'none';
            } else if (initialContentType === 'Text') {
                videoUrlField.style.display = 'none';
                textContentField.style.display = 'block';
            }
        });
    </script>
</head>

<body class="bg-gradient-to-r from-blue-50 to-blue-100 min-h-screen flex flex-col items-center justify-center">
    <div class="container-fluid mx-auto justify-center w-full">
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
            <form action="../controllers/teacher/updateCours.php" method="POST" class="space-y-6">
                <!-- Title -->
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($coursinfo['title']); ?>"
                    class="block w-full border border-gray-300 rounded-md px-4 py-2 text-sm shadow focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">

                <!-- Description -->
                <textarea id="description" name="description" rows="4"
                    class="block w-full border border-gray-300 rounded-md px-4 py-2 text-sm shadow focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"><?php echo htmlspecialchars($coursinfo['description']); ?></textarea>

                <!-- Content Type: Video or Text -->
                <div class="space-x-4">
                    <label>
                        <input type="radio" name="content_type" value="Video" <?php echo ($coursinfo['content_type'] === 'Video') ? 'checked' : ''; ?>
                            class="form-radio h-4 w-4 text-blue-600 focus:ring-blue-500">
                        Video
                    </label>
                    <label>
                        <input type="radio" name="content_type" value="Text" <?php echo ($coursinfo['content_type'] === 'Text') ? 'checked' : ''; ?>
                            class="form-radio h-4 w-4 text-blue-600 focus:ring-blue-500">
                        Text
                    </label>
                </div>

                <!-- Video URL or Text Content -->
                <div class="space-y-4">
                    <input type="url" id="video_url" name="video_url"
                        value="<?php echo ($coursinfo['content_type'] === 'Video') ? htmlspecialchars($coursinfo['content']) : ''; ?>"
                        class="block w-full border border-gray-300 rounded-md px-4 py-2 text-sm shadow focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                        placeholder="Enter Video URL" <?php echo ($coursinfo['content_type'] !== 'Video') ? 'disabled' : ''; ?>>

                    <textarea id="content" name="content" rows="4"
                        class="block w-full border border-gray-300 rounded-md px-4 py-2 text-sm shadow focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                        placeholder="Enter Text Content" <?php echo ($coursinfo['content_type'] !== 'Text') ? 'disabled' : ''; ?>><?php echo ($coursinfo['content_type'] === 'Text') ? htmlspecialchars($coursinfo['content']) : ''; ?></textarea>
                </div>

                <!-- Hidden course ID -->
                <input type="hidden" name="course_id" value="<?php echo $_GET['courseID']; ?>">

                <!-- Update button -->
                <button type="submit"
                    class="bg-blue-600 text-white font-medium py-3 px-8 rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50 transition-all duration-300 shadow-lg transform hover:scale-105">
                    Update Course
                </button>
            </form>
        </div>

    </div>
</body>
</html>
