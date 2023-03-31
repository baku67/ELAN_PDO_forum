<?php

    namespace Controller;

    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Managers\UserManager;
    use Model\Managers\TopicManager;
    use Model\Managers\PostManager;
    use Model\Managers\LikeManager;
    use Model\Managers\CategoryManager;


    class HomeController extends AbstractController implements ControllerInterface{

        public function index(){}


        public function connexionForm() {
            return [
                "view" => VIEW_DIR."security/login.php",
                "data" => []
            ];
        }

        public function subscribeForm() {
            return [
                "view" => VIEW_DIR."security/register.php",
                "data" => []
            ];
        }


        public function changeUserStatus() {

            $userManager = new UserManager;

            if(Session::isAdmin()){

                $newStatus = filter_var($_POST["status-Select"], FILTER_VALIDATE_INT);
                $userId = filter_var($_POST["userId"], FILTER_VALIDATE_INT);

                if(($newStatus !== false) && ($userId !== false)) {

                    $userManager->updateUserStatus($userId, $newStatus);

                    if($_POST["redirectTo"] == "viewUserProfile") {
                        $_SESSION["success"] = "Statut de l'utilisateur modifié";
                        $this->redirectTo("security", "viewUserProfile", $userId);
                    }
                    else {
                        $_SESSION["success"] = "Statut de l'utilisateur modifié";
                        $this->redirectTo("forum", "users");
                    }
                }
                else {
                    if($_POST["redirectTo"] == "viewUserProfile") {
                        $_SESSION["error"] = "Requête refusée";
                        $this->redirectTo("security", "viewUserProfile", $userId);
                    }
                    else {
                        $_SESSION["error"] = "Requête refusée";
                        $this->redirectTo("forum", "users");
                    } 
                }
            }
            else {
                $_SESSION["error"] = "Accès non autorisé";
                $this->redirectTo("home", "index");
            }
        }


        public function changeUserRole() {

            $userManager = new UserManager;

            if(Session::isAdmin()){

                $newRole = filter_input(INPUT_POST, "role-Select", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $userId = filter_var($_POST["userId2"], FILTER_VALIDATE_INT);

                if($newRole && ($userId !== false)) {

                    $userManager->updateUserRole($userId, $newRole);

                    if($_POST["redirectTo2"] == "viewUserProfile") {
                        $_SESSION["success"] = "Rôle de l'utilisateur modifié";
                        $this->redirectTo("security", "viewUserProfile", $userId);
                    }
                    else if($_POST["redirectTo2"] == "usersList") {
                        $_SESSION["success"] = "Rôle de l'utilisateur modifié";
                        $this->redirectTo("forum", "users");
                    }
                }
                else {
                    if($_POST["redirectTo2"] == "viewUserProfile") {
                        $_SESSION["error"] = "Requête refusée";
                        $this->redirectTo("security", "viewUserProfile", $userId);
                    } else {
                        $_SESSION["error"] = "Requête refusée";
                        $this->redirectTo("forum", "users");
                    } 
                }
            }
            else {
                $_SESSION["error"] = "Accès non autorisé";
                $this->redirectTo("home", "index");
            }
        }

        public function viewProfile() {

            $topicManager = new TopicManager();
            $postManager = new PostManager();
            $likeManager = new LikeManager();
            $userManager = new UserManager();

            $userTopicList = $topicManager->getUserTopics($_SESSION["user"]->getId());
            $countTopics = $topicManager->getCountTopics($_SESSION["user"]->getId());

            $userMsgList = $postManager->getUserMsgList($_SESSION["user"]->getId());
            $countUserMsgList = $postManager->countUserMsgList($_SESSION["user"]->getId());

            $userLikesList = $likeManager->userlikesList($_SESSION["user"]->getId());

            $userTotalLikes = $likeManager->getUserTotalLikes($_SESSION["user"]->getId());

            return [
                "view" => VIEW_DIR."security/viewProfile.php",
                "data" => [
                    "user" => $userManager->findOneByIdAndCount($_SESSION["user"]->getId()),
                    "userTopicList" => $userTopicList,
                    "countTopics" => $countTopics,
                    "userMsgList" => $userMsgList,
                    "countMsg" => $countUserMsgList,
                    "userLikesList" => $userLikesList,
                    "userTotalLikes" => $userTotalLikes
                ]
            ];
        }


        public function viewUserProfile($userId) {

            $topicManager = new TopicManager();
            $userManager = new UserManager();
            $postManager = new PostManager();
            $likeManager = new LikeManager();
            $categoryManager = new CategoryManager();

            $userTopicList = $topicManager->getUserTopics($userId);
            $countTopics = $topicManager->getCountTopics($userId);

            $userMsgList = $postManager->getUserMsgList($userId);
            $countUserMsgList = $postManager->countUserMsgList($userId);

            $userLikesList = $likeManager->userlikesList($userId);

            $userTotalLikes = $likeManager->getUserTotalLikes($userId);

            $userConnectedRoleFromBdd = $userManager->findOneById($userId)->getRole();

            return [
                "view" => VIEW_DIR."security/viewProfile.php",
                "data" => [
                    "user" => $userManager->findOneByIdAndCount($userId),
                    "userTopicList" => $userTopicList,
                    "countTopics" => $countTopics,
                    "userMsgList" => $userMsgList,
                    "countMsg" => $countUserMsgList,
                    "userLikesList" => $userLikesList,
                    "userTotalLikes" => $userTotalLikes,
                    "userConnectedRoleFromBdd" => $userConnectedRoleFromBdd,
                ]
            ];
        }


        public function userMsgList($userId) {

            if($_SESSION["user"]->getRole() == "ROLE_ADMIN") {

                $postManager = new PostManager();

                $userMsgList = $postManager->getUserMsgList($userId);
                $countUserMsgList = $postManager->countUserMsgList($userId);

                return [
                    "view" => VIEW_DIR."security/userMsgList.php",
                    "data" => [
                        "userMsgList" => $userMsgList,
                        "count" => $countUserMsgList
                    ]
                ];
            }
            else {
                $_SESSION["error"] = "Non autorisé";
                $this->redirectTo("security", "subscribeForm");
            }



        }
        

        public function register() {

            $userManager = new UserManager();  

            $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
            // Regex de validation de password A-Z-ù$^ù$*ù... (TODO: fix le comparatif bug si Regex):
            $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $passwordCheck = filter_input(INPUT_POST, "passwordCheck", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            // $password = filter_var("password", FILTER_VALIDATE_REGEXP, array( "options"=> array( "regexp" => "/.{8,25}/")));
            // $passwordCheck = filter_var("passwordCheck", FILTER_VALIDATE_REGEXP, array( "options"=> array( "regexp" => "/.{8,25}/")));

            // check si les filtres passent 
            if($username && $email && $password && $passwordCheck){
                if ($password != $passwordCheck) {
                    $_SESSION["error"] = "Passwords doesn't match";
                    return [
                        "view" => VIEW_DIR."home.php",
                    ];
                }
                else {
                    // Check if user exists (email), false ou objet NULL s'il y a:
                    $countEmail = $userManager->findOneByMail($email);

                    if(!$countEmail) {
                        //check if user exists (username):
                        $countPseudo = $userManager->findOneByUsername($username);
                        if(!$countPseudo) {
                        
                            // Hash Password:
                            $finalPassword = password_hash($password, PASSWORD_DEFAULT);

                            // add user:
                            $newUserId = $userManager->add(["username" => $username, "email" => $email, "password" => $finalPassword]);

                            $_SESSION["success"] = "Inscription réussie";
                            $this->redirectTo("security", "connexionForm");
                        }
                        else {
                            $_SESSION["error"] = "Le nom d'utilisateur est déjà utilisé";
                            $this->redirectTo("security", "subscribeForm");
                        }
                    }
                    else {
                        $_SESSION["error"] = "L'email est déjà utilisé";
                        $this->redirectTo("security", "subscribeForm");
                    }

                }
            }
            else {
                $_SESSION["error"] = "Veuillez entrer un email valide";
                $this->redirectTo("security", "subscribeForm");
            }
 
        }


        public function login() {

            $userManager = new UserManager();  

            $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
            $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if($email && $password){

                $dbPass = $userManager->retrievePassword($email);

                if($dbPass !== false) {

                    $hash = $dbPass->getPassword();

                    $user = $userManager->findOneByMail($email);

                    if (password_verify($password, $hash)) {

                        // Si user pas banni
                        if ($user->getStatus() != 2) {

                            Session::setUser($user);

                            $this->redirectTo("home", "index");
                        }
                        else {
                            $_SESSION["error"] = "You are currently banned and can not log in";
                            $this->redirectTo("security", "connexionForm");
                        }
                    }
                    else {
                        $_SESSION["error"] = "Mot de passe incorrect";
                        $this->redirectTo("security", "connexionForm");
                    }
                }
                else {
                    $_SESSION["error"] = "Erreur lors du retrieve password (utilisateur inconnu)";
                    $this->redirectTo("security", "connexionForm");
                }

            }
            else {
                $_SESSION["error"] = "Veuillez entrer un email valide";
                $this->redirectTo("security", "connexionForm");
            }

        }



        public function logout() {
            session_start(); 
            session_destroy();
            $this->redirectTo("security", "connexionForm");
        }
    

    }
