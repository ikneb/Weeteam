<?php
get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">


        <?php $slider = new WP_Query(array('post_type' => 'property', 'order' => 'ASC')) ?>

        <?php  if ($slider->have_posts()) : ?>

            <?php while ($slider->have_posts()) : $slider->the_post(); ?>
                <?php
                    echo $name = simple_fields_value("name");
                    echo '<br>';
                    echo $coordinates = simple_fields_value("coordinates");
                    echo '<br>';

                $number_floors = simple_fields_value("number_floors");
                var_dump($number_floors['selected_option']['value']);
                echo '<br>';

               $type = simple_fields_value("type");
                var_dump($type['selected_radiobutton']['value']);
                echo '<br>';

                $image_property = simple_fields_value("image_property");
                ?>
                <img src="<?php echo $image_property['url'];?>">
                <?php
                echo '<br>';

               /* $rooms = simple_fields_fieldgroup("block");
               foreach ($rooms as $room){
                   echo $room['area'];
                   echo $room['number_rooms']['selected_radiobutton']['value'];
                   echo $room['balcony']['selected_radiobutton']['value'];
                   echo $room['bathroom']['selected_radiobutton']['value'];
                   var_dump($room['image_room']);

               }*/
                echo '<br>';

                ?>
            <?php endwhile; ?>


        <?php else: ?>
            <div><h1>Not found</h1></div>
        <?php endif; ?>


    </main><!-- .site-main -->
</div><!-- .content-area -->

<?php get_footer(); ?>
