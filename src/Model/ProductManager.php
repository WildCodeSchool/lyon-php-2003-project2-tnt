<?php


namespace App\Model;

class ProductManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'product';
    /**
     * ProductManager constructor.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }
    
    /**
     * @param array $product
     * @return int
     */
    public function insert(array $product): int
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (`title`) VALUES (:title)");
        $statement->bindValue('title', $product['title'], \PDO::PARAM_STR);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }

    /**
     * @param int $id
     */
    public function delete(int $id): void
    {
        // prepared request
        $statement = $this->pdo->prepare("DELETE FROM " . self::TABLE . " WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * @param array $product
     * @return bool
     */

    public function update(array $product):bool
    {
        // prepared request
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET `title` = :title WHERE id=:id");
        $statement->bindValue('id', $product['id'], \PDO::PARAM_INT);
        $statement->bindValue('title', $product['title'], \PDO::PARAM_STR);

        return $statement->execute();
    }

    /**
     * Recupère tout depuis les tables product / .
     *
     * @return array
     */
    public function selectAllProduct(): array
    {
        return $this->pdo->query('SELECT * FROM ' . $this->table .
                             ' JOIN user ON user.id = product.user_id 
                                 JOIN product_type ON product_type.id = product.product_type_id
                                 JOIN exchange_type ON exchange_type.id =product.exchange_type_id
                                 HAVING product_type_id=1')->fetchAll();
    }

    /**
     * Recupère tout depuis les tables product / .
     *
     * @return array
     */
    public function selectAllService(): array
    {
        return $this->pdo->query('SELECT * FROM ' . $this->table .
        ' JOIN user ON user.id = product.user_id 
                                 JOIN product_type ON product_type.id = product.product_type_id
                                 JOIN exchange_type ON exchange_type.id =product.exchange_type_id
                                 HAVING product_type_id="2"')->fetchAll();
    }

    /**
     * @param array $product
     * @return string
     */
    public function insertProduct($product) :string
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE .
            " ('user_id','title','category_id','etat','description',
            'exchange_type_id','product_type_id','enEchangeDe','proposition')
        VALUES ( :user_id, :title, :category_id, :etat, :description,
         :exchange_type_id, :product_type_id, :enEchangeDe, :proposition)");

        $statement->bindValue(':user_id', $product['user_id']);
        $statement->bindValue(':title', $product['title']);
        $statement->bindValue(':category_id', $product['category_id']);
        $statement->bindValue(':etat', $product['etat']);
        $statement->bindValue(':description', $product['description']);
        $statement->bindValue(':exchange_type_id', $product['exchange_type_id']);
        $statement->bindValue(':product_type_id', $product['product_type_id']);
        $statement->bindValue(':enEchangeDe', $product['enEchangeDe']);
        $statement->bindValue(':proposition', $product['proposition']);

        if ($statement->execute()) {
            return $this->pdo->lastInsertId();
        }
    }

    public function searchService(string $search, string $category) : array
    {
        $query = 'SELECT * FROM '. $this->table .
                ' JOIN category ON category.id = product.category_id 
                  JOIN exchange_type ON exchange_type.id =product.exchange_type_id
                  WHERE category.id ='. $category .' AND product.exchange_type_id = 2 
                  AND product.title LIKE "%'. $search .'%" ';
        return $this->pdo->query($query)->fetchAll();
    }
}
