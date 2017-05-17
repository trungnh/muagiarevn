<?php ob_start(); ?>


<?php if( !is_user_logged_in() ): ?>

    <?php $login_page = _WSh()->option('login_page');
    if( $login_page ) {
        $page_content = get_page($login_page);
        if( !is_wp_error($page_content) ) echo do_shortcode($page_content->post_content);
        else echo new WP_Error('post_data_missing', __( 'You need to login or sign up to access this page.' ));
    }
    else echo new WP_Error('post_data_missing', __( 'You need to login or sign up to access this page.' )); ?>

<?php return ob_get_clean();

else: ?>

<section class="comre-my-account-page" id="portfolio">

    <div class="container">

        <div class="row">

            <div class="col-md-2">

                <?php $current_tab = esc_attr( sh_set( $_GET, 'comre_current_tab' ) ); ?>
                <ul class="nav nav-tabs tabs-left">

                    <?php $active = ( !$current_tab || $current_tab == 'profile') ? ' class="active"' : ''; ?>
                    <li <?php echo balanceTags($active); ?>>
                        <a href="<?php echo get_permalink(); ?>"><?php esc_html_e('Profile', 'comre' ); ?></a>
                    </li>

                    <?php $active = ( $current_tab == 'coupon') ? ' class="active"' : ''; ?>

                    <?php if( $coupon ): 

                        $link = add_query_arg(array('comre_current_tab'=>'coupon'));?>
                    
                        <li <?php echo balanceTags($active); ?>>
                            <a href="<?php echo esc_url($link); ?>"><?php esc_html_e('Coupons', 'comre'); ?></a>
                        </li>
                    
                    <?php endif; ?>
                    
                    <?php $active = ( $current_tab == 'blog') ? ' class="active"' : ''; ?>

                    <?php if( $blog ): 

                        $link = add_query_arg(array('comre_current_tab'=>'blog'));?>
                    
                        <li <?php echo balanceTags($active); ?>>
                            <a href="<?php echo esc_url($link); ?>"><?php esc_html_e('Blog', 'comre'); ?></a>
                        </li>
                    
                    <?php endif; ?>

                </ul>
            
            </div>

            <div class="col-md-10">

                <div class="tab-content">

                    <?php $active = ( !$current_tab || $current_tab == 'profile') ? true : false; ?>

                    <?php if( $active ): ?>
                        
                        <div class="tab-pane fade in active">
                            <h5><?php esc_html_e('Profile', 'comre' ); ?></h5>
                            <?php do_action('wt_account_manager_users_form'); ?>
                        </div>
                    
                    <?php endif;

                    $active = ( $current_tab == 'coupon' ) ? true : false;

                    if( $active && $coupon ): ?>
                        <div class="tab-pane fade in active">
                            
                            <h5><?php esc_html_e('Coupons', 'comre'); ?></h5>
                            
                            <?php if(isset($_GET['wtam_current_page']) && esc_attr($_GET['wtam_current_page']) == 'coupon_form' )
                            {
                                do_action('wt_account_manager_coupons_form');   
                            }
                            else {
                                wt_account_manager_get_template_part('coupon/coupon_listing');
                            } ?>

                        </div>
                    <?php endif;

                    $active = ( $current_tab == 'blog' ) ? true : false;

                    if( $active && $blog ): ?>
                        
                        <div class="tab-pane fade in active">
                            
                            <h5><?php esc_html_e('Blog', 'comre') ?></h5>
                            
                            <?php if(isset($_GET['wtam_current_page']) && esc_attr($_GET['wtam_current_page']) == 'post_form' )
                            {
                                do_action('wt_account_manager_post_form');  
                            }
                            else {
                                wt_account_manager_get_template_part('post/post_listing');
                            } ?>
                        
                        </div>
                    
                    <?php endif; ?>

                </div>
        
            </div>

        </div>
    </div>
</section>


<?php return ob_get_clean();

endif;