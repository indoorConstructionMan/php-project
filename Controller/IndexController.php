<?php
//require_once("/Model/User.php");

class IndexController extends PHPProject_Controller {

    protected function _is_logged_in() {
        if (isset($_SESSION['chatapp_user']) && $_SESSION['chatapp_user'] instanceof Users_Object) {
            // they are logged in
            return true;
        } else {
            // they are NOT logged in
            return false;
        }
    }

    public function index_action()
    {
        // check if they are logged in or not
        if ($this->_is_logged_in()) {
            // they are logged in, display index view
            $this->_generate_view_path(true);
        } else {
            // they are NOT logged in, redirect them to the login page
            $this->_redirect('login');
        }
    }

    public function login_action()
    {
        // check if they are logged in already or not
        if ($this->_is_logged_in()) {
            // they are logged in, display index view
            $this->_redirect();
            return;
        }

        // are we logging in or viewing the form
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // logging
            $email = $_POST['email'];
            $password = $_POST['password'];

            // try to find a user associated with the email or username provided
            $user_model = new Users();
            $find_result = $user_model->find_by($email);
            
            // check if we found a user
            if ($find_result->success && $find_result->data instanceof Users_Object) {
                // if we did, try to log them in using the password provided
                $login_result = $find_result->data->login($password);
                if ($login_result->success) {
                    // they are now logged in, redirect them to the index page
                    $this->_redirect();
                    return;
                } else {
                    // they failed to login, show login page with error
                    $login_result->data = $_POST;
                    $this->_generate_view_path(true, $login_result);
                }
            } else {
                // we failed to find a user with their email, show login page with error
                $find_result->data = $_POST;
                $this->_generate_view_path(true, $find_result);
            }
        } else {
            // viewing the form
            $this->_generate_view_path(true);
        }
    }

    public function register_action()
    {
        // are we registering or viewing the form
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $user_model = new Users();

            $result = $user_model->register($_POST);
       
            if($result->success) {
                $this->_redirect();
                return;
            }

            $this->_generate_view_path(true, $result);
        } else {
            // viewing the form
            $this->_generate_view_path(true);
        }

    }

    public function logout_action() {
        session_start();

        // Unset all of the session variables.
        $_SESSION = array();

        // If it's desired to kill the session, also delete the session cookie.
        // Note: This will destroy the session, and not just the session data!
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Finally, destroy the session.
        session_destroy();

        // send them to the login page
        $this->_redirect('login');
    }
    
}
