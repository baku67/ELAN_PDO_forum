<?php

    $listUsers = $result["data"]['users'];

?>

<p>Liste des utilisateurs</p>
    <table id="usersTable">

        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Date d'inscription</th>
                <th>Likes</th>
            </tr>
        </thead>

        <tbody>
        
            <?php 
            foreach($listUsers as $user) {

                $roleText = "";
                if($user->getRole() == "ROLE_USER") {
                    $roleText = "Utilisateur";
                    $roleSelectedAdmin = "";
                    $roleSelectedStandard = "selected";
                }
                else if ($user->getRole() == "ROLE_ADMIN") {
                    $roleText = "Administrateur";
                    $roleSelectedAdmin = "selected";
                    $roleSelectedStandard = "";
                }

                if($user->getStatus() == 0) {
                    $selectedStandard = "selected";
                    $selectedMute = "";
                    $selectedBan = "";
                }
                else if ($user->getStatus() == 1) {
                    $selectedStandard = "";
                    $selectedMute = "selected";
                    $selectedBan = "";
                }
                else if ($user->getStatus() == 2) {
                    $selectedStandard = "";
                    $selectedMute = "";
                    $selectedBan = "selected";
                }

                // Chercher "carbon php time human reading" library
                // Formattage *Time*Temps*Date
                $date0 = str_replace("/", "-", $user->getSignInDate());
                $date1 = trim($date0, ",");
                $date2 = new DateTime($date1, new DateTimeZone("+0000"));
                
                $dateNow0 = date("Y-m-d H:i:s");
                $dateNow1 = new DateTime($dateNow0, new DateTimeZone("+0200"));

                $dateDiff0 = $date2->diff($dateNow1);
                $dateDiff1 = $dateDiff0->format("il y a %dj %Hh %im");

            ?>
                <tr>
                    <td><?= $user->getId() ?></td>
                    <td><a href="index.php?ctrl=security&action=viewUserProfile&id=<?= $user->getId() ?>"><?= $user->getUsername() ?></a></td>
                    <td><?= $user->getEmail() ?></td>
                    <td>
                        <form action="index.php?ctrl=security&action=changeUserRole" method="post">
                            <input type="hidden" name="userId2" id="userId2" value="<?= $user->getId() ?>">
                            <input type="hidden" name="redirectTo2" id="redirectTo2" value="usersList">
                            <select name="role-Select" id="role-Select" onchange='this.form.submit()'>
                                <option <?= $roleSelectedStandard ?> value="ROLE_USER">Utilisateur</option>
                                <option <?= $roleSelectedAdmin ?> value="ROLE_ADMIN">Administrateur</option>
                            </select>
                            <noscript><input type="submit" value="Ok"></noscript>
                        </form>
                    </td>
                    <td>
                        <!-- Form submitted when select change -->
                        <form action="index.php?ctrl=security&action=changeUserStatus" method="post">
                            <input type="hidden" name="userId" id="userId" value="<?= $user->getId() ?>">
                            <input type="hidden" name="redirectTo" id="redirectTo" value="usersList">
                            <select name="status-Select" id="status-Select" onchange='this.form.submit()'>
                                <option <?= $selectedStandard ?> value=0>Standard</option>
                                <option <?= $selectedMute ?> value=1>Mute</option>
                                <option <?= $selectedBan ?> value=2>Ban</option>
                            </select>
                            <noscript><input type="submit" value="Ok"></noscript>
                        </form>
                    </td>
                    <td><?php echo $dateDiff1 ?></td>
                    <td><?= $user->getLikesCount() ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
        
    </table>

    <p>Ajouter une catégorie</p>
    <form action="index.php?ctrl=category&action=addCategory" method="post">
        <label for="categoryName"></label>
        <input id="categoryName" name="categoryName" type="text" maxlength="20">
        <input type="submit" value="ajouter">
    </form>


    <script>
        let table = new DataTable('#usersTable');
    </script>
