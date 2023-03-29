<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;
    use Model\Managers\LikeManager;

    class LikeManager extends Manager{

        protected $className = "Model\Entities\Like";
        protected $tableName = "liking_post";


        public function __construct(){
            parent::connect();
        }

        public function topicUserLikeList($connectedUser, $topicId) {

            $sql = "
            SELECT * FROM ".$this->tableName . " l
            INNER JOIN post p ON p.id_post = l.post_id
            INNER JOIN topic t ON t.id_topic = p.topic_id
            WHERE l.user_id = :id
            AND t.id_topic = :topicId
            ORDER BY p.creationdate DESC
            ";

            return $this->getMultipleResults(
                DAO::select($sql, ["topicId" => $topicId, 'id' => $connectedUser], true),
                $this->className
            );

        }

    }