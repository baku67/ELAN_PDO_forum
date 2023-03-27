<?php

$topic = $result["data"]['topicDetail'];

$posts = $result["data"]['posts'];
    
?>

<h1>Detail du topic</h1>


    <p><?=$topic->getTitle()?></p>
    <p>by <?=$topic->getUser()->getUsername()?>, le <?=$topic->getCreationdate()?></p>

    <?php
    if (isset($posts)) {
        foreach ($posts as $post) {
        ?>
            <div class="postCard">
                <p><?= $post->getText() ?></p>
                <span class="postInfos">by <?= $post->getUser()->getUsername() ?>, le <?= $post->getCreationdate() ?></span>
            </div>
        <?php
        }
    } else {
    ?>
        <p class="postCard">Aucun post</p>
    <?php
    }
    ?>


  
