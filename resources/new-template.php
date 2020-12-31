<?php 
/**
 * Template Name: __NAME__
 * 
 * @package _slate
 * @todo prevent WP from loading this as an actual template
 */

use \Timber\Timber;

$context = Timber::context();
$context['post'] = Timber::get_post();

Timber::render( 'views/templates/__SLUG__.twig', $context );