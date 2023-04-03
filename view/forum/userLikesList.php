<?php

    $likesList = $result["data"]["likesList"];
    // foreach($likesList as $like) {
    //     echo($like->getUser()->getUsername());
    // }
?>

    <h2><?= $result["data"]["titlePage"] ?></h2>

    <?php
    if(!empty($likesList)) {
    ?>
        <table id="likesTable">
            <thead>
                <tr>
                    <th><i class="fa-regular fa-thumbs-up"></i></th>
                    <th>User</th>
                    <th>Post liké</th>
                    <th>Topic</th>
                </tr>
            </thead>

            <tbody>
                <?php
                foreach($likesList as $like) {
                ?>
                    <tr>
                        <td><i class="fa-solid fa-thumbs-up"></i></td>
                        <td><a href="index.php?ctrl=security&action=viewUserProfile&id=<?= $like->getId() ?>"><?= $like->getUser()->getUsername() ?></a></td>
                        <td><a href="index.php?ctrl=forum&action=topicDetail&id=<?= $like->getPost()->getTopic()->getId() ?>"><?= $like->getPost()->getText() ?></td>
                        <td><a href="index.php?ctrl=forum&action=topicDetail&id=<?= $like->getPost()->getTopic()->getId() ?>"><?= $like->getPost()->getTopic()->getTitle() ?></a></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    <?php
    }
    else {
    ?>
        <p>Aucun Like</p>
    <?php
    }
    ?>


    <script>
        let table = new DataTable('#likesTable');
    </script>

