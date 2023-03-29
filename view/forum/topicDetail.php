<?php

$topic = $result["data"]['topicDetail'];

$posts = $result["data"]['posts'];

$postsCount = $result["data"]['topicPostsCount'];

$userTopicLikeList = $result["data"]['likeList'];


if($topic->getStatus() == 1) {
    $statusText = "Ouvert";
}
else {
    $statusText = "Fermé";
}
    
?>

<?php 
if(!empty($userTopicLikeList)) {
    foreach ($userTopicLikeList as $like) {
        echo("postId liké: " . $like->getPost()->getId());
    }
}
?>

<h1>Detail du topic n°<?= $topic->getId() ?><span> &nbsp;(<?= $statusText ?>)</span></h1><span>(<?= $postsCount ?> messages)</span>


    <p><?=$topic->getTitle()?></p>
    <p>by <?=$topic->getUser()->getUsername()?>, le <?=$topic->getCreationdate()?></p>

    <?php
    if (isset($posts)) {
        foreach ($posts as $post) {
        ?>
            <div class="postCard">
                <p><?= $post->getText() ?></p>
                <span class="postInfos">by <a href="index.php?ctrl=security&action=viewUserProfile&id=<?= $post->getUser()->getId() ?>"><?= $post->getUser()->getUsername() ?></a>, le <?= $post->getCreationdate() ?></span>
                <?php
                if(App\Session::getUser()){
                ?>
                    <!-- Liste objet from like inner join user inner join post where userID
                        Puis dans foreach post, si postId présent dans listLike ? -->
                    <a href="index.php?ctrl=forum&action=likePost&id=<?= $post->getId() ?>&id2=<?= $topic->getId() ?>"><i class="fa-solid fa-thumbs-up"></i></a>
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
    else if(!empty($_SESSION["user"]) && ($_SESSION['user']->getRole() == "ROLE_ADMIN")) {
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

  
