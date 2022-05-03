<?php

class Category{

    public $id;
    public $category;
}

interface CategoryDao{

    public function returnCategories();
    public function findByCategory($category);
}