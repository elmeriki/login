<?php
class Dbconnecr{

private $server = 'locahost';
private $dbname = 'lindoapi';
private $username ='root';
private $pass='';

public function connect(){

try{

    $conn = new PDO('mysql:host='.$this->server.'; dbname='
     .$this->dbname, $this->username, $this->pass);

$conn->setAttribute(PDO::ATTR_ERRMODE,pdo::ERRMODE_EXCEPTION);
return $conn;


}catch(\Exception $e){

echo " Database Error :". $e->getMessage();

}


}



}
?>