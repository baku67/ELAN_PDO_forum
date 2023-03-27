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
           $categoryManager = new CategoryManager();

            return [
                "view" => VIEW_DIR."forum/listTopics.php",
                "data" => [
                    "categories" => $categoryManager->findAll(["name", "DESC"]),
                    "topics" => $topicManager->findAll(["creationdate", "DESC"])
                ]
            ];
        }


        public function topicDetail($id){

            $topicManager = new TopicManager();
            $postManager = new PostManager();

            return [
                "view" => VIEW_DIR."forum/topicDetail.php",
                "data" => [
                    "posts" => $postManager->findByTopicId($id),
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


        // Pour résumer, quelque soit l'élément que vous souhaitez ajouter en BDD (user, post, topic, categorie; ...) vous n'aurez pas besoin de faire une méthode personnalisée dans vos TopicManager, PostManager, etc
        // Le framework vous aide déjà dans cette démarche à travers les méthodes qui se trouvent déjà dans "App/Manager.php"
        public function createTopic() {

            $topicManager = new TopicManager();
            $postManager = new PostManager();

            // if ($_SESSION['user']) {
            // $user = $_SESSION['user']->getId();
            $user = 1;
            $newTopicId;

            if(isset($_POST["title"]) && isset($_POST["category"]) && isset($_POST["firstMsg"])){ 
                $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $category = filter_input(INPUT_POST, "category", FILTER_VALIDATE_INT);
                $firstMsg = filter_input(INPUT_POST, "firstMsg", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                // $topicManager->add(["user_id" => $user, "title" => $title, "category_id" => $category]);
                $newTopicId = $topicManager->add(["user_id" => $user, "title" => $title, "category_id" => $category]);
                $postManager->add(["user_id" => $user, "topic_id" => $newTopicId, "text" => $firstMsg]);

                header("Location: index.php?ctrl=forum&action=topicDetail&id=".$newTopicId);
            }
            else {
                header("Location: index.php");
            }
                 
        }


        public function addPost() {

            $topicManager = new TopicManager();
            $postManager = new PostManager();

            // if ($_SESSION['user']) {
            // $user = $_SESSION['user']->getId();
            $user = 1;
            $topicId = $_GET['topicId'];

            if (isset($_POST["postText"])) {

                $msg = filter_input(INPUT_POST, "postText", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $postManager->add(["user_id" => $user, "text" => $msg, "topic_id" => $topicId]);

                header("Location: index.php?ctrl=forum&action=topicDetail&id=".$topicId);
            }
        }

        

    }
