<?php
include "../app/Helpers/roleValidaiton.php";
include "../app/Helpers/isAccountvalidated.php";
class User extends Controller
{
    public function __construct()
    {
        $roleValidaitons = new roleValidaiton($_COOKIE["userROLE"], "Student", "/pages");
        $accountValidation = new IsAccountvalidated(Database::getInstance());
        $accountValidation->validateAccount($_COOKIE["userID"]);
        $accountStatus = $accountValidation->getAccountStatus();
        if ($accountStatus == "Inactive") {
            header("Location: user/inactive");
        }
    }
    public function index(){
        $categorie = $this->model("Categorie");
        $categories=$categorie->listCategories()["categories"];
        $data = ["categories"=>$categories];
        $this->view("user/index",[]);
    }
    public function inactive(){
        $this->view("user/inactive");
    }
}
?>