<?php 
/**
 * Template Name: Narrow
 */

$context = \Timber\Timber::context();
$context['post'] = \Timber\Timber::get_post();

\Timber\Timber::render( 'views/templates/page-narrow.twig', $context );