<?php

    namespace Controller;

    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Managers\TopicManager;
    use Model\Managers\CategoryManager;
    use Model\Managers\UserManager;

    
    class CategoryController extends AbstractController implements ControllerInterface{

        public function index(){
          

           $categoryManager = new CategoryManager();
           $userManager = new UserManager();

           // On envoie le role de l'user connecté depuis la BDD et non la SESSION (pour si changement de role en cours de session active)
           $userConnectedRoleFromBdd = $userManager->findOneById($_SESSION["user"]->getId())->getRole();

            return [
                "view" => VIEW_DIR."forum/listCategories.php",
                "data" => [
                    "categories" => $categoryManager->findAll(["name", "DESC"]),
                    "userConnectedRoleFromBdd" => $userConnectedRoleFromBdd

                ]
            ];
        
        }


        public function addCategory() {

            $categoryManager = new CategoryManager;
            $userManager = new UserManager;

            $userConnectedRoleFromBdd = $userManager->findOneById($_SESSION["user"]->getId())->getRole();

            // On check le role de l'user connecté depuis la BDD et non la SESSION (pour si changement de role en cours de session active)
            if($userConnectedRoleFromBdd == "ROLE_ADMIN"){
                $categoryName = filter_input(INPUT_POST, "categoryName", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                if($categoryName) {

                    $categoryManager->add(["name" => $categoryName]);

                    $_SESSION["success"] = "Catégorie ajoutée";
                    $this->redirectTo("category", "index");
                }
                else {
                    $_SESSION["error"] = "Nom de la catégorie invalide";
                    $this->redirectTo("category", "index");
                }  
            }
            else {
                $_SESSION["error"] = "You must be administrator to add a category";
                $this->redirectTo("category", "index");
            }
        }



        

    }
