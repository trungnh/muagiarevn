<?php
add_action( '_sh_after_body_start', '_sh_preloader', 5, 1 );
add_action( '_sh_after_body_start', '_sh_sidebar_menu', 10, 1 );
add_action( '_sh_after_body_start', '_sh_nav_and_logo', 15, 1 );
function _WSH()
{
	return $GLOBALS['_sh_base'];
}
/** function to hook body id */
function _sh_body_id()
{
	do_action( '_sh_body_id' );
}
/** A function to fetch the categories from wordpress */
function sh_get_categories($arg = false, $by_slug = false, $show_all = true)
{
	global $wp_taxonomies;
	if( ! empty($arg['taxonomy']) && ! isset($wp_taxonomies[$arg['taxonomy']]))
	{
		//register_taxonomy( $arg['taxonomy'], 'sh_'.$arg['taxonomy']);
	}
	//printr($arg);
	
	$categories = get_terms(sh_set( $arg, 'taxonomy', 'category' ), $arg);
	$cats = array();
	if( $show_all ) $cats[] = __( 'All Categories', 'comre' );
	
	if( !is_wp_error( $categories ) ) {
	foreach($categories as $category)
	{
		if( $by_slug ) $cats[$category->slug] = $category->name;
		else $cats[$category->term_id] = $category->name;
	}
	}
	return $cats;
}
if( !function_exists( 'sh_slug' ) )
{
	function sh_slug( $string )
	{
		$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
		return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
	}
}
function sh_get_sidebars($multi = false)
{
	global $wp_registered_sidebars;
	$sidebars = !($wp_registered_sidebars) ? get_option('wp_registered_sidebars') : $wp_registered_sidebars;
	if( $multi ) $data[] = array('value'=>'', 'label' => 'No Sidebar');
	else $data = array('' => __('No Sidebar', 'comre'));
	foreach( (array)$sidebars as $sidebar)
	{
		if( $multi ) $data[] = array( 'value'=> sh_set($sidebar, 'id'), 'label' => sh_set( $sidebar, 'name') );
		else $data[sh_set($sidebar, 'id')] = sh_set($sidebar, 'name');
	}
	return $data;
}
if ( ! function_exists('character_limiter'))
{
	function character_limiter($str, $n = 500, $end_char = '&#8230;', $allowed_tags = false)
	{
		if($allowed_tags) $str = strip_tags($str, $allowed_tags);
		if (strlen($str) < $n)	return $str;
		$str = preg_replace("/\s+/", ' ', str_replace(array("\r\n", "\r", "\n"), ' ', $str));
		if (strlen($str) <= $n) return $str;
		$out = "";
		foreach (explode(' ', trim($str)) as $val)
		{
			$out .= $val.' ';
			
			if (strlen($out) >= $n)
			{
				$out = trim($out);
				return ( strlen($out ) == strlen($str)) ? $out : $out.$end_char;
			}		
		}
	}
}
function sh_get_social_icons()
{
	$options = _WSH()->option('social_media');//printr($options);
	$output = '';
	
	$count = 0;
	
	if( sh_set( $options, 'social_media' ) && is_array( sh_set( $options, 'social_media' ) ) )
	{
		$social_media = sh_set( $options, 'social_media' );
		$total = count( $social_media );
		foreach( sh_set( $options, 'social_media' ) as $social_icon ){
			
			if($total <= $count) continue;
			
			if( isset( $social_icon['tocopy' ] ) ) continue;
			
			$title = sh_set( $social_icon, 'title');
			$link = sh_set( $social_icon, 'social_link');
			$icon = sh_set( $social_icon, 'social_icon');
			$color = sh_set( $social_icon, 'hover_color' );
			
			if(!$link && !$icon) continue;
			$output .= '
			<li data-color="'.esc_attr($color).'">
				<a title="'.esc_attr( $title ).'" href="'.esc_url( $link ).'"><i class="fa '.$icon.'"></i></a>
			</li>'."\n";
			
			$count++;
		}
	}
	
	
	return $output;
}
function sh_get_posts_array( $post_type = 'post', $flip = false )
{
	global $wpdb;
	$res = $wpdb->get_results( "SELECT `ID`, `post_title` FROM `" .$wpdb->prefix. "posts` WHERE `post_type` = '$post_type' AND `post_status` = 'publish' ", ARRAY_A );
	
	$return = array();
	foreach( $res as $k => $r) {
		if( $flip ) {
			if( isset( $return[sh_set($r, 'post_title')] ) ) $return[sh_set($r, 'post_title').$k] = sh_set($r, 'ID');
			else $return[sh_set($r, 'post_title')] = sh_set( $r, 'ID' );
		}
		else $return[sh_set($r, 'ID')] = sh_set($r, 'post_title');
	}
	return $return;
}
function get_the_breadcrumb()
{
	global $wp_query;
	$queried_object = get_queried_object();
	
	$breadcrumb = '';
	$delimiter = ' ';
	$before = '<li>';
	$after = '</li>';
	if ( ! is_home())
	{
		$breadcrumb .= '<li><a href="'.home_url().'"><i class="fa fa-home"></i></a>  /  </li>';
		
		/** If category or single post */
		if(is_category())
		{
			$cat_obj = $wp_query->get_queried_object();
			$this_category = get_category( $cat_obj->term_id );
	
			if ( $this_category->parent != 0 ) {
				$parent_category = get_category( $this_category->parent );
				$breadcrumb .= get_category_parents($parent_category, TRUE, $delimiter );
			}
			
			$breadcrumb .= '<li><a href="'.get_category_link(get_query_var('cat')).'">'.single_cat_title('', FALSE).'</a></li>';
		}
		elseif(is_tax())
		{
			$breadcrumb .= '<li><a href="'.get_term_link($queried_object).'">'.$queried_object->name.'</a></li>';
		}
		elseif(is_page()) /** If WP pages */
		{
			global $post;
			if($post->post_parent)
			{
                $anc = get_post_ancestors($post->ID);
                foreach($anc as $ancestor)
				{
                    $breadcrumb .= '<li><a href="'.get_permalink($ancestor).'">'.get_the_title($ancestor).'</a> / </li>';
                }
				$breadcrumb .= '<li>'.get_the_title($post->ID).'</li>';
				
            }else $breadcrumb .= '<li>'.get_the_title().'</li>';
		}
		elseif (is_singular())
		{
			if($category = wp_get_object_terms(get_the_ID(), get_taxonomies()))
			{
				if( !is_wp_error($category) )
				{
					$breadcrumb .= '<li><a href="'.get_term_link(sh_set($category, '0')).'">'.sh_set( sh_set($category, '0'), 'name').'</a> / </li>';
					$breadcrumb .= '<li>'.get_the_title().'</li>';
					
				} else $breadcrumb .= '<li>'.get_the_title().'</li>';
			}else{
				$breadcrumb .= '<li>'.get_the_title().'</li>';
			}
		}
		elseif(is_tag()) $breadcrumb .= '<li><a href="'.get_term_link($queried_object).'">'.single_tag_title('', FALSE).'</a></li>'; /**If tag template*/
		elseif(is_day()) $breadcrumb .= '<li><a href="">'.__('Archive for ', 'comre').get_the_time('F jS, Y').'</a></li>'; /** If daily Archives */
		elseif(is_month()) $breadcrumb .= '<li><a href="' .get_month_link(get_the_time('Y'), get_the_time('m')) .'">'.__('Archive for ', 'comre').get_the_time('F, Y').'</a></li>'; /** If montly Archives */
		elseif(is_year()) $breadcrumb .= '<li><a href="'.get_year_link(get_the_time('Y')).'">'.__('Archive for ', 'comre').get_the_time('Y').'</a></li>'; /** If year Archives */
		elseif(is_author()) $breadcrumb .= '<li><a href="'. esc_url( get_author_posts_url( get_the_author_meta( "ID" ) ) ) .'">'.__('Archive for ', 'comre').get_the_author().'</a></li>'; /** If author Archives */
		elseif(is_search()) $breadcrumb .= '<li>'.__('Search Results for ', 'comre').get_search_query().'</li>'; /** if search template */
		elseif(is_404()) $breadcrumb .= '<li>'.__('404 - Not Found', 'comre').'</li>'; /** if search template */
		elseif ( is_post_type_archive('product') )
		{
			
			$shop_page_id = woocommerce_get_page_id( 'shop' );
			if( get_option('page_on_front') !== $shop_page_id  )
			{
				$shop_page    = get_post( $shop_page_id );
				
				$_name = woocommerce_get_page_id( 'shop' ) ? get_the_title( woocommerce_get_page_id( 'shop' ) ) : '';
		
				if ( ! $_name ) {
					$product_post_type = get_post_type_object( 'product' );
					$_name = $product_post_type->labels->singular_name;
				}
		
				if ( is_search() ) {
		
					$breadcrumb .= $before . '<a href="' . get_post_type_archive_link('product') . '">' . $_name . '</a>' . $delimiter . __( 'Search results for &ldquo;', 'comre' ) . get_search_query() . '&rdquo;' . $after;
		
				} elseif ( is_paged() ) {
		
					$breadcrumb .= $before . '<a href="' . get_post_type_archive_link('product') . '">' . $_name . '</a>' . $after;
		
				} else {
		
					$breadcrumb .= $before . $_name . $after;
		
				}
			}
	
		}
		else $breadcrumb .= '<li><a href="'.get_permalink().'">'.get_the_title().'</a></li>'; /** Default value */
	}
	return '<ul class="sub-nav">'.$breadcrumb.'</ul>';
}
function sh_register_user( $data )
{
	//printr($data);
	$user_name = sh_set( $data, 'user_login' );
	$user_email = sh_set( $data, 'user_email' );
	$user_pass = sh_set( $data, 'user_password' );
	$nonce = sh_set( $data, '_nounce');
	
	$user_id = username_exists( $user_name );
	//$message = '<div class="alert-error" style="margin-bottom:10px;padding:10px"><h5>'.__('You must agreed the policy', 'comre').'</h5></div>';;
	//if( !$policy ) $message = '';
	$message = '';
	if ( ! wp_verify_nonce( $nonce, '__comre_signup_nonce' ) ) {
			$message .= '<div class="alert-error" style="margin-bottom:10px;padding:10px"><h5>'.__('You are trying to spam this form. Stop!', 'comre').'<br>'.'</h5></div>';
			//$error = true;
		}
	else{
	if ( !$user_id && email_exists($user_email) == false ) {
		//exit("ssss");
		if( true ){
			$random_password = ( $user_pass ) ? $user_pass : wp_generate_password( $length=12, $include_standard_special_chars=false );
			$user_id = wp_create_user( $user_name, $random_password, $user_email );
			if ( is_wp_error($user_id) && is_array( $user_id->get_error_messages() ) )
			{
				foreach($user_id->get_error_messages() as $message)	$message .= '<div class="alert-error" style="margin-bottom:10px;padding:10px"><h5>'.$message.'</h5></div>';
			}
			else {
				wp_new_user_notification( $user_id, $random_password);
				$message = '<div class="alert-success" style="margin-bottom:10px;padding:10px"><h5>'.__('Registration Successful - An email is sent', 'comre').'</h5></div>';
			}
		}
		
	} else {
		$message .= '<div class="alert-error" style="margin-bottom:10px;padding:10px"><h5>'.__('Username or email already exists.  Password inherited.', 'comre').'</h5></div>';
	}}
	return $message;
}
function sh_list_comments($comment, $args, $depth)
{
	$GLOBALS['comment'] = $comment; ?>

<li class="media" id="comment-<?php comment_ID(); ?>">
  <?php $email = sh_set( $comment, 'comment_author_email' );
		
		if( $email ): ?>
  <div class="media-left"> <a href="#"> <img class="img-circ media-object" src="<?php echo get_gravatar_url( $email ); ?>" alt="avatar" /> </a> </div>
  <?php else: ?>
  <div class="media-left"> <a href="#"> <img class="img-circ media-object" src="http://0.gravatar.com/avatar/ad516503a11cd5ca435acc9bb6523536?s=70" /> </a> </div>
  <?php endif;?>
  <div class="media-body">
    <h4 class="media-heading"> <?php echo get_comment_author_link(); ?> </h4>
    <span><?php echo get_comment_date(); ?></span>
    <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth'], 'reply_text' => __('Reply', 'comre')))) ?>
  </div>
  <?php comment_text(); /** print our comment text */ ?>
  <?php
	//endif;
}
/**
 * returns the formatted form of the comments
 *
 * @param	array	$args		an array of arguments to be filtered
 * @param	int		$post_id	if form is called within the loop then post_id is optional
 *
 * @return	string	Return the comment form
 */
function sh_comment_form( $args = array(), $post_id = null, $review = false )
{
	if ( null === $post_id )
		$post_id = get_the_ID();
	else
		$id = $post_id;
	$commenter = wp_get_current_commenter();
	$user = wp_get_current_user();
	$user_identity = $user->exists() ? $user->display_name : '';
	$args = wp_parse_args( $args );
	if ( ! isset( $args['format'] ) )
		$args['format'] = current_theme_supports( 'html5', 'comment-form' ) ? 'html5' : 'xhtml';
	$req      = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );
	$html5    = 'html5' === $args['format'];
	$fields   =  array(
		'author' => '<li class="col-sm-4"><label> Name *<input id="website" placeholder="'. __( 'Name', 'comre' ).'" class="border-radius form-control" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></label></li>',
		'email'  => '<li class="col-sm-4"><label> Email *<input id="subject" placeholder="'. __( 'Email', 'comre' ).'" class="border-radius form-control" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></label></li>',
		'website'  => '<li class="col-sm-4"><label> Subject<input id="comment_subject" placeholder="'. __( 'Subject', 'comre' ).'" class="border-radius form-control" name="subject" ' . ( $html5 ? 'type="text"' : 'type="text"' ) . ' size="30"' . $aria_req . ' /></label></li>',				
	);
	$required_text = sprintf( ' ' . __('Required fields are marked %s', 'comre'), '<span class="required">*</span>' );
	/**
	 * Filter the default comment form fields.
	 *
	 * @since 3.0.0
	 *
	 * @param array $fields The default comment fields.
	 */
	$fields = apply_filters( 'comment_form_default_fields', $fields );
	$defaults = array(
		'fields'               => $fields,
		'comment_field'        => '<li class="col-sm-12"><label> MESSAGE<textarea id="comments" placeholder="'. __( 'Enter Your Comment here.....', 'comre' ).'" class="form-control" name="comment" cols="45" rows="8" aria-required="true"></textarea></label></li>',
		'must_log_in'          => '<li class="col-md-12 col-sm-12">' . sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.', 'comre' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</li>',
		'logged_in_as'         => '<li class="col-md-12 col-sm-12">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'comre' ), get_edit_user_link(), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</li>',
		'comment_notes_before' => '<p class="col-md-12 col-sm-12">' . __( 'Your email address will not be published.', 'comre' ) . ( $req ? $required_text : '' ) . '</p>',
		'comment_notes_after'  => '<li class="col-md-12 col-sm-12">' . sprintf( __( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s', 'comre' ), ' <code>' . allowed_tags() . '</code>' ) . '</li>',
		'id_form'              => 'comments_form',
		'id_submit'            => 'submit',
		'title_reply'          => __( 'leave a comment', 'comre' ),
		'title_reply_to'       => __( 'Leave a Reply to %s', 'comre' ),
		'cancel_reply_link'    => __( 'Cancel reply', 'comre' ),
		'label_submit'         => __( 'Post comment', 'comre' ),
		'format'               => 'xhtml',
	);
	/**
	 * Filter the comment form default arguments.
	 *
	 * Use 'comment_form_default_fields' to filter the comment fields.
	 *
	 * @since 3.0.0
	 *
	 * @param array $defaults The default comment form arguments.
	 */
	$args = wp_parse_args( $args, apply_filters( 'comment_form_defaults', $defaults ) );
	?>
  <?php if ( comments_open( $post_id ) ) : ?>
  <?php
			/**
			 * Fires before the comment form.
			 *
			 * @since 3.0.0
			 */
			do_action( 'comment_form_before' );
			?>
  <div id="respond" class="comments_form">
    <div class="widget-title">
      <h3>
        <?php comment_form_title( $args['title_reply'], $args['title_reply_to'] ); ?>
        <small>
        <?php cancel_comment_reply_link( $args['cancel_reply_link'] ); ?>
        </small></h3>
    </div>
    <?php if ( get_option( 'comment_registration' ) && !is_user_logged_in() ) : ?>
    <?php echo balanceTags($args['must_log_in']); ?>
    <?php
					/**
					 * Fires after the HTML-formatted 'must log in after' message in the comment form.
					 *
					 * @since 3.0.0
					 */
					do_action( 'comment_form_must_log_in_after' );
					?>
    <?php else : ?>
    <form action="<?php echo site_url( '/wp-comments-post.php' ); ?>" method="post" id="<?php echo esc_attr( $args['id_form'] ); ?>" class="row"<?php echo balanceTags($html5) ? ' novalidate' : ''; ?>>
      <?php
						/**
						 * Fires at the top of the comment form, inside the <form> tag.
						 *
						 * @since 3.0.0
						 */
						do_action( 'comment_form_top' );
						?>
      <ul class="row">
        <?php if ( is_user_logged_in() ) : ?>
        <?php
							/**
							 * Filter the 'logged in' message for the comment form for display.
							 *
							 * @since 3.0.0
							 *
							 * @param string $args['logged_in_as'] The logged-in-as HTML-formatted message.
							 * @param array  $commenter            An array containing the comment author's username, email, and URL.
							 * @param string $user_identity        If the commenter is a registered user, the display name, blank otherwise.
							 */
							echo apply_filters( 'comment_form_logged_in', $args['logged_in_as'], $commenter, $user_identity );
							?>
        <?php
							/**
							 * Fires after the is_user_logged_in() check in the comment form.
							 *
							 * @since 3.0.0
							 *
							 * @param array  $commenter     An array containing the comment author's username, email, and URL.
							 * @param string $user_identity If the commenter is a registered user, the display name, blank otherwise.
							 */
							do_action( 'comment_form_logged_in_after', $commenter, $user_identity );
							?>
        <?php else : ?>
        <?php echo balanceTags($args['comment_notes_before']); ?>
        <?php
							/**
							 * Fires before the comment fields in the comment form.
							 *
							 * @since 3.0.0
							 */
							do_action( 'comment_form_before_fields' );
							foreach ( (array) $args['fields'] as $name => $field ) {
								/**
								 * Filter a comment form field for display.
								 *
								 * The dynamic portion of the filter hook, $name, refers to the name
								 * of the comment form field. Such as 'author', 'email', or 'url'.
								 *
								 * @since 3.0.0
								 *
								 * @param string $field The HTML-formatted output of the comment form field.
								 */
								echo apply_filters( "comment_form_field_{$name}", $field ) . "\n";
							}
							/**
							 * Fires after the comment fields in the comment form.
							 *
							 * @since 3.0.0
							 */
							do_action( 'comment_form_after_fields' );
							?>
        <?php endif; ?>
        <?php
						/**
						 * Filter the content of the comment textarea field for display.
						 *
						 * @since 3.0.0
						 *
						 * @param string $args['comment_field'] The content of the comment textarea field.
						 */
						echo apply_filters( 'comment_form_field_comment', $args['comment_field'] );
						?>
        <?php echo balanceTags($args['comment_notes_after']); ?>
        <li class="col-sm-4">
          <input name="submit" type="submit" class="pull-left btn btn-primary" id="<?php echo esc_attr( $args['id_submit'] ); ?>" value="<?php echo esc_attr( $args['label_submit'] ); ?>" />
          <?php comment_id_fields( $post_id ); ?>
        </li>
        <?php
						/**
						 * Fires at the bottom of the comment form, inside the closing </form> tag.
						 *
						 * @since 1.5.2
						 *
						 * @param int $post_id The post ID.
						 */
						do_action( 'comment_form', $post_id );
						?>
      </ul>
    </form>
    <?php endif; ?>
  </div>
  <!-- #respond -->
  <?php
			/**
			 * Fires after the comment form.
			 *
			 * @since 3.0.0
			 */
			do_action( 'comment_form_after' );
		else :
			/**
			 * Fires after the comment form if comments are closed.
			 *
			 * @since 3.0.0
			 */
			do_action( 'comment_form_comments_closed' );
		endif;
}
function sh_blog_excerpt_more( $more ) {
	return '';
}
add_filter('excerpt_more', 'sh_blog_excerpt_more');
function _the_pagination($args = array(), $echo = 1)
{
	
	global $wp_query;
	
	$default =  array('base' => str_replace( 99999, '%#%', esc_url( get_pagenum_link( 99999 ) ) ), 'format' => '?paged=%#%', 'current' => max( 1, get_query_var('paged') ),
						'total' => $wp_query->max_num_pages, 'next_text' => '&raquo;', 'prev_text' => '&laquo;', 'type'=>'list');
						
	$args = wp_parse_args($args, $default);			
	
	//$pagination = '<div class="text-center pagination">'.paginate_links($args).'</div>';
	$pagination = str_replace("<ul class='page-numbers'", '<ul class="pagination"', paginate_links($args) );
	
	if(paginate_links(array_merge(array('type'=>'array'),$args)))
	{
		if($echo) echo balanceTags($pagination);
		return $pagination;
	}
}
add_action( '_sh_blog_post_image', 'sh_get_post_format_output' );
function sh_get_post_format_output($meta = array() )
{
	global $post;
	
	//if( ! $settings ) return;
	$meta = ( $meta ) ? $meta : _WSH()->get_meta();
	$format = get_post_format();
	
	$format = get_post_format();
	//$size = (sh_set( $settings, 'size' ) ) ? sh_set( $settings, 'size' ) : '1750x1143';
	
	$output = '';
	switch( $format )
	{
		case 'standard':
		case 'image': ?>
  <div class="media-element entry">
    <?php the_post_thumbnail('1000x600', array('class' => 'img-responsive'));?>
    <div class="magnifier"></div>
  </div>
  <!-- end media -->
  
  <?php break;
		case 'gallery': ?>
  <div class="media-element">
    <?php $thumbnails = sh_set( $meta, 'sh_gallery_imgs' );
                if( $thumbnails ) : ?>
    <div class="flexslider flex-direction-nav-on-top">
      <ul class="slides entry">
        <?php foreach( $thumbnails as $thumbnail ): ?>
        <?php $att_id = sh_set($thumbnail, 'gallery_image');?>
        <?php if( esc_url( $att_id ) ): ?>
        <li><img class="img-responsive" src="<?php echo esc_url( $att_id ); ?>" alt="<?php the_title_attribute(); ?>" /></li>
        <?php endif; ?>
        <?php endforeach; ?>
      </ul>
    </div>
    <!-- end flexslider -->
    <?php endif; ?>
  </div>
  <!-- end media -->
  <?php break;
		case 'video': ?>
  <div class="media-element"> <?php echo sh_set( $meta, 'video' ); ?> </div>
  <!-- end media -->
  <?php break;
		case 'audio': ?>
  <div class="media-element"> <?php echo sh_set( $meta, 'audio' ); ?> </div>
  <!-- end media -->
  <?php break;
		case 'quote':
		case 'link': ?>
  <blockquote class="custom"><?php echo sh_set($meta, 'quote'); ?><small>
    <?php the_author(); ?>
    </small></blockquote>
  <?php break;
		default: ?>
  <div class="media-element entry">
    <?php the_post_thumbnail('1000x600', array('class' => 'img-responsive'));?>
    <div class="magnifier"></div>
  </div>
  <!-- end media -->
  <?php break;
	}
	
	//echo balanceTags($output);
}
function sh_get_font_settings( $FontSettings = array(), $StyleBefore = '', $StyleAfter = '' )
{
	$i = 1;
	$settings = _WSH()->option();
	$Style = '';
	foreach( $FontSettings as $k => $v )
	{
		if( $i == 1 || $i == 5 )
		{
			$Style .= ( sh_set( $settings, $k )  ) ? $v.':'.sh_set( $settings, $k ).'px!important;': '';
		}
		else
		{
			$Style .= ( sh_set( $settings, $k  )  ) ? $v.':'.sh_set( $settings, $k ).'!important;': '';
		}
		$i++;
	}
	return ( !empty( $Style ) ) ? $StyleBefore.$Style.$StyleAfter: '';
}
function sh_register_dynamic_sidebar()
{
	$theme_options = get_option( 'comre'.'_theme_options');
	$sidebars = sh_set( sh_set( $theme_options, 'dynamic_sidebar' ), 'dynamic_sidebar' );
	if( $sidebars && is_array( $sidebars ) )
	{
		foreach( $sidebars as $sidebar ){
			
			if( isset( $sidebar['tocopy'] ) ) continue;
			
			register_sidebar( array(
				'name' => $sidebar['sidebar_name'],
				'id' => sh_slug( $sidebar['sidebar_name'] ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => "</div>",
				'before_title' => '<h4 class="title"><span>',
				'after_title' => '</span></h4>',
			) );
		}
	}
}
function get_gravatar_url( $email, $width = 80 ) {
    $hash = md5( strtolower( trim ( $email ) ) );
    return 'http://gravatar.com/avatar/' . $hash.'?s='.$width;
}
function _sh_star_rating( $dis = false )
{
	$ip = $_SERVER['REMOTE_ADDR'];
	
	$meta = get_post_meta( get_the_id(), '_download_rating', true );
	
	$count = count( $meta ) ? count( $meta ) : 1;
	
	$titles = array( __('Poor', 'comre'), __('Satisfactory', 'comre'), __('Good', 'comre'), __('Better', 'comre'), __('Awesome', 'comre') );
	
	$evg = array_sum((array)$meta) / $count;
	
	if( $dis )
	{
		foreach( array_reverse( range( 0, 4 ) ) as $rang )
		{
			$checked = ( ( $rang + 1 ) <= round( $evg ) ) ? 'fa-star' : 'fa-star-o';
			echo '<i class="fa '.$checked.'" title="'.$titles[$rang].'" data-post-id="'.get_the_ID().'"/></i>'."\n";
		}
	}
	else
	{
		$disabled = isset( $meta[$ip] ) ? ' disabled="disabled"' : '';
		echo '<div class="clearfix center">'."\n";
		foreach( range( 0, 4 ) as $rang )
		{
			$checked = ( ( $rang + 1 ) == round( $evg ) ) ? ' checked="checked"' : '';
			echo '<input class="download-star" type="radio" name="download-2-rating-1"'.$disabled.$checked.' value="'.( $rang + 1 ).'" title="'.$titles[$rang].'" data-post-id="'.get_the_ID().'"/>'."\n";
		}
		echo '</div>'."\n";
		printf(__('Average Rating %s', 'comre'), $evg );
	}
}
function _sh_trim( $text, $len, $more = null )
{
	$text = strip_shortcodes( $text );
	
	$text = apply_filters( 'the_content', $text );
	$text = str_replace(']]>', ']]&gt;', $text);
	
	$excerpt_length = apply_filters( 'excerpt_length', $len );
	
	$excerpt_more = apply_filters( 'excerpt_more', ' ' . '[&hellip;]' );
	
	$excerpt_more = ( $more ) ? $more : ' ...';
	
	$text = wp_trim_words( $text, $excerpt_length, $excerpt_more );
	
	return $text;
	
}
function _sh_get_page_by_template( $tmpl, $index = 0 )
{
	$pages = get_posts(array(
        'post_type' => 'page',
		'meta_key' => '_wp_page_template',
		'meta_value' => $tmpl
	));
	
	if( $pages ){
		return $pages[$index];
	}
	
	return false;
}
function _sh_preloader($options)
{
	/** Preloader if enabled from theme options */
	if( sh_set( $options, 'preloader' ) ): ?>
  <div class="animationload">
    <div class="loader">
      <?php esc_html_e('Loading...', 'comre'); ?>
    </div>
  </div>
  <?php endif;
}
function _sh_sidebar_menu($options)
{
	include( _WSH()->includes('includes/modules/sidebar_menu.php') );
	
}
function _sh_nav_and_logo( $options )
{
	$custom_header = sh_set( $options, 'custom_header' );
	$custom_header = sh_set( $_GET, 'custom_header' ) ? 'center_logo' : $custom_header;
	if( $custom_header == 'center_logo' )
		include( _WSH()->includes('includes/modules/nav_style1.php') );
	else
		include( _WSH()->includes('includes/modules/nav_default.php') );
}
function sh_header_class( $class = null )
{
	$options = _WSH()->option();
	$header_option = sh_set( $options, 'header_option' );
	$custom_header = sh_set( $options, 'custom_header' );
	$header_class = '';
	
	$header_class .= ( $header_option && $custom_header == 'center_logo' ) ? 'header_center affix-top ' : '';
	$header_class .= ( $header_option && $custom_header == 'dafault' ) ? 'dark_header affix-top ' : '';
	
	if( sh_set( $options, 'sticky_menu' ) ) $header_class .= 'afffix ';
	if( $class ) $header_class .= $class;
	if( $header_class ) return ' class="'.$header_class.'" ';
	
	return false;
}

function _sh_submit_a_coupon()
{
	if( !$_POST ) return;
	//printr($_FILES);
	//printr($_POST);
	global $current_user;
    get_currentuserinfo();
	
	// In our file that handles the request, verify the nonce.
	$nonce = $_REQUEST['_nounce'];
	$res_msg = '';
	$error = false;
	
	if( !$current_user->ID ) {
		$error = true;
		$res_msg .= __('You must login to submit this form!', 'comre').'<br>';
	}
	
	
	if ( ! wp_verify_nonce( $nonce, '__comre_nonce' ) ) {
	
		 $res_msg .= __('You are trying to spam this form. Stop!', 'comre').'<br>'; 
		 $error = true;
	
	} else {
		
		$by_slug = get_term_by( 'slug', $_POST['coupons_category'], 'coupons_category' );
		if( $by_slug ) $term = $by_slug->term_id;
		else $term = 0;
		
		 $my_post = array(
		  'post_title'    => $_POST['post_title'],
		  'post_content'  => $_POST['post_content'],
		  'post_status'   => 'pending',
		  'post_author'   => $current_user->ID,
		  'tax_input' => array( 'coupons_category' => array($term) ),
		  'post_type' => 'sh_coupons'
		); 
		
		// Insert the post into the database
		$post_id = wp_insert_post( $my_post );
		//printr($post_id);
		//$post_id = 450;
		if( !is_wp_error( $post_id ) ) {
			
			//update terms
			$set_terms = wp_set_post_terms( $post_id, array($term), 'coupons_category');
			//printr($set_terms);
			
			//Update meta data
			$values = array();
			$meta_fields = array( 'expiration' => 'expires_date', 'coupon_code' => 'coupon_link');
			foreach( $meta_fields as $k => $met_field )
			{
				if( $meta_value = sh_set( $_POST, $k ) ) $values[$met_field] = $meta_value;
			}
			
			if( $values ) update_post_meta( $post_id, '_sh_sh_coupons_settings', $values );
			
			//printr($_FILES);
			// $filename should be the path to a file in the upload directory.
			
			// These files need to be included as dependencies when on the front end.
			require_once( ABSPATH . 'wp-admin/includes/image.php' );
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
			require_once( ABSPATH . 'wp-admin/includes/media.php' );
			
			// Let WordPress handle the upload.
			// Remember, 'my_image_upload' is the name of our file input in our form above.
			$attachment_id = media_handle_upload( 'featured_image', $post_id );
			set_post_thumbnail( $post_id, $attachment_id );
			$res_msg = __('Your coupon Added successfully and pending for review', 'comre');	
			$error = false;
		}
		else {
			$res_msg .= $post_id->get_message();
		}
	}
	
	if( $error ) echo '<div class="alert alert-danger">'.$res_msg.'</div>';
	else echo '<div class="alert alert-success">'.$res_msg.'</div>';
}


add_action('publish_sh_coupons', '_sh_publish_sh_coupons', 10, 2);

function _sh_publish_sh_coupons( $post_id, $post )
{

	if($coupons_setting = sh_set($_POST, '_sh_sh_coupons_settings')) {
		if( $exp_date = sh_set($coupons_setting, 'expires_date') ) {
			$date = date('Y-m-d h:i:s', strtotime($exp_date));
			update_post_meta($post_id, '_sh_coupons_expires_date', $date );
		}
	}
}

function my_home_category( $query ) {
	
	$options = _WSH()->option('expiredcoupons');
	
	if( is_admin() ) return;
	
	if( !$options ) return;
	
	$post_type = sh_set( $query->query, 'post_type');
	
	if( $post_type == 'sh_coupons' )
	{
	
		$meta_query = array(
			   array(
				  'key' => '_sh_coupons_expires_date',
				  'value' => date("Y-m-d"),
				  'compare' => '>=',
				  'type' => 'datetime'// you can change it to datetime also
			  ),
			   array(
				  'key' => '_sh_coupon_expire_date',
				  'value' => date("Y-m-d"),
				  'compare' => '>=',
				  'type' => 'datetime'// you can change it to datetime also
			  )
		);
		$query->set('meta_query', $meta_query);
		$query->set('orderby', 'meta_value');
	}
}
add_action( 'pre_get_posts', 'my_home_category' );

function _set_refferer_to_link($link)
{
	$referer = _WSH()->option('global_referer');
	$href = '';
	if( $referer && $link ) {
		$explode = explode('=', $referer);
		$link = esc_url( add_query_arg(sh_set( $explode, 0), sh_set( $explode, 1), $link) );
		return $link;
	}

	return $link;
}


function comre_sh_login_user()
{
	if( !$_POST ) return;

	if( !wp_verify_nonce( $_REQUEST['_nounce'], '__comre_login_nonce' ) )
	{
		return new WP_Error('post_data_missing', esc_html__( 'There is security check error, try again.', 'comre' ));
	}

	$cred['user_login'] = sh_set($_POST, 'user_login');
	$cred['user_password'] = sh_set( $_POST, 'user_password' );

	$res = wp_signon( $cred, false );

	if ( is_wp_error($res) )
		return '<div class="alert alert-danger" style="height: auto;">'.$res->get_error_message().'</div>';
	
	wp_redirect($_SERVER['HTTP_REFERER']);exit;
}

