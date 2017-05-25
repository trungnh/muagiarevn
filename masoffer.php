<?php 
ini_set('display_errors', 1);
include "./wp-load.php";
include dirname(__FILE__) . "/wp-content/themes/clipper/framework/admin/importer.php";
echo date('h:i:s')."\n";
define('PUB_ID', 'dunghy7');
define('TOKEN', '3zYsjOLpNu/jObLJ8vpWjw==');

wp_set_current_user(1);

$offers	=	getAllOffer(PUB_ID, TOKEN);
foreach($offers as $offer) {
	$promotions = getPromotionsByOffer($offer);
	if(!empty($promotions))
	{
		//import promotion/coupon
		foreach ($promotions as $promo){
			// Check if coupon is non-exist and coupon data is not empty then create coupon post
			if(!clpr_get_listing_by_coupon_aff_url($promo['coupon_aff_url'])){
				echo $promo['id'].'--'.$promo['coupon_type']."\n";
				import($promo);
			}
		}
	}
}

echo date('h:i:s')."\n";
/*============ Functions ============*/

/**
 * Get offers data(fptshop, lazada)
 *
 * @param string $pub_id - offer data
 * 
 * @param string $token  - offer data
 * 
 * @return array.
 */
function getAllOffer($pub_id, $token)
{
	$ignoreOffers = array('zalora-sg', 'zalora-id', 'tokopedia-ticket-id',
		'blibli-id', 'elevenia-id', 'tokopedia-epay-id',
		'lazada-id', 'lazada-th', 'lazada-mobile-id');

	$requestUrl = "https://api.masoffer.com/offer/all?pub_id={$pub_id}&token={$token}";
	$response   = file_get_contents($requestUrl);
	$offerData  = json_decode($response)->data;
	
	$offers = array();
	
	foreach($offerData as $item){
		if(in_array($item->offer_id, $ignoreOffers)){
			continue;
		}

		$offers[$item->offer_id] = array('id'	=>	$item->offer_id,
										'name'	=>	$item->name,
										'about'	=>	$item->about,
										'url'	=>	$item->domain);
	}
	
	return $offers;
}

/**
 * Get Promotion/Coupon by offer (fptshop, lazada)
 *
 * @param array $offer - offer data
 *
 * @return array.
 */
function getPromotionsByOffer($offer)
{
	$requestUrl = "https://api.masoffer.com/promotions/{$offer['id']}";
	$response   = file_get_contents($requestUrl);
	$promoData  = json_decode($response)->data->promotions;
	
	$promotions = array();
	foreach($promoData as $item){
		$aff_url            =   str_replace('{publisher_id}', PUB_ID, $item->aff_url);
		$count              = preg_match_all('|<a href="(.+?)">T|s', $item->content, $matches, PREG_SET_ORDER);
		if($count > 0){
			$description    = str_replace($matches[0][1], $aff_url, $item->content);
		}

		$tmp = array (
			'coupon_title'          => $item->title,
			'coupon_description'    => $description,
			'coupon_excerpt'        => '',
			'coupon_status'         => 'publish',
			'author'                => '1',
			'date'                  => date('m/d/Y H:m'),
			'slug'                  => null,//sanitize_title($item->title),
			'coupon_code'           => $item->coupon_code,
			'expire_date'           => is_null($item->expired_date) ? null : date('m/d/Y', $item->expired_date),
			'print_url'             => '',
			'id'                    => $item->id ? $item->id : clpr_generate_id(),
			'coupon_aff_url'        => $aff_url,
			'coupon_category'       => $item->category_name,
			'coupon_tag'            => $item->category_name.',muagiare',
			'coupon_type'           => ($item->coupon_code == '') ? 'Khuyến Mại' : 'Mã Giảm Giá',
			'stores'                => $offer['name'],
			'store_desc'            => $offer['about'],
			'store_url'             => $offer['url'],
			'store_aff_url'         => $offer['url'],
			'clpr_featured'         => '0',
		);
		
		$promotions[]	=	$tmp;
	}
	return $promotions;
}

/**
 * Create coupon
 *
 * @param array $data promotion/soupon data.
 *
 * @return boolean.
 */
function import($data)
{
	$fields = array(
		'coupon_title'       => 'post_title',
		'coupon_description' => 'post_content',
		'coupon_excerpt'     => 'post_excerpt',
		'coupon_status'      => 'post_status',
		'author'             => 'post_author',
		'date'               => 'post_date',
		'slug'               => 'post_name',
	);

	$args = array(
		'taxonomies'     => array( 'coupon_category', 'coupon_tag', 'coupon_type', 'stores' ),

		'custom_fields'  => array(
			'coupon_code'        => 'clpr_coupon_code',
			'expire_date'        => 'clpr_expire_date',
			'print_url'          => 'clpr_print_url',
			'id'                 => 'clpr_id',
			'coupon_aff_url'     => 'clpr_coupon_aff_url',
			'clpr_featured'      => 'clpr_featured',
			'clpr_votes_down'    => array( 'default' => '0' ),
			'clpr_votes_up'      => array( 'default' => '0' ),
			'clpr_votes_percent' => array( 'default' => '100' ),
		),

		'tax_meta' => array(
			'stores' => array(
				'store_aff_url' => 'clpr_store_aff_url',
				'store_url'     => 'clpr_store_url',
				'store_desc'    => 'clpr_store_desc',
			),
		),
	);
	
	$appImport = new APP_Importer('coupon', $fields, $args );
	
	// import single coupon
	$appImport->import_row_from_outside($data);
}

/**
 * Retrieves listing data by given reference coupon_aff_url.
 * @since 1.5.1
 *
 * @param string $reference_id An listing reference coupon_aff_url.
 *
 * @return object|bool A listing object, boolean False otherwise.
 */
function clpr_get_listing_by_coupon_aff_url( $coupon_aff_url ) {

	if ( empty( $coupon_aff_url ) || ! is_string( $coupon_aff_url ) ) {
		return false;
	}

	$coupon_aff_url = appthemes_numbers_letters_only( $coupon_aff_url );

	$listing_q = new WP_Query( array(
		'post_type'         => 'coupon',
		'post_status'       => 'any',
		'meta_key'          => 'clpr_id',
		'meta_value'        => $coupon_aff_url,
		'posts_per_page'    => 1,
		'suppress_filters'  => true,
		'no_found_rows'     => true,
	) );

	if ( empty( $listing_q->posts ) ) {
		return false;
	}

	return true;
}