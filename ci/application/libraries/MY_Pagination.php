<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * CodeIgniter Dwoo Parser Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Pagination
 */

class MY_Pagination extends CI_Pagination {
	/**
	 * Generate alpha pagination links
	 *
	 * @access	public
	 * @return	string
	 */
	function create_alpha_links()
	{	
		// Set num of pahes
		$num_pages = ord('z');
		// Set the base page index for starting page number
		$base_page = ord('a');

		// Determine the current page number.
		$CI =& get_instance();

		if ($CI->config->item('enable_query_strings') === TRUE OR $this->page_query_string === TRUE)
		{
			if ($CI->input->get($this->query_string_segment) != $base_page)
			{
				$this->cur_page = $CI->input->get($this->query_string_segment);

				// Prep the current page - no funny business!
				$this->cur_page = ord($this->cur_page);
			}
		}
		else
		{
			if ($CI->uri->segment($this->uri_segment) != $base_page)
			{
				$this->cur_page = $CI->uri->segment($this->uri_segment);

				// Prep the current page - no funny business!
				$this->cur_page = ord($this->cur_page);
			}
		}
		
		// Set current page to a if cur_page equal 0
		if ($this->cur_page == 0)
		{
			$this->cur_page = $base_page;
		}

		$this->num_links = (int)$this->num_links;

		if ($this->num_links < 1)
		{
			show_error('Your number of links must be a positive number.');
		}

		if ( ! is_numeric($this->cur_page))
		{
			$this->cur_page = $base_page;
		}

		// Is the page number beyond the result range?
		// If so we show the last page
		if ($this->cur_page > $num_pages)
		{
			$this->cur_page = $num_pages;
		}

		$uri_page_number = $this->cur_page;

		// Calculate the start and end numbers. These determine
		// which number to start and end the digit links with
		$start = (($this->cur_page - $this->num_links) > $base_page - 1) ? $this->cur_page - ($this->num_links) : $base_page;
		$end   = (($this->cur_page + $this->num_links) < $num_pages) ? $this->cur_page + $this->num_links : $num_pages;
		// Is pagination being used over GET or POST?  If get, add a per_page query
		// string. If post, add a trailing slash to the base URL if needed
		if ($CI->config->item('enable_query_strings') === TRUE OR $this->page_query_string === TRUE)
		{
			$this->base_url = rtrim($this->base_url).'&amp;'.$this->query_string_segment.'=';
		}
		else
		{
			$this->base_url = rtrim($this->base_url, '/') .'/';
		}

		// And here we go...
		$output = '';

		// echo $this->cur_page; die();
		// Render the "First" link
		if  ($this->first_link !== FALSE AND $this->cur_page > ($this->num_links + $base_page))
		{
			$first_url = ($this->first_url == '') ? $this->base_url : $this->first_url;
			$output .= $this->first_tag_open.'<a '.$this->anchor_class.'href="'.$first_url.'">'.$this->first_link.'</a>'.$this->first_tag_close;
		}

		// Render the "previous" link
		if  ($this->prev_link !== FALSE AND $this->cur_page != $base_page)
		{
			$i = chr($uri_page_number - 1);

			if (ord($i) == $base_page && $this->first_url != '')
			{
				$output .= $this->prev_tag_open.'<a '.$this->anchor_class.'href="'.$this->first_url.'">'.$this->prev_link.'</a>'.$this->prev_tag_close;
			}
			else
			{
				$i = ($i == $base_page) ? '' : $this->prefix.$i.$this->suffix;
				$output .= $this->prev_tag_open.'<a '.$this->anchor_class.'href="'.$this->base_url.$i.'">'.$this->prev_link.'</a>'.$this->prev_tag_close;
			}

		}

		// Render the pages
		if ($this->display_pages !== FALSE)
		{
			// Write the digit links
			for ($loop = $start; $loop <= $end; $loop++)
			{
				$i = $loop;

				if ($i >= $base_page)
				{
					if ($this->cur_page == $loop)
					{
						$output .= $this->cur_tag_open.chr($loop).$this->cur_tag_close; // Current page
					}
					else
					{
						$n = ($i == $base_page) ? '' : chr($i);
						if ($n == '' && $this->first_url != '')
						{
							$output .= $this->num_tag_open.'<a '.$this->anchor_class.'href="'.$this->first_url.'">'.chr($loop).'</a>'.$this->num_tag_close;
						}
						else
						{
							$n = ($n == '') ? '' : $this->prefix.$n.$this->suffix;

							$output .= $this->num_tag_open.'<a '.$this->anchor_class.'href="'.$this->base_url.$n.'">'.chr($loop).'</a>'.$this->num_tag_close;
						}
					}
				}
			}
		}

		// Render the "next" link
		if ($this->next_link !== FALSE AND $this->cur_page < $num_pages)
		{
			$i = chr($this->cur_page + 1);

			$output .= $this->next_tag_open.'<a '.$this->anchor_class.'href="'.$this->base_url.$this->prefix.$i.$this->suffix.'">'.$this->next_link.'</a>'.$this->next_tag_close;
		}

		// Render the "Last" link
		if ($this->last_link !== FALSE AND ($this->cur_page + $this->num_links) < $num_pages)
		{
			$i = chr($num_pages);
			$output .= $this->last_tag_open.'<a '.$this->anchor_class.'href="'.$this->base_url.$this->prefix.$i.$this->suffix.'">'.$this->last_link.'</a>'.$this->last_tag_close;
		}

		// Kill double slashes.  Note: Sometimes we can end up with a double slash
		// in the penultimate link so we'll kill all double slashes.
		$output = preg_replace("#([^:])//+#", "\\1/", $output);

		// Add the wrapper HTML if exists
		$output = $this->full_tag_open.$output.$this->full_tag_close;

		return $output;
	}
}