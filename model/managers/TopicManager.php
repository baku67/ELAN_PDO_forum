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

        // Lors creation du topic (avec fistMsg) puis lors d'un addPost dans topic
        public function updateLastPostId($topicId, $newPostId) {
            $sql = "UPDATE ".$this->tableName."
             SET lastPostId = :lastPostId
            WHERE id_topic = :id
            ";

            return $this->getOneOrNullResult(
                DAO::update($sql, ['lastPostId' => $newPostId, 'id' => $topicId], false), 
                $this->className
            );
        }
        public function updateLastPostIdMsg($topicId, $newPostId, $msg) {
            $sql = "UPDATE ".$this->tableName."
             SET lastPostMsg = :msg, lastPostId = :lastPostId
            WHERE id_topic = :id
            ";

            return $this->getOneOrNullResult(
                DAO::update($sql, ['lastPostId' => $newPostId, 'msg' => $msg, 'id' => $topicId], false), 
                $this->className
            );
        }


        // Close et open différents ou juste toggle avec !value ?
        public function changeStatusTopic($id, $status) {
            $sql = "UPDATE ".$this->tableName."
             SET status = :status
            WHERE id_topic = :id
            ";

            return $this->getOneOrNullResult(
                DAO::update($sql, ['status' => $status, 'id' => $id], false), 
                $this->className
            );
        }

        public function getCountTopics($userId) {
            $sql = "
            SELECT COUNT(*) AS count FROM ".$this->tableName . " 
            WHERE user_id = :id
            ";

            return $this->getSingleScalarResult(
                DAO::select($sql, ['id' => $userId])
            );
        }

    }