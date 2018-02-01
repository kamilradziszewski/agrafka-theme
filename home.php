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

Timber::render( 'home.twig', $context );