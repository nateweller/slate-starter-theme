<?php 
/**
 * Template Name: Full Width
 */

$context = \Timber\Timber::context();
$context['post'] = \Timber\Timber::get_post();

\Timber\Timber::render( 'views/templates/page-full.twig', $context );