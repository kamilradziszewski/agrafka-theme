<?php
/**
 * Template Name: Posts Index
 */

$context = Timber::get_context();

$args = array(
    'post_type' => 'post'
);

$context['posts'] = Timber::get_posts( $args );
$context['posts_index_page'] = Timber::query_post();

Timber::render( 'home.twig', $context );