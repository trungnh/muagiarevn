<?php $options = _WSH()->option();

 ?>

<!DOCTYPE html>

<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->

<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->

<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->

<!--[if (gte IE 9)|!(IE)]><!--><!--<![endif]-->

<html <?php language_attributes(); ?>>

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicons - Touch Icons -->

    <?php echo ( sh_set( $options, 'site_favicon' ) ) ? '<link rel="shortcut icon" type="image/png" href="'.esc_url(sh_set( $options, 'site_favicon' )).'">': '';?>    



    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

    <!--[if lt IE 9]>

        <script src="<?php echo get_template_directory_uri();?>/js/html5shiv.js"></script>

        <script src="<?php echo get_template_directory_uri();?>/js/respond.min.js"></script>

    <![endif]-->

    

    <?php wp_head(); ?>



</head>



<body <?php body_class('customize-support'); ?>>





    <!-- Page Wrap ===========================================-->

    <div id="wrap"> 



        <!--======= TOP BAR =========-->
		<?php if(sh_set($options, 'topbarstatus')):?>	
        <div class="top-bar">

            <div class="container">
				  
                <ul class="left-bar-side">

                    <?php if(!is_user_logged_in()): ?>
    					<?php if( $login_page = sh_set( $options, 'login_page' ) ): ?>
                        	<li> <a href="<?php echo get_permalink( $login_page ); ?>"><i class="fa fa-lock"></i><?php esc_html_e(' Login', 'comre');?></a> </li>
                            <li> <a href="<?php echo get_permalink( $login_page ); ?>"><i class="fa fa-lock"></i><?php esc_html_e(' Register', 'comre');?></a> </li>
    					<?php endif; ?>
                    <?php else: ?>
                        <li><a href="<?php echo esc_url(wp_logout_url()); ?>" title="<?php esc_html_e('Logout', 'comre'); ?>"><i class="fa fa-user"></i><?php esc_html_e('Logout', 'comre'); ?></a></li>
                        <?php if( $account_page = sh_set( $options, 'account_page' ) ): ?>
                        	<li> <a href="<?php echo get_permalink( $account_page ); ?>"><i class="fa fa-user"></i><?php esc_html_e(' My Account', 'comre');?></a> </li>
    					<?php endif; ?>
                        <?php if( $favourites_page = sh_set( $options, 'favourites_page' ) ): ?>
                        	<li> <a href="<?php echo get_permalink( $favourites_page ); ?>"><i class="fa fa-heart"></i><?php esc_html_e(' My Favourites ', 'comre');?></a></li>
    					<?php endif; ?>
                    <?php endif; ?>

                </ul>
                
				<?php if(sh_set($options, 'show_social_icons')):?>	
                <ul class="right-bar-side social_icons">
                	<?php echo sh_get_social_icons(); ?>
				</ul>
                <?php endif;?>
                

            </div>

        </div>
        
        <?php endif;?>


    

    <!--======= HEADER =========-->

    <header>

        <div class="container"> 



            <!--======= LOGO =========-->
			<div class="logo"> 
            	<?php if(sh_set($options, 'site_logo')):?>
                	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="logo"><img src="<?php echo sh_set($options, 'site_logo');?>" alt="logo" /></a>
            	<?php else:?>
                	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="logo"><img src="<?php echo get_template_directory_uri();?>/images/logo.png" alt="logo" /></a>
            	<?php endif;?>
            </div>
              

            <!--======= SEARCH =========-->
			 <?php if ( is_active_sidebar( 'header-sidebar' ) ) : 
			 		 dynamic_sidebar( 'header-sidebar' );
			else: ?>

            <div class="search">
            
            	<?php get_template_part('includes/modules/searchbox'); ?>

                



            </div>
			<?php endif; ?><!-- end sidebar -->

        </div>



        <!--======= NAV =========-->

        <nav>

            <div class="container"> 



                <!--======= MENU START =========-->

                <ul class="ownmenu">
                <?php wp_nav_menu( array( 'theme_location' => 'main_menu', 'container_id' => 'navbar-collapse-1',
									'container_class'=>'navbar-collapse collapse navbar-right',
									'menu_class'=>'nav navbar-nav',
									'fallback_cb'=>false, 
									'items_wrap' => '%3$s', 
									'container'=>false, 
									'walker'=> new SH_Bootstrap_walker() 
								) ); ?>
				</ul>



                <!--======= SUBMIT COUPON =========-->
				<?php if( $coupon_page = sh_set( $options, 'coupon_page' ) ): ?>
                	<div class="sub-nav-co"> <a href="<?php echo get_permalink( $coupon_page ); ?>"><?php esc_html_e('Submit coupon', 'comre');?></a> </div>
				<?php endif;?>
            </div>

        </nav>

    </header>