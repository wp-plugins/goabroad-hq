<?php
if ( $instance ) {
  $title = $instance['title'];
  $rows = $instance['rows'];
  $required = $instance['required'];
  $labels = $instance['labels'];
  $redirect_url = $instance['redirect_url'];
}
else {
  $title = __( 'Lead Capture' , 'goabroadhq');
  $rows = __( array('Email') , 'goabroadhq');
  $required = __( array('Email'=>true) , 'goabroadhq');
  $labels = __( array('Email'=>'Email') , 'goabroadhq');
  $redirect_url = __( '/' , 'goabroadhq');
}
  $defaults = include(__DIR__.'/../sdk/defaults.php');
?>
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>

    <style type="text/css">
    .lead_capture_row:after {
           visibility: hidden;
           display: block;
           font-size: 0;
           content: " ";
           clear: both;
           height: 0;
       }

      .lead_capture_row {
          display: block;
          padding-bottom: .5rem;
          margin-bottom: .5rem;
          border-bottom: 1px solid #ddd;
      }

      .delete_row {
          display: block;
          float: left;
          padding: .25rem;
          position: relative;
          border: 1px solid #ddd;
          background: #FFB6B6;
          box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.07);
          border-radius: 5px;
          margin-right: 1rem;
      }

      .goabroadhq_select {
          float: left;
          margin-right:1rem;
          display: block;
      }

      .goabroadhq_options {
          float: left;
          padding: 6px;
          display: block;
      }
      .goabroadhq_options_label {
          display: block;
          float: left;
          width: 100%;
      }

      .goabroadhq_options_label > label {
          width: 66px;
          display: block;
          float: left;
          padding: 6px 0;
      }

      .goabroadhq_options_label > input {
          border-radius: 5px;
          display: block;
          float: left;
          width: 243px;
      }
    </style>
<p>
<label for="<?php echo $widget->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:' , 'goabroadhq'); ?></label>
<input class="widefat" id="<?php echo $widget->get_field_id( 'title' ); ?>" name="<?php echo $widget->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
<label for="<?php echo $widget->get_field_id( 'redirect_url' ); ?>"><?php esc_html_e( 'Redirect Url:' , 'goabroadhq'); ?></label>
<input class="widefat" id="<?php echo $widget->get_field_id( 'redirect_url' ); ?>" name="<?php echo $widget->get_field_name( 'redirect_url' ); ?>" type="text" value="<?php echo esc_attr( $redirect_url ); ?>" />
<div id="lead_capture_rows">
  <label>Fields</label>
  <?php if(is_array($rows) && count($rows) > 0): ?>
    <?php foreach($rows as $row): ?>
      <div class="lead_capture_row">
      <div class="goabroadhq_options_label">
        <label>Label</label>
        <input type="text" name="<?php echo $widget->get_field_name('labels'); ?>[<?=$row?>]" placeholder="Label" value="<?= $labels[$row] ?>" />
      </div>
      <button class="delete_row">Delete</button>
      <select class="goabroadhq_select" data-required="<?php echo $widget->get_field_name('required'); ?>" data-label="<?php echo $widget->get_field_name('labels');?>" name="<?php echo $widget->get_field_name('rows'); ?>[]">
        <option value="">Select One</option>
        <?php foreach($HQ->getFieldTypes() as $key=>$val): ?>
          <option value="<?php echo $key ?>" <?php echo $key==$row ? 'selected' : null; ?>><?php echo $val?></option>
        <?php endforeach; ?>
      </select>
      <div class="goabroadhq_options">
        <?php if(!$defaults['fields'][$row]['required']): ?>
          <label><input type="checkbox" name="<?php echo $widget->get_field_name('required'); ?>[<?=$row?>]" <?php if($required[$row]==true) echo 'checked' ?>/> required?</label>
        <?php else: ?>
          <label><input type="checkbox" name="<?php echo $widget->get_field_name('required'); ?>[<?=$row?>]" checked/> required?</label>
        <?php endif; ?>
      </div>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
  <a href="javascript:void(0)" class="add_row">Add Field</a>
</div>
</p>

<script type="text/javascript">
  if(typeof addRow == 'undefined'){
    var addRow = false;
  }
  if(!addRow){
    $(document).on('click','.add_row',function(){
      var rows = '<option value="">Select One</option>';
      <?php foreach($HQ->getFieldTypes() as $key=>$val): ?>
        rows += '<option value="<?php echo $key ?>"><?php echo $val?></option>'
      <?php endforeach; ?>
      var key = $(this).prev().children('select').attr('name');
      var required = $(this).prev().children('select').data('required');
      var label = $(this).prev().children('select').data('label');
      $('<div class="lead_capture_row"><div class="goabroadhq_options_label"></div><button class="delete_row">Delete</button><select name='+key+' data-label="'+label+'" data-required='+required+' class="goabroadhq_select">'+rows+'</select><div class="goabroadhq_options"></div></div>').insertBefore(this);
    })
    $(document).on('click','.delete_row',function(){
      $(this).parent('.lead_capture_row').remove();
    })
    var defaults = JSON.parse('<?= json_encode($defaults) ?>');
    $('body').on('change','.goabroadhq_select',function(e){
      var required = $(this).data('required');
      var label = $(this).data('label');
      $(this).prev().prev('.goabroadhq_options_label').html('<label>Label</label><input type="text" name="'+label+'['+e.target.value+']" placeholder="Label" value="'+defaults['fields'][e.target.value].title+'" />');
      if(!defaults['fields'][e.target.value].required){
        $(this).next('.goabroadhq_options').html('<label><input name="'+required+'['+e.target.value+']" type="checkbox" /> required?</label>');
      } else {
        $(this).next('.goabroadhq_options').html('<label><input name="'+required+'['+e.target.value+']" type="checkbox" checked/> required?</label>');
      }
    });
  }
  addRow = true;

</script>