<?php 
/**
 * Template Name: __NAME__
 * 
 * @package _slate
 */

use \Timber\Timber;

$context = Timber::context();
$context['post'] = Timber::get_post();

Timber::render( 'views/templates/__SLUG__.twig', $context );