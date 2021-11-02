<?php

if ( ! defined( 'ABSPATH' ) ) exit;


if ( ! class_exists( 'WP_Customize_Control' ) )
    return NULL;


/**
 * Class to create a custom tags control
 */
class CF_WPEditor_Control extends WP_Customize_Control {

	/**
	 * The type of control being rendered
	 */
	public $type = 'tinymce_editor';


	/**
	 * Relation to elements with the children class
	 */
	public $relation = '';
	
	
	/**
	 * Settings of wp editor
	 */
	public $params = array();

	
    /**
     * Render the content on the theme customizer page
     */
    public function render_content() {
        ?>
		<div class="tinymce-control <?php echo $this->relation; ?>">
			<label>
				<span class="customize-control-title"><?php echo esc_html($this->label); ?><span class="cody-help" data-title="<?php echo wp_kses_post($this->description); ?>"></span></span>
				<input class="wp-editor-area" type="hidden" <?php $this->link(); ?> value="<?php echo esc_textarea( $this->value() ); ?>">
				<?php
				$settings = array(
					'textarea_name'    => $this->id,
					'media_buttons'    => false,
					'drag_drop_upload' => false,
					'teeny'            => true,
					'quicktags'        => false,
					'textarea_rows'    => 6,
				);
				$settings = array_merge( $settings, $this->params );
				$this->filter_editor_setting_link();
				wp_editor( $this->value(), $this->id, $settings );
				?>
			</label>
		</div>
        <?php
        do_action( 'admin_footer' );
        do_action( 'admin_print_footer_scripts' );
    }
    private function filter_editor_setting_link() {
        add_filter( 'the_editor', function( $output ) { return preg_replace( '/<textarea/', '<textarea ' . $this->get_link(), $output, 1 ); } );
    }
	
}