<?php 
/**
 * Header Template
 * 
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package _slate
 */

$context = \Timber\Timber::context();
$context['menu'] = new Timber\Menu( 'primary_menu', array( 'depth' => 2 ) );

\Timber\Timber::render( 'views/templates/header.twig', $context );