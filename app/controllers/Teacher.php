<?php
include "../app/Helpers/roleValidaiton.php";
include "../app/Helpers/isAccountvalidated.php";

class Teacher extends Controller
{
    public function __construct()
    {
        $roleValidaitons = new roleValidaiton($_COOKIE["userROLE"], "Student", );
        $accountValidation = new IsAccountvalidated();
        $accountValidation->validateAccount($_COOKIE["userID"]);
        $accountStatus = $accountValidation->getAccountStatus();
        if ($accountStatus == "Inactive") {
            header("Location: /YoudmyMVC/Teacher/inactive");
        }
    }
    public function index()
    {
        $categorie = $this->model("Categorie");
        $Teacher = $this->model("Teacher");
        $CoursStatistcs = $Teacher->viewCourseStatistics($_COOKIE["userID"]);
        $categories = $categorie->listCategories()["categories"];
        $data = ["categories" => $categories, "coursStatistecs" => $CoursStatistcs];
        $this->view("teacher/index",$data);
    }
    public function inactive()
    {
        $this->view("/user/inactive");
    }
    public function myCourses()
    {
        $teacher = $this->model("Teacher");
        $myCourses = $teacher->getCoursesByTeacherId($_COOKIE["userID"]);
        $data = ["teacherCoures" => $myCourses["data"]];
        $this->view("teacher/myCourses", $data);
    }
    public function single($id)
    {
        $cours = $this->model("Cours");
        $coursData = $cours->getCourseDetails($id[0])["course"];
        $this->view("/Teacher/single", $coursData);
    }
    public function edit($id)
    {
        $cours = $this->model("Cours");
        $catigory = $this->model("Catigory");
        $coursData = $cours->getCourseDetails($id[0])["course"];
        if (isset($_POST["title"], $_POST["description"], $_POST["content_type"], $_POST["course_id"])) {
            $title = $_POST["title"];
            $description = $_POST["description"];
            $content_type = $_POST["content_type"];
            $course_id = $_POST["course_id"];
            $video_url = $_POST["video_url"] ?? null;
            $content = $_POST["content"] ?? null;
            if ($content_type === "Video" && empty($video_url)) {
                $error="Error: Video URL is required for video content.<br>" ;
                $data = ["coursInfo" => $coursData,"error"=>$error];
                $this->view("/Teacher/editCours", $data);
                exit;
            }
            if ($content_type === "Text" && empty($content)) {
                $error = "Error: Text content is required for text content.";
                $data = ["coursInfo" => $coursData, "error" => $error];
                $this->view("/Teacher/editCours", $data);
                exit;
            }
            $cours->updateCourse($course_id,$title,$description,$content,$video_url,$content_type);
            header("/YoudmyMVC/teacher/myCourses");
        } 
        $data = ["coursInfo" => $coursData];
        $this->view("/Teacher/editCours", $data);
    }
    public function CreateCours()
    {
        $tag = $this->model("Tag");
        $catigory = $this->model("Catigory");
        $cours = $this->model("Cours");
        $listTags = $tag->listTags()['categories'];
        $catigorylist = $catigory->listCategories()['message'];
        if (isset($_POST["title"], $_POST["description"], $_POST["content_type"], $_POST["teacher_id"], $_POST["category"])) {
            $title = $_POST["title"];
            $description = $_POST["description"];
            $content_type = $_POST["content_type"];
            $teacher_id = $_POST["teacher_id"];
            $category = $_POST["category"];
            $video_url = $_POST["video_url"] ?? null;
            $content = $_POST["content"] ?? null;
            $tags = $_POST["tags"] ?? [];
            if ($content_type === "Video" && !isset($_POST["video_url"])) {
                $error = "Error: Video URL is required for video content";
                $data = ["tags" => $listTags, "catigoreis" => $catigorylist, "error" => $error];
                $this->view("/Teacher/createCourse", $data);
                exit;
            }
            if ($content_type === "Text" && !isset($_POST["content"])) {
                $error = "Error: Text content is required for text content.";
                $data = ["tags" => $listTags, "catigoreis" => $catigorylist, "error" => $error];
                $this->view("/Teacher/createCourse", $data);
                exit;
            }
            $cours->addCours($title, $description, $content, $video_url, $content_type, $_COOKIE["userID"]);
            header("/YoudmyMVC/teacher/myCourses");
        } else {
            $data = ["tags" => $listTags, "catigoreis" => $catigorylist];
            $this->view("/Teacher/createCourse", $data);
        }
    }
}
?>