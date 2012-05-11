<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


function replace_ipsum($content)
{
 	//replace all 'ipsum' words with bold and blue 'ipsum' words
 	$content = str_replace('ipsum', '<strong style="color: blue;">ipsum</strong>', $content);
 	return $content;
}


class Hooking_example extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		//load the spark
		$this->load->spark('hooking/1.0.0');
	}

	function index()
	{
		/**
		 * If the PHP version is greater than 5.3.0 it
		 * will support Anonymous functions
		 */

		if (strnatcmp(phpversion(),'5.3.0') >= 0)
		{
	  		add_action('before_title', function(){
	  			echo '<small>This text is prepended before the title</small>';
	 		});

	 		add_action('after_title', function(){
	  			echo '<small>This text is appended after the title</small> <hr/>';
	 		});
		}

		/**
		 * Add some class specific actions
		 */

		add_action('before_content', array($this, 'action_before_content'));
		add_action('after_content', array($this, 'action_after_content'));

		/**
		 * Add filters to the content (1 global function and 1 class specific function)
		 */

		add_filter('content', 'replace_ipsum', 30); //global function (see above) with 30 priority
		add_filter('content', array($this, 'filter_add_author_to_content'), 10); //class function (see below) with 10 priority (first executed)


		/**
		 *  add time to the title and underline the word title
		 */
		add_filter('title', array($this, 'filter_add_time_to_the_title')); //add a time to the title


		$data = array(
			'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi at sem leo. Pellentesque sed ipsum tortor sed mi gravida imperdiet ac sed magna. Nunc tempor libero nec ligula ullamcorper euismod. Sed adipiscing consectetur metus eget congue. ipsum dignissim mauris nec risus tempus vulputate. Ut in arcu felis. Sed imperdiet mollis ipsum. Aliquam non lacus libero, eu tristique urna. ipsum Morbi vel gravida justo. Curabitur sed velit lorem, nec ultrices odio. Cras et magna vel purus dapibus egestas. Etiam massa eros, pretium eget venenatis fermentum, tincidunt id nisl. Aenean ut felis velit. Donec non neque congue nibh convallis pretium. Nam egestas luctus eros ac elementum. Vestibulum nisl sapien, pellentesque sit amet pulvinar at, ullamcorper in purus.',
		);

		$this->load->view('hooking_example', $data);
	}

	function action_before_content()
	{
		echo '<p class="content" style="border: 1px solid red; margin: 10px; padding: 10px;">';
	}

	function action_after_content()
	{
		echo '</p>';
	}

	function filter_add_author_to_content($content)
	{
  		return $content . '<div><i> - 2012 By ipsum author</i></div>';
	}

	function filter_add_time_to_the_title($title)
	{
  		$title = $title . ' - ' . strftime('%H:%M'); //add the time
  		$title = str_replace('title', '<u>title</u>', $title); //and underline the title
  		return $title;
	}
}