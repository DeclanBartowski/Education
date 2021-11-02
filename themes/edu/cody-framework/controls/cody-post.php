<?php
/**
 * Class to create a custom post control
 */
if( class_exists( 'WP_Customize_Control' ) ) {
 
	class CF_Posts_Control extends WP_Customize_Control {
		
		public $type = 'posts';
		
		public $post_type = 'post';
	
	
		/**
		 * Multiselect
		 */
		public $multi = 0;
	
	
		/**
		 * Relation to elements with the children class
		 */
		public $relation = '';
		

		public function render_content() {
			
			$posts = new WP_Query( array(
				'post_type'    => $this->post_type,
				'post_status'  => 'publish',
				'numberposts'  => '-1',
			));
			
			$multiple = '';
			if ( $this->multi == 1 ) {
				$multiple = 'multiple';
			} 
		 
		?>
		<div class="<?php echo $this->relation; ?>">
			<label>
				<span class="customize-control-title"><?php echo esc_html($this->label); ?><span class="cody-help" data-title="<?php echo wp_kses_post($this->description); ?>"></span></span>
				<select <?php $this->link(); echo $multiple; ?>>
					<?php
					while( $posts->have_posts() ) {
						$posts->the_post();
						echo "<option " . selected( $this->value(), get_the_ID() ) . " value='" . get_the_ID() . "'>" . the_title( '', '', false ) . "</option>";
					}
					?>
				</select>
			</label>
		</div>
		<?php
		} 
	}
}