<?php

$respUsers = $pdo->query('SELECT * FROM users ORDER BY user_id');
$users = $respUsers->fetchAll(PDO::FETCH_ASSOC);

?>
<div class="container" id="users">
    <div class="row">
        <div class="col">
            <h2 class="text-center text-secondary-emphasis">Utilisateurs</h2>
        </div>
    </div>
    <div class="row">
        <table class="table text-secondary-emphasis border border-light mt-5">
            <thead class="text-bg-light">
                <tr style="vertical-align:middle;">
                    <th scope="col">ID</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Prenom</th>
                    <th scope="col">Mail</th>
                    <th scope="col" class="d-flex justify-content-end"><button type="button" onclick="window.location.href = '/website/admin/users/create_modify_user.php';" class=" btn btn-primary mx-2">Ajouter</button></th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($users as $user) {
                ?>
                    <tr style="vertical-align:middle;">
                        <th scope="row"><?php echo $user['user_id']; ?></th>
                        <td><?php echo $user['nom']; ?></td>
                        <td><?php echo $user['prenom']; ?></td>
                        <td><?php echo $user['mail']; ?></td>
                        <td class="d-flex justify-content-end">
                            <button type="button" onclick="window.location.href = '/website/admin/users/create_modify_user.php?modifier_id_user=<?php echo $user['user_id'] ?>';" class=" btn btn-warning me-2">Modifier</button>
                            <button type="button" onclick="window.location.href = '/website/admin/index.php?supprimer_id_user=<?php echo $user['user_id'] ?>';" class=" btn btn-danger">Supprimer</button>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>