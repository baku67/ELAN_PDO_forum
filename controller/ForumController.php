<?php

    namespace Controller;

    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Managers\TopicManager;
    use Model\Managers\PostManager;
    use Model\Managers\CategoryManager;
    use Model\Managers\LikeManager;
    
    class ForumController extends AbstractController implements ControllerInterface{

        public function index(){
          
            $topicManager = new TopicManager();
            $categoryManager = new CategoryManager();
            // $postManager = new PostManager();

            return [
                "view" => VIEW_DIR."forum/listTopics.php",
                "data" => [
                    "categories" => $categoryManager->findAll(["name", "DESC"]),
                    "topics" => $topicManager->findAll(["creationdate", "DESC"]),
                    // "posts" => $postManager->findAll(["creationdate", "DESC"])
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
            $categoryManager = new CategoryManager();

            return [
                "view" => VIEW_DIR."forum/listTopics.php",
                "data" => [
                    "catName" => $_GET['catName'],
                    "topics" => $topicManager->listTopicByCat($id),
                    "categories" => $categoryManager->findAll(["name", "DESC"])
                ]
            ];
        }


        public function createTopic() {

            $topicManager = new TopicManager();
            $postManager = new PostManager();

            // $user = 1;
            if (!empty($_SESSION['user'])) {
                $user = $_SESSION['user']->getId();
            
                $newTopicId;

                if(!empty($_POST["title"]) && !empty($_POST["category"]) && !empty($_POST["firstMsg"])){ 
                    $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $category = filter_input(INPUT_POST, "category", FILTER_VALIDATE_INT);
                    $firstMsg = filter_input(INPUT_POST, "firstMsg", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                    $newTopicId = $topicManager->add(["user_id" => $user, "title" => $title, "category_id" => $category]);
                    $newPostId = $postManager->add(["user_id" => $user, "topic_id" => $newTopicId, "text" => $firstMsg]);
                    
                    // (lastPostId pas utilisé pour l'instant) update du lastPostId du topic apres insertion (ID vérifiés):
                    // $topicManager->updateLastPostId($newTopicId, $newPostId);
                    $topicManager->updateLastPostIdMsg($newTopicId, $newPostId, $firstMsg);

                    $_SESSION["success"] = "Topic created successfully.";
                    $this->redirectTo("forum", "topicDetail", $newTopicId);
                }
                else {
                    $_SESSION["error"] = "You must fullfill all inputs.";
                    $this->redirectTo("forum", "listTopics");
                }

            }
            else {
                $_SESSION["error"] = "You must be logged in to create topics";
                $this->redirectTo("security", "connexionForm");
            } 
        }


        public function closeTopic($topicId) {

            $topicManager = new TopicManager();

            $topic = $topicManager->findOneById($topicId);

            // Check si user = auteur/admin 
            if(!empty($_SESSION["user"])) {
                if(($_SESSION["user"]->getRole() == "ROLE_ADMIN") || ($_SESSION["user"]->getId() == $topic->getUser()->getId())) {
                    
                    // On inverse le status du topic (fermeture/reouverture)
                    if($topic->getStatus() == "1") {
                        $topicManager->changeStatusTopic($topicId, "0");
                        $_SESSION["success"] = "Le topic a été fermé";
                    }
                    else {
                        $topicManager->changeStatusTopic($topicId, "1");
                        $_SESSION["success"] = "Le topic a été rouvert";
                    }

                    $this->redirectTo("forum", "topicDetail", $topicId);
                }
                else {
                    $_SESSION["error"] = "You must be the author or Admin to close this topic";
                    $this->redirectTo("forum", "topicDetail", $topicId);
                }

            }
            else {
                $_SESSION["error"] = "You must be logged in to close this topic";
                $this->redirectTo("forum", "topicDetail", $topicId);
            }


        }


        public function addPost() {

            $topicManager = new TopicManager();
            $postManager = new PostManager();

            // $user = 1;
            if ($_SESSION['user']) {
                $user = $_SESSION['user']->getId();
                $topicId = $_GET['topicId'];

                if (!empty($_POST["postText"])) {

                    $msg = filter_input(INPUT_POST, "postText", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $newPostId = $postManager->add(["user_id" => $user, "text" => $msg, "topic_id" => $topicId]);

                    // (lastPostId pas utilisé pour l'instant) update du lastPostId du topic apres insertion (ID vérifiés):
                    // $topicManager->updateLastPostId($topicId, $newPostId);
                    $topicManager->updateLastPostIdMsg($topicId, $newPostId, $msg);


                    $_SESSION["success"] = "Message added successfully.";
                    $this->redirectTo("forum", "topicDetail", $topicId);
                }
                else {
                    $_SESSION["error"] = "You must enter a message.";
                    $this->redirectTo("forum", "topicDetail", $topicId);
                }
            }
            else {
                $_SESSION["error"] = "You must be logged in to post something";
                $this->redirectTo("security", "connexionForm");
            }

        }


        public function likePost($postId) {

            $likeManager = new LikeManager();

            if ($_SESSION['user']) {

                $user = $_SESSION['user']->getId();

                $likeManager->add(["user_id" => $user, "post_id" => $postId]);

                $_SESSION["success"] = "Liké";
                // $this->redirectTo("forum", "topicDetail", $topicId);
                $this->redirectTo("forum", "index");
            }
            else {
                $_SESSION["error"] = "You must be logged in to like a post";
                $this->redirectTo("security", "connexionForm");
            }
                
        }

        

    }
