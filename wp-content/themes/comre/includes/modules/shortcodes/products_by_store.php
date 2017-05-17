<?php /**
 * The template for displaying the coupons categories by alphabets.
 *
 * Override this template by copying it to comre-child/includes/modules/shortcodes/products_by_store.php
 *
 * @author    WoWThemes
 * @package   Modules/Shortcodes
 * @version     1.1.0
 */



wp_enqueue_script(array('jquery-mixitup'));
$stores_options = _WSH()->option('stores_page_layout');
$taxonomy = ( $stores_options == 'layout-coupons' ) ? 'coupons_category' : 'product_cat';

ob_start();
$count = 0;
$results = array();
?>

<?php $all_terms = get_terms($taxonomy, array('hide_empty'=>false));?>

<?php foreach( $all_terms as $a_term) {
	$character = ucwords(substr($a_term->name, 0, 1 ));
	$results[$character][$a_term->term_id] = $a_term;
} ?>
<section class="stores">
  <div class="container"> 
    
    <!--======= TITTLE =========-->
    <div class="tittle">
      <h3><?php echo $title;?></h3>

      <!--======= FILTERS LETTERS =========-->
      <div class="finde">
        <form method="get">
        
           <select id="store" name="_store_sorting">
            <?php foreach( $results as $k=> $res ): ?>
              <option value="lett<?php echo esc_attr($k); ?>"><?php echo ucwords($k); ?></option>
            <?php endforeach; ?>
          </select>
          
          <button type="button" id="_store_show_all"><?php esc_html_e('all', 'comre'); ?></button>
        
        </form>
    </div>

  </div>

  <div class="filter-list">

    <!--======= A =========-->
    <?php foreach( $results as $k => $v ): 
                  //printr($v);
      $count = ( count($v) < 3 ) ?  1 : (count($v)/3); 
      $chunks = array_chunk( (array)$v, $count ); ?>

      <div class="mix letters lett<?php echo esc_attr($k); ?>">
        <h3><?php echo ucwords( $k ); ?></h3>


        <ul class="row">

          <?php foreach( $chunks as $chunk ): ?>
            <li class="col-sm-4">
              <ul class="link-letter">

                <?php foreach( $chunk as $ch ): 
                  $term_link = get_term_link($ch);
                  ?>
                  <li><a href="<?php echo esc_url($term_link);?>"> <?php echo balanceTags($ch->name);?> (<?php echo balanceTags( $ch->count); ?>)</a></li>
                <?php endforeach; ?>


              </ul>

            </li>
          <?php endforeach; ?>

        </ul>
      </div>

    <?php endforeach; ?>

  </div>

</section>

<?php return ob_get_clean();