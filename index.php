<?php

if (isset($_POST['tag']) && $_POST['tag'] != '') {
    // get tag
    $tag = $_POST['tag'];
 
    require_once 'Functions.php';
    $db = new Functions();

    $response = array("tag" => $tag, "success" => 0, "error" => 0);

    if ($tag == 'registerUser') { 
  
        $email = $_POST['email'];
        $first = $_POST['first'];
        $last = $_POST['last'];
        $phone = $_POST['phone'];
        $password = $_POST['password'];
 	
 	       
        if ($db->isUserExisted($email) == true) {
            $user = $db->registerUser($email, $first, $last, $phone, $password);
            //user already exists
            $response["success"] = 0;
            $response["userid"] = $user["userid"];
            $response["error"] = 1;
            $response["error_msg"] = "Email already exists!";
            echo json_encode($response);
        }
        else if ($db->isMechanicExisted($email) == true) {
            $user = $db->registerMechanic($email, $first, $last, $phone, $password);
            //user already exists
            $response["success"] = 0;
            $response["userid"] = $user["mechanicid"];
            $response["error"] = 1;
            $response["error_msg"] = "Email already exists!";
            echo json_encode($response);
        }
        else {
            
            if ($user) {
                // user stored successfully
                $response["success"] = 1;
                	$response["userid"] = $user["userid"];
                $response["user"]["first"] = $user["first"];
                $response["user"]["last"] = $user["last"];
                $response["user"]["email"] = $user["email"];
                $response["user"]["phone"] = $user["phone"];
                
                	echo json_encode($response);
            } else {
                // user failed to store
                $response["error"] = 1;
                $response["error_msg"] = "Error occured in registration";
                echo json_encode($response);
            }
      }
   }
   else if ($tag == 'registerMechanic') {   
        $email = $_POST['email'];
        $first = $_POST['first'];
        $last = $_POST['last'];
        $phone = $_POST['phone'];
        $password = $_POST['password'];
        if ($db->isMechanicExisted($email) == true) {
            //user already exists
            $response["success"] = 0;
            $response["userid"] = $user["mechanicid"];
            $response["error"] = 1;
            $response["error_msg"] = "Email already exists!";
            echo json_encode($response);
        }
        else if ($db->isUserExisted($email) == true) {
            //user already exists
            $response["success"] = 0;
            $response["userid"] = $user["userid"];
            $response["error"] = 1;
            $response["error_msg"] = "Email already exists!";
            echo json_encode($response);
        }
        else {
            $user = $db->registerMechanic($email, $first, $last, $phone, $password);
            if ($user) {
                // user stored successfully
                $response["success"] = 1;
                	$response["mechanicid"] = $user["mechanicid"];
                $response["user"]["first"] = $user["first"];
                $response["user"]["last"] = $user["last"];
                $response["user"]["email"] = $user["email"];
                $response["user"]["phone"] = $user["phone"];
                
                	echo json_encode($response);
            } else {
                // user failed to store
                $response["error"] = 1;
                $response["error_msg"] = "Error occured in registration";
                echo json_encode($response);
            }
      }
   } else if ($tag == 'login') {
   	    $email = $_POST['email'];
        $password = $_POST['password'];
   	    $user = $db->getUserByEmailAndPassword($email, $password);
        if ($user =!null) {
            if ($password === $user["password"]) {
                $response["success"] = 1;
            }
            else if ($user["mechanicid"] != null) {
                $response["user"]["mechanicid"] = $user["mechanicid"];
            } else {
                $response["user"]["userid"] = $user["userid"];
            }

                $response["success"] = 0;
                $response["error"] = 1;
                $response["error_msg"] = "Bad password";
                echo json_encode($response);

        } else{
            $response["success"] = 0;
            $response["error"] = 1;
            $response["error_msg"] = "Bad email";
            echo json_encode($response);
        }
       
   
   }
    
    
 }
?>