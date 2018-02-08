<?php
/**
 * Template Name: Posts Index
 */

$context = Timber::get_context();

$args = array(
  'post_type' => 'post'
);

$context['posts'] = Timber::get_posts( $args );
$context['post'] = Timber::query_post();

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

Timber::render( 'home.twig', $context );