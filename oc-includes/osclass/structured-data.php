<?php
/*
 * Copyright 2020 OsclassPoint.com
 *
 * Osclass maintained & developed by OsclassPoint.com
 * you may not use this file except in compliance with the License.
 * You may download copy of Osclass at
 *
 *     https://osclass-classifieds.com/download
 *
 * Software is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 */
 
function osc_structured_data_title() {
  $text = meta_title();
  return osc_apply_filter('structured_data_title_filter', $text);
}

function osc_structured_data_description() {
  $text = meta_description();
  return osc_apply_filter('structured_data_description_filter', $text);
}

function osc_structured_data_image() {
  $logo_url = '';
  $logo = osc_get_preference('logo', osc_current_web_theme());

  if($logo != '' && file_exists(osc_uploads_path() . $logo)) {
    $path = str_replace(ABS_PATH, '', osc_uploads_path());
    $logo_url = osc_base_url() . $path . $logo;
  } else if (file_exists(osc_base_path() . 'oc-content/themes/' . osc_current_web_theme() . '/images/logo.jpg')) {
    $logo_url = osc_base_url() . 'oc-content/themes/' . osc_current_web_theme() . '/images/logo.jpg';
  } else if (file_exists(osc_base_path() . 'oc-content/themes/' . osc_current_web_theme() . '/images/logo.png')) {
    $logo_url = osc_base_url() . 'oc-content/themes/' . osc_current_web_theme() . '/images/logo.png';
  } else if (file_exists(osc_base_path() . 'oc-content/themes/' . osc_current_web_theme() . '/images/logo.gif')) {
    $logo_url = osc_base_url() . 'oc-content/themes/' . osc_current_web_theme() . '/images/logo.gif';
  }
  
  $url = $logo_url;

  if(osc_is_ad_page()) {
    if(osc_count_item_resources() > 0) {
      $url = osc_resource_url();
    }
  }

  return osc_apply_filter('structured_data_image_filter', $url);
}


function osc_structured_data_footer() {
  if(osc_structured_data_enabled()) {
    $url = osc_get_current_url();
    $image_url = osc_structured_data_image();

    if(osc_is_ad_page()) {
      $url = osc_item_url();
      $location = array(osc_item_country(), osc_item_region(), osc_item_city(), osc_item_address());
      $location = implode(', ', array_filter($location));
    }

    if(osc_is_ad_page()) {
?>
<script type="application/ld+json">
{
  "@context": "https://schema.org/", 
  "@type": "Product", 
  "name": "<?php echo osc_esc_html(osc_structured_data_title()); ?>",
  <?php if($image_url <> '') { ?>"image": "<?php echo osc_esc_html($image_url); ?>",<?php echo PHP_EOL; } ?>
  "description": "<?php echo osc_esc_html(osc_highlight(osc_structured_data_description(), 200)); ?>",
  "brand": "Osclass",
  <?php if(1==2) { ?>"sku": "OSC-<?php echo osc_item_id(); ?>",<?php echo PHP_EOL; } ?>
  "offers": {
    "@type": "Offer",
    "itemOffered": "<?php echo osc_esc_html(osc_item_title()); ?>",
    "url": "<?php echo osc_esc_html($url); ?>",
    <?php if(osc_item_price() > 0) { ?>"priceCurrency": "<?php echo osc_esc_html(osc_item_currency()); ?>",<?php echo PHP_EOL; } ?>
    "price": "<?php echo osc_esc_html(osc_item_price() > 0 ? osc_item_price() : 0); ?>",
    "priceValidUntil": "<?php echo date('Y-m-d', strtotime(osc_item_field('dt_pub_date') . ' + 365 days')); ?>",
    "availability": "https://schema.org/InStock"
  },
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "<?php echo round(osc_count_item_comments_rating(), 1); ?>",
    "bestRating": "5",
    "worstRating": "0",
    "ratingCount": "<?php echo (osc_count_item_comments() > 0 ? osc_count_item_comments() : 1); ?>",
    "reviewCount": "<?php echo (osc_count_item_comments() > 0 ? osc_count_item_comments() : 1); ?>"
  }
  <?php osc_run_hook('structured_data_footer'); ?>
}
</script>
    <?php } else { ?>
<script type="application/ld+json">
{
  "@context": "http://schema.org/",
  "@type": "Organization",
  <?php if($image_url <> '') { ?>"logo": "<?php echo osc_esc_html($image_url); ?>",<?php echo PHP_EOL; } ?>
  "name": "<?php echo osc_esc_html(osc_structured_data_title()); ?>",
  "url": "<?php echo osc_esc_html($url); ?>"
  <?php osc_run_hook('structured_data_footer'); ?>
}
</script>
  <?php 
    }
  } 
} 

osc_add_hook('footer', 'osc_structured_data_footer');


function osc_structured_data_header() {
  if(osc_structured_data_enabled()) {
    $url = osc_get_current_url();
    $image_url = osc_structured_data_image();

    if(osc_is_ad_page()) {
      $url = osc_item_url();
      $location = array(osc_item_country(), osc_item_region(), osc_item_city(), osc_item_address());
      $location = implode(', ', array_filter($location));
    }

?>
<!-- Facebook Open Graph Tags-->
<meta property="og:title" content="<?php echo osc_esc_html(osc_structured_data_title()); ?>" />
<meta property="og:site_name" content="<?php echo osc_esc_html(osc_structured_data_title()); ?>"/>
<meta property="og:url" content="<?php echo osc_esc_html($url); ?>" />
<meta property="og:description" content="<?php echo osc_esc_html(osc_highlight(osc_structured_data_description(), 200)); ?>" />
<meta property="og:locale" content="<?php echo osc_esc_html(osc_current_user_locale()); ?>" />
<meta property="og:image" content="<?php echo $image_url; ?>" />
<?php if(osc_is_ad_page()) { ?>
<?php if($location <> '') { ?><meta property="og:place" content="<?php echo osc_esc_html($location); ?>" /><?php echo PHP_EOL; } ?>
<meta property="og:type" content="product" />
<meta property="product:availability" content="<?php echo __('Available'); ?>" />
<meta property="product:retailer_item_id" content="<?php echo osc_esc_html(osc_item_id()); ?>" />
<?php if(osc_item_price() > 0) { ?><meta property="product:price:amount" content="<?php echo osc_esc_html(osc_item_price()); ?>" /><?php echo PHP_EOL; } ?>
<?php if(osc_item_price() > 0) { ?><meta property="product:price:currency" content="<?php echo osc_esc_html(osc_item_currency()); ?>" /><?php echo PHP_EOL; } ?>
<?php } ?>

<!-- Twitter Tags-->
<meta name="twitter:card" content="summary" />
<meta name="twitter:site" content="@<?php echo osc_esc_html(osc_item_contact_name() <> '' ? osc_item_contact_name() : __('Anonymous')); ?>" />
<meta name="twitter:title" content="<?php echo osc_esc_html(osc_structured_data_title()); ?>" />
<meta name="twitter:description" content="<?php echo osc_esc_html(osc_highlight(osc_structured_data_description(), 200)); ?>" />
<meta name="twitter:image" content="<?php echo osc_esc_html($image_url); ?>" />

<?php osc_run_hook('structured_data_header'); ?>
<?php 
  } 
}

osc_add_hook('header', 'osc_structured_data_header');

?>