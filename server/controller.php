<?php


require_once 'connection.php';

//only process the data if there a request was made and the session is active

function is_session_active() {
    return isset($_SESSION) && count($_SESSION) > 0 && time() < $_SESSION['start'] + 60 * 5; //check if it has been 5 minutes
}



function rent($connection,$car_id) {
    
    $query = "UPDATE Car SET Status='2' WHERE ID = '$car_id' AND Customer_ID='" . $_SESSION["username"] . "'";

    $result = mysqli_query($connection, $query);
    if (!$result)
        return "fail";
    return "success";
}



function logout() {
    // Unset all of the session variables.
    $_SESSION = array();

// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]
        );
    }

// Finally, destroy the session.
    session_destroy();
}

?>
