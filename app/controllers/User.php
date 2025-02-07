<?php
include "../app/Helpers/roleValidaiton.php";
include "../app/Helpers/isAccountvalidated.php";
class User extends Controller
{
    public function __construct()
    {
        Database::getInstance();
        $roleValidaitons = new roleValidaiton($_COOKIE["userROLE"], "Student", );
        $accountValidation = new IsAccountvalidated();
        $accountValidation->validateAccount($_COOKIE["userID"]);
        $accountStatus = $accountValidation->getAccountStatus();
        if ($accountStatus == "Inactive") {
            header("Location: /YoudmyMVC/user/inactive");
        }
    }
    public function index(){
        $categorie = $this->model("Categorie");
        $categories=$categorie->listCategories()["categories"];
        $data = ["categories"=>$categories];
        $this->view("user/index",$data);
    }
    public function inactive(){
        $this->view("/user/inactive");
    }
    public function about(){
        $this->view("/user/about");
    }
    public function course(){
        $categorie = $this->model("Categorie");
        $Cours = $this->model("Cours");
        $coursStatus = $Cours->listApprovedCourses()["status"];
        if ($coursStatus==0) {
            $approvedCours = $Cours->listApprovedCourses()["message"];
        }else {
            $approvedCours = $Cours->listApprovedCourses()["courses"];
        }
        $categories=$categorie->listCategories()["categories"];
        $data = ["categories"=>$categories,"courses"=>$approvedCours,"coursStatus"=>$coursStatus];
        $this->view("/user/course",$data);
    }
    public function enroll($userCours){
        $Student = $this->model("Student");
        $Student->enrollInCourse($userCours[0],$userCours[1]);
        header("location: /YoudmyMVC/user/course");
    }
    public function mycours(){
        $student = $this->model("Student");
        $myCourses = $student->viewMyCourses($_COOKIE["userID"])["data"];
        $data = ["myCourses"=>$myCourses];
        $this->view("/user/myCourses",$data);
    }
    public function single($id){
        $cours = $this->model("Cours");
        $coursData = $cours->getCourseDetails($id[0])["course"];

        $this->view("/user/single",$coursData);
    }
}
?>