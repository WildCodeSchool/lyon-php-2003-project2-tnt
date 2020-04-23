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

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function selectAllCategory()
    {
        $query= 'SELECT * FROM ' . self::TABLE ;
        return $this->pdo->query($query)->fetchAll();
    }
}
