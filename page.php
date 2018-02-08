<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * To generate specific templates for your pages you can use:
 * /mytheme/views/page-mypage.twig
 * (which will still route through this PHP file)
 * OR
 * /mytheme/page-mypage.php
 * (in which case you'll want to duplicate this file and save to the above path)
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$context = Timber::get_context();
$post = new TimberPost();
$context['post'] = $post;

$acf = get_field_objects($context["post"]->ID);

if( ! empty( $acf ) ) {
  $acf_slider_images = array();

  foreach ($acf as $value) {
    $slider_image_id = $value['value'];
    if( isset($slider_image_id) && strlen($slider_image_id) ) {
      array_push($acf_slider_images, new TimberImage($slider_image_id));
    }
  }

  $context['slider_images'] = $acf_slider_images;
}

Timber::render( array( 'page-' . $post->post_name . '.twig', 'page.twig' ), $context );