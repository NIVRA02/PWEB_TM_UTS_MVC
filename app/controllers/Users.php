<?php


class Users {
    private $userModel;

    public function __construct(){

        require_once '../app/models/User.php';
        $this->userModel = new User();
    }

    public function register(){

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
           $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'name_err' => '', 'email_err' => '', 'password_err' => '', 'confirm_password_err' => ''
            ];


            if(empty($data['name'])){ $data['name_err'] = 'Please enter name'; }
            if(empty($data['email'])){ $data['email_err'] = 'Please enter email'; }
            if($this->userModel->findUserByEmail($data['email'])){ $data['email_err'] = 'Email is already taken'; }
            if(empty($data['password'])){ $data['password_err'] = 'Please enter password'; } elseif(strlen($data['password']) < 6){ $data['password_err'] = 'Password must be at least 6 characters'; }
            if(empty($data['confirm_password'])){ $data['confirm_password_err'] = 'Please confirm password'; } else { if($data['password'] != $data['confirm_password']){ $data['confirm_password_err'] = 'Passwords do not match'; }}


            if(empty($data['name_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])){

                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                if($this->userModel->register($data)){
                    redirect('users/login');
                } else {
                    die('Something went wrong');
                }
            } else {
                $this->loadView('users/register', $data);
            }

        } else {

            $data = ['name' => '', 'email' => '', 'password' => '', 'confirm_password' => '', 'name_err' => '', 'email_err' => '', 'password_err' => '', 'confirm_password_err' => ''];
            $this->loadView('users/register', $data);
        }
    }

    public function login(){

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
             $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_err' => '', 'password_err' => '',
            ];

            if(empty($data['email'])){ $data['email_err'] = 'Please enter email'; }
            if(empty($data['password'])){ $data['password_err'] = 'Please enter password'; }
            
            if($this->userModel->findUserByEmail($data['email'])){

            } else {
                $data['email_err'] = 'No user found';
            }

            if(empty($data['email_err']) && empty($data['password_err'])){
                $loggedInUser = $this->userModel->login($data['email'], $data['password']);
                if($loggedInUser){
                    $this->createUserSession($loggedInUser);
                } else {
                    $data['password_err'] = 'Password incorrect';
                    $this->loadView('users/login', $data);
                }
            } else {
                $this->loadView('users/login', $data);
            }

        } else {

            $data = ['email' => '', 'password' => '', 'email_err' => '', 'password_err' => ''];
            $this->loadView('users/login', $data);
        }
    }
    
    public function createUserSession($user){
        session_start();
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_name'] = $user->name;
        redirect('pages/index'); 
    }

    public function logout(){
        session_start();
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        session_destroy();
        redirect('users/login');
    }


    public function loadView($view, $data = []){
        if(file_exists('../app/views/' . $view . '.php')){
            require_once '../app/views/' . $view . '.php';
        } else {
            die('View does not exist');
        }
    }
}