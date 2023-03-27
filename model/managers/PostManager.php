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


    }