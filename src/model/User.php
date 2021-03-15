<?php

namespace app\model;

class User extends Db
{
    protected function tableName() 
    {
        return 'user';
    }

    protected function columns() 
    {        
        return ['user_first', 'user_last', 'user_email', 'user_pwd', 'user_admin'];
    }

    protected function validate($data) 
    {
        if (empty($data['user_first'])) {
            $this->errors['user_first'] = 'Name must be filled!';
        }
        if (empty($data['user_last'])) {
            $this->errors['user_last'] = 'Lastname must be filled!';
        }
        if (empty($data['user_email'])) {
            $this->errors['user_email'] = 'E-mail field must be filled!';
        } else if ( ! filter_var($data['user_email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors['user_email'] = 'E-mail is invalid!';
        } else if ($this->selectOneBy('user_email', $data['user_email'])) {
            $this->errors['user_email'] = 'E-mail is already taken!';
        }
        if ( ! empty($data['password'])) {
            $pass = $data['password'];            
            if (strlen($pass) < 8) {
                $this->errors['user_pwd'] = 'Password must be a minimum 8 characters';
            } else if (!preg_match('/[A-Z]+/', $pass) || !preg_match('/[a-z]+/', $pass) || !preg_match('/[0-9]+/', $pass)) {
                $this->errors['user_pwd'] = 'The password must contain one uppercase, lowercase letter and number!';
            }            
        } else {
            $this->errors['user_pwd'] = 'Password field must be filled!';
        }
        return !$this->errors;
    }
    
    public function authenticate($data)
    {
        if (empty($data['user_email'])) {
            $this->errors['user_email'] = 'E-mail field must be filled!';
        } else if (!filter_var($data['user_email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors['user_email'] = 'E-mail is invalid!';
        }
        if (empty($data['password'])) {
            $this->errors['user_pwd'] = 'Enter your password!';
        }
        if (!$this->errors) {
            $user = $this->selectOneBy('user_email', $data['user_email']);
            if ( ! $user || ! password_verify($data['password'], $user['user_pwd'])) {
                $this->errors['user_email'] = 'Your e-mail or password is incorrect!';
            }
        }
        if (!$this->errors) {
            return $user['user_id'];
        }
        return false;
    }
    
    public static function login($id)
    {
        $_SESSION['userId'] = $id;
    }
    
    public static function logout()
    {
        session_destroy();
    }
    
    public static function getLoggedId()
    {
        if (empty($_SESSION['userId'])) {
            return false;
        }
        return intval($_SESSION['userId']);
    }
    
    private static $loggedUser = null;
    public static function getLoggedUser()
    {
        if (self::$loggedUser === null) {
            $id = self::getLoggedId();
            if (!$id) {
                return [];
            }
            $userDb = new self();
            self::$loggedUser = $userDb->selectOne($id);
        }
        return self::$loggedUser;
    }
    
    public static function isAdmin()
    {
        return self::getLoggedId() && self::getLoggedUser()['user_admin'];
    }
    
    public function register($data) 
    {
        if (!empty($data['password'])) {
            $data['user_pwd'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        $data['user_admin'] = 0;
        return $this->write($data);
    }
    
}
