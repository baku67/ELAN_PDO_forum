<?php

    namespace Controller;

    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Managers\TopicManager;
    use Model\Managers\PostManager;
    use Model\Managers\CategoryManager;
    
    class ForumController extends AbstractController implements ControllerInterface{

        public function index(){
          
           $topicManager = new TopicManager();

            return [
                "view" => VIEW_DIR."forum/listTopics.php",
                "data" => [
                    "topics" => $topicManager->findAll(["publishDate", "DESC"])
                ]
            ];
        }


        public function topicDetail($id){

            $topicManager = new TopicManager();

            return [
                "view" => VIEW_DIR."forum/topicDetail.php",
                "data" => [
                    "topicDetail" => $topicManager->findOneById($id)
                ]
            ];
        }


        public function listTopicByCat($id) {

            $topicManager = new TopicManager();

            return [
                "view" => VIEW_DIR."forum/listTopics.php",
                "data" => [
                    "catName" => $_GET['catName'],
                    "topics" => $topicManager->listTopicByCat($id)
                ]
            ];
        }

        

    }
