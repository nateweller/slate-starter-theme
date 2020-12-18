<?php 
/**
 * Template Name: Sidebar Left
 * 
 * @package _slate
 */

use Timber\Timber;
use Timber\Menu;

$context = Timber::context();
$context['menu'] = new Menu( 'sidebar_menu' );
$context['post'] = Timber::get_post();

Timber::render( 'views/templates/page-sidebar-left.twig', $context );