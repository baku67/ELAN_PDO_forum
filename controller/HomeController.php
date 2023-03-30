<?php

    namespace Controller;

    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Managers\UserManager;
    use Model\Managers\TopicManager;
    use Model\Managers\PostManager;
    
    class HomeController extends AbstractController implements ControllerInterface{

        public function index(){
            
                return [
                    "view" => VIEW_DIR."home.php"
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

        public function forumRules(){
            
            return [
                "view" => VIEW_DIR."rules.php"
            ];
        }

        /*public function ajax(){
            $nb = $_GET['nb'];
            $nb++;
            include(VIEW_DIR."ajax.php");
        }*/
    }
