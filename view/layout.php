<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tiny.cloud/1/zg3mwraazn1b2ezih16je1tc6z7gwp5yd4pod06ae5uai8pa/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" />
    <link rel="stylesheet" href="<?= PUBLIC_DIR ?>/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Abel&display=swap" rel="stylesheet">

    <!-- https://datatables.net/ -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css">
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/698848973e.js" crossorigin="anonymous"></script>

    <title>FORUM</title>
</head>
<body>
    <div id="wrapper"> 
       
        <div id="mainpage">
            <!-- c'est ici que les messages (erreur ou succès) s'affichent-->
            <p class="message msgFixed msgError"><?= App\Session::getFlash("error") ?></p>
            <p class="message msgFixed msgSuccess"><?= App\Session::getFlash("success") ?></p>
            <header>
                <nav>
                    <div id="nav-left">
                        <a id="titleSite" href="/">Forum</a>
                    </div>
                    <div id="nav-right">
                    <?php
                        
                        if(App\Session::getUser()){
                            ?>
                            <a class="onglets" href="index.php?ctrl=forum&action=listTopics">Parcourir les topics</a>
                            <a class="onglets" href="index.php?ctrl=category&action=index">Catégories</a>
                            <div style="display:inline-flex">
                                <a class="onglets" href="index.php?ctrl=security&action=viewProfile"><span class="fas fa-user"></span>&nbsp;<?= ucfirst(App\Session::getUser()->getUsername()) ?></a>
                                <a class="onglets" href="index.php?ctrl=security&action=logout">Déconnexion</a>
                                <?php
                                if(App\Session::isAdmin()){
                                    ?>
                                        <a class="onglets" href="index.php?ctrl=home&action=users">Admin</a>
                                    <?php
                                }
                                ?>
                            </div>
                            <?php
                        }
                        else{
                            ?>
                            <a class="onglets" href="index.php?ctrl=security&action=connexionForm">Connexion</a>
                            <a class="onglets" href="index.php?ctrl=security&action=subscribeForm">Inscription</a>
                            <a class="onglets" href="index.php?ctrl=forum&action=listTopics">Liste des topics</a>
                            <a class="onglets" href="index.php?ctrl=category&action=index">Liste des catégories</a>
                        <?php
                        }
                    ?>
                    </div>
                </nav>
            </header>
            
            <main id="forum">
                <?= $page ?>
            </main>
        </div>
        <footer>
            <p>&copy; 2020 - Forum CDA - <a href="/home/forumRules.html">Règlement du forum</a> - <a href="">Mentions légales</a></p>
            <!--<button id="ajaxbtn">Surprise en Ajax !</button> -> cliqué <span id="nbajax">0</span> fois-->
        </footer>
    </div>
    <script
        src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous">
    </script>
    <script>

        $(document).ready(function(){
            $(".message").each(function(){
                if($(this).text().length > 0){
                    $(this).slideDown(500, function(){
                        $(this).delay(3000).slideUp(500)
                    })
                }
            })
            $(".delete-btn").on("click", function(){
                return confirm("Etes-vous sûr de vouloir supprimer?")
            })
            tinymce.init({
                selector: '.post',
                menubar: false,
                plugins: [
                    'advlist autolink lists link image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table paste code help wordcount'
                ],
                toolbar: 'undo redo | formatselect | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help',
                content_css: '//www.tiny.cloud/css/codepen.min.css'
            });
        })

        

        /*
        $("#ajaxbtn").on("click", function(){
            $.get(
                "index.php?action=ajax",
                {
                    nb : $("#nbajax").text()
                },
                function(result){
                    $("#nbajax").html(result)
                }
            )
        })*/
    </script>
</body>
</html>