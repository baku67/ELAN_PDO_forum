<?php

$topics = $result["data"]['topics'];

// $posts = $result["data"]['posts'];

$categories = $result["data"]['categories'];

$totalCountTopics = $result["data"]['totalCountTopics'];

if (isset($result["data"]["catName"])) {
    $catName = $result["data"]["catName"];
}
else {
    $catName = "";
}

if (isset($result["data"]["category"])) {
    $category = $result["data"]["category"];
}
else {
    $category = "";
}
    
?>

<?php 
if (!empty($result["data"]["title"]) && $result["data"]["title"] == "Recherche") {
?>
    <div class="titleDiv">
        <h1 class="titleUnderline">Recherche "<?= $result["data"]["searchText"] ?>"</h1>
        <span>(<?= $totalCountTopics["count"] ?> résultats) <?= $catName ?></span>
    </div>
<?php
}
else if (($result["data"]["title"] == "Liste topics") || (empty($result["data"]["title"]))) {
?>
    <div class="titleDiv">
        <h1 class="titleUnderline">Tout les topics</h1>
        <span>(<?= $totalCountTopics["count"] ?> résultats)</span>
    </div>

<?php
}
else if (($result["data"]["title"] == "Liste topics by Cat") || (empty($result["data"]["title"]))) {
?>
    <div class="titleDiv">
        <h1 class="titleUnderline"><?= $catName ?></h1>
        <span> (<?= $totalCountTopics["count"] ?> résultats)</span>
    </div>
<?php
}
?>
<form class="searchForm" action="index.php?ctrl=forum&action=search" method="post">
    <div class="searchDiv"> 
        <input type="text" name="searchInput" id="searchInput" placeholder="Mots-clés" required>
        <input id="searchSubmit" type="submit" value="Chercher">
    </div>
</form>

<br>
<div class="separatorLine"></div>
<br>

<?php
if(!empty($topics)) {

    foreach($topics as $topic ){

        if($topic->getStatus() == 1) {
            $statusText = "Ouvert";
            $statusStyleClass = "openTopic";
        }
        else {
            $statusText = "Fermé";
            $statusStyleClass = "closedTopic";
        }
    
        // Si auteur du topic: surligagne de l'auteur
        if(App\Session::getUser()) {
            if($topic->getUser()->getId() == $_SESSION["user"]->getId()) {
                $authorClass = "authorTopic";
            }
            else {
                $authorClass = "";
            }
        }
        else {
            $authorClass = "";
        }
    
        // Chercher "carbon php time human reading" library
        // Formattage *Time*Temps*Date
        $date0 = str_replace("/", "-", $topic->getCreationdate());
        $date1 = trim($date0, ",");
        $date2 = new DateTime($date1, new DateTimeZone("+0000"));
        
        $dateNow0 = date("Y-m-d H:i:s");
        $dateNow1 = new DateTime($dateNow0, new DateTimeZone("+0200"));
    
        $dateDiff0 = $date2->diff($dateNow1);
        $dateDiff1 = $dateDiff0->format("il y a %dj %Hh %im");

    ?>

        <a href="index.php?ctrl=forum&action=topicDetail&id=<?= $topic->getId() ?>">
            <div class="topicCard">
                <div class="topicCardHeader">
                    <span class="topicCardTitleLine">
                        <span class="topicCardTitle"><?=$topic->getTitle()?></span>
                    </span>
                    <div class="topicHeaderRight">
                        <span class="categoryLabel"><?=$topic->getCategory()->getName()?></span>
                        <span class="statusTopic <?= $statusStyleClass ?>"><?= $statusText ?></span>
                    </div>
                    <!-- Si SESSION[user] auteur du post: -->
                    <!-- <span style="display:none" class="<?= $authorClass ?>">Auteur</span> -->
                </div>
                <div class="topicCardContent">
                    <p class="lastMsgLine">
                        <span class="lastMsgLabel">Dernier post:</span>
                        <span class="lastMsgText"><?= $topic->getLastPostMsg() ?></span>
                    </p>
                    <div class="topicCardBottomLine">
                        <span class="topicCardNbrMsg"><?= $topic->getNbrPosts() ?> <i class="fa-solid fa-comments"></i></span>
                        <span class="topicCardDate"><?= $dateDiff1 ?>, par <span class="userLink <?= $authorClass ?>" href="index.php?ctrl=security&action=viewUserProfile&id=<?= $topic->getUser()->getId() ?>"><?= $topic->getUser()->getUsername() ?></span></span>
                    </div>
                </div>
            </div>
        </a>

        <br>

    <?php
    }
}
else {
?>
    <p>Aucun résultat :/</p>
<?php
}
?>



    <p class="topicFormTitle">Créer un topic:</p>

    <form action="index.php?ctrl=forum&action=createTopic" method="post">
        <div class="topicFormDiv"> 
            <label>Titre</label>
            <input id="title" type="text" name="title" placeholder="Titre" required>
            <label>Premier message</label>
            <textarea name="firstMsg" placeholder="blabla..." rows="5" required></textarea>
            <label>Catégorie</label>
            <?php 
            if( ($result["data"]["title"] == "Liste topics by Cat") ) {
            ?>
                <input type="text" value="<?= $catName ?>" disabled >
                <input type="hidden" value="<?= $category->getId() ?>" id="category" name="category" >
            <?php
            }
            else {
            ?>
                <select id="category" name="category">
                    <?php 
                    foreach ($categories as $category) { 
                    ?>
                        <option value="<?= $category->getId() ?>"><?= $category->getName() ?></option>
                    <?php 
                    }
                    ?>
                </select>
            <?php
            }
            ?>
            
            <input class="loginSubmit" id="submit" type="submit" value="Créer" style="width: 30% !important">
        </div>
    </form>



  
