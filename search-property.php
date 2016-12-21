<?php
/*
 * Ajax for search property
 */

define('WP_USE_THEMES', false);
require_once('../../../wp-load.php');
/*require_once ('../simple-fields/functions.php');*/

if (isset($_POST)) {
    print_r(get_property());
}

/*
 * Function that check meta data
 * and do query for search property
 *
 */
function get_property()
{
    $page = !empty($_POST['page']) ? $_POST['page'] : 1;
    $limit = 5;
    $posts = wp_count_posts('property');
    $count_posts = $posts->publish;
    $offset = $count_posts - ($limit * $page);

    if ($count_posts % 10 == 0) {
        $pages = ($count_posts / $limit);
    } else {
        $pages = ($count_posts / $limit + 1);
    }

    if (($limit * $page) > $count_posts) {
        $offset = 0;
        $limit = $count_posts % $limit;
    }

    $meta = array();


    if (isset($_POST['name'])) {
        $name = htmlspecialchars($_POST['name']);
        $meta = ['name' => $name];
    }
    if (isset($_POST['coordinates'])) {
        $coordinates = htmlspecialchars($_POST['coordinates']);
        $meta = ['coordinates' => $coordinates];
    }
    if (isset($_POST['number_floors'])) {
        $number_floors = htmlspecialchars($_POST['number_floors']);
        $meta = ['number_floors' => $number_floors];
    }
    if (isset($_POST['type'])) {
        $type = htmlspecialchars($_POST['type']);
        $meta = ['type' => $type];
    }
    if (isset($_POST['area'])) {
        $area = htmlspecialchars($_POST['area']);
        $meta = ['area' => $area];
    }
    if (isset($_POST['number_rooms'])) {
        $number_rooms = htmlspecialchars($_POST['number_rooms']);
        $meta = ['number_rooms' => $number_rooms];
    }
    if (isset($_POST['balcony'])) {
        $balcony = htmlspecialchars($_POST['balcony']);
        $meta = ['balcony' => $balcony];
    }
    if (isset($_POST['bathroom'])) {
        $bathroom = htmlspecialchars($_POST['bathroom']);
        $meta = ['bathroom' => $bathroom];
    }
    
    $query = new WP_Query(array(
        'post_type' => 'property',
        'meta_query' => array($meta),
        'posts_per_page' => $limit,
        'offset' => $offset,
    ));
    if ($query->have_posts()) : ?>

        <?php while ($query->have_posts()) :
            $query->the_post(); ?>
            <hr>
            <div class="search__block">
                <?php
                $image_property = simple_fields_value("image_property");
                $name = simple_fields_value("name");
                $number_floors = simple_fields_value("number_floors");
                $type = simple_fields_value("type");
                ?>
                <img src="<?php echo $image_property['url']; ?>">
                <h3><a href="<?php echo get_permalink(); ?>"><?php echo $name; ?></a></h3>
                <p>
                    <span class="search__type">Type: <?php echo $type['selected_radiobutton']['value']; ?></span>
                    <span class="search__floors">Floors :<?php echo $number_floors['selected_option']['value']; ?></span>
                </p>
            </div>
        <?php endwhile; ?>
        <div class="page-block">
            <?php for ($i = 1; $i <= $pages; $i++): ?>

                <?php if ($i == $page): ?><b><?= $i ?></b>
                <?php else: ?><a class="page" href="<?= $i ?>"><?= $i ?></a>
                <?php endif; ?>

            <?php endfor; ?>
        </div>

    <?php else: ?>
        <div><h1>Not found</h1></div>
    <?php endif;

}
