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


        // public function countByEmail($email) {
        //     $sql = "
        //     SELECT COUNT(*) FROM ".$this->tableName . " u
        //     WHERE u.email = :email
        //     ORDER BY u.id_user DESC
        //     ";

        //     return $this->getOneOrNullResult(
        //         DAO::select($sql, ['email' => $email], false),
        //         $this->className
        //     );
        // }

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