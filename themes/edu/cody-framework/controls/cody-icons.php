<?php
/**
 * @author https://github.com/Arcath/wp-controls
 */

if ( ! defined( 'ABSPATH' ) ) exit;


if ( ! class_exists( 'WP_Customize_Control' ) )
    return NULL;


/**
 * Class to create a custom control
 */
class CF_Icons_Control extends WP_Customize_Control{


	/**
	 * Relation to elements with the children class
	 */
	public $relation = '';


	public function __construct($manager, $id, $args = array()){
		add_action( 'customize_controls_enqueue_scripts', array($this, 'assets') );
		parent::__construct($manager, $id, $args);
	}
	
	public function assets(){
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_style( 'wp-color-picker' );
 		wp_enqueue_style( 'font-icon-picker-css', get_template_directory() . '/cody-framework/assets/icons.css' );
		wp_enqueue_script( 'font-icon-picker', get_template_directory() . '/cody-framework/assets/icons.js', array('jquery') );
	}
	
	public function render_content(){
		?>
		<script type="text/javascript">
		jQuery(document).ready(function($) {
			if(!(window.hasOwnProperty('mediaIconsLoad'))){
				window.mediaIconsLoad = {}
			}
			window.mediaIconsLoad['<?php echo( $this->settings['default']->id ); ?>'] = [
			<?php 
			if ( $this->value() ) {
				foreach( $this->value() as $icon ) {
					echo( json_encode( $icon ) ) . ',';
				}
			} ?>
			]
		});
		</script>
		<div class="<?php echo $this->relation; ?>">
			<label id="mediaIcons">
				<span class="customize-control-title"><?php echo esc_html($this->label); ?><span class="cody-help" data-title="<?php echo wp_kses_post($this->description); ?>"></span></span>
				<ul id="media-icons-list">
				</ul>
				<a href="#" id="mi-add-new" class="button button-primary"><?php _e( 'Add' ); ?></a>
				<input type="hidden" <?php echo($this->link()); ?> id="media-icons-data">
			</label>
		</div>
		<?php
	}
}