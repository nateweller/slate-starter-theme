<?php 
/**
 * Template Name: Sidebar Left
 */

$context = \Timber\Timber::context();
$context['menu'] = new Timber\Menu( 'sidebar_menu' );
$context['post'] = \Timber\Timber::get_post();

\Timber\Timber::render( 'views/templates/page-sidebar-left.twig', $context );