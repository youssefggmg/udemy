<?php

class RoleValidaiton
{
    private $role = null;
    public function __construct($role="none", $allowdRole="none", $loginPath="")
    {
        if ($role != $allowdRole) {
            header("Location: $loginPath");
        }
    }
    public function setRole($role)
    {
        $this->role = $role;
    }
    public function getRole()
    {
        return $this->role;
    }
    public function redirect($roleHome){
        header("Location: $roleHome");
        exit;
    }
}
?>