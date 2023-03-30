<?php
    // echo "<br><br>";
    // var_dump($result["data"]["user"]);
    // echo "<br><br>";
    // var_dump($result["data"]["userTopicList"]);

    if ($result["data"]["user"]->getRole() == "ROLE_ADMIN") {
        $role = "Administrateur";
    }
    else if ($result["data"]["user"]->getRole() == "ROLE_USER") {
        $role = "Utilisateur";
    }


    if ($result["data"]["user"]->getStatus() == 1) {
        $status = "Normal";
    }
    else {
        $status = "Banni";
    }
    
    $countTopics = $result["data"]["countTopics"];

    $userMsgList = $result["data"]["userMsgList"];
    $countMsg = $result["data"]["countMsg"];


    // ** Tous les postLikes du User (All topic)
    $listLikesTopic = $result["data"]['userLikesList'];

    $globalListLikesTopic = [];
    foreach($listLikesTopic as $like) {
        $globalListLikesTopic[] = $like->getPost()->getId();
    }
    // var_dump($globalListLikesTopic);
    // echo("<br>Décompte: ");
    // echo(var_dump(array_count_values($globalListLikesTopic)));
    // ** Exemple de récup du nbr de like en passant l'idPost en index
    // var_dump(array_count_values($globalListLikesTopic)[51]);


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
    
    
?>


<h1>Profile (user n°<?= $result["data"]["user"]->getId() ?>)</h1>

<p>Username: <?= $result["data"]["user"]->getUsername() ?></p>
<p>Email: <?= $result["data"]["user"]->getEmail() ?></p>
<p>Password: ********** </p>
<br>
<p>Rôle: <?= $role ?></p>
<p>Status: <?= $status ?></p>


 <!-- Liste des topics créé par l'user (clickable, modifiables ici) -->
<!-- + liste des topics ou il a parler ? -->
<h2>Topics créés (<?= $countTopics["count"] ?>)</h2>
<?php 
if(!empty($result["data"]["userTopicList"])) {
    foreach ($result["data"]["userTopicList"] as $topic) {

        if($topic->getStatus() == 1) {
            $statusText = "Ouvert";
        }
        else {
            $statusText = "Fermé";
        }
    
        // Chercher "carbon php time human reading" library
        // Formattage *Time*Temps*Date
        $date0 = str_replace("/", "-", $topic->getCreationdate());
        $date1 = trim($date0, ",");
        $date2 = new DateTime($date1, new DateTimeZone("+0000"));
        
        $dateNow0 = date("Y-m-d H:i:s");
        $dateNow1 = new DateTime($dateNow0, new DateTimeZone("+0200"));
    
        $dateDiff0 = $date2->diff($dateNow1);
        $dateDiff1 = $dateDiff0->format("il y a %Ya %mm %dj, %Hh %im %ss");
    ?>
    
    <a href="index.php?ctrl=forum&action=topicDetail&id=<?= $topic->getId() ?>">
        <div class="topicCard">
            <p><span class="categoryLabel"><?=$topic->getCategory()->getName()?></span><?=$topic->getTitle()?><span> &nbsp;(<?= $statusText ?>)</span></p>
            <p><?= $topic->getLastPostMsg() ?></p>
            <p><?= $dateDiff1 ?></p>
        </div>
    </a>

    <br>
<?php
}
}
else {
    if($result["data"]["user"]->getId() == $_SESSION["user"]->getId()) {
?>
    <p style="font-style:italic; opacity:0.7;">Vous n'avez pas créé de Topics pour l'instant</p>
<?php
    } else {
?>
    <p style="font-style:italic; opacity:0.7;">Cet utilisateur n'a publié aucun Topic pour l'instant</p>
<?php
    }
}
?>

<h2>Messages publiés (<?= $countMsg["count"] ?>)</h2>
<?php
    if (!empty($userMsgList)) {
        foreach ($userMsgList as $post) {

            // $isLiked = false;
            // if(in_array($post->getId(), $postIdLikedArray)) {
            //     $isLiked = true;
            // }
            // else {
            //     $isLiked = false;
            // }
        
            if(!empty(array_count_values($globalListLikesTopic)[$post->getId()])) {
                $postLikesCount = array_count_values($globalListLikesTopic)[$post->getId()];
            }
            else {
                $postLikesCount = 0;
            }
            ?>

            <a href="index.php?ctrl=forum&action=topicDetail&id=<?= $post->getTopic()->getId() ?>">
                <div class="postCard">
                    <p><?= $post->getText() ?></p>
                    <span class="postInfos">le <?= $post->getCreationdate() ?></span>
                    <p><?= $postLikesCount ?> likes</p></a>
                </div>
            </a>
        <?php
        }
    } 
    else {
    ?>
        <p class="postCard">Aucun post</p>
    <?php
    }
    ?>
