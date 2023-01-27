<?php

$respSlider = $pdo->query('SELECT * FROM slider');
$sliders = $respSlider->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="container" id="slider">
    <div class="row">
        <div class="col">
            <h2 class="text-center text-secondary-emphasis">Slider</h2>
        </div>
    </div>
    <div class="row">
        <table class="table text-secondary-emphasis border border-light mt-5">
            <thead class="text-bg-light">
                <tr style="vertical-align:middle;">
                    <th scope="col">ID</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Image</th>
                    <th scope="col">Description</th>
                    <th scope="col" class="d-flex justify-content-end"><button type="button" onclick="window.location.href = '/website/admin/slider/create_modify_slider.php';" class=" btn btn-primary mx-2">Ajouter</button></th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($sliders as $slider) {
                ?>
                    <tr style="vertical-align:middle;">
                        <th scope="row"><?php echo $slider['id_slider']; ?></th>
                        <td><?php echo $slider['name_slider']; ?></td>
                        <td><img src="/website/uploads/<?php echo $slider['img_slider'] ?>" width="50" height="50"></td>
                        <td><?php echo $slider['desc_slider']; ?></td>
                        <td class="d-flex justify-content-end mt-3">
                            <button type="button" onclick="window.location.href = '/website/admin/slider/create_modify_slider.php?modifier_id_slider=<?php echo $slider['id_slider'] ?>';" class=" btn btn-warning me-2">Modifier</button>
                            <button type="button" onclick="window.location.href = '/website/admin/index.php?supprimer_id_slider=<?php echo $slider['id_slider'] ?>';" class=" btn btn-danger">Supprimer</button>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>