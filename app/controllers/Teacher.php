<?php
include "../app/Helpers/roleValidaiton.php";
include "../app/Helpers/isAccountvalidated.php";

class Teacher extends Controller {
    public function __construct() {
        $roleValidaitons = new roleValidaiton($_COOKIE["userROLE"], "Student", );
        $accountValidation = new IsAccountvalidated();
        $accountValidation->validateAccount($_COOKIE["userID"]);
        $accountStatus = $accountValidation->getAccountStatus();
        if ($accountStatus == "Inactive") {
            header("Location: /YoudmyMVC/Teacher/inactive");
        }
    }
    public function index() {
        $categorie = $this->model("Categorie");
        $Teacher = $this->model("Teacher");
        $CoursStatistcs = $Teacher->viewCourseStatistics($_COOKIE["userID"]);
        $categories=$categorie->listCategories()["categories"];
        $data = ["categories"=>$categories,"coursStatistecs"=>$CoursStatistcs];
        $this->view("teacher/index");
    }
    public function inactive(){
        $this->view("/user/inactive");
    }
}
?>