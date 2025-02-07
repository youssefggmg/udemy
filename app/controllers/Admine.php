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
}
?>