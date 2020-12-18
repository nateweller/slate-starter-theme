<?php 
/**
 * The template for displaying search results pages
 * 
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 * 
 * @package _slate
 */

use Timber\Timber;

$context = Timber::context();
$context['title'] = get_search_query();

Timber::render( 'views/templates/search.twig', $context );