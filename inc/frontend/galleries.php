<?php

/**
 * This is the hero carousel - we might repurpose this to use in other places later
 */
function benjamin_carousel_markup($images =array(), $size = 'carousel-feed') {
    if(empty($images))
        return null;

    $images = explode(',', $images);
    $count = count($images);


    ?>
    <div id="carousel" class="js--carousel carousel cf" data-ride="carousel">


        <!-- Wrapper for slides -->
        <div class="carousel-inner cf" role="listbox">
            <?php foreach($images as $i=>$id): ?>
                <?php
                    $image = get_post($id);
                    $image_title = $image->post_title;
                    $image_caption = $image->post_excerpt;
                    $src = wp_get_attachment_image_src($id, $size);
                    if(empty($src))
                        continue;

                    $active = ($i == 0) ? 'active' : '';

                 ?>
                <div class="item <?php echo esc_attr($active); ?>">
                    <img src="<?php echo esc_url($src[0]); ?>" alt="...">
                    <div class="carousel-caption">
                        <?php echo esc_html($image_caption); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>


        <!-- Indicators -->
        <ol class="carousel-indicators cf">
            <?php for($num = 0; $num < $count; $num++ ): ?>
            <?php $active = ($num == 0) ? 'active' : ''; ?>
            <li class="<?php echo esc_attr($active); ?> " data-target="#carousel" 
                data-slide-to="<?php echo esc_attr($num); ?>" >
                &nbsp;
             </li>
        <?php endfor; ?>
        </ol>

        <div class="carousel-controls">
            <!-- Controls -->
            <a class="carousel-control carousel-control--left js--next" href="#" role="button" data-slide="prev">
                <span class="dashicons dashicons-arrow-left-alt2" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control carousel-control--right js--prev" href="#" role="button" data-slide="next">
                <span class="sr-only">Next</span>
                <span class="dashicons dashicons-arrow-right-alt2" aria-hidden="true"></span>
            </a>
        </div>
    </div>
    <?php
}


function benjamin_get_carousel_markup($images =array(), $size = 'carousel-feed'){
    $content = '';
    ob_start();
        benjamin_carousel_markup($images, $size);
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}
