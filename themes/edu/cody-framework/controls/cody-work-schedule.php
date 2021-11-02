<?php

if ( ! defined( 'ABSPATH' ) ) exit;


if ( ! class_exists( 'WP_Customize_Control' ) )
    return NULL;


/**
 * Class to create work schedule control
 */
class CF_Work_Schedule_Control extends WP_Customize_Control{
	
	
	/**
	 * Enqueue script
	 * https://github.com/loebi-ch/jquery-clock-timepicker
	 */
	public function enqueue() {
		wp_enqueue_script( 'timepicker', get_template_directory_uri() . '/cody-framework/inc/lib/jquery-clock-timepicker.min.js' ,'' ,'' , true );
	}
	
	
	/**
	 * Relation to elements with the children class
	 */
	public $relation = '';
	

	/**
	 * Display control
	 */
	public function render_content(){
		$class = 'time-' . esc_attr( $this->id );
		$week = array( __( 'Mon' ), __( 'Tue' ), __( 'Wed' ), __( 'Thu' ), __( 'Fri' ), __( 'Sat' ), __( 'Sun' ) );
	?>
		<div class="customize_image_select <?php echo $this->relation; ?>">
			<span class="customize-control-title"><?php echo esc_html($this->label); ?><span class="cody-help" data-title="<?php echo wp_kses_post($this->description); ?>"></span></span>
			<script type="text/javascript">
			jQuery(document).ready(function($){
				function work_schedule(elem){
					var arr = [];
					var el = elem.parents('.schedule-box');
					var fields = jQuery.map(el.children('.item'), function(e) {
						var _this = jQuery(e).children('.day');
						if ( _this.hasClass('active') ) {
							arr.push({
								day: _this.attr('data-id'),
								start: jQuery(e).find('.time').children('div').find('.start').val(),
								end: jQuery(e).find('.time').children('div').find('.end').val()
							});
						}
					}).join(',');
					arr = JSON.stringify(arr);
					//console.log(arr);
					el.children('.result').val(arr).change();
				}
				$('.schedule-box .day').click(function(){
					$(this).toggleClass('active'); 
					$(this).siblings('.time').toggleClass('active');
					work_schedule($(this));
				});
				$('.<?php echo $class; ?>').clockTimePicker({
					duration: true,
					durationNegative: true,
					precision: 5,
					minimum: '00:00',
					maximum: '23:59',
				});
				$('.schedule-box .hour').click(function(){
					$(this).siblings('.time').children('div').children('.start').val('00:00');
					$(this).siblings('.time').children('div').children('.end').val('23:59');
					work_schedule($(this));
				});
				$('.<?php echo $class; ?>').focusout(function(){
					work_schedule($(this));
				});
			});
			</script>
			<div class="schedule-box">
				<input type="hidden" class="result" name="<?php echo esc_attr($this->id); ?>" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); ?> />
				<?php
				$i = 0;
				$datas = (array)json_decode( $this->value() );
				foreach( $datas as $data ) {
					$index = (array)$data;
					$result[$index['day']] = $index;
				}
				
				foreach( $week as $day ) {
				?>
				<div class="item">
					<span class="day <?php echo isset( $result[$i] ) && $result[$i]['day'] == $i ? 'active' : ''; ?>" data-id="<?php echo $i; ?>"><?php echo $day; ?></span>
					<span class="hour"><?php _e( '24 h.' ); ?></span>
					<span class="time <?php echo isset( $result[$i] ) && $result[$i]['day'] == $i ? 'active' : ''; ?>"><input type="text" class="start <?php echo $class; ?>" value="<?php echo isset( $result[$i] ) && $result[$i]['start'] != '' ? $result[$i]['start'] : '08:00'; ?>" /> - <input type="text" class="end <?php echo $class; ?>" value="<?php echo isset( $result[$i] ) && $result[$i]['end'] != '' ? $result[$i]['end'] : '20:00'; ?>" /></span>
				</div>
				<?php $i++;
				} ?>
			</div>
		</div>
	<?php
	}
}