<?php


namespace App\Model;

class ProductManager extends AbstractManager
{

    /**
     *
     */
    const TABLE = 'product';
    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }



}
