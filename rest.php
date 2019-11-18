<?php
require_once('contants.php');

?>
<?php

class Rest {

protected $request;
protected $serviceName;
public    $param;
public $name;

public function __construct(){
if($_SERVER['REQUEST_METHOD'] == 'POST'){

$this->throwError(REQUEST_METHOD_NOT_VALID, 'Reuqest Method should be POST');

}
$handler = fopen('php://input','r');
   $this->request = stream_get_contents($handler);
   $this->validateRequest($this->request);
    
}

public function validateRequest(){
if($_SERVER["Content-Type: application/json"] == 'application/json'){

$this->throwError(REQUEST_CONTENTTYPE_NOT_VALID,
 'The Content Type is not valid');

}

$data=json_decode($this->request, true);

if(isset($data['name']) || $data['name'] !== ""){
$this->throwError(API_NAME_REQUIRED, "API Name is required ");

}
$this->serviceName = $data['name'];


if(!is_array($data['param']) || $data['param'] !== ""){
    $this->throwError(API_PARAM_REQUIRED, "API Param is needed");
    
    }
    $this->serviceName = $data['param'];
    

}

public function processApi(){

$api = new API;
$rmethod = new reflectionMethod('API',$this->serviceName);
if(!method_exists($api,$this->serviceName)){

$this->throwError(API_DOES_NOT_EXIST,"This API does not exist in our server");

}
$rmethod->invoke($api);

}

public function validateParametters($fieldName, $value, $dataType, $required = true){

    if($required == true && empty($value)== true){

$this->throwError(VALIDATE_PARAMETER_REQUIRED, $fieldName ."parameter is required");

    }

    switch($dataType){

        case BOOLEAN :
        if(!is_bool($value)){
        $this->throwError(VALIDATE_PARAMETER_DATATYPE, "Datatype is not valid for".$fieldName."It should be Boolean");
        }
        break;

        case INTEGER :
        if(!is_numeric($value)){
        $this->throwError(VALIDATE_PARAMETER_DATATYPE, "Datatype is not valid for".$fieldName."It should be Numeric");
        }
        break;


        case STRING :
        if(!is_string($value)){
        $this->throwError(VALIDATE_PARAMETER_DATATYPE, "Datatype is not valid for".$fieldName."It should be String");
        }
        break;

    default;

    }
return $value;

}

public function throwError($code, $message){
    header("Content-Type: application/json; charset=UTF-8");
    $errormessage = json_encode(['Erro Message'=>['status'=>$code, 'message'=>$message]]);

    echo $errormessage;
    exit();


}

public function returnResponse($code, $data){

header("Content-Type: application/json; charset=UTF-8");
$response = json_encode(['resonse' =>['status'=> $code,$data]]);
echo $response; 

exit();

}

}


?>