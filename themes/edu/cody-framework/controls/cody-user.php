<?php
/**
 * Customize for user select, extend the WP customizer
 */

if ( ! class_exists( 'WP_Customize_Control' ) )
	return NULL;

class CF_Users_Control extends WP_Customize_Control {

    private $users = false;
	
	
	/**
	 * Relation to elements with the children class
	 */
	public $relation = '';
	
	
	/**
	 * Multiselect
	 */
	public $multi = 0;
	

    public function __construct($manager, $id, $args = array(), $options = array()) {
        $this->users = get_users( $options );

        parent::__construct( $manager, $id, $args );
    }

	/**
	 * Render the control's content.
	 *
	 * Allows the content to be overriden without having to rewrite the wrapper.
	 *
	 * @since   01/13/2013
	 * @return  void
	 */
	public function render_content() {
		
		$multiple = '';
		if ( $this->multi == 1 ) {
			$multiple = 'multiple';
		}
		
        if(empty($this->users)) {
            return false;
        }
		?>
		<div class="<?php echo $this->relation; ?>">
			<label>
				<span class="customize-control-title"><?php echo esc_html($this->label); ?><span class="cody-help" data-title="<?php echo wp_kses_post($this->description); ?>"></span></span>
				<select <?php $this->link(); echo $multiple; ?>>
				<?php foreach( $this->users as $user ) {
					printf('<option value="%s" %s>%s</option>', $user->data->ID, selected($this->value(), $user->data->ID, false), $user->data->display_name);
				} ?>
				</select>
			</label>
		</div>
		<?php
	}
}