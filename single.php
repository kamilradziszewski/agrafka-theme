<?php
/**
 * The Template for displaying all single posts
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$context = Timber::get_context();
$post = Timber::query_post();
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

if ( post_password_required( $post->ID ) ) {
	Timber::render( 'single-password.twig', $context );
} else {
	Timber::render( array( 'single-' . $post->ID . '.twig', 'single-' . $post->post_type . '.twig', 'single.twig' ), $context );
}
