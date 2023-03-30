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

        
        // (not used) Fonction de récupération des ID de post liké par l'utilisateur connecté pour le Topic en question (pour comparer: si postId présent dans l'array result => liké)
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


        // Fonction pour compter les likes d'un post (PB: nécessite le postId)
        public function countLikesPost($postId) {

            $sql = "
            SELECT COUNT(*) FROM ".$this->tableName . " l
            INNER JOIN post p ON p.id_post = l.post_id
            WHERE p.id_post = :postId
            ";

            return $this->getSingleScalarResult(
                DAO::select($sql, ['postId' => $postId], false)
            );
        }

        // On récupère la liste globale des likes du TOPIC (avec le FK:post_id) et apres dans la vue pour chaque post on compte+1 si y'a match
        public function listLikesTopic($topicId) {

            $sql = "
            SELECT * 
            FROM ".$this->tableName . " l
            INNER JOIN post p ON p.id_post = l.post_id
            WHERE p.topic_id = :topicId
            ";

            return $this->getMultipleResults(
                DAO::select($sql, ["topicId" => $topicId], true),
                $this->className
            );
        }

        // ViewProfile: on récupère la liste des postLikes
        public function userlikesList() {

            $sql = "
            SELECT * 
            FROM ".$this->tableName . " l
            ";

            return $this->getMultipleResults(
                DAO::select($sql, null, true),
                $this->className
            );
        }


        // Check si le like existe deja pour ce userId et ce postId
        // Avec findOneOrNull plus facile pour le check ForumController likePost()
        public function findOneByUserAndPost($user, $id) {

            $sql = "
            SELECT * FROM ".$this->tableName . " l 
            WHERE l.user_id = :userId 
            AND l.post_id = :postId
            ";

            return $this->getOneOrNullResult(
                DAO::select($sql, ["postId" => $id, 'userId' => $user], false),
                $this->className
            );
        }
        

    }