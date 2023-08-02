<?php
namespace src\handlers;

use \src\models\User;
use \src\models\Person;

class UserHandler {

    public static function checkLogin() {
        if(!empty($_SESSION['token'])) {
            $token = $_SESSION['token'];

            $data = User::select()->where('token', $token)->one();
            if(count($data) > 0) {

                $loggedUser = new User();
                $loggedUser->iduser = $data['iduser'];
                $loggedUser->deslogin = $data['deslogin'];
                $loggedUser->inadmin = $data['inadmin'];
                $loggedUser->token = $data['token'];

                return $loggedUser;
            }
        }

        return false;
    }
    public static function verifyLogin($login, $password){

        $user = User::select()->where('deslogin', $login)->one();
        $dataUser = [];

        if($user){
            if(password_verify($password, $user['despassword'])){
                $dataUser['admin'] = $user['inadmin'];

                $dataUser['token'] = md5(time().rand(0,9999).time());

                User::update()
                    ->set('token', $dataUser['token'])
                    ->where('deslogin', $login)
                ->execute();

                return $dataUser;
            }
        }

        return false;
    }

    public static function getAllUsers(){
        $userList = User::select()
            ->join('persons', 'users.iduser', '=' , 'persons.idperson')
            ->orderBy('deslogin')
        ->get();
        $users = [];

        if($userList) {
            foreach($userList as $data){
            
                $user = new User();
                $user->iduser = $data['iduser'];
                $user->idperson = $data['idperson'];
                $user->deslogin = $data['deslogin'];
                $user->inadmin = $data['inadmin'];
                $user->dtregisterty = $data['dtregister'];
                $user->desperson = $data['desperson'];
                $user->desemail = $data['desemail'];
                $user->nrphone = $data['nrphone'];
    
                $users[] = $user;
            }

            return $users;
        }
        return false;
    }

    public static function validateEmail($email){
        $user = Person::select()->where('desemail', $email)->get();

        if(count($user) > 0){
            return $user;
        }
        
        return false;
    }

    public static function validateLogin($login){
        $user = User::select()->where('deslogin', $login)->get();

        if(count($user) > 0){
            return $user;
        }
        
        return false;
    }


 
}