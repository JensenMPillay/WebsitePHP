<?php
$respSlider = $pdo->query('SELECT * FROM slider');
$sliders = $respSlider->fetchAll(PDO::FETCH_ASSOC);

?>
<!-- Carousel  -->
<div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <?php
        for ($i = 0; $i < count($sliders); $i++) {
            $slider = $sliders[$i];
            $key_slider = $i;
            $id_slider = $slider['id_slider'];
        ?> <button type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide-to=<?php echo $key_slider ?> class="<?php if ($i == 0) {
                                                                                                                                    echo "active";
                                                                                                                                } ?>" aria-current="true" aria-label="Slide <?php echo $id_slider ?>"></button><?php } ?>
    </div>
    <div class="carousel-inner">
        <?php
        for ($i = 0; $i < count($sliders); $i++) {
            $slider = $sliders[$i];
            $key_slider = $i;
            $id_slider = $slider['id_slider'];
            $name_slider = $slider['name_slider'];
            $img_slider = $slider['img_slider'];
            $desc_slider = $slider['desc_slider'];
        ?>
            <div class="carousel-item <?php if ($i == 0) {
                                            echo "active";
                                        } ?>">
                <img src="/website/uploads/<?php echo $img_slider ?>" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5 class="text-secondary-emphasis"><?php echo $name_slider ?></h5>
                    <p class="text-secondary-emphasis"><?php echo $desc_slider ?></p>
                </div>
            </div>
        <?php
        } ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
<!-- Carousel -->