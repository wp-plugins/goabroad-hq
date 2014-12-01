<div class="wrap">

  <h2><?php esc_html_e( 'GoAbroadHQ' , 'goabroadhq');?></h2>
  <form action="<?php echo esc_url( GoAbroadHQ_Admin::get_page_url() ); ?>" method="post" id="goabroadhq-enter-api-cred" class="right">
    <label for="goabroadhq_environment">New Credentials</label>
    <input type="text" placeholder="New Username" name="username" />
    <input type="text" placeholder="New Password" name="password" />
    <input type="hidden" name="action" value="save-config">
    <?php wp_nonce_field( GoAbroadHq_Admin::NONCE ); ?>
    <input type="submit" name="submit" id="submit" class="button button-secondary" value="Change Credentials">
  </form>
</div>