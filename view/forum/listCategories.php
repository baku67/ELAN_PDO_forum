<?php

$categories = $result["data"]['categories'];

$userConnectedRoleFromBdd = $result["data"]['userConnectedRoleFromBdd'];
    
?>

<div class="categoriesMain">


    <h1 class="titleUnderline">Catégories</h1>

    <div class="categoriesDiv">
        <?php
        foreach($categories as $category ){
            if ($category->getNbrTopics() > 0) {
            ?>
                <a class="categoryLink" href="index.php?ctrl=forum&action=listTopicByCat&id=<?= $category->getId() ?>&catName=<?= $category->getName() ?>"><?= ucfirst($category->getName()) ?> <br class="displayedPc"><span class="opacityPc">(</span><?= $category->getNbrTopics() ?><span class="opacityPc">)</span></a>
            <?php
            }
            else {
            ?>
                <p class="categoryLinkDisabled"><?= ucfirst($category->getName()) ?> <br class="displayedPc"><span class="opacityPc">(</span><?= $category->getNbrTopics() ?><span class="opacityPc">)</span></p>
            <?php
            }
            ?>
            <?php
        }
        ?>
    </div>


    <?php
    // On check le role de l'user connecté depuis la BDD et non la SESSION (pour si changement de role en cours de session active)
    if($userConnectedRoleFromBdd == "ROLE_ADMIN"){
    ?>
        <p>(Admin) Ajouter une catégorie</p>
        <form action="index.php?ctrl=category&action=addCategory" method="post">
            <label for="categoryName"></label>
            <input id="categoryName" name="categoryName" placeholder="Nouvelle catégorie" type="text" maxlength="20">
            <input id="searchSubmit" class="catSubmit" type="submit" value="ajouter">
        </form>
    <?php
    }
    ?>

</div>


  
