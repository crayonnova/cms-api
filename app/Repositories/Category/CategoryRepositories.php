<?php
namespace App\repositories\Category;

use App\repositories\CategoryInterface as CategoryInterface;
use App\Category;

class CategoryRepository implements CategoryInterface{
    public $category;

    function __construct(Category $category)
    {
        $this->category = $category;
    }
}