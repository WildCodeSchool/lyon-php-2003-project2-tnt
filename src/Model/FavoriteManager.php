<?php


namespace App\Model;

use PDO;

class FavoriteManager extends AbstractManager
{

    const TABLE = 'Favorite';


    public function addFavorite(array $favorite)
    {

        $query = "INSERT INTO " . $this->table . " (product_id, user_id) VALUES (:product_id, :user_id)";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('product_id', $favorite['product_id'], \PDO::PARAM_INT);
        $statement->bindValue('user_id', $favorite['user_id'], \PDO::PARAM_INT);
        return $statement->execute();
    }
}
