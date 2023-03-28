<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;
    use Model\Managers\TopicManager;

    class TopicManager extends Manager{

        protected $className = "Model\Entities\Topic";
        protected $tableName = "topic";


        public function __construct(){
            parent::connect();
        }


        public function listTopicByCat($id){

            $sql = "
            SELECT * FROM " .$this->tableName. " t
            WHERE t.category_id = :id
            ORDER BY t.id_topic DESC";

            return $this->getMultipleResults(
                DAO::select($sql, ['id' => $id]),
                $this->className
            );
        }

        public function getUserTopics($id) {
            $sql = "SELECT *
                    FROM ".$this->tableName."
                    WHERE user_id = :id
                    ORDER BY id_topic DESC
                    ";

            return $this->getMultipleResults(
                DAO::select($sql, ['id' => $id]),
                $this->className
            );
        }


    }