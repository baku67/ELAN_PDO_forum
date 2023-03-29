<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;
    use Model\Managers\PostManager;

    class PostManager extends Manager{

        protected $className = "Model\Entities\Post";
        protected $tableName = "post";


        public function __construct(){
            parent::connect();
        }

        public function findByTopicId($id) {
            $sql = "
            SELECT * FROM ".$this->tableName . " p
            WHERE p.topic_id = :id
            ORDER BY p.creationdate DESC";

            return $this->getMultipleResults(
                DAO::select($sql, ['id' => $id]),
                $this->className
            );

        }


        public function getUserMsgList($userId) {
            $sql = "
            SELECT * FROM ".$this->tableName . " 
            WHERE user_id = :id
            ORDER BY creationdate DESC
            LIMIT 100
            ";

            return $this->getMultipleResults(
                DAO::select($sql, ['id' => $userId]),
                $this->className
            );
        }

        // public function countUserMsgList($userId) {
        //     $sql = "
        //     SELECT COUNT(*) FROM ".$this->tableName . " 
        //     WHERE user_id = :id
        //     ";

        //     return $this->getOneOrNullResult(
        //         DAO::select($sql, ['id' => $userId]),
        //         $this->className
        //     );
        // }


    }