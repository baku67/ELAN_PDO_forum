<?php

    namespace Controller;

    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Managers\TopicManager;
    use Model\Managers\PostManager;
    use Model\Managers\CategoryManager;
    use Model\Managers\LikeManager;
    use Model\Managers\UserManager;
    
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
                    "totalCountTopics" => $topicManager->getTotalCountTopics()
                    // "posts" => $postManager->findAll(["creationdate", "DESC"])
                ]
            ];
        }

        public function users(){
            $userManager = new UserManager();

            // On check le role de l'user connecté depuis la BDD et non la session (pour si changement du role pendant la session active)
            if($userManager->findOneById($_SESSION["user"]->getId())->getRole() == "ROLE_ADMIN") {
                $users = $userManager->findAll(['signInDate', 'DESC']);

                return [
                    "view" => VIEW_DIR."security/users.php",
                    "data" => [
                        "users" => $users
                    ]
                ];
            }
            else {
                $_SESSION["error"] = "You are no more Administrator";
                $this->redirectTo("security", "viewProfile");
            } 
        }


        public function topicDetail($id){

            $topicManager = new TopicManager();
            $postManager = new PostManager();
            $likeManager = new LikeManager();
            $userManager = new UserManager();


            // Pas de list userLikedPostId si pas connecté:
            if(!empty($_SESSION["user"])) {
                return [
                    "view" => VIEW_DIR."forum/topicDetail.php",
                    "data" => [
                        "posts" => $postManager->findByTopicId($id),
                        "topicDetail" => $topicManager->findOneById($id),
                        "topicPostsCount" => $postManager->countByTopic($id),
                        "likeList" => $likeManager->topicUserLikeList($_SESSION["user"]->getId(), $id),
                        "listLikesTopic" => $likeManager->listLikesTopic($id),
                        "userConnectedRoleFromBdd" => $userManager->findOneById($_SESSION["user"]->getId())->getRole()                
                    ]
                ];
            }
            else {
                return [
                    "view" => VIEW_DIR."forum/topicDetail.php",
                    "data" => [
                        "posts" => $postManager->findByTopicId($id),
                        "topicDetail" => $topicManager->findOneById($id),
                        "topicPostsCount" => $postManager->countByTopic($id),
                        "listLikesTopic" => $likeManager->listLikesTopic($id),
                    ]
                ];
            }

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
            $userManager = new UserManager();

            if (!empty($_SESSION['user'])) {
                $user = $_SESSION['user']->getId();
            
                // if(!Session::isMuted() && !Session::isBanned()) {
                // Pour checker le status de l'utilisateur connecté, on prend pas le status du SESSION["user"] car ne se met pas à jour si changement Status BDD en cours de session
                if($userManager->findOneById($_SESSION["user"]->getId())->getStatus() == 0) {

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
                    $_SESSION["error"] = "You are currently muted or banned by an administrator";
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
            $userManager = new UserManager();

            $topic = $topicManager->findOneById($topicId);

            // On recheck le role du user connecté dans la BDD et non à partir du $_SESSION (pour si changement role en cours de session)
            $userConnectedRoleFromBdd = $userManager->findOneById($_SESSION["user"]->getId())->getRole();

            // Check si user = auteur/admin (utiliser Session::isAdmin())
            if(!empty($_SESSION["user"])) {
                if(($userConnectedRoleFromBdd == "ROLE_ADMIN") || ($_SESSION["user"]->getId() == $topic->getUser()->getId())) {
                    
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
            $userManager = new UserManager();

            if ($_SESSION['user']) {
                $user = $_SESSION['user']->getId();
                $topicId = $_GET['topicId'];

                // Pour checker le status de l'utilisateur connecté, on prend pas le status du SESSION["user"] car ne se met pas à jour si changement Status BDD en cours de session
                if($userManager->findOneById($_SESSION["user"]->getId())->getStatus() == 0) {


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
                    $_SESSION["error"] = "You are currently muted or banned by an administrator";
                    $this->redirectTo("forum", "topicDetail", $topicId);
                }

            }
            else {
                $_SESSION["error"] = "You must be logged in to post something";
                $this->redirectTo("security", "connexionForm");
            }

        }


        public function likePost($id, $id2) {

            $likeManager = new LikeManager();

            if ($_SESSION['user']) {

                $user = $_SESSION['user']->getId();

                if($likeManager->findOneByUserAndPost($user, $id)) {
                    
                    $matchingLikeId = $likeManager->findOneByUserAndPost($user, $id)->getId();
                    $likeManager->delete($matchingLikeId);

                    $_SESSION["error"] = "Post Unliké";
                    $this->redirectTo("forum", "topicDetail", $id2);
                }
                else {
                    $likeManager->add(["user_id" => $user, "post_id" => $id]);
                    $_SESSION["success"] = "Post Liké";
                    $this->redirectTo("forum", "topicDetail", $id2);
                }

                // $_SESSION["success"] = "Liké";
                // $this->redirectTo("forum", "topicDetail", $id2);
            }
            else {
                $_SESSION["error"] = "You must be logged in to like a post";
                $this->redirectTo("security", "connexionForm");
            }
                
        }

        

    }
