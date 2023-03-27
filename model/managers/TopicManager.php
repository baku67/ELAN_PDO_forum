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


        public function topicDetail($id){

            return [
                "view" => VIEW_DIR."forum/topicDetail.php",
                "data" => [
                    "topicDetail" => $topicManager->findOneById($id)
                ]
            ];
        }


    }