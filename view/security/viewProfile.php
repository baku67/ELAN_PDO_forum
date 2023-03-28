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
<h2>Topics</h2>
<?php 
foreach ($result["data"]["userTopicList"] as $topic) {
?>
    <p><span class="categoryLabel"><?=$topic->getCategory()->getName()?></span><a href="index.php?ctrl=forum&action=topicDetail&id=<?= $topic->getId() ?>"><?=$topic->getTitle()?></a></p>
    <br>

<?php
}
?>

