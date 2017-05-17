<?php         
class SH_NewsLetter extends WP_Widget

{

	/** constructor */

	function __construct()

	{

		parent::__construct( /* Base ID */'SH_NewsLetter', /* Name */__('Comre','comre'), array( 'description' => __('Comre Subsriber', 'comre' )) );

	}



	/** @see WP_Widget::widget */

	function widget($args, $instance)

	{

		extract( $args );

		$title = apply_filters( 'widget_title', $instance['title'] );

		

		echo balanceTags($before_widget.'<div class="subcribe">');

		?>
			<?php echo balanceTags($before_title.$title.$after_title);?>
            <p><?php echo balanceTags($instance['txt']); ?></p>
            <form action="http://wowthemes.us10.list-manage1.com/subscribe/post" method="POST" target="popupwindow">
            
            <input type="hidden" name="u" value="bd58b69cc8b502a1ae890b1b3">
			<input type="hidden" name="id" value="b8e79867fc">
            <input type="hidden" name="b_bd58b69cc8b502a1ae890b1b3_b8e79867fc" tabindex="-1" value="">
            <input type="email" class="form-control" placeholder="Email Address" autocapitalize="off" autocorrect="off" name="MERGE0" id="MERGE0" size="25" value="">
            <button type="submit">SIGNUP!</button>
            </form>
			<?php //include('mailchimp.php'); ?>
            
		<?php

		echo '</div>'.$after_widget;

	}

	

	

	/** @see WP_Widget::update */

	function update($new_instance, $old_instance)

	{

		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['mc'] = $new_instance['mc'];
		$instance['txt'] = $new_instance['txt'];

		return $instance;
	}



	/** @see WP_Widget::form */

	function form($instance)

	{

		$title = ($instance) ? esc_attr($instance['title']) : __('Subscribe', 'comre');

		$txt = ($instance) ? esc_attr($instance['txt']) : 'Get our Daily email newsletter with Special Services, Updates, Offers and more!';
		$mc = ($instance) ? esc_attr($instance['mc']) : 'http://wowthemes.us10.list-manage1.com/subscribe/post';

		?>

		<p>

            <label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>"><?php esc_html_e('Title:', 'comre'); ?></label>

            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />

        </p>        

        <p>

            <label for="<?php echo esc_attr( $this->get_field_id('mc') ); ?>"><?php esc_html_e('Main Chimp Form URL:', 'comre'); ?></label>

            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('mc') ); ?>" name="<?php echo esc_attr( $this->get_field_name('mc') ); ?>" type="text" value="<?php echo esc_attr( $mc ); ?>" />

        </p>

        <p>

            <label for="<?php echo esc_attr( $this->get_field_id('txt') ); ?>"><?php esc_html_e('Enter the title:', 'comre'); ?></label>

            <textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id('txt') ); ?>" name="<?php echo esc_attr( $this->get_field_name('txt') ); ?>" ><?php echo esc_attr( $txt ); ?></textarea>

        </p>

        

                

		<?php 

	}

}

// Quick Links Widget
class SH_Quicklinks extends WP_Widget

{

	/** constructor */

	function __construct()

	{

		parent::__construct( /* Base ID */'SH_Quicklinks', /* Name */__('Comre Quicklinks','comre'), array( 'description' => __('Comre Quicklinks', 'comre' )) );

	}



	/** @see WP_Widget::widget */

	function widget($args, $instance)

	{

		extract( $args );

		$title = apply_filters( 'widget_title', $instance['title'] );

		

		echo balanceTags($before_widget);

		?>
			<?php echo balanceTags($before_title.$title.$after_title);?>
               
         
          <div class="row links">
            <ul class="col-xs-4">
              <li><a href="#.">Home</a> </li>
              <li><a href="#.">stores</a> </li>
              <li><a href="#.">contact </a> </li>
              <li><a href="#.">careers</a> </li>
              <li><a href="#.">blog</a> </li>
            </ul>
            <ul class="col-xs-8">
              <li><a href="#.">Sitemap</a> </li>
              <li><a href="#.">Press</a> </li>
              <li><a href="#.">Privacy Policy & Opt Out</a> </li>
              <li><a href="#.">List your business on CD</a> </li>
              <li><a href="#.">Terms of Service</a> </li>
            </ul>
          </div>
        
		<?php

		echo balanceTags($after_widget);

	}

	

	

	/** @see WP_Widget::update */

	function update($new_instance, $old_instance)

	{

		$instance = $old_instance;



		$instance['title'] = strip_tags($new_instance['title']);

		$instance['txt'] = $new_instance['txt'];



		return $instance;

	}



	/** @see WP_Widget::form */

	function form($instance)

	{

		$title = ($instance) ? esc_attr($instance['title']) : __('Enter Text', 'comre');

		$txt = ($instance) ? esc_attr($instance['txt']) : '';

		?>

        

        <p>

            <label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>"><?php esc_html_e('Title:', 'comre'); ?></label>

            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />

        </p>

        
        <p>

            <label for="<?php echo esc_attr( $this->get_field_id('txt') ); ?>"><?php esc_html_e('Page ID:', 'comre'); ?></label>

            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('txt') ); ?>" name="<?php echo esc_attr( $this->get_field_name('txt') ); ?>" type="text" value="<?php echo esc_attr( $txt ); ?>" />

        </p>
        

                

		<?php 

	}

}

 // recent posts widget
 
 
 class SH_Recent_Posts extends WP_Widget
{
	/** constructor */
	function __construct()
	{
		parent::__construct( /* Base ID */'SH_Recent_Posts', /* Name */__('Blog Recent Posts ','comre'), array( 'description' => __('New items with images', 'comre' )) );
	}
	/** @see WP_Widget::widget */
	function widget($args, $instance)
	{
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		
		echo balanceTags($before_widget);
		
		echo balanceTags($before_title.$title.$after_title); 
		
		$query_string = 'posts_per_page='.$instance['number'].'&post_type=post';
		if( $instance['cat'] ) $query_string .= '&cat='.$instance['cat'];
		query_posts( $query_string ); 
	
		$this->posts();
		wp_reset_query(); 
		
		echo balanceTags($after_widget);
	}
 
	/** @see WP_Widget::update */
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		
		$instance['title'] = $new_instance['title'];
		$instance['number'] = $new_instance['number'];
		$instance['cat'] = $new_instance['cat'];
		
		return $instance;
	}
	/** @see WP_Widget::form */
	function form($instance)
	{
		$title = ( $instance ) ? esc_attr($instance['title']) : __('Recent Posts', 'comre');
		$number = ( $instance ) ? esc_attr($instance['number']) : 4;
		$cat = ( $instance ) ? esc_attr($instance['cat']) : '';?>
			
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title: ', 'comre'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('number')); ?>"><?php esc_html_e('No. of Posts:', 'comre'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('number')); ?>" name="<?php echo esc_attr($this->get_field_name('number')); ?>" type="text" value="<?php echo esc_attr($number); ?>" />
        </p>
       
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('cat')); ?>"><?php esc_html_e('Category', 'comre'); ?></label>
            <?php wp_dropdown_categories( array('show_option_all'=>__('All Categories w p l o c k e r .c o m', 'comre'), 'selected'=>$cat, 'class'=>'widefat', 'name'=>$this->get_field_name('cat')) ); ?>
        </p>
        
		<?php 
	}
	
	function posts()
	{
		if( have_posts() ):?>
        <?php $count = 0; ?>
        
    <div class="tw-widgets">
        <ul>
		  <?php while( have_posts() ): the_post(); ?>
  
             <li class="clearfix">
               <ul class="wid-in">
                 <li><?php the_post_thumbnail('thumbnail', array('class'=>'img-responsive'));?></li>
                 <li>
                    <div class="img-side"> </div>
                    <a href="<?php the_permalink();?>"><?php the_title(); ?></a> <span><i class="fa fa-calendar"></i><?php the_date('M j,Y'); ?>Jan 12, 2015 </span>
                 </li>
              </ul>
            </li>
		<?php endwhile;?>
		</ul>
	</div>
            
		<?php endif;
    }
}



// Flicker Gallery
class SH_Flickr extends WP_Widget
{
	function __construct()
	{
		parent::__construct( /* Base ID */'SH_Flickr', /* Name */__('Comre Flickr Feed','comre'), array( 'description' => __('Fetch the latest feed from Flickr', 'comre' )) );
	}
	
	function widget($args, $instance)
	{
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		
		wp_enqueue_script( array( 'jflickrfeed' ) );
		
		$flickr_id = $instance['flickr_id'];
		$number = $instance['number'];
		
		echo balanceTags($before_widget);

		echo balanceTags($before_title.$title.$after_title);
		
		
		$limit = ( $number ) ? $number : 8;?>
            <div class="flickr-image rw clearfix">
               <ul class="flickr flickr-images">
			   
               </ul>
               <script type="text/javascript">
					jQuery(document).ready(function($) {
						$('.flickr-images').jflickrfeed({
							limit: <?php echo esc_js($limit);?> ,
							qstrings: {id: '<?php echo esc_js($flickr_id); ?>'},
							itemTemplate: '<li class="col-xs-4"><a href="{{link}}" title="{{title}}"><img src="{{image_s}}" alt="{{title}}" /></a></li>'
							
						});
					});
               </script>
            </div><?php
			
		echo balanceTags($after_widget);
	}
	
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		
		$instance['title'] = strip_tags($new_instance['title']);

		$instance['flickr_id'] = $new_instance['flickr_id'];
		$instance['number'] = $new_instance['number'];
		
		return $instance;
	}
	
	function form($instance)
	{
		wp_enqueue_script('flickrjs');
		$title = ($instance) ? esc_attr($instance['title']) : __('Flicker', 'comre');
		$flickr_id = ($instance) ? esc_attr($instance['flickr_id']) : '';
		$number = ( $instance ) ? esc_attr($instance['number']) : 8;?>
		  
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title'));?>"><?php esc_html_e('Title:', 'comre');?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title'));?>" name="<?php echo esc_attr($this->get_field_name('title'));?>" type="text" value="<?php echo esc_attr($title);?>" />
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('flickr_id'));?>"><?php esc_html_e('Flickr ID:', 'comre');?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('flickr_id'));?>" name="<?php echo esc_attr($this->get_field_name('flickr_id'));?>" type="text" value="<?php echo esc_attr($flickr_id);?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('number'));?>"><?php esc_html_e('Number of Images:', 'comre');?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('number'));?>" name="<?php echo esc_attr($this->get_field_name('number'));?>" type="text" value="<?php echo esc_attr($number);?>" />
        </p>
        <?php 
	}
}


// twitter
class SH_Twitter extends WP_Widget
{
	/** constructor */
	function __construct()
	{
		parent::__construct( /* Base ID */'SH_Twitter', /* Name */__('Comre Tweets','comre'), array( 'description' => __('Gryvh the latest tweets from twitter', 'comre' )) );
	}

	/** @see WP_Widget::widget */
	function widget($args, $instance)
	{
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		
		echo balanceTags($before_widget);
		echo balanceTags($before_title.$title.$after_title);
		
		$twitter_id = ($instance) ? esc_attr($instance['twitter_id']) : 'wordpress';
		$number = ( $instance ) ? esc_attr($instance['number']) : 3;
		?>
      	<?php //FW_Twitter(array('Template'=>'p','screen_name'=>$twitter_id, 'count'=>$number, 'selector'=>'.tweets-shortcode'));?>
		<div class="tw-widgets latest-tw"></div>
	    <script type="text/javascript"> jQuery(document).ready(function($) {$('.latest-tw').tweets({screen_name: '<?php echo $instance['twitter_id']; ?>', number: '<?php echo $number; ?>'});});</script>
		<?php
		
		echo balanceTags($after_widget);
	}
	
	
	/** @see WP_Widget::update */
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;

		$instance['title'] = strip_tags($new_instance['title']);
		$instance['twitter_id'] = $new_instance['twitter_id'];
		$instance['number'] = $new_instance['number'];

		return $instance;
	}

	/** @see WP_Widget::form */
	function form($instance)
	{
		$title = ($instance) ? esc_attr($instance['title']) : __('Recent Tweets', 'comre');
		$twitter_id = ($instance) ? esc_attr($instance['twitter_id']) : 'wordpress';
		$number = ( $instance ) ? esc_attr($instance['number']) : '';?>
        
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'comre'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('twitter_id')); ?>"><?php esc_html_e('Twitter ID:', 'comre'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('twitter_id')); ?>" name="<?php echo esc_attr($this->get_field_name('twitter_id')); ?>" type="text" value="<?php echo esc_attr( $twitter_id ); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('number')); ?>"><?php esc_html_e('Number of Tweets:', 'comre'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('number')); ?>" name="<?php echo esc_attr($this->get_field_name('number')); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" />
        </p>
        
                
		<?php 
	}
}
