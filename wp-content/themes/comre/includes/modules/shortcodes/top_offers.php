<?php /**
 * The template for displaying the coupons in owl carousel.
 *
 * Override this template by copying it to comre-child/includes/modules/shortcodes/top_offers.php
 *
 * @author    WoWThemes
 * @package   Modules/Shortcodes
 * @version     1.1.0
 */

wp_enqueue_script(array('owl-carousel'));

global $post ;
$count = 0;
$query_args = array('post_type' => 'sh_coupons' , 'showposts' => $num , 'order_by' => $sort , 'order' => $order);
if( $cat ) $query_args['coupons_category'] = $cat;
  //echo balanceTags($cat); exit('sssss');
  $query = new WP_Query($query_args) ;   
  ob_start() ;?>

<section class="top-offer">
  <div class="container"> 

    <!--======= TITTLE =========-->
    <div class="tittle">
      <h3><?php echo balanceTags($title);?></h3>
    </div>

    <div class="today-top"> 
     <?php if($query->have_posts()):  ?>
      
      <!--======= COUPON 1 =========-->
      <?php while($query->have_posts()): $query->the_post();
        global $post ; 
        $post_meta = _WSH()->get_meta();?>

        <div class="offer-in"><?php the_post_thumbnail('268x160',array('class'=>'img-responsive')); ?> 
          
          <div class="offer-top-in">
            <h6><?php the_title(); ?></h6>
            <p class="text-uppercase"><?php esc_html_e('Expires :', 'comre')?> <?php echo sh_set($post_meta,'expires_date') ?> </p>
            <div class="btm-offer">
              <p class="text-uppercase"><?php echo sh_set($post_meta, 'cashback');?></p>
            </div>
          </div>

          <!--======= COUPON HOVER =========-->
          <div class="off-over">
            <h6> <?php the_title(); ?> </h6>
            <p class="text-uppercase"><?php esc_html_e('Expires :','comre')?><?php echo sh_set($post_meta,'expires_date')?>  </p>
            
            <a href="<?php the_permalink(); ?>" class="btn"><?php esc_html_e('GET COUPON CODE','comre') ;?></a>
            
            <div class="btm-offer">
              <p class="text-uppercase"><?php echo sh_set($post_meta, 'cashback');?></p>
            </div>
          </div>
        </div>
      
      <?php endwhile;
      wp_reset_postdata();?>
    </div>
  </div>
</section>

<?php endif; ?>

<?php return ob_get_clean();