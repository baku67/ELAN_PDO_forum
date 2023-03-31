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

        public function findAllAndCount() {
            $sql = "
                SELECT u.id_user, u.username, u.password, u.email, u.role, u.signInDate, u.status, COUNT(l.id_liking_post) AS likesCount
                FROM user u
                LEFT JOIN liking_post l ON l.user_id = u.id_user
                GROUP BY u.id_user
                ORDER BY u.signInDate DESC
            ";

            return $this->getMultipleResults(
                DAO::select($sql),
                $this->className
            );
        }

        public function findOneByIdAndCount($userId) {
            $sql = "
                SELECT u.id_user, u.username, u.password, u.email, u.role, u.signInDate, u.status, COUNT(l.id_liking_post) AS likesCount
                FROM user u
                LEFT JOIN liking_post l ON l.user_id = u.id_user
                WHERE u.id_user = :userId
            ";

            return $this->getOneOrNullResult(
                DAO::select($sql, ['userId' => $userId], false), 
                $this->className
            );
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