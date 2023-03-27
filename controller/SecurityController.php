<?php

    namespace Controller;

    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Managers\UserManager;

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



        // public function checkIfUserExists($email) {
        //     $result = $userManager->findAll(["email", "DESC"]);
        //     // if count...
        //     if(count() > 0) {
        //         return true;
        //     }
        //     else {
        //         return false;
        //     }
        // }
        

        public function register() {

            $userManager = new UserManager();  

            $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL, FILTER_VALIDATE_EMAIL);
            // Regex de validation de password A-Z-ù$^ù$*ù... (TODO: fix le comparatif bug si Regex):
            $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $passwordCheck = filter_input(INPUT_POST, "passwordCheck", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            // $password = filter_var("password", FILTER_VALIDATE_REGEXP, array( "options"=> array( "regexp" => "/.{8,25}/")));
            // $passwordCheck = filter_var("passwordCheck", FILTER_VALIDATE_REGEXP, array( "options"=> array( "regexp" => "/.{8,25}/")));
            if ($password != $passwordCheck) {
                $_SESSION["error"] = "Passwords doesn't match";
                return [
                    "view" => VIEW_DIR."home.php",
                ];
            }
            else {
                // Check if user exists (email):
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
                        return [
                            "view" => VIEW_DIR."home.php"
                        ];
                    }
                    else {
                        $_SESSION["error"] = "Le nom d'utilisateur est déjà utilisé";
                        return [
                            "view" => VIEW_DIR."home.php"
                        ]; 
                    }
                }
                else {
                    $_SESSION["error"] = "L'email est déjà utilisé";
                    return [
                        "view" => VIEW_DIR."home.php"
                    ];
                }

            }

            
           
        }
    

    }
