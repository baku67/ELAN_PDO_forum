<?php

    $topic = $result["data"]['topicDetail'];

    $posts = $result["data"]['posts'];

    $postsCount = $result["data"]['topicPostsCount'];

    if (!empty($result["data"]['categories'])) {
        $categories = $result["data"]['categories'];
    }

    if (!empty($result["data"]['userConnectedRoleFromBdd'])) {
        $userConnectedRoleFromBdd = $result["data"]['userConnectedRoleFromBdd'];
    }

    
    if($topic->getStatus() == 1) {
        $statusText = "Ouvert";
        $statusClass = "openTopicDetail";
    }
    else {
        $statusText = "Fermé";
        $statusClass = "closedTopicDetail";
    }

    // ** (isLiked userCo) On récupère la liste des Posts liés au topic et à l'userConnected (Puis dans foreachPost on check si le postId est dans l'array)
    if(!empty($result["data"]['likeList'])) {
        $userTopicLikeList = $result["data"]['likeList'];
    }

    $postIdLikedArray = [];
    if(!empty($userTopicLikeList)) {
        foreach ($userTopicLikeList as $like) {
            $postIdLikedArray[] = $like->getPost()->getId();
        }
    }

    // ** Tous les postLikes du Topic (All user)
    $listLikesTopic = $result["data"]['listLikesTopic'];

    $globalListLikesTopic = [];
    if(!empty($listLikesTopic)) {
        foreach($listLikesTopic as $like) {
            $globalListLikesTopic[] = $like->getPost()->getId();
        }
    }
    // var_dump($globalListLikesTopic);
    // echo("<br>Décompte: ");
    // echo(var_dump(array_count_values($globalListLikesTopic)));
    // ** Exemple de récup du nbr de like en passant l'idPost en index
    // var_dump(array_count_values($globalListLikesTopic)[51]);


?>


    <div class="titleDiv">
        <h1 class="titleUnderline">Detail du topic n°<?= $topic->getId() ?></h1>
        <span class="<?= $statusClass ?>"><?= $statusText ?></span>
    </div>

    <br>


    <div style="display:inline-flex">

        <?php
        if((empty($userConnectedRoleFromBdd)) || ($userConnectedRoleFromBdd == "ROLE_USER")) {
        ?>
            <span>(<?= $topic->getCategory()->getName() ?>)</span>
        <?php
        } else {
        ?>
            <form action="index.php?ctrl=forum&action=changeTopicCategory&id=<?= $topic->getId() ?>" method="post">
                <select name="category_Select" id="category_Select" onchange='this.form.submit()'>
                    <?php 
                    foreach ($categories as $category) {
                        // Si Topic->Categorie->name = Category->name alors $selected="selected"
                        if($topic->getCategory()->getId() == $category->getId()) {
                            $selected = "selected";
                        }
                        else {
                            $selected = "";
                        }
                    ?>
                        <option value="<?= $category->getId() ?>" <?=$selected?>><?= $category->getName() ?></option>
                    <?php
                    }
                    ?>
                </select>
                <noscript><input type="submit" value="changer"></noscript>
            </form>
        <?php
        }
        ?>

        <span class="topicDetailNbrPosts"><?= $postsCount ?> <i class="fa-regular fa-comments"></i></span>
        
    </div>



    <p><?=$topic->getTitle()?></p>
    <p>by <a href="index.php?ctrl=security&action=viewUserProfile&id=<?= $topic->getUser()->getId() ?>"><?=$topic->getUser()->getUsername()?></a>, le <?=$topic->getCreationdate()?></p>

    <?php
    if (isset($posts)) {
        foreach ($posts as $post) {

            // Check si l'user est auteur du post
            if(App\Session::getUser()) {
                if ($post->getUser()->getId() == $_SESSION["user"]->getId()) {
                    $authorClass = "authorPost";
                }
                else {
                    $authorClass = "";
                }
            }
            else {
                $authorClass = "";
            }

            // Check si Post liked (on check si le postId est dans l'array des userPostIdLiked)
            $isLiked = false;
            if(in_array($post->getId(), $postIdLikedArray)) {
                $isLiked = true;
            }
            else {
                $isLiked = false;
            }

            // Compte des likes Globaux à l'aide de l'array $globalListLikesTopic (qui comprend tout les id de post liké all users, donc doublons de postId)
            if(!empty(array_count_values($globalListLikesTopic)[$post->getId()])) {
                $postGlobalLikesCount = array_count_values($globalListLikesTopic)[$post->getId()];
            }
            else {
                $postGlobalLikesCount = 0;
            }



        ?>

            <div class="postCard <?= $authorClass ?>">
                <p><?= $post->getText() ?></p>
                <span class="postInfos">by <a href="index.php?ctrl=security&action=viewUserProfile&id=<?= $post->getUser()->getId() ?>"><?= $post->getUser()->getUsername() ?></a>, le <?= $post->getCreationdate() ?></span>
                <?php
                if(App\Session::getUser()){
                    // Bouton like différent selon isLiked
                    if($isLiked) {
                ?>
                    <a href="index.php?ctrl=forum&action=likePost&id=<?= $post->getId() ?>&id2=<?= $topic->getId() ?>"><i class="fa-solid fa-thumbs-up"></i></a>
                    <a href="index.php?ctrl=forum&action=postLikesList&id=<?= $post->getId() ?>"><p><?= $postGlobalLikesCount ?> likes</p></a>
                <?php
                    }else{
                ?>  
                    <a href="index.php?ctrl=forum&action=likePost&id=<?= $post->getId() ?>&id2=<?= $topic->getId() ?>"><i class="fa-regular fa-thumbs-up"></i></a>
                    <a href="index.php?ctrl=forum&action=postLikesList&id=<?= $post->getId() ?>"><p><?= $postGlobalLikesCount ?> likes</p></a>
                <?php
                    }
                }
                else {
                ?>
                    <!-- Vérification user dans le controller finalement -->
                    <a href="index.php?ctrl=forum&action=likePost&id=<?= $post->getId() ?>&id2=<?= $topic->getId() ?>"><i class="fa-regular fa-thumbs-up" style="opacity:0.5"></i></a>
                    <a href="index.php?ctrl=forum&action=postLikesList&id=<?= $post->getId() ?>"><p><?= $postGlobalLikesCount ?> likes</p></a>
                <?php
                }
                ?>
            </div>

        <?php
        }
    } else {
    ?>
        <p class="postCard">Aucun post</p>
    <?php
    }
    ?>

    <!-- Si user = admin, bouton de fermeture/réouverture du topic -->
    <!-- Si user = auteur du topic: bouton de fermeture/réouverture du topic -->
    <?php
    if($topic->getStatus() == 0) {
        $actionText = "Rouvrir";
    }
    else {
        $actionText = "Fermer";
    }

    if(!empty($_SESSION["user"]) && ($_SESSION["user"]->getId() == $topic->getUser()->getId())) {
    ?>
        <a href="index.php?ctrl=forum&action=closeTopic&id=<?= $topic->getId() ?>">(Auteur) <?= $actionText ?> le topic</a>
    <?php
    }
    else if(!empty($_SESSION["user"]) && ($userConnectedRoleFromBdd == "ROLE_ADMIN")) {
    ?>
        <a href="index.php?ctrl=forum&action=closeTopic&id=<?= $topic->getId() ?>">(Admin) <?= $actionText ?> le topic</a>
    <?php
    }
    ?>

    <!-- Gestion du droit d'écrire un post -->
    <?php 
    if($topic->getStatus() == 1) {
    ?>
        <p>Publier un message</p>
        <form action="index.php?ctrl=forum&action=addPost&topicId=<?= $topic->getId() ?>" method="post">
            <label for="postText">Message</label>
            <textarea id="postText" name="postText"></textarea>
            <input type="submit" value="Envoyer">
        </form>
    <?php 
    } else {
    ?>
        <p>L'auteur a fermé le topic</p>
    <?php
    }
    ?>

  
