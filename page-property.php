<?php
get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

        <div class="container">
            <?php $slider = new WP_Query(array('post_type' => 'property', 'order' => 'ASC')) ?>

            <?php if ($slider->have_posts()) : ?>

                <?php while ($slider->have_posts()) :
                    $slider->the_post(); ?>
                    <div class="property__block">
                        <?php
                        $image_property = simple_fields_value("image_property");
                        $name = simple_fields_value("name");
                        $number_floors = simple_fields_value("number_floors");
                        $type = simple_fields_value("type");
                        $coordinates = simple_fields_value("coordinates");
                        ?>
                        <img src="<?php echo $image_property['url']; ?>">
                        <h2><a href="<?php echo get_permalink(); ?>"><?php echo $name; ?></a></h2>
                        <p>
                            <span class="property__type">Type: <?php echo $type['selected_radiobutton']['value'];?></span>
                            <span class="property__floors">Floors :<?php  echo $number_floors['selected_option']['value']; ?></span>
                        </p>
                    </div>
                <?php endwhile; ?>

            <?php else: ?>
                <div><h1>Not found</h1></div>
            <?php endif;
            ?>

        </div>
    </main><!-- .site-main -->
</div><!-- .content-area -->

<?php get_footer(); ?>

