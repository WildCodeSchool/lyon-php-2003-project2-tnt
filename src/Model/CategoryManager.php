<?php

namespace App\Model;

class CategoryManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'category';
    /**
     *  Initializes this class.
     */

    private $category = [];

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function selectAllCategory()
    {
        $query= 'SELECT name FROM ' . self::TABLE ;
        $statement = $this->pdo->query($query);
        return $this->category = $statement->fetchAll();
    }
}
