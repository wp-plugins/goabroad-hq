<?php
if ( $instance ) {
  $title = $instance['title'];
  $rows = $instance['rows'];
}
else {
  $title = __( 'Lead Capture' , 'goabroadhq');
  $rows = __( array('FirstName') , 'goabroadhq');
}
?>
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>

    <style type="text/css">
    .goabroadhq_select {
      display: block;
    }
    </style>
<p>
<label for="<?php echo $widget->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:' , 'goabroadhq'); ?></label>
<input class="widefat" id="<?php echo $widget->get_field_id( 'title' ); ?>" name="<?php echo $widget->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
<div id="lead_capture_rows">
  <label>Fields</label>
  <?php if(is_array($rows) && count($rows) > 0): ?>
    <?php foreach($rows as $row): ?>
      <select class="goabroadhq_select" name="<?php echo $widget->get_field_name('rows'); ?>[]">
        <option value="">Select One</option>
        <?php foreach($HQ->getFieldTypes() as $key=>$val): ?>
          <option value="<?php echo $key ?>" <?php echo $key==$row ? 'selected' : null; ?>><?php echo $val?></option>
        <?php endforeach; ?>
      </select>
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
      var key = $(this).prev().attr('name');
      console.log(key);
      $('<select class="goabroadhq_select">'+rows+'</select>').insertBefore(this).attr('name',key);
    })
  }
  addRow = true;
</script>