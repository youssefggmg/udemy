<?php
include "../app/Helpers/roleValidaiton.php";
include "../app/Helpers/isAccountvalidated.php";
class User extends Controller
{
    public function __construct()
    {
        Database::getInstance();
        $roleValidaitons = new roleValidaiton($_COOKIE["userROLE"], "Student", "/pages");
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
        $this->view("user/index",[]);
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
        $approvedCours = $Cours->listApprovedCourses()["courses"];
        $categories=$categorie->listCategories()["categories"];
        $data = ["categories"=>$categories];
        $this->view("/user/course",$data);
    }
}
?>