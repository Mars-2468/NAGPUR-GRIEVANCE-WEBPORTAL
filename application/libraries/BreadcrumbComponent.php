<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Breadcrumbs Class
 *
 * This class manages the breadcrumb object
 *
 * @package		Breadcrumb
 * @version		1.0
 * @author 		Buti <buti@nobuti.com>
 * @copyright 	Copyright (c) 2012, Buti
 * @link		https://github.com/nobuti/codeigniter-breadcrumb
 */
class BreadcrumbComponent {
	
	/**
	 * Breadcrumbs stack
	 *
     */
	private $breadcrumbs = array();
	 	
	 /**
	  * Constructor
	  *
	  * @access	public
	  *
	  */
	public function __construct()
	{	
		$this->ci =& get_instance();
		// Load config file
		$this->ci->load->config('breadcrumbs');
		// Get breadcrumbs display options
		$this->tag_open = $this->ci->config->item('tag_open');
		$this->tag_close = $this->ci->config->item('tag_close');
		$this->divider = $this->ci->config->item('divider');
		$this->crumb_open = $this->ci->config->item('crumb_open');
		$this->crumb_close = $this->ci->config->item('crumb_close');
		$this->crumb_last_open = $this->ci->config->item('crumb_last_open');
		$this->crumb_divider = $this->ci->config->item('crumb_divider');
		
		log_message('debug', "Breadcrumbs Class Initialized");
	}
	
	// --------------------------------------------------------------------

	/**
	 * Append crumb to stack
	 *
	 * @access	public
	 * @param	string $page
	 * @param	string $href
	 * @return	void
	 */		
	function add($page, $href)
	{
		// no page or href provided
		if (!$page OR !$href) return;
		
		// Prepend site url
		//$href = site_url($href);
		
		// push breadcrumb
		$this->breadcrumbs[] = array('page' => $page, 'href' => $href);
	}
	
	// --------------------------------------------------------------------

	/**
	 * Prepend crumb to stack
	 *
	 * @access	public
	 * @param	string $page
	 * @param	string $href
	 * @return	void
	 */		
	function end($page, $href)
	{
		// no crumb provided
		if (!$page OR !$href) return;
		
		// Prepend site url
		$href = site_url($href);
		
		// add at firts
		array_unshift($this->breadcrumbs, array('page' => $page, 'href' => $href));
	}
	
	// --------------------------------------------------------------------

	/**
	 * Generate breadcrumb
	 *
	 * @access	public
	 * @return	string
	 */		
	function render()
	{
		if ($this->breadcrumbs) {
		
			// set output variable
			$output = $this->tag_open;
			
			// construct output
			//print_r($this->breadcrumbs);
			foreach ($this->breadcrumbs as $key => $crumb) {
				$keys = array_keys($this->breadcrumbs);
				if (end($keys) == $key) {
					$output .= $this->crumb_last_open . ' &nbsp; / &nbsp; ' . $crumb['page'] . '' . $this->crumb_close;
				} else {
					$output .= $this->crumb_open.'<a href="' . $crumb['href'] . '">' . $crumb['page'] . '</a>  '.$this->crumb_divider.$this->crumb_close;
					
				}
			}
			
			// return output
			return $output . $this->tag_close . PHP_EOL;
		}
		
		// no crumbs
		return '';
	}

}
// END Breadcrumbs Class

/* End of file Breadcrumbs.php */
/* Location: ./application/libraries/Breadcrumbs.php */




/*if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class BreadcrumbComponent {

	private $breadcrumbs = array();
	private $tags = "";
	
	function __construct()
	{
		$this->tags['open'] = "<ol class='breadcrumb'>";
		$this->tags['close'] = "</ol>";
		$this->tags['itemOpen'] = "<li>";
		$this->tags['itemClose'] = "</li>";
	}

	function add($title, $href,$target,$class){		
		if (!$title OR !$href) return;
		$this->breadcrumbs[] = array('title' => $title, 'href' => $href,'target'=>$target,'class'=>$class);
	}
	
	function openTag($tags=""){
		if(empty($tags)){
			return $this->tags['open'];
		}else{
			$this->tags['open'] = $tags;
		}
	}
	
	function closeTag($tags=""){
		if(empty($tags)){
			return $this->tags['close'];
		}else{
			$this->tags['close'] = $tags;
		}
	}
	
	function itemOpenTag($tags=""){
		if(empty($tags)){
			return $this->tags['itemOpen'];
		}else{
			$this->tags['itemOpen'] = $tags;
		}
	}
	
	function itemCloseTage($tags=""){
		if(empty($tags)){
			return $this->tags['itemClose'];
		}else{
			$this->tags['itemClose'] = $tags;
		}
	}
	
	function render(){

		if(!empty($this->tags['open'])){
			$output = $this->tags['open'];
		}else{
			$output = '<ol class="breadcrumb">';
		}
		
		$count = count($this->breadcrumbs)-1;
		foreach($this->breadcrumbs as $index => $breadcrumb){
		
			if($index == $count){
				$output .= '<li class="active">';
				$output .= $breadcrumb['title'];
				$output .= '</li>';
			}else{
				$output .= ($this->tags['itemOpen'])?$this->tags['itemOpen']:'<li>';
				$output .= '<a href="'.$breadcrumb['href'].'" target="'.$breadcrumb['target'].'" class="'.$breadcrumb['class'].'">';
				$output .= $breadcrumb['title'];
				$output .= '</a>';
				$output .= '</li>';
			}
			
		}
		
		if(!empty($this->tags['open'])){
			$output .= $this->tags['close'];
		}else{
			$output .= "</ol>";
		}		
		

		return $output;
	}

}
