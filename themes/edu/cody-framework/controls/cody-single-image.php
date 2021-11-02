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
class CF_SingleMedia_Control extends WP_Customize_Control {
	
	
	/**
	 * Relation to elements with the children class
	 */
	public $relation = '';
	
	/**
	 * Enqueue control related scripts/styles.
	 */
	public function enqueue() {
		wp_enqueue_media();
	}
	
	/**
	 * Content of the control
	 */
	public function render_content(){
	?>
		<div class="<?php echo $this->relation; ?>">
			<label id="single-media">
				<span class="customize-control-title"><?php echo esc_html($this->label); ?><span class="cody-help" data-title="<?php echo wp_kses_post($this->description); ?>"></span></span>
				<div>
					<?php if ( $this->value() != '' ) {
						$url = wp_get_attachment_image_url( $this->value(), 'full' );
					} else {
						$url = '';
					}?>
					<img src="<?php echo $url; ?>" />
					<div>
						<button type="submit" class="upload_image_button button">Загрузить</button>
						<button type="submit" class="remove_image_button button">&times;</button>
					</div>
				</div>
				<input type="hidden" id="<?php echo $this->id; ?>" name="<?php echo $this->id; ?>" value="<?php echo $this->value(); ?>" <?php $this->link(); ?>/>
			</label>
		</div>
	<?php
	}
}