<?php


namespace App\Model;

class UserManager extends AbstractManager
{
    const TABLE = 'user';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    /**
     * @param array $infos
     * @return int
     */
    public function createProfil(array $infos): int
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (`nickname`,`email`,`password`)
                                                   VALUES (:nickname, :email, :password)");
        $statement->bindValue('nickname', $infos['nickname'] , \PDO::PARAM_STR);
        $statement->bindValue('email', $infos['email'], \PDO::PARAM_STR);
        $statement->bindValue('password', $infos['pass'], \PDO::PARAM_STR);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }
}




