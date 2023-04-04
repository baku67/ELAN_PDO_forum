<?php

$categories = $result["data"]['categories'];

$userConnectedRoleFromBdd = $result["data"]['userConnectedRoleFromBdd'];
    
?>

<div class="categoriesMain">


    <h1>Catégories</h1>

    <div class="categoriesDiv">
        <?php
        foreach($categories as $category ){

            ?>
            <a class="categoryLink" href="index.php?ctrl=forum&action=listTopicByCat&id=<?= $category->getId() ?>&catName=<?= $category->getName() ?>"><?= ucfirst($category->getName()) ?> (<?= $category->getNbrTopics() ?>)</a>
            <?php
        }
        ?>
    </div>


    <?php
    // On check le role de l'user connecté depuis la BDD et non la SESSION (pour si changement de role en cours de session active)
    if($userConnectedRoleFromBdd == "ROLE_ADMIN"){
    ?>
        <p>Ajouter une catégorie</p>
        <form action="index.php?ctrl=category&action=addCategory" method="post">
            <label for="categoryName"></label>
            <input id="categoryName" name="categoryName" type="text" maxlength="20">
            <input type="submit" value="ajouter">
        </form>
    <?php
    }
    ?>

</div>


  
