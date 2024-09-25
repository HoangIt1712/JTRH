<?php 
function is_admin(){
    $user = isset($_SESSION["user"])?$_SESSION["user"]:null;
    if($user == null || $user["role"] != "ADMIN"){
        return false;
    }
    return true;
}

function currentUser() {
    $user = isset($_SESSION["user"])?$_SESSION["user"]:null;
    return $user;
}