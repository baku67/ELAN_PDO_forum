<?php

$userMsgList = $result["data"]['userMsgList'];

// A améliorer (ajouter un vrai COUNT())
$count = 0;
   
?>


    <h2>Messages de l'utilisateur (<span id="countTitle"><?= $count ?></span>)</h2>
    
    <?php
    if (!empty($userMsgList)) {
        foreach ($userMsgList as $post) {
        $count += 1;
        ?>
            <a href="index.php?ctrl=forum&action=topicDetail&id=<?= $post->getTopic()->getId() ?>">
                <div class="postCard">
                    <p><?= $post->getText() ?></p>
                    <span class="postInfos">le <?= $post->getCreationdate() ?></span>
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

    <!-- // Affichage du nombre de msg dans le titre apres foreach count -->
    <p id="count" style="display:none"><?= $count ?></p>
    <script>
        var countNbr = document.getElementById("count").innerText;
        document.getElementById("countTitle").innerText = countNbr;
    </script>

    