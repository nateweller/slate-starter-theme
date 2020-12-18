<?php 
/**
 * The template for displaying all single posts and pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package _s
 */

use Timber\Timber;

$context = Timber::context();
$context['post'] = Timber::get_post();

Timber::render( 'views/templates/singular.twig', $context );