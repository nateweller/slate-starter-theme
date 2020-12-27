<?php 
/**
 * Template Name: Narrow Width
 * 
 * @package _slate
 */

use Timber\Timber;

$context = Timber::context();
$context['post'] = Timber::get_post();

Timber::render( 'views/templates/page-narrow.twig', $context );