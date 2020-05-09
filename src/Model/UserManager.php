<?php


namespace App\Model;

use PDO;

class UserManager extends AbstractManager
{
    protected $table = 'user';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct($this->table);
    }

    public function selectOneByEmail($mail)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE email=:email";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('email', $mail, PDO::PARAM_STR);

        if ($statement->execute()) {
            return $statement->fetch();
        }
        return '1';
    }

    public function selectOneByNickname($nickname)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE nickname=:nickname";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('nickname', $nickname, PDO::PARAM_STR);

        if ($statement->execute()) {
            return $statement->fetch();
        }
        return null;
    }

    /**
     * @param array $infos
     *
     */
    public function createProfil(array $infos)
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO user (`nickname`,`email`,`password`,`zip_code`) 
                                                   VALUES (:nickname, :email, :password, :zip_code)");
        $statement->bindValue('nickname', $infos['nickname'], PDO::PARAM_STR);
        $statement->bindValue('email', $infos['email'], PDO::PARAM_STR);
        $statement->bindValue('password', $infos['pass'], PDO::PARAM_STR);
        $statement->bindValue('zip_code', $infos['zipCode'], PDO::PARAM_STR);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
        return null;
    }

    public function userProduct($id)
    {
        $query= "SELECT * FROM product having user_id = :id";

        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':id', $id, \PDO::PARAM_STR);

        if ($statement->execute()) {
            return $statement->fetchAll();
        }
        return null;
    }

    /**
     * @param array $user
     */
    public function update(array $user):void
    {
        $statement = $this->pdo->prepare("UPDATE " . $this->table .
            " SET lastname = :lastname, firstname= :firstname, email = :email, 
            phone = :phone, zip_code = :zip_code where user.id = :id");
        $statement->bindValue(':lastname', $user['lastname'], \PDO::PARAM_STR);
        $statement->bindValue(':firstname', $user['firstname'], \PDO::PARAM_STR);
        $statement->bindValue(':email', $user['email'], \PDO::PARAM_STR);
        $statement->bindValue(':phone', $user['phone'], \PDO::PARAM_STR);
        $statement->bindValue(':zip_code', $user['zip_code'], \PDO::PARAM_STR);
        $statement->bindValue(':id', $user['id'], \PDO::PARAM_INT);

        $statement->execute();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function selectUserById(int $id)
    {
        $statement = $this->pdo->prepare("SELECT * FROM " . $this->table . " WHERE user.id = :id");
        $statement->bindValue(':id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }
}
