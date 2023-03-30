<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;
    use Model\Managers\UserManager;

    class UserManager extends Manager{

        protected $className = "Model\Entities\User";
        protected $tableName = "user";


        public function __construct(){
            parent::connect();
        }


        public function updateUserStatus($userId, $newStatus) {
            $sql = "
                UPDATE user
                SET status = :newStatus
                WHERE id_user = :userId
            ";

            return $this->getOneOrNullResult(
                DAO::update($sql, ['userId' => $userId, 'newStatus' => $newStatus], false), 
                $this->className
            );
        }


        public function updateUserRole($userId, $newRole) {
            $sql = "
                UPDATE user
                SET role = :newRole
                WHERE id_user = :userId
            ";

            return $this->getOneOrNullResult(
                DAO::update($sql, ['userId' => $userId, 'newRole' => $newRole], false), 
                $this->className
            );
        }


        public function findOneByMail($email){

            $sql = "SELECT *
                    FROM ".$this->tableName."
                    WHERE email = :email
                    ";

            return $this->getOneOrNullResult(
                DAO::select($sql, ['email' => $email], false), 
                $this->className
            );
        }


        public function findOneByUsername($username){

            $sql = "SELECT *
                    FROM ".$this->tableName."
                    WHERE username = :username
                    ";

            return $this->getOneOrNullResult(
                DAO::select($sql, ['username' => $username], false), 
                $this->className
            );
        }


        public function retrievePassword($email) {
            $sql = "SELECT password
                    FROM ".$this->tableName."
                    WHERE email = :email
                    ";

            return $this->getOneOrNullResult(
                DAO::select($sql, ['email' => $email], false), 
                $this->className
            );
        }



    }