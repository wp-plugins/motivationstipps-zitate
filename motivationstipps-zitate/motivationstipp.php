<?php
/*
Plugin Name: Dirk Schmidt Motivationstipp
Plugin URI: http://www.dirkschmidt.com
Description: Dieses Widget zeigt einen motivierenden Spruch an. Powered by Motivationstrainer Dirk Schmidt
Author: Dirk Schmidt
Version: 1
Author URI: http://www.dirkschmidt.com
*/
 


class motivations_tipp extends WP_Widget {

function motivations_tipp() {
    $widget_ops = array( 'classname' => 'motivations_tipp', 'description' => __('Zeigt ein motivierendes Zitat an', 'wptheme'));
    $this->WP_Widget( 'motivations_tipp', __('Motivationstipp', 'wptheme'), $widget_ops, $control_ops);
}

public function widget( $args, $instance ) {
	
	//include(plugin_dir_path( __FILE__ ) . '/tipps.php');
	include_once('tipps.php');
	wp_enqueue_style('ds-css');   
	 $anzahltipps = count($tipps);
  $tippnr =  rand(0, $anazahltipps-1);
  
  
    extract( $args );
    $title = apply_filters('widget_title', $instance['title'] );
//This is the variable of the checkbox
    $mtlink = $instance['mtlink'] ? 'true' : 'false';

    echo $before_widget;

        if ( $title ) {
            echo $before_title . $title . $after_title;
        }
                    //Retrieve the checkbox
                   ?>
            <p><span class='ds-tipp'>&raquo;<?php echo $tipps[$tippnr][0] ?>&laquo;</span><br /><span class='ds-autor'><?php echo $tipps[$tippnr][1] ?></span><?php if('on' == $instance['mtlink'] ) {
            ?><br /><a href='http://www.dirkschmidt.com' title='Motivationstrainer Dirk Schmidt' target='_blank' class='ds-copy'>powered by Dirk Schmidt</a></p><?php } ?>
			
        <?php 
    echo $after_widget;
}

public function update( $new_instance, $old_instance ) {
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
//The update for the variable of the checkbox
            $instance['mtlink'] = $new_instance['mtlink'];
    return $instance;
}

public function form( $instance ) {
    $defaults = array( 'title' => __('Motivationstipp', 'wptheme'), 'mtlink' => 'off' );
    $instance = wp_parse_args( (array) $instance, $defaults ); 
    ?>
    <p>
                <label for="<?php echo $this->get_field_id('title'); ?>">Title</label>
                <input class="widefat"  id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
    </p>
<!-- The input (checkbox) -->
            <p>
                <input class="checkbox" type="checkbox" <?php checked($instance['mtlink'], 'on'); ?> id="<?php echo $this->get_field_id('mtlink'); ?>" name="<?php echo $this->get_field_name('mtlink'); ?>" /> 
                <label for="<?php echo $this->get_field_id('mtlink'); ?>">Anbieter mit Link unterstützen</label>
                <p><small>Es würde uns freuen, wenn Sie uns mit einem Link unterstützen - dies ist föllig kostenlos für Sei</small></p>
    </p>
<?php
}
}
 

function register_dstipp() {
   register_widget('motivations_tipp');
   wp_register_style( 'ds-css', plugin_dir_url( __FILE__ ) .'ds-css.css' );
}
add_action( 'widgets_init', 'register_dstipp' );


//SHORTCODE
function motivationstipp_shortcode( $atts, $content = null)	{
 
	$atts = shortcode_atts( array(
		'link' => 'no',
	), $atts, 'ds-motivationstipp' );
	
	include(plugin_dir_path( __FILE__ ) . '/tipps.php');
	wp_enqueue_style('ds-css');   
  
  $anzahltipps = count($tipps);
  $tippnr =  rand($anzahltipps-1,0);
  
  if($atts['link'] == "no"){
	   return
  
  "<p><span class='ds-tipp'>&raquo;".$tipps[$tippnr][0] ."&laquo;</span><br /><span class='ds-autor'>". $tipps[$tippnr][1] ."</span><br /></p>" ;
	  
	  } else {
  
  return
  
  "<p><span class='ds-tipp'>&raquo;".$tipps[$tippnr][0] ."&laquo;</span><br /><span class='ds-autor'>". $tipps[$tippnr][1] ."</span><br /><a href='http://www.dirkschmidt.com' title='Motivationstrainer Dirk Schmidt' target='_blank' class='ds-copy ds-shortcode'>powered by Dirk Schmidt</a></p>" ;
  }
 
}
add_shortcode('ds-motivationstipp', 'motivationstipp_shortcode');

?>