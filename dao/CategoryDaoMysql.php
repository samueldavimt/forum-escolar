<?php

require_once("models/Category.php");


class CategoryDaoMysql implements CategoryDao{

    private $pdo;

    public function __construct(PDO $driver){
        $this->pdo = $driver;
    }

    public function buildCategory($data){

        $category = new Category();
        $category->id = $data['id'];
        $category->name = $data['name'];

        return $category;
    }

    public function returnCategories($limit=false){

        if($limit){
            $stmt = $this->pdo->query("SELECT * FROM categories LIMIT $limit");

        }else{
            $stmt = $this->pdo->query("SELECT * FROM categories");
        }

        $data = $stmt->fetchAll();
        $categories = [];

        foreach($data as $categoryItem){

            $category = $this->buildCategory($categoryItem);
            $categories[] = $category;
        }

        return $categories;

        
    }


    public function findByCategory($category){

        $stmt = $this->pdo->prepare("SELECT * FROM categories WHERE name=:category LIMIT 1");
        $stmt->bindValue(":category",$category);
        $stmt->execute();

        if($stmt->rowCount() > 0){

            $data = $stmt->fetch();
            $category = $this->buildCategory($data);
            return $category;

        }else{
            return false;
        }
    }
}