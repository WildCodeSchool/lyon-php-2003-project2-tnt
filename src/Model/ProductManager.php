<?php


namespace App\Model;

use PDO;

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
     * @param int $userId
     * @param int $productTypeId
     * @return int
     */
    public function insert(array $product, int $userId, int $productTypeId): int
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " " .
            "(`title`,`description`,`user_id`,`product_type_id`,`exchange_type_id`,
            `img`,`category_id`,`etat`,`proposition`)
            VALUES (:title,:description,:user_id,:product_type_id,:exchange_type_id,
            :fileName, :category_id,:etat,:proposition)");
        $statement->bindValue('title', $product['title'], \PDO::PARAM_STR);
        $statement->bindValue('description', $product['description'], \PDO::PARAM_STR);
        $statement->bindValue('user_id', $userId, \PDO::PARAM_INT);
        $statement->bindValue('product_type_id', $productTypeId, \PDO::PARAM_INT);
        $statement->bindValue('exchange_type_id', $product['exchange_type_id'], \PDO::PARAM_STR);
        $statement->bindValue('fileName', $product['fileName'], \PDO::PARAM_STR);
        $statement->bindValue('category_id', $product['category_id'], \PDO::PARAM_STR);
        $statement->bindValue('etat', $product['etat'], \PDO::PARAM_STR);
        $statement->bindValue('proposition', $product['fullProp'], \PDO::PARAM_STR);


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

    public function update(array $product): bool
    {
        // prepared request
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET `title` = :title WHERE id=:id");
        $statement->bindValue('id', $product['id'], \PDO::PARAM_INT);
        $statement->bindValue('title', $product['title'], \PDO::PARAM_STR);

        return $statement->execute();
    }

    public function selectAllCategories(): array
    {
        return $this->pdo->query('SELECT * FROM category WHERE parent_id IS NULL')->fetchAll();
    }

    /**
     * Recupère tous les biens OU services
     * @param int $productType
     * Bien    -> $productType = 1
     * @return array
     */
    public function selectAll(int $productType): array
    {
        $query = "SELECT product.id, product.title, product.description, product.exchange_type_id, product.img, 
                   product.etat, product.created_at,exchange_type.deal_type FROM " . $this->table .
                 " JOIN user ON user.id = product.user_id 
                   JOIN product_type ON product_type.id = product.product_type_id
                   JOIN exchange_type ON exchange_type.id = product.exchange_type_id
                   WHERE product_type_id = :productType";

        $state = $this->pdo->prepare($query);
        $state->bindValue(':productType', $productType, \PDO::PARAM_INT);
        $state->execute();
        return $state->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param string $search
     * @param int $category
     * @param int $productType
     * @return array
     */
    public function search(string $search, int $category, int $productType): array
    {
        $query = "SELECT * FROM ". $this->table .
                " /*JOIN category ON category.id = product.category_id 
                  JOIN product_type ON product_type.id =product.product_type_id
                  */WHERE /*category.id =". $category ." AND product.product_type_id = :productType 
                  AND */product.title LIKE '%". $search ."%'";

        $state = $this->pdo->prepare($query);
        $state->bindValue(':productType', $productType, \PDO::PARAM_INT);
        $state->execute();
        return $state->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Get all details from an ad
     *
     * @param string $productId
     * @return array
     */
    public function getDetails(string $productId): array
    {
        $query = "SELECT p.id, p.img, p.title, p.description, p.created_at, p.etat,
                  p.proposition, p.enEchangeDe, x.deal_type, 
                         /*etat.title, */category.name, user.email, user.nickname, user.zip_code, pt.name  
                  FROM product AS p 
                  JOIN exchange_type as x ON p.exchange_type_id = x.id 
                  JOIN product_type as pt ON pt.id = p.product_type_id     
                  /*JOIN etat ON p.etat_id = etat.id */
                  JOIN category ON p.category_id = category.id 
                  JOIN user ON p.user_id = user.id 
                  WHERE p.id = :id";
        $state = $this->pdo->prepare($query);
        $state->bindValue('id', $productId, \PDO::PARAM_STR);
        $state->execute();

        return $state->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function userId(int $idProduct)
    {
        $query = "SELECT user_id FROM " . $this->table . " WHERE product.id= :idProduct";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':idProduct', intval($idProduct), \PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetch();
    }
}
