<?php 
/**
 * Header Template
 * 
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package _slate
 */

use Timber\Timber;
use Timber\Menu;

$context = Timber::context();
$context['menu'] = new Menu( 'primary_menu', array( 'depth' => 2 ) );

Timber::render( 'views/templates/header.twig', $context );