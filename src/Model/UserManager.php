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

    public function selectOneByEmail($mail)
    {
        $query = "SELECT * FROM " . self::TABLE . " WHERE email=:email";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('email', $mail, \PDO::PARAM_STR);

        if ($statement->execute()) {
            return (array)$statement->fetchAll(\PDO::FETCH_ASSOC);
        }
    }

    public function selectOneByNickname($nickname)
    {
        $query = "SELECT * FROM " . self::TABLE . " WHERE nickname=:nickname";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('nickname', $nickname, \PDO::PARAM_STR);

        if ($statement->execute()) {
            return (array)$statement->fetchAll(\PDO::FETCH_ASSOC);
        }
        return "Nom inconnu";
    }


    /**
     * @param array $infos
     * @return int
     */
    public function createProfil(array $infos)
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (`nickname`,`email`,`password`) 
                                                   VALUES (:nickname, :email, :password)");
        $statement->bindValue('nickname', $infos['nickname'], \PDO::PARAM_STR);
        $statement->bindValue('email', $infos['email'], \PDO::PARAM_STR);
        $statement->bindValue('password', $infos['pass'], \PDO::PARAM_STR);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }
}
