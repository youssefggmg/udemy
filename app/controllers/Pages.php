<?php
class Pages extends Controller
{
    public function index()
    {
        $data = [];
    
        $userModel = $this->model("User");
        if (isset($_POST["email"], $_POST["password"])) {
            $result = $userModel->logIn($_POST["email"], $_POST["password"]);
            if ($result["status"] == 0) {
                $data[] = $result["message"];
                $this->view("index", $data);
            }else {
                $result=$result["message"];
                setcookie("userID", $result->__get("id"), time() + 86400, "/");
                setcookie("userROLE", $result->__get("user_type"), time() + 86400, "/");
                header("location: /YoudmyMVC/User");
            }
        }
    } 
    public function sign()
    {
        $this->view("signup");
    }
    public function signUP()
    {
        $userModel = $this->model("User");
        $result = $userModel->signUp($_POST["username"], $_POST["email"], $_POST["password"], $_POST["user_type"]);
        if ($result["status"] == 0) {
            $data = ["error" => $result["message"]];
            $this->view("signup", $data);
        } else {
            $result = $result["message"];
            setcookie("userID", $result->__get("id"), time() + 86400, "/");
            setcookie("userROLE", $result->__get("user_type"), time() + 86400, "/");
            header("location: /YoudmyMVC/user");
        }
    }
}