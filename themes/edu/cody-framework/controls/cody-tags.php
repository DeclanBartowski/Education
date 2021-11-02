<?php
if ( ! class_exists( 'WP_Customize_Control' ) )
    return NULL;
/**
 * Class to create a custom tags control
 */
class CF_Tags_Control extends WP_Customize_Control {
	
	
    private $tags = false;

    public function __construct($manager, $id, $args = array(), $options = array()) {
        $this->tags = get_tags($options);

        parent::__construct( $manager, $id, $args );
    }
	
	
	/**
	 * Relation to elements with the children class
	 */
	public $relation = '';
	
	
	/**
	 * Multiselect
	 */
	public $multi = 0;
	
	
    /**
    * Render the content on the theme customizer page
    */
    public function render_content() {
		global $cody_l18n;
		$multiple = '';
		if ( $this->multi == 1 ) {
			$multiple = 'multiple';
		}
		
		if( !empty($this->tags) ) {
        ?>
		<div class="<?php echo $this->relation; ?>">
            <label>
                <span class="customize-control-title"><?php echo esc_html($this->label); ?><span class="cody-help" data-title="<?php echo wp_kses_post($this->description); ?>"></span></span>
                <select <?php $this->link(); echo $multiple; ?>>
                <?php
                    foreach ( $this->tags as $tag ) {
                        printf('<option value="%s" %s>%s</option>',  $tag->term_id,  selected($this->value(), $tag->term_id, false), $tag->name);
                    }
                ?>
                </select>
            </label>
		</div>
        <?php
		} else { ?>
		<div class="<?php echo $this->relation; ?>">
			<label>
                <span class="customize-control-title">
					<?php echo esc_html($this->label); ?>
					<span class="cody-help" data-title="<?php echo wp_kses_post($this->description); ?>"></span>
				</span>
				<?php echo __( 'No tags found.', $cody_l18n ); ?>
            </label>
		</div>
	<?php }
    }
}