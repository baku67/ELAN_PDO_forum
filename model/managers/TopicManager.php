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


        // Récupère tout les topics et le compte de posts pour chaque (MAIS on renvoi objet donc pas récupérable)
        public function findAllAndCount() {

            $sql="
                SELECT t.id_topic, t.title, t.status, t.creationdate, t.user_id, t.category_id, t.lastPostId, t.lastPostMsg, COUNT(p.id_post) AS nbrPosts
                FROM " .$this->tableName. " t
                LEFT JOIN post p ON p.topic_id = t.id_topic
                GROUP BY t.id_topic
                ORDER BY t.creationdate DESC
            ";

            return $this->getMultipleResults(
                DAO::select($sql),
                $this->className
            );
        }


        public function listTopicByCat($id){

            $sql = "
                SELECT t.id_topic, t.title, t.status, t.creationdate, t.user_id, t.category_id, t.lastPostId, t.lastPostMsg, COUNT(p.id_post) AS nbrPosts 
                FROM " .$this->tableName. " t
                LEFT JOIN post p ON p.topic_id = t.id_topic
                WHERE t.category_id = :id
                GROUP BY t.id_topic
                ORDER BY t.creationdate DESC
            ";

            return $this->getMultipleResults(
                DAO::select($sql, ['id' => $id]),
                $this->className
            );
        }

        public function getUserTopics($id) {
            $sql = "
                SELECT t.id_topic, t.title, t.status, t.creationdate, t.user_id, t.category_id, t.lastPostId, t.lastPostMsg, COUNT(p.id_post) AS nbrPosts
                FROM ".$this->tableName." t
                LEFT JOIN post p ON p.topic_id = t.id_topic
                WHERE t.user_id = :id
                GROUP BY t.id_topic
                ORDER BY t.creationdate DESC
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


        public function listTopicBySearch($searchInput) {
            $sql = "
                SELECT t.id_topic, t.title, t.status, t.creationdate, t.user_id, t.category_id, t.lastPostId, t.lastPostMsg, COUNT(p.id_post) AS nbrPosts 
                FROM " .$this->tableName. " t
                LEFT JOIN post p ON p.topic_id = t.id_topic
                WHERE t.title LIKE :searchInput
                GROUP BY t.id_topic
                ORDER BY t.creationdate DESC
            ";

            return $this->getMultipleResults(
                DAO::select($sql, ['searchInput' => "%".$searchInput."%"], true),
                $this->className
            );
        }

        public function getSearchCountTopics($searchInput) {
            $sql = "
                SELECT COUNT(*) AS count
                FROM topic t
                WHERE t.title LIKE :searchInput
            ";

            return $this->getSingleScalarResult(
                DAO::select($sql, ['searchInput' => "%".$searchInput."%"])
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

        public function changeTopicCategory($topicId, $newCategoryId) {
            $sql = "UPDATE ".$this->tableName."
             SET category_id = :categoryId
            WHERE id_topic = :id
            ";

            return $this->getOneOrNullResult(
                DAO::update($sql, ['categoryId' => $newCategoryId, 'id' => $topicId], false), 
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


        public function getTotalCountTopics() {
            $sql = "
            SELECT COUNT(*) AS count FROM ".$this->tableName . "";

            return $this->getSingleScalarResult(
                DAO::select($sql)
            );
            
        }


        public function getTotalCountTopicsByCat($idCat) {
            $sql = "
            SELECT COUNT(*) AS count 
            FROM ".$this->tableName . " t
            WHERE t.category_id = :idCat
            ";

            return $this->getSingleScalarResult(
                DAO::select($sql, ["idCat" => $idCat])
            );
            
        }

    }