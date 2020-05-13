<?php


namespace App\Model;

use mysql_xdevapi\Exception;
use PDO;

class FavoriteManager extends AbstractManager
{

    const TABLE = 'favorite';

    public function selectAllFavorite(string $id){
            $query = "SELECT f.product_id, f.user_id 
                FROM favorite AS f  
                JOIN product as p ON f.product_id = p.id 
                WHERE f.user_id= :id";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue('id', $id, \PDO::PARAM_STR);

            if ($statement->execute()){
                return $statement->fetch();
            }
            return 'liste vide';
    }


    public function addFavorite(array $favorite)
    {

        $query = "INSERT INTO " . $this->table . " (product_id, user_id) VALUES (:product_id, :user_id)";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('product_id', $favorite['product_id'], \PDO::PARAM_INT);
        $statement->bindValue('user_id', $favorite['user_id'], \PDO::PARAM_INT);
        return $statement->execute();
    }
}
