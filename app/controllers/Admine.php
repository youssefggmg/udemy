<?php
include "../app/Helpers/roleValidaiton.php";
include "../app/Helpers/isAccountvalidated.php";
class Admine extends Controller
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
    public function inactive()
    {
        $this->view("/admine/inactive");
    }
    public function index(){
        $categorie = $this->model("Categorie");
        $categories=$categorie->listCategories()["categories"];
        $data = ["categories"=>$categories];
        $this->view("user/index",);
    }
}
?>