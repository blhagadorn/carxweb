<?php
 
class Functions {
 
    private $db;
 
    //put your code here
    // constructor
    function __construct() {
        require_once 'Connect.php';
        // connecting to database
        $this->db = new Connect();
        $this->db->Connect();
    }
 
    // destructor
    function __destruct() {
         
    }
 
    /**
     * Storing new user
     * returns user details
     */
    public function registerUser($email,$first,$last,$phone,$password) {

        $result = mysql_query("INSERT INTO `users`(`email`, `first`, `last`, `phone`, `password`) VALUES ('$email','$first','$last','$phone','$password')");
        // check for successful store
        if ($result) {
            // get user details 
            $lastid = mysql_insert_id(); // last inserted id
            $result = mysql_query("SELECT * FROM users WHERE userid = '$lastid'");
            // return user details
            return mysql_fetch_array($result);
        } else {
            return false;
        }
    }
    
    public function registerMechanic($email,$first,$last,$phone,$password) {

        $result = mysql_query("INSERT INTO `mechanics`(`email`, `first`, `last`, `phone`, `password`) VALUES ('$email','$first','$last','$phone','$password')");
        // check for successful store
        if ($result!=null) {
            // get mechanic details 
            $lastid2 = mysql_insert_id(); // last inserted id
            $result = mysql_query("SELECT * FROM mechanics WHERE mechanicid = '$lastid2'");
            // return user details
            return mysql_fetch_array($result);
        } else {
            return false;
        }
    }
    
 
    /**
     * Get user by email and password
     */
    public function getUserByEmailAndPassword($email, $password) {
        $results = mysql_query("SELECT * FROM mechanics WHERE ('email','password') = ('$email','$password')");
        $results = mysql_query("SELECT * FROM users WHERE ('email','password') = ('$email','$password')");
        $result = mysql_fetch_array($results);
        return $result;

    }

 
    /**
     * Check user is existed or not
     */
    public function isUserExisted($email) {
        $result = mysql_query("SELECT email from users WHERE email = '$email'");
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            // user existed 
            return true;
        } else {
            // user not existed
            return false;
        }
    }
    
    public function isMechanicExisted($email) {
        $result = mysql_query("SELECT email from mechanics WHERE email = '$email'");
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            // user existed 
            return true;
        } else {
            // user not existed
            return false;
        }
    }
 
    /**
     * Encrypting password
     * @param password
     * returns salt and encrypted password
     */
    public function hashSSHA($password) {
 
        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(sha1($password . $salt, true) . $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
        return $hash;
    }
 
    /**
     * Decrypting password
     * @param salt, password
     * returns hash string
     */
    public function checkhashSSHA($salt, $password) {
 
        $hash = base64_encode(sha1($password . $salt, true) . $salt);
 
        return $hash;
    }
 
}
 
?>