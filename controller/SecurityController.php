<?php

    namespace Controller;

    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Managers\UserManager;
    use Model\Managers\TopicManager;
    use Model\Managers\PostManager;

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

        public function viewProfile() {

            $topicManager = new TopicManager();

            $userTopicList = $topicManager->getUserTopics($_SESSION["user"]->getId());

            return [
                "view" => VIEW_DIR."security/viewProfile.php",
                "data" => [
                    "user" => $_SESSION["user"],
                    "userTopicList" => $userTopicList
                ]
            ];
        }


        public function userMsgList($userId) {

            if($_SESSION["user"]->getRole() == "ROLE_ADMIN") {

                $postManager = new PostManager();

                $userMsgList = $postManager->getUserMsgList($userId);
                // $countUserMsgList = $postManager->countUserMsgList($userId);

                return [
                    "view" => VIEW_DIR."security/userMsgList.php",
                    "data" => [
                        "userMsgList" => $userMsgList,
                        // "count" => $countUserMsgList
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
                        if ($user->getStatus()) {

                            Session::setUser($user);

                            $this->redirectTo("home", "index");
                        }
                        else {
                            $_SESSION["error"] = "Vous avez été banni du Formum";
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
