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
class CF_MultiImages_Control extends WP_Customize_Control{
	
	
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
		<script type="text/javascript">
			if(!(window.hasOwnProperty('multiImagesLoad'))){
				window.multiImagesLoad = {}
			}
			window.multiImagesLoad['<?php echo($this->settings['default']->id); ?>'] = [
			
			<?php 
			if ( $this->value() ) {
				$i = 0;
				foreach( $this->value() as $image ) {
					$data = wp_get_attachment_metadata( $image );
					if( isset( $data['sizes'] ) ){
						$data['id'] = $image;
						foreach( $data['sizes'] as $size => $sizeData ){
							$data['sizes'][$size]['url'] = wp_get_attachment_image_src($image, $size)[0];
						}
						echo( json_encode( $data ) . ',' );
					}
				}
			} ?>
			]
		</script>
		<div class="<?php echo $this->relation; ?>">
			<label id="multiImages">
				<span class="customize-control-title"><?php echo esc_html($this->label); ?><span class="cody-help" data-title="<?php echo wp_kses_post($this->description); ?>"></span></span>
				<label>
					<ul id="multiImages-images" class="multiImages-box">
					</ul>
				</label>
				<span id="multiImages-add" class="dashicons dashicons-plus"></span>
				<input type="hidden" <?php echo($this->link()); ?> id="multi-images-data">
			</label>
		</div>
	<?php
	}
}