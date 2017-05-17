<?php ob_start(); ?>
            <div class="contact-form">
            <div id="message"></div>
            <form role="form" name="contact_form" method="post" id="contact_form" action="<?php echo admin_url( 'admin-ajax.php?action=_sh_ajax_callback&amp;subaction=contact_form_submit'); ?>">
              <ul>
                <li>
                  <input type="text" class="form-control" name="contact_name" id="contact_name" placeholder="<?php esc_html_e('Name', 'comre');?>">
                </li>
                <li>
                  <input type="text" class="form-control" name="contact_email" id="contact_email" placeholder="<?php esc_html_e('Email', 'comre');?>">
                </li>
                <li>
                  <input type="text" class="form-control" name="contact_company" id="contact_company" placeholder="<?php esc_html_e('Company', 'comre');?>">
                </li>
                <li>
                  <input type="text" class="form-control" name="contact_website" id="contact_website" placeholder="<?php esc_html_e('Website', 'comre');?>">
                </li>
                <li>
                  <textarea class="form-control" name="contact_message" id="contact_message" rows="5" placeholder="<?php esc_html_e('Message', 'comre');?>"></textarea>
                </li>
                <li>
                  <button type="submit" value="submit" class="btn" id="submit"><?php esc_html_e('SEND MESSAGE', 'comre');?></button>
                </li>
              </ul>
            </form>
          </div>
      

<?php return ob_get_clean();