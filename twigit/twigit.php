<?php

	/**
	 * Twigit
	 *
	 * A plugin that allows Twig templates for WordPress themes
	 *
	 * @package   Twigit
	 * @author    Joe Reilly
	 * @license   GPL-3.0+
	 * @copyright 2016 Joe Reilly
	 *
	 * @wordpress-plugin
	 * Plugin Name: Twigit
	 * Description: 
	 * Version:     1.0
	 * Author:      Joe Reilly
	 * License:     GPL-3.0+
	 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
	 */

	# If this file is called directly, abort.
	if (!defined('WPINC')) {
		die;
	}


	# Bring in the Twigitclass file
	require_once plugin_dir_path(__FILE__) . 'class-twigit.php';

	# Initialise Twigit
	Twigit::get_instance();





	/**
	 * A function for rendering a template through calling the Twigit Class
	 *
	 * @param array    $vals            An array of variables to be rendered with the template, defaults to an empty array
	 * @param string   $template        The name of the template to be rendered, if users want to override the default action, defaults to false
	 * @param bool     $echo            A boolean indicating whether to echo or return the rendered template, defaults to true
	 *
	 * @return string The rendered template
	 */
	function twigit_render_twig_template($vals = array(), $template = false, $echo = true)
	{
		$Twigit = Twigit::get_instance();

		# If no template has been specified, look for {PHP Template Filename}.twig
		if (false === $template) {
			$template = pathinfo(basename($Twigit::$template), PATHINFO_FILENAME) . '.twig';
		}

		# Check whether we are echoing or returning
		if (true === $echo) {
			echo $Twigit->render_template($template, $vals);
		} else {
			return $Twigit->render_template($template, $vals);
		}
	}





	/**
	 * Function for return the content for a post
	 *
	 * As get_the_content() returns the unformatted content, this function takes
	 * care of turning the unformatted content into formated content for passing
	 * to a template
	 *
	 * This function can only be used inside the loop
	 *
	 * @return string The string of formatted content
	 */
	function twigit_get_the_content()
	{
		return str_replace(']]>', ']]&gt;', apply_filters('the_content', get_the_content()));
	}
