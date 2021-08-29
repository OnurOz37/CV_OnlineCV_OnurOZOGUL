<?php 

$array = array("firstname" =>"", "name"=>"","email" =>"","tel" =>"","message" =>"","firstnameError" =>"","nameError" =>"","emailError" =>"","telError" =>"","messageError" =>"",
"isSuccess" => false);



$emailTo = "onurozogul1@gmail.com"; 

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $array["firstname"] = verifyInput($_POST["firstname"]); 
    $array["name"]=verifyInput( $_POST["name"]); 
    $array["email"] =verifyInput( $_POST["email"]); 
    $array["tel"] =verifyInput( $_POST["tel"]); 
    $array["message"] =verifyInput( $_POST["message"]); 
    $array["isSuccess"]=true; 
    $emailText = "";

    if(empty($array ["firstname"]))
    {
        $array["firstnameError"] = "Veuillez entrer votre prénom svp.";
        $array["isSuccess"]=false;
    }
    else
    {
        $emailText .= "firstname: {$array["firstname"]}  \n";
    }
    if(empty($array["name"]))
    {
        $array["nameError"] = "Veuillez entrer votre nom svp.";
        $array["isSuccess"]=false;
    }
    else
    {
        $emailText .= "name: {$array["name"]}\n";
    }
    if(empty($array["message"]))
    {
        $array["messageError"] = "Veuillez entrer votre message svp. ";
        $array["isSuccess"]=false;
    }
    else
    {
        $emailText .= "message: {$array["message"]}\n";
    }
    if (!isEmail($array["email"]))
    {
        $array["emailError"] = "Veuillez entrer un email valide svp. ";
        $array["isSuccess"]=false;
    }
    else
    {
        $emailText .= "email: {$array["email"]}\n";
    }
    if (!isTel($array["tel"]))
    {
        $array["telError"] = "Veuillez entrer que des chiffres et des espaces svp. ";
        $array["isSuccess"]=false;
    }
    else
    {
        $emailText .= "tel: {$array["tel"]}\n";
    }
    if($array["isSuccess"])
    {
        $headers = "From: {$array["firstname"]} {$array["name"]} <{$array["email"]}>\r\nReply-To: {$array["email"]}"; 
        //envoie de l'email
        mail($emailTo, "Vous avez un message", $emailText, $headers);
        

    }

    echo json_encode($array); 
}


function isTel($var)
{
    return preg_match("/^[0-9 ]*$/", $var);
}
function isEmail($var)
{
    return filter_var($var, FILTER_VALIDATE_EMAIL); //cette fonction va permettre de comparer notre mail a un filtre de validation de email
}

function verifyInput ($variable)
{
    $variable = trim($variable);
    $variable = stripslashes($variable);
    $variable= htmlspecialchars($variable); 
    return $variable; 
}



?>