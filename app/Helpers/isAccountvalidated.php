<?php
class IsAccountvalidated{
    private $db;
    private $accountStatus;
    public function __construct(){
        $this->db =Database::getInstance() ;
    }
    public function validateAccount($accountId){
        $query = 'SELECT account_status FROM "User" WHERE id = :accountid';
        $this->db->query($query);
        $this->db->bind(":accountid",$accountId);
        $this->accountStatus = $this->db->single();
    }
    public function getAccountStatus(){
        return $this->accountStatus;
    }
}
?>