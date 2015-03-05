<div class="wrap">

  <h2><?php esc_html_e( 'GoAbroadHQ' , 'goabroadhq');?></h2>
  <h3>Set Up HQ</h3>
  <form action="<?php echo esc_url( GoAbroadHQ_Admin::get_page_url() ); ?>" method="post" id="goabroadhq-enter-api-cred">
    <label for="goabroadhq_environment">New Credentials</label>
    <input type="text" placeholder="New Username" name="username" <?= get_option('goabroadhq_username') ? 'value="'.get_option('goabroadhq_username').'"' : null ?> />
    <input type="password" placeholder="New Password" name="password" <?= get_option('goabroadhq_password') ? 'value="'.get_option('goabroadhq_password').'"' : null ?> />
    <input type="hidden" name="action" value="save-config">
    <?php wp_nonce_field( GoAbroadHq_Admin::NONCE ); ?>
    <input type="submit" name="submit" id="submit" class="button button-secondary" value="Change Credentials">
  </form>
  <hr>
  <h3>Set Up ReCaptcha</h3>
  <p>You can sign up for a recaptcha or learn about it <a href="http://www.google.com/recaptcha/intro/index.html" target="_blank">here</a>.
  <form action="<?php echo esc_url( GoAbroadHQ_Admin::get_page_url() ); ?>" method="post">
    <label for="goabroadhq_environment">ReCaptcha Credentials</label>
    <input type="text" placeholder="New Site Key" name="sitekey" <?= get_option('goabroadhq_recaptcha_sitekey') ? 'value="'.get_option('goabroadhq_recaptcha_sitekey').'"' : null ?> />
    <input type="text" placeholder="New Secret Key" name="secret" <?= get_option('goabroadhq_recaptcha_secret') ? 'value="'.get_option('goabroadhq_recaptcha_secret').'"' : null ?> />
    <input type="hidden" name="action" value="save-recaptcha">
    <?php wp_nonce_field( GoAbroadHq_Admin::NONCE ); ?>
    <input type="submit" name="submit" id="submit" class="button button-secondary" value="Change Credentials">
  </form>
</div>