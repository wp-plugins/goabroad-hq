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
		$instance['redirect_url'] = strip_tags( $new_instance['redirect_url'] );
		$instance['rows'] = (is_array($new_instance['rows'])) ? $new_instance['rows'] : array('Email');
		$instance['labels'] = (is_array($new_instance['labels'])) ? $new_instance['labels'] : array('Email'=>'Email');

		$required = array();
		if(is_array($new_instance['required'])){
			foreach($new_instance['required'] as $key=>$val){
				if($val == 'on'){
					$required[$key]=true;
				} else {
					$required[$key]=false;
				}
			}
		}

		$instance['required'] = $required;
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
			<input type="hidden" value="<?=$instance['redirect_url'] ?>" name="goabroadhq_redirect_url" />
			<?php foreach($instance['rows'] as $val): ?>
				<label <?= $instance['required'][$val] ? 'class="required"' : '' ?> ><?= $instance['labels'][$val] ?></label>
        <?= $HQ->render($val,array('class'=>'widefat','name'=>$val),$instance['required'][$val]) ?>
			<?php endforeach; ?>
			<?php if(!in_array('TimeZoneId', $instance['rows'])): ?>
				<input type="hidden" name="TimeZoneId" value="Mountain Standard Time" />
			<?php endif; ?>
			<?php if(get_option('goabroadhq_recaptcha_sitekey')): ?>
      	<div class="g-recaptcha" data-sitekey="<?=get_option('goabroadhq_recaptcha_sitekey') ?>"></div>
	      <script type="text/javascript"
	          src="https://www.google.com/recaptcha/api.js?hl=<?php echo $lang;?>">
	      </script>
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
