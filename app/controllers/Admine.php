<?php
include "../app/Helpers/roleValidaiton.php";
include "../app/Helpers/isAccountvalidated.php";
class Admine extends Controller
{
    public function __construct()
    {
        Database::getInstance();
        $roleValidaitons = new roleValidaiton($_COOKIE["userROLE"], "Admine", );
    }
    public function index()
    {
        $cours = $this->model("Cours");
        $category = $this->model("Catigorie");
        $admine = $this->model("Admine");
        $allCourses = $cours->listAllCourses()["courses"];
        $coursCount = $category->getCategoryCourseCounts()["categories"];
        $platformStatistics = $admine->generatePlatformStatistics()["message"];
        $data = ["allcourses" => $allCourses, "coursCount" => $coursCount, "platformStatistics" => $platformStatistics];
        $this->view("user/index", $data);
    }
    public function courses()
    {
        $cours = $this->model("Cours");
        $admine = $this->model("Admine");
        $allCourses = $cours->listAllCourses()["courses"];
        $data = ["allCourses" => $allCourses];
        $this->view("admine/courses", $data);
    }
    public function updateCourseStatus($id)
    {
        $cours = $this->model("Cours");
        $cours->changeStatus($id[0], $id[1]);
    }
    public function deleteCourse($id)
    {
        $cours = $this->model("Cours");
        $cours->deleteCourse($id[0]);
        header("location: /YoudmyMVC/Admine/courses");
    }
    public function single($id)
    {
        $cours = $this->model("Cours");
        $coursInfo = $cours->getCourseDetails($id[0])['course'];
        $data = ["coursInfo" => $coursInfo];
        $this->view("admine/single", $data);
    }
    public function tags()
    {
        $tag = $this->model("tags");
        $allTags = $tag->listAllTags()["tags"];
        $tags = [];
        $inputCounter = 0;
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Retrieve the input counter
            $inputCounter = isset($_POST['inputCounter']) ? (int) $_POST['inputCounter'] : 0;

            // Extract tags
            for ($i = 1; $i <= $inputCounter; $i++) {
                $tagKey = "tag" . $i;
                if (!empty($_POST[$tagKey])) {
                    $tags[] = htmlspecialchars(trim($_POST[$tagKey]));
                }
            }
            $result = $tag->createTags($tags, $inputCounter);
            if ($result["status"] == 0) {
                $data = ["error" => $result["error"]];
                $this->view("admine/tags", $data);
            }
        }
        $data = ["allTags" => $allTags];
        $this->view("admine/tags", $data);
    }
    public function deleteTag($id)
    {
        $tag = $this->model("tags");
        $tag->deleteTag($id[0]);
    }
    public function Users()
    {
        $admine = $this->model("Admine");
        $allStudents = $admine->getAllStudents()["message"];
        $allTeachers = $admine->getTeachersAccount()["message"];
        $data= [ "allStudents" => $allStudents, "allTeachers" => $allTeachers];
        $this->view("admine/users", $data);
    }
    public function activateUser($id){
        $admine = $this->model("Admine");
        $admine->activateUser($id[0]);
        header("location: /YoudmyMVC/Admine/Users");
    }
    public function disActivate($id){
        $admine = $this->model("Admine");
        $admine->DeactivateUser($id[0]);
        header("location: /YoudmyMVC/Admine/Users");
    }
}