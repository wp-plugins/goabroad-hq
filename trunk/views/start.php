<form action="<?php echo esc_url( GoAbroadHQ_Admin::get_page_url() ); ?>" method="post" id="goabroadhq-enter-api-cred">
  <input id="username" placeholder="username" name="username" type="text" value="">
  <input id="password" placeholder="password" name="password" type="text" value="">
  <input type="hidden" name="action" value="enter-key">
  <?php wp_nonce_field( GoAbroadHq_Admin::NONCE ); ?>
  <input type="submit" name="submit" id="submit" class="button button-secondary" value="Activate">
</form>