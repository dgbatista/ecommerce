<?php
namespace src\controllers;

use \core\Controller;
use \src\handlers\UserHandler;
use \src\handlers\ProductHandler;
use \src\handlers\CategoryHandler;
use \src\handlers\AddressHandler;
use \src\models\User;
use \src\models\Addresse;

class SiteController extends Controller {

    private $loggedUser;

    public function __construct() {
        $this->loggedUser = UserHandler::checkLogin();      
    }

    public function index() {
        $products = ProductHandler::getProducts();

        $this->render('index', [
            'products' => $products,
            'menuCurrent' => 'home',
            'loggedUser' => $this->loggedUser
        ]);
    }

    public function logout(){
        if(!empty($_SESSION['token'])){
            $_SESSION['token'] = '';
            $this->redirect('/login');
        }
    }

    public function categories($args){
        $idcategory = (int)$args['id'];
        $page = intval(filter_input(INPUT_GET, 'page'));

        $category = CategoryHandler::getCategoryById($idcategory);
        $products = CategoryHandler::getProductsPerPage(true, $idcategory, $page);

        if($category){
            $this->render('category',[
                'category' => $category,
                'products' => $products,
                'page'=> $page
            ]);
        } else {
            $this->redirect('index');
        }      
    }

    public function product($args){
        $desurl = $args['desurl'];

        $product = ProductHandler::getFromURL($desurl);
        $categories = ProductHandler::getCategories($product->idproduct);

        if($product){
            $this->render('detalhes-produto',[
                'product' => $product,
                'categories' => $categories,
                'menuCurrent' => 'products'
            ]);
        } else {
            $this->redirect('index');
        }   
    }

    public function products(){
        echo 'produtos';
    }

    public function checkout(){

        $user = UserHandler::checkLogin();

        if(!$user){
            $this->redirect('/login');
        }

        $person = UserHandler::getUserById($user->iduser);
        
        $address = AddressHandler::getAddressById($person->idperson);

        if(!$address){
            $address = new Addresse();
        }

        $this->render('checkout', [
            'address' => $address,
            'error' => '',
            'loggedUser' => $person
        ]);

    }

    public function login(){
        $flash = '';

        if(isset($_SESSION['flash'])){
            $flash = $_SESSION['flash'];
            $_SESSION['flash'] = NULL;
        }

        $login = filter_input(INPUT_POST, 'login');
        $password = filter_input(INPUT_POST, 'password');
        $error = '';        

        if(isset($login)){
            $login = filter_input(INPUT_POST, 'login');
            $password = filter_input(INPUT_POST, 'password');            
        
            if(!empty($password)){
                try{
                    $user = UserHandler::verifyLogin($login, $password);

                    if(count($user) > 0){
                        $this->redirect('/checkout');
                    }
        
                }catch(Exception $e){
                    $error = throw new \Exception("Usuário inexistente ou senha inválida");
                }
            }else{
                echo 'não entrou';
            } 
        }        

        $this->render('login-site', [
            'error' => $error,
            'flash' => $flash
        ]);
    }

    public function register(){

        $name = filter_input(INPUT_POST, 'name');
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $phone = filter_input(INPUT_POST, 'phone');
        $password = filter_input(INPUT_POST, 'password');

        $user = UserHandler::saveNewPersonUser([
            'inadmin'=>0,
            'desperson'=>$name,
            'desemail'=>$email,
            'nrphone'=>$phone,
            'despassword'=>$password
        ]);

        if(!$user){
            $flash = $_SESSION['flash'];
            $this->redirect('/login');
        }

        print_r($user);
        exit;

        $this->redirect('/checkout');

    }
}