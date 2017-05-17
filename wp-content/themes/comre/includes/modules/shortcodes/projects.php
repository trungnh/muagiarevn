<?php global $wp_query;



wp_enqueue_script( array( 'jquery-prettyphoto', 'main-script','jquery-isotope', 'masonry-cube' ) );	

$paged = get_query_var('paged');

$args = array('post_type' => 'sh_portfolio', 'showposts'=>$num, 'orderby'=>$sort, 'order'=>$order, 'paged'=>$paged);

if( $cat ) $args['tax_query'] = array(array('taxonomy' => 'portfolio_category','field' => 'id','terms' => $cat));

query_posts($args);

$t = $GLOBALS['_sh_base'];

$paged = get_query_var('paged');

$data_filtration = '';

$data_posts = '';?>



<?php if( have_posts() ):

	

ob_start();?>

	<?php $count = 0; 

	$fliteration = array();?>

	<?php while( have_posts() ): the_post(); 

		$meta = get_post_meta( get_the_id(), '_sh_portfolio_meta', true );//printr($meta);

		$post_terms = get_the_terms( get_the_id(), 'portfolio_category'); //printr($post_terms); exit();

		foreach( (array)$post_terms as $pos_term ) $fliteration[$pos_term->term_id] = $pos_term;

		$temp_category = get_the_term_list(get_the_id(), 'portfolio_category', '', ', ');?>

		

		<?php $post_terms = wp_get_post_terms( get_the_id(), 'portfolio_category'); 

		$term_slug = '';

		if( $post_terms ) foreach( $post_terms as $p_term ) $term_slug .= $p_term->slug.' ';?>		

                

			           <div class="item item-h2 <?php echo esc_attr($term_slug); ?>">

                            <div class="entry">

                                <a href="<?php the_permalink();?>">

								

								<?php the_post_thumbnail('289x230', array('class'=>'img-responsive'));?>

																

								</a>

                                <div class="magnifier">

                                    <a href="<?php the_permalink();?>" title="<?php the_title_attribute();?>">

                                    <span class="buttons">

                                        <i class="fa fa-link"></i>

                                    </span><!-- end buttons -->

                                    </a>

                                </div><!-- end magnifier -->

                            </div>

                            <div class="desc">

                            <h3><?php the_title();?></h3>

                            <p><?php the_category(', '); ?></p>

                                <a href="<?php the_permalink();?>">

                                <span class="butto">

                                    <i class="fa fa-picture-o"></i>

                                </span><!-- end buttons -->

                                </a>

                            </div>

                        </div>

	

  <?php endwhile;?>

  

<?php wp_reset_query();

$data_posts = ob_get_contents();

ob_end_clean();

endif; 

ob_start();?>	 

<section class="section-w clearfix">

<div class="container">

	<div class="section-title leftside">

		<h3><?php echo balanceTags($title); ?></h3>

		<span class="divider"></span>

		<nav class="portfolio-filter clearfix">

			<?php $terms = get_terms(array('portfolio_category')); ?>

			  <?php if( $terms ): ?>

				<ul>

							  

				<li><a class="active" href="#" data-filter="*"><span></span> All</a></li>

				<?php foreach( $fliteration as $t ): ?>

				<li><a href="#" data-filter=".<?php echo sh_set( $t, 'slug' ); ?>"><?php echo sh_set( $t, 'name'); ?></a></li>

								

				<?php endforeach;?>

								

				</ul>

			<?php endif;?>

				</nav>

                </div><!-- end section-title -->

                

                <div class="section- clearfix">

                    <div class="masonry_wrapper row">

                         <?php echo balanceTags($data_posts);?>

										

                        <!-- end item -->

                    </div><!-- end masonry_wrapper -->        

                </div><!-- end row -->

            </div><!-- end container -->

        </section><!-- end section -->

<?php $output = ob_get_contents();

ob_end_clean(); 

return $output;?>