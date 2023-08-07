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
            ->join('persons', 'users.idperson', '=' , 'persons.idperson')
            ->orderBy('desperson')
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


    public static function savePerson($desperson, $desemail, $nrphone){
        Person::insert([
            'desperson'=>$desperson,
            'desemail'=>$desemail,
            'nrphone'=>$nrphone
        ])->execute();

        $person = Person::select()->where('desemail', $desemail)->one();
        if($person){
            return $person;
        }
        return false;
    }

    public static function saveUser($idperson, $deslogin, $despassword, $inadmin = 0 ){
        User::insert([
            'idperson'=>$idperson,
            'deslogin'=>$deslogin,
            'despassword'=>$despassword
        ])->execute();

        $user  = User::select()->where('deslogin', $deslogin)->one();  
        if($user){
            return $user;
        }    
        return false;
    }

    public static function getUserById($iduser){
        $data = User::select()
            ->where('iduser', $iduser)
            ->join('persons', 'users.idperson', '=' , 'persons.idperson')
            ->orderBy('deslogin')
        ->one();

        $user = self::transformArrayToUser($data);

        return $user;
    }

    public static function getPersonById($idperson){
        $data = Person::select()
            ->where('idperson', $idperson)
        ->one();

        if($data){
            $user = $user = new User($data);
            $user->idperson = $data['idperson'];
            $user->desperson = $data['desperson'];
            $user->desemail = $data['desemail'];
            $user->nrphone = $data['nrphone'];
            $user->dtregister = $data['dtregister'];
            
            return $user;
        }      

        return false;;
    }



    /**Auxiliar*/
    private static function transformArrayToUser($data = []){

        if($data){
            $user = new User();

            $user->iduser = $data['iduser'];
            $user->deslogin = $data['deslogin'];
            $user->despassword = $data['despassword'];
            $user->idperson = $data['idperson'];
            $user->desperson = $data['desperson'];
            $user->desemail = $data['desemail'];
            $user->nrphone = $data['nrphone'];
            $user->inadmin = $data['inadmin'];
            $user->dtregister = $data['dtregister'];

            return $user;
        }

        return $data;
    }

    public static function updateUserPerson($user){

        try{
            User::update([
                    'deslogin' => $user->deslogin,
                    'despassword' => $user->despassword,
                    'inadmin' => $user->inadmin
                ])->where('iduser', $user->iduser)
            ->execute();

            Person::update([
                    'desperson' => $user->desperson,
                    'desemail' => $user->desemail,
                    'nrphone' => $user->nrphone
                ])->where('idperson', $user->idperson)
            ->execute();
        }catch(Exception $e){
            echo 'Exceção capturada: ', $e->getMessage(), "\n";
        }

        return true;
    }

    public static function deleteUser($iduser){

        $user = User::select()->where('iduser', $iduser)->execute();

        if(count($user)> 0){
            User::delete()->where('iduser',$user[0]['iduser'])->execute();
            Person::delete()->where('idperson',$user[0]['idperson'])->execute();
        }
    }
 
}