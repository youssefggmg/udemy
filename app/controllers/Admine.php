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
        $data = ["allcourses"=>$allCourses,"coursCount"=>$coursCount,"platformStatistics"=>$platformStatistics];
        $this->view("user/index",$data);
    }
    public function courses(){
        $cours = $this->model("Cours");
        $admine = $this->model("Admine");
        $allCourses = $cours->listAllCourses()["courses"];
        $data=["allCourses"=>$allCourses];
        $this->view("admine/courses",$data);
    }
    public function single($id){
        $cours = $this->model("Cours");
        $coursInfo = $cours->getCourseDetails($id[0])['course'];
        $data=["coursInfo"=>$coursInfo];
        $this->view("admine/single",$data);
    }
    public function tags(){
        $this->model( "tags");
    }
}
?>