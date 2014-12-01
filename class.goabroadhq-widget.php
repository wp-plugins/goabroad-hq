<?php
/**
 * @package GoAbroadHQ
 */

require_once(__DIR__.'/sdk/LeadCapture.php');

class GoAbroadHQ_Lead_Widget extends WP_Widget {

	function __construct() {
		load_plugin_textdomain( 'goabroadhq' );
		
		parent::__construct('goabroadhq_lead_widget',__( 'GoAbroadHQ Lead Widget' , 'goabroadhq'),array( 'description' => __( 'Display a GoAbroadHQ lead capture form.' , 'goabroadhq_lead') ));

		if ( is_active_widget( false, false, $this->id_base ) ) {
			add_action( 'wp_head', array( $this, 'css' ) );
		}
	}

	function css() {
		?>

		<style type="text/css">
		.goabroadhq-form input, .goabroadhq-form select {
			display: block;
			width: 100%;
			margin-bottom: 10px;
		}
		</style>

		<?php
			}
	function update( $new_instance, $old_instance ) {
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['rows'] = (is_array($new_instance['rows'])) ? $new_instance['rows'] : array('FirstName');
		return $instance;
	}

	function form( $instance ) {
		$HQ = GoAbroadHQ::LeadCapture();
		GoAbroadHQ::view('widget_admin',array('instance'=>$instance,'widget'=>$this,'HQ'=>$HQ));
	}	
	function widget( $args, $instance ) {
			echo $args['before_widget'];
			if ( ! empty( $instance['title'] ) ) {
				echo $args['before_title'];
				echo esc_html( $instance['title'] );
				echo $args['after_title'];
			}
			$HQ = GoAbroadHQ::LeadCapture();
		?>
		<form action="<?= esc_url( $_SERVER['REQUEST_URI'] ) ?>" class="goabroadhq-form" method="post">
			<input type="hidden" value="goabroadhq_submit" name="goabroadhq_submit" />
			<?php foreach($instance['rows'] as $val): ?>
				<label><?= $HQ->getOption($val,'title'); ?></label>
        <?= $HQ->render($val,array('class'=>'widefat','name'=>$val)) ?>
			<?php endforeach; ?>
			<?php if(!in_array('TimeZoneId', $instance['rows'])): ?>
				<input type="hidden" name="TimeZoneId" value="(UTC-07:00) Mountain Time (US & Canada)" />
			<?php endif; ?>
			<input type="submit" value="submit">
		</form>
		<?php
		echo $args['after_widget'];
	}
}
function goabroadhq_register_widgets() {
	register_widget( 'GoAbroadHQ_Lead_Widget' );
}
if(GoAbroadHQ::get_api_key()){
	add_action( 'widgets_init', 'goabroadhq_register_widgets' );
}
