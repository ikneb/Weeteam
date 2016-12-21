<?php
/*
Plugin Name: Realty Task Plugin
Plugin URI: http://test.ua
Description: Task plugin.You need create page 'property' for correct work plugin
Version: 1.0
Author: Eduard
*/


add_action('init', 'property_index');
add_action('init', 'district_tag_for_property');
add_filter('page_template', 'property_page_template');
add_filter('the_content', 'singl_page_add_to_content');
add_action('wp_enqueue_scripts', 'load_my_script');
add_shortcode('property-filter', 'property_filter');
add_action( 'widgets_init', 'register_property_widget' );





/*
 * Create taxonomy for type post property
 */
function district_tag_for_property()
{

    $labels = array(
        'name' => _x('Districts', 'districts general name', 'districts'),
        'singular_name' => _x('District', 'districts singular name', 'districts'),
        'search_items' => __('Search District', 'districts'),
        'all_items' => __('All District', 'districts'),
        'parent_item' => __('Parent District', 'districts'),
        'parent_item_colon' => __('Parent District:', 'districts'),
        'edit_item' => __('Edit District', 'districts'),
        'update_item' => __('Update District', 'districts'),
        'add_new_item' => __('Add New District', 'districts'),
        'new_item_name' => __('New District Name', 'districts'),
        'menu_name' => __('District', 'districts'),
    );

    $args = array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'district'),
    );
    register_taxonomy('district', 'property', $args);

}


/*
 * Create new type post property
 */
function property_index()
{
    register_post_type('property', array(
        'public' => true,
        'supports' => array('title'),
        'menu_position' => 5,
        'menu_icon' => 'dashicons-admin-home',
        'labels' => array(
            'name' => 'Property',
            'all_items' => 'All property',
            'add_new' => 'New property',
            'add_new_item' => 'Add property',

        )
    ));
}


/*
 *  Connect
 */
function property_page_template($page_template)
{
    if (is_page('Property')) {
        $page_template = dirname(__FILE__) . '/page-property.php';
    }
    return $page_template;
}


/*
 *  Load script and style
 */
function load_my_script()
{
    wp_enqueue_style('style_my_plugin', plugins_url('/assets/css/style.css', __FILE__));
    wp_enqueue_script('js_my_plugin', plugins_url('/assets/js/main.js', __FILE__), array('jquery'));
}


/*
 * Add information for single page if post type is property
 *
 */
function singl_page_add_to_content($content)
{
    if (is_single() && get_post_type() == 'property') {
        $image_property = simple_fields_value("image_property");
        $name = simple_fields_value("name");
        $number_floors = simple_fields_value("number_floors");
        $type = simple_fields_value("type");
        $coordinates = simple_fields_value("coordinates");

        ?>
        <div class="propperty__singl-block">
            <img src="<?php echo $image_property['url']; ?>">
            <h2><a href="<?php echo get_permalink(); ?>"><?php echo $name; ?></a></h2>
            <p>
                <span class="property__type">Type: <?php echo $type['selected_radiobutton']['value']; ?></span>
                <span class="property__floors">Floors :<?php echo $number_floors['selected_option']['value']; ?></span>
                <span class="property__coordinate">   Coordinate :<?php echo $coordinates; ?></span>
            </p>
            <div class="propery__rooms-block">
                <h3>All foat in <?php echo $name; ?> </h3>
                <?php
                $rooms = simple_fields_fieldgroup("block");
                if (!empty($rooms)):
                    foreach ($rooms as $room):
                        ?>
                        <div class="property__room">
                            <?php
                            if ($room["image_room"]['is_image']):?>
                                <hr>
                                <img src="<?php echo $room["image_room"]['url']; ?>">
                                <h4>Information about float:</h4>
                                <p> Area: <?php echo $room['area']; ?> </p>
                                <p>Number
                                    rooms: <?php echo $room['number_rooms']['selected_radiobutton']['value']; ?></p>
                                <p>Presence
                                    balcony: <?php echo $room['balcony']['selected_radiobutton']['value']; ?></p>
                                <p>Presence
                                    bathroom: <?php echo $room['bathroom']['selected_radiobutton']['value']; ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        <?php

    }
    return $content;
}

/*
 * Short code for filter property
 * [property-filter]
 */
function property_filter()
{
    $content = filter_property_result();
    return $content;
}


/*
 * Widget for filter property
 */
function filter_property_result()
{
    ?>
    <div class="filter__block">
        <h2>Search property for:</h2>

        <form id="form">
            <input type="hidden" id="page" name="page" value="">
            <h3>Properties building</h3>
            <div class="filter__name">
                <label for="name">Name</label>
                <input id="name" type="text" name="name">
            </div>

            <div class="filter__coordinate">
                <label for="coordinates">Coordinate</label>
                <input id="coordinates" type="text" name="coordinates">
            </div>

            <div class="filter__number-floors">
                <label for="number_floors">Numbers floors</label>
                <select name="number_floors" id="number_floors">
                    <option selected="selected">Select</option>
                    <?php for ($i = 1; $i < 21; $i++): ?>
                        <option value="<?= $i ?>"><?= $i ?></option>
                    <?php endfor; ?>
                </select><br>
            </div>
            <div class="filter__type">
                <label for="">Type building:</label><br>
                <input type="radio" name="type" value="radiobutton_num_1">Panel<br>
                <input type="radio" name="type" value="radiobutton_num_2">Brick<br>
                <input type="radio" name="type" value="radiobutton_num_3">Block<br>
            </div>
            <h3>Properties float</h3>
            <div class="filter__area">
                <lable for="area"></lable>
                <input type="text" id="area" name="area">
            </div>
            <div class="filter__number-rooms">
                <label for="number_rooms">Numbers floors</label>

                <select name="number_rooms" id="number_rooms">
                    <option selected="selected">Select</option>
                    <?php for ($i = 1; $i < 11; $i++): ?>
                        <option value="<?= $i ?>"><?= $i ?></option>
                    <?php endfor; ?>
                </select><br>
            </div>

            <div class="filter__balcony">
                <label for="">Type building:</label><br>
                <input type="radio" name="balcony" value="radiobutton_num_1">Yes<br>
                <input type="radio" name="balcony" value="radiobutton_num_2">No<br>
            </div>

            <div class="filter__bathroom">
                <label for="">Type building:</label><br>
                <input type="radio" name="bathroom" value="radiobutton_num_1">Yes<br>
                <input type="radio" name="bathroom" value="Nradiobutton_num_2">No<br>
            </div>

            <div class="filter__button">
                <button type="submit" >Search</button>
            </div>
            <div class="filter__view">
            </div>
        </form>
    </div>

    <?php
}


function register_property_widget() {
    register_widget( 'Property_Widget' );
}

/*
 * Add widget for filter property
 */
class Property_Widget extends WP_Widget {

    function __construct() {
        parent::__construct(
            'property_widget', // Base ID
            esc_html__( 'Property filter', 'text_domain' ), // Name
            array( 'description' => esc_html__( 'A Property Widget', 'text_domain' ), ) // Args
        );
    }

    public function widget( $args, $instance ) {
        echo $args['before_widget'];
        if ( ! empty( $instance['title'] ) ) {
            echo  $instance['title'];
        }
        filter_property_result();
    }

    public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'New title', 'text_domain' );
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'text_domain' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

        return $instance;
    }

}


