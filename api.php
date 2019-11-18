<?php

class API extends Rest{
public $dbconn;
public function __construct(){
    parent::__construct();
    $db = new Dbconnect;
    $this->dbconn = $db->connect();
    
}

public function generateToken(){

$email = $this->validateParametters('email', $this->param['email'],

STRING);

$pass = $this->validateParametters('pass', $this->param['pass'],

STRING);

$stmt = $this->dbconn->prepare("SELECT * FROM api_users WHERE email =:email AND password =:pass");
$stmt->bindparam(":email", $email);
$stmt->bindparam(":pass", $pass);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
if(!is_array($user)){

$this->returnResponse(INVALID_USER_PASS, "Email or password is not correct");

}

}


}


?>