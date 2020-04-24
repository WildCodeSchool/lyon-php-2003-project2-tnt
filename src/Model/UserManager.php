<?php


namespace App\Model;

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
        $statement->bindValue('email', $mail, \PDO::PARAM_STR);

        if ($statement->execute()) {
            return $statement->fetch();
        }
        return null;
    }

    public function selectAllEmails()
    {
        $query = "SELECT user.email FROM ". $this->table;
        return $this->pdo->query($query)->fetchAll();
    }

    public function selectOneByNickname($nickname)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE nickname=:nickname";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('nickname', $nickname, \PDO::PARAM_STR);

        if ($statement->execute()) {
            return $statement->fetch();
        }
        return null;
    }

    public function selectAllNickname()
    {
        $query = "SELECT user.nickname FROM ". $this->table;
        return $this->pdo->query($query)->fetchAll();
    }


    /**
     * @param array $infos
     * @return int
     */
    public function createProfil(array $infos)
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO " . $this->table . " (`nickname`,`email`,`password`) 
                                                   VALUES (:nickname, :email, :password)");
        $statement->bindValue('nickname', $infos['nickname'], \PDO::PARAM_STR);
        $statement->bindValue('email', $infos['email'], \PDO::PARAM_STR);
        $statement->bindValue('password', $infos['pass'], \PDO::PARAM_STR);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }
}
