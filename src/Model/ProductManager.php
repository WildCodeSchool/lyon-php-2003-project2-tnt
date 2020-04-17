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

    /**
     * Recupère tout depuis les tables product / .
     *
     * @return array
     */
    public function selectAll(): array
    {
        return $this->pdo->query('SELECT * FROM ' . $this->table . ' JOIN user ON user.id = product.user_id JOIN product_type ON product_type.id = product.product_type_id JOIN exchange_type ON exchange_type.id =product.exchange_type_id HAVING product_type_id="1"')->fetchAll();
    }
}
