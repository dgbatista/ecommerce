<?php
namespace src\handlers;

use \src\models\Categorie;

class CategoryHandler {

    private static function categoryArrayToObject($category){

        $categorie = new Categorie();
        $categorie->idcategory = $category['idcategory'];
        $categorie->descategory = $category['descategory'];
        $categorie->dtregister = $category['dtregister'];

        return $categorie;
    }

    public static function getCategories(){
        $data = Categorie::select()->get();
        $categories = [];

        if(count($data)> 0){
            foreach($data as $category){
                $categories[] = self::categoryArrayToObject($category);
            }
        }

        return $categories;
    }

    public static function save($descategory){

        Categorie::insert([
            'descategory'=> $descategory
        ])->execute();

        return true;
    }

    public static function getCategoryById($idcatagory){
        $data = Categorie::select()->where('idcategory', $idcatagory)->one();

        if($data){
            $category = self::categoryArrayToObject($data);

            return $category;
        }

        return false;
    }

    

}