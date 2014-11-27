<?php

// Substring without losing word meaning and
// tiny words (length 3 by default) are included on the result.
// "..." is added if result do not reach original string length

function pp_substr($str, $length, $minword = 3)
{
    $sub = '';
    $len = 0;
    
    foreach (explode(' ', $str) as $word)
    {
        $part = (($sub != '') ? ' ' : '') . $word;
        $sub .= $part;
        $len += strlen($part);
        
        if (strlen($word) > $minword && strlen($sub) >= $length)
        {
            break;
        }
    }
    
    return $sub . (($len < strlen($str)) ? '...' : '');
} 
function of_content_builder_add_meta() {
	add_meta_box(
		'content_builder_metabox',
		__( 'Content Builder', OF_DOMAIN ),
		'of_content_builder',
		'page',
		'normal',
		'high'
	);
} 

function of_content_builder() {

	global $post;
	
	include_once( 'content-builder-shortcode.php' );
	
	$content_enable = get_post_meta( $post->ID, 'content_enable' );
	?>
	
	<table class="form-table">
		<tr>
			<th>
				<label for="enable">Enable</label>
			</th>
			<td>
				<input type="checkbox" class="iphone_checkboxes" name="content_enable" id="content_enable" value="1	" <?php if ( ! empty( $content_enable) ) : ?>checked<?php endif; ?> />
				<span class="description"><?php _e( 'To build this page using content builder, please enable this option.', OF_DOMAIN ); ?></span>
			</td>
		</tr>
		<tr>
			<th>
				<label>Content Builder</label>
			</th>
			<td>
				<select name="ppb_options" id="ppb_options" class="pp_sortable_select">
					<option value=""><?php _e( 'Please Select Content', OF_DOMAIN ); ?></option>
					<?php foreach( $ppb_shortcodes as $key => $ppb_shortcode ) : ?>
						<option value="<?php echo $key; ?>" title="<?php echo $ppb_shortcode['title']; ?>"><?php echo $ppb_shortcode['title']; ?></option>
						<?php endforeach; ?>
					</select>
					<a id="sortable_add_button" class="button"><?php _e( 'Add', OF_DOMAIN ); ?></a>
			</td>
		</tr>
	</table>
	
		
	<div class="clear"/></div>
	
	<input type="hidden" id="inline_current" name="inline_current" value="" />
	<input type="hidden" id="form_data_order" name="form_data_order" value="" />

	<?php foreach( $ppb_shortcodes as $key => $ppb_shortcode ) { ?>
		<div id="ppb_inline_<?php echo $key; ?>" data-shortcode="<?php echo $key; ?>" class="ppb_inline">
		
		
		<h2><?php echo $ppb_shortcode['title']; ?></h2>

			<?php if ( isset( $ppb_shortcode['title'] ) && $ppb_shortcode['title'] != 'Divider' ) { ?>
			
			<label for="<?php echo $key; ?>_title">Title</label>
			<span class="label_desc">Enter Title for this content</span><br/>
			<input type="text" id="<?php echo $key; ?>_title" name="<?php echo $key; ?>_title" data-attr="title" value="Text Block"/>
			
			<?php
				}
				else
				{
			?>
			<input type="hidden" id="<?php echo $key; ?>_title" name="<?php echo $key; ?>_title" data-attr="title" value="<?php echo $ppb_shortcode['title']; ?>"/>
			<?php
				}
			?>
			
			<?php
				foreach($ppb_shortcode['attr'] as $attr_name => $attr_item)
				{
					if(!isset($attr_item['title']))
					{
						$attr_title = ucfirst($attr_name);
					}
					else
					{
						$attr_title = $attr_item['title'];
					}
				
					if($attr_item['type']=='jslider')
					{
			?>
			<label for="<?php echo $key; ?>_<?php echo $attr_name; ?>"><?php echo $attr_title; ?></label><span class="label_desc"><?php echo $attr_item['desc']; ?></span><br/>
			<input name="<?php echo $key; ?>_<?php echo $attr_name; ?>" id="<?php echo $key; ?>_<?php echo $attr_name; ?>" type="text" class="ppb_jslider" />
			<br/>
			<?php
					}
			
					if($attr_item['type']=='file')
					{
			?>
			<label for="<?php echo $key; ?>_<?php echo $attr_name; ?>"><?php echo $attr_title; ?></label><span class="label_desc"><?php echo $attr_item['desc']; ?></span><br/>
			<input name="<?php echo $key; ?>_<?php echo $attr_name; ?>" id="<?php echo $key; ?>_<?php echo $attr_name; ?>" type="text" /><br/>
			<a id="<?php echo $key; ?>_<?php echo $attr_name; ?>_button" name="<?php echo $key; ?>_<?php echo $attr_name; ?>_button" type="button" class="metabox_upload_btn button" rel="<?php echo $key; ?>_<?php echo $attr_name; ?>" style="margin:7px 0 0 0">Upload</a>
			<br/><br/>
			<?php
					}
					
					if($attr_item['type']=='select')
					{
			?>
			<label for="<?php echo $key; ?>_<?php echo $attr_name; ?>"><?php echo $attr_title; ?></label><span class="label_desc"><?php echo $attr_item['desc']; ?></span><br/>
			<select name="<?php echo $key; ?>_<?php echo $attr_name; ?>" id="<?php echo $key; ?>_<?php echo $attr_name; ?>" class="ppb_select">
				<?php
						foreach($attr_item['options'] as $attr_key => $attr_item_option)
						{
				?>
						<option value="<?php echo $attr_key; ?>"><?php echo ucfirst($attr_item_option); ?></option>
				<?php
						}
				?>
			</select>
			<br class="clear"/><br/>
			<?php
					}
					
					if($attr_item['type']=='select_multiple')
					{
			?>
			<label for="<?php echo $key; ?>_<?php echo $attr_name; ?>"><?php echo $attr_title; ?></label><span class="label_desc"><?php echo $attr_item['desc']; ?></span><br/>
			<select name="<?php echo $key; ?>_<?php echo $attr_name; ?>" id="<?php echo $key; ?>_<?php echo $attr_name; ?>" class="ppb_select" multiple="multiple">
				<?php
						foreach($attr_item['options'] as $attr_key => $attr_item_option)
						{
							if(!empty($attr_item_option))
							{
				?>
							<option value="<?php echo $attr_key; ?>"><?php echo ucfirst($attr_item_option); ?></option>
				<?php
							}
						}
				?>
			</select>
			<br class="clear"/><br/>
			<?php
					}
					
					if($attr_item['type']=='text')
					{
			?>
			<label for="<?php echo $key; ?>_<?php echo $attr_name; ?>"><?php echo $attr_title; ?></label><br/>
			<input name="<?php echo $key; ?>_<?php echo $attr_name; ?>" id="<?php echo $key; ?>_<?php echo $attr_name; ?>" type="text" />
			<br/><br/>
			<?php
					}
					
					if($attr_item['type']=='textarea')
					{
			?>
			<label for="<?php echo $key; ?>_<?php echo $attr_name; ?>"><?php echo $attr_title; ?></label><br/>
			<textarea name="<?php echo $key; ?>_<?php echo $attr_name; ?>" id="<?php echo $key; ?>_<?php echo $attr_name; ?>" cols="" rows="3"></textarea>
			<br/><br/>
			<?php
					}
				}
			?>
			
			<?php
				if(isset($ppb_shortcode['content']) && $ppb_shortcode['content'])
				{
			?>
					<label for="<?php echo $key; ?>_content">Content</label><span class="label_desc">Enter text/HTML content to display in this "<?php echo $ppb_shortcode['title']; ?>"</span><br/>
					<textarea id="<?php echo $key; ?>_content" name="<?php echo $key; ?>_content" cols="" rows="7"></textarea>
			<?php
				}
			?>
			<br/><br/>
			<a data-parent="ppb_inline_<?php echo $key; ?>" class="button-primary ppb_inline_save" href="#">Save Changes</a>
			<a class="button" href="javascript:;" onClick="jQuery.fancybox.close();">Cancel</a>
		</div>
	<?php
		}
	?>

	<ul id="content_builder_sort" class="ppb_sortable" rel="content_builder_sort_data"> 
	<?php
		$ppb_form_data_order = get_post_meta($post->ID, 'ppb_form_data_order');
		$ppb_form_item_arr = array();
		
		if(isset($ppb_form_data_order[0]))
		{
			$ppb_form_item_arr = explode(',', $ppb_form_data_order[0]);
		}

		if(isset($ppb_form_item_arr[0]) && !empty($ppb_form_item_arr[0]))
		{
			foreach($ppb_form_item_arr as $key => $ppb_form_item)
			{
				if(isset($ppb_form_item[0]))
				{
					$ppb_form_item_data = get_post_meta($post->ID, $ppb_form_item.'_data');
					$ppb_form_item_size = get_post_meta($post->ID, $ppb_form_item.'_size');
					$ppb_form_item_data_obj = json_decode($ppb_form_item_data[0]);
					
					if($ppb_form_item_data_obj->shortcode!='ppb_divider')
					{
						$obj_title_name = $ppb_form_item_data_obj->shortcode.'_title';
						$obj_title_name = $ppb_form_item_data_obj->$obj_title_name;
					}
					else
					{
						$obj_title_name = 'Divider';
					}
	?>
			<li id="<?php echo $ppb_form_item; ?>" class="ui-state-default <?php echo $ppb_form_item_size[0]; ?> <?php echo $ppb_form_item_data_obj->shortcode; ?>" data-current-size="<?php echo $ppb_form_item_size[0]; ?>">
				<div class="title"><?php echo urldecode($obj_title_name); ?></div>
				<a href="javascript:;" class="ppb_remove"></a>
				<a data-rel="<?php echo $ppb_form_item; ?>" href="#ppb_inline_<?php echo $ppb_form_item_data_obj->shortcode; ?>" class="pp_fancybox ppb_edit"></a>
				<input type="hidden" class="ppb_setting_columns" value="<?php echo $ppb_form_item_size[0]; ?>"/>
				
				
			</li>
	<?php
				}
			}
		}
	?>
	</ul>
	<br class="clear"/><br/>
	
	<script type="text/javascript">
	jQuery(document).ready(function(){
	<?php
		foreach($ppb_form_item_arr as $key => $ppb_form_item)
		{
			if(!empty($ppb_form_item))
			{
				$ppb_form_item_data = get_post_meta($post->ID, $ppb_form_item.'_data');
	?>
				jQuery('#<?php echo $ppb_form_item; ?>').data('ppb_setting', '<?php echo addslashes($ppb_form_item_data[0]); ?>');
	<?php
			}
		}
	?>
	});
	</script>
	
<?php

}

//init

add_action( 'add_meta_boxes', 'of_content_builder_add_meta' );

function pp_apply_content($pp_content) {
	$pp_content = apply_filters('the_content', $pp_content);
	$pp_content = str_replace(']]>', ']]>', $pp_content);
	return $pp_content;
}

function pp_apply_builder($page_id) {
	$ppb_form_data_order = get_post_meta($page_id, 'ppb_form_data_order');
	
	if(isset($ppb_form_data_order[0]))
	{
			$ppb_form_item_arr = explode(',', $ppb_form_data_order[0]);
	}
	
	include_once ( 'content-builder-shortcode.php' );
	//pp_debug($ppb_shortcodes);
	
	if(isset($ppb_form_item_arr[0]) && !empty($ppb_form_item_arr[0]))
	{
			$ppb_shortcode_code = '';
	
			foreach($ppb_form_item_arr as $key => $ppb_form_item)
			{
				$ppb_form_item_data = get_post_meta($page_id, $ppb_form_item.'_data');
				$ppb_form_item_size = get_post_meta($page_id, $ppb_form_item.'_size');
				$ppb_form_item_data_obj = json_decode($ppb_form_item_data[0]);
				//pp_debug($ppb_form_item_data_obj);
				$ppb_shortcode_content_name = $ppb_form_item_data_obj->shortcode.'_content';
				
				if(isset($ppb_form_item_data_obj->$ppb_shortcode_content_name))
				{
					$ppb_shortcode_code = '['.$ppb_form_item_data_obj->shortcode.' size="'.$ppb_form_item_size[0].'" ';
					
					//Get shortcode title
					$ppb_shortcode_title_name = $ppb_form_item_data_obj->shortcode.'_title';
					if(isset($ppb_form_item_data_obj->$ppb_shortcode_title_name))
					{
						$ppb_shortcode_code.= 'title="'.urldecode($ppb_form_item_data_obj->$ppb_shortcode_title_name).'" ';
					}
					
					//Get shortcode attributes
					$ppb_shortcode_arr = $ppb_shortcodes[$ppb_form_item_data_obj->shortcode];
					
					foreach($ppb_shortcode_arr['attr'] as $attr_name => $attr_item)
					{
						$ppb_shortcode_attr_name = $ppb_form_item_data_obj->shortcode.'_'.$attr_name;
						
						if(isset($ppb_form_item_data_obj->$ppb_shortcode_attr_name))
						{
							$ppb_shortcode_code.= $attr_name.'="'.$ppb_form_item_data_obj->$ppb_shortcode_attr_name.'" ';
						}
					}

					$ppb_shortcode_code.= ']'.urldecode($ppb_form_item_data_obj->$ppb_shortcode_content_name).'[/'.$ppb_form_item_data_obj->shortcode.']';
				}
				else
				{
					$ppb_shortcode_code = '['.$ppb_form_item_data_obj->shortcode.' size="'.$ppb_form_item_size[0].'" ';
					
					//Get shortcode title
					$ppb_shortcode_title_name = $ppb_form_item_data_obj->shortcode.'_title';
					if(isset($ppb_form_item_data_obj->$ppb_shortcode_title_name))
					{
						$ppb_shortcode_code.= 'title="'.urldecode($ppb_form_item_data_obj->$ppb_shortcode_title_name).'" ';
					}
					
					//Get shortcode attributes
					$ppb_shortcode_arr = $ppb_shortcodes[$ppb_form_item_data_obj->shortcode];
					
					foreach($ppb_shortcode_arr['attr'] as $attr_name => $attr_item)
					{
						$ppb_shortcode_attr_name = $ppb_form_item_data_obj->shortcode.'_'.$attr_name;
						
						if(isset($ppb_form_item_data_obj->$ppb_shortcode_attr_name))
						{
							$ppb_shortcode_code.= $attr_name.'="'.$ppb_form_item_data_obj->$ppb_shortcode_attr_name.'" ';
						}
					}
					
					$ppb_shortcode_code.= ']';
				}
				
				echo pp_apply_content($ppb_shortcode_code);
				//echo $ppb_shortcode_code.'<hr/>';
				}
		}
		
		return false;
}

function ppb_text_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one'
	), $atts));

	$return_html = '<div class="'.$size.' withpadding"><div class="standard_wrapper">'.$content.'</div></div>';

	return $return_html;

}

add_shortcode('ppb_text', 'ppb_text_func');


function ppb_divider_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one'
	), $atts));

	$return_html = '<div class="standard_wrapper divider">&nbsp;</div>';

	return $return_html;

}

add_shortcode('ppb_divider', 'ppb_divider_func');


function ppb_classic_blog_func($atts, $content) {

	remove_filter('the_content', 'pp_formatter', 99);

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'title' => '',
		'description' => '',
		'items' => 4,
		'category' => '',
		'link' => '',
	), $atts));
	
	if(!is_numeric($items))
	{
		$items = 1;
	}
	
	//Get current page template
	$current_page_template = basename(get_page_template());

	//Get category posts
	$args = array(
	    'numberposts' => $items,
	    'order' => 'DESC',
	    'orderby' => 'date',
	    'post_type' => array('post'),
	);
	
	if(!empty($category))
	{
		$args['category'] = $category;
	}

	$posts_arr = get_posts($args);
	$return_html = '';
	$return_html.= '<div class="'.$size.' ppb_classic">';

	if(!empty($posts_arr))
	{	
		$return_html.= '<div class="standard_wrapper">';
	
		if(!empty($title))
		{
			$return_html.= '<div class="ppb_header ';
			
			if($current_page_template != 'page_sidebar.php')
			{
				$return_html.= 'fullwidth';
			}
			
			$return_html.= '"><h5 class="header_line ';
			
			if($current_page_template != 'page_sidebar.php')
			{
				$return_html.= 'post_fullwidth';
			}
			
			//if activate category link
			$category_url = '';
			if(!empty($link))
			{
				$category_url = get_category_link($category);
				$title = '<a href="'.$category_url.'">'.$title.'</a>';
			}
			
			$return_html.= '">'.$title.'</h5>';
			
			if(!empty($description))
			{
				$return_html.= '<div class="ppb_desc">'.urldecode($description).'</div>';
			}
			
			$return_html.= '</div>';
		}
		
		$count = 1;
		foreach($posts_arr as $key => $post)
		{
			$image_thumb = '';
			
			if($current_page_template == 'page_sidebar.php')
			{
				$return_html.= '<div class="post_wrapper ppb_classic_fullwidth entry_post animated'.$count.'" style="';
			}
			else
			{
				if($count%2==0)
	        	{
		            $return_html.= '<div class="one_half ppb_classic last entry_post animated'.$count.'" style="';
		        }
		        else
		        {
			        $return_html.= '<div class="one_half ppb_classic entry_post animated'.$count.'" style="';
		        }
			}

			if(has_post_thumbnail($post->ID, 'blog_ft'))
			{
			    $image_id = get_post_thumbnail_id($post->ID);
			    $image_thumb = wp_get_attachment_image_src($image_id, 'blog_ft', true);
			}
			
			if($count==1) 
			{ 
			    $return_html.= 'padding-top:0;'; 
			}
			if($count == sizeof($posts_arr))
			{
			    $return_html.= 'border:0;padding-bottom:15px;'; 
			}
			
			$return_html.= '">';
		    $return_html.= '<div class="post_inner_wrapper" style="position:relative">';
		    
		    if(isset($image_thumb[0]) && !empty($image_thumb))
			{
				if(comments_open($post->ID))
				{
				    $return_html.= '<div class="post_comment_count fixed"><a href="'.get_permalink($post->ID).'" title="'.$post->post_title.'">'.get_comments_number($post->ID).' ';
				    if(get_comments_number($post->ID) <= 1)
				    {
				    	$return_html.= __( 'Comment', OF_DOMAIN );
				    }
				    else
				    {
				    	$return_html.= __( 'Comments', OF_DOMAIN );
				    }
				    $return_html.= '</a></div>';
				}
			
				$return_html.= '<div class="post_img ';
				
				if($current_page_template == 'page_sidebar.php')
				{
					$return_html.= 'ppb_classic_sidebar';
				}
				else
				{
					$return_html.= 'ppb_classic_fullwidth';
				}
				
				$return_html.= '" ';
				
				$return_html.= '>';
				$return_html.= '<a href="'.get_permalink($post->ID).'" title="'.$post->post_title.'">';
				$return_html.= '<img src="'.$image_thumb[0].'" alt="" class="post_ft" ';
				$return_html.= 'style="width:'.$image_thumb[1].'px;height:'.$image_thumb[2].'px"';
				$return_html.= '/></a>';
				
				//Get post type
		        $post_ft_type = get_post_meta($post->ID, 'post_ft_type', true);
				
				//Get Post review score
				$post_review_score = 0;
				$post_percentage_score = $post_review_score*10;
				
				if(!empty($post_review_score))
				{
					$return_html.= '<div class="review_score_bg two_cols ppb_classic"><div class="review_point" style="width:'.$post_percentage_score.'%">'.$post_percentage_score.'%</div></div>';
				}
				
				$return_html.='</div>';
			}
		    	
		    $return_html.= '<div class="post_header_wrapper">';
		    $return_html.= '<div class="post_header single_post">';
		    $return_html.= '<h5 class="ppb_classic_title"><a href="'.get_permalink($post->ID).'" title="'.$post->post_title.'">'.$post->post_title.'</a></h5>';
		    $return_html.= '</div></div>';
			$return_html.= '<p>'.pp_substr(strip_tags(strip_shortcodes($post->post_content)), 160).'</p></div>';
		    $return_html.= '<div class="post_wrapper_inner">';
			$return_html.= '<div class="post_detail half grey space">';
			
			$author_firstname = get_the_author_meta('first_name', $post->post_author);
			$author_url = get_author_posts_url($post->post_author);
			
			if(!empty($author_firstname))
			{
				$return_html.= '<a href="'.$author_url.'">'.__( 'By', OF_DOMAIN ).' '.$author_firstname.'</a>&nbsp;/&nbsp;';
			}
			$return_html.= date( 'F j Y', strtotime($post->post_date));
			$return_html.= '</div></div><br class="clear"/></div>';
			$count++;
		}
		
		$return_html.= '</div>';
	}
	else
	{
		$return_html.= 'Empty blog post Please make sure you have created it.';
	}

	$return_html.= '</div>';
	
	if($current_page_template != 'page_sidebar.php')
	{
		$return_html.= '<br class="clear"/>';	
	}	

	return $return_html;

}

add_shortcode('ppb_classic_blog', 'ppb_classic_blog_func');


function ppb_category_blog_func($atts, $content) {

	remove_filter('the_content', 'pp_formatter', 99);

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'description' => '',
		'title' => '',
		'items' => 5,
		'category' => '',
		'link' => '',
	), $atts));
	
	if(!is_numeric($items))
	{
		$items = 1;
	}
	
	//Get current page template
	$current_page_template = basename(get_page_template());

	//Get category posts
	$args = array(
	    'numberposts' => $items,
	    'order' => 'DESC',
	    'orderby' => 'date',
	    'post_type' => array('post'),
	);
	
	if(!empty($category))
	{
		$args['category'] = $category;
	}

	$posts_arr = get_posts($args);
	$return_html = '';
	$return_html.= '<div class="'.$size.' ppb_category">';

	if(!empty($posts_arr))
	{	
		$return_html.= '<div class="standard_wrapper">';
	
		if(!empty($title))
		{
			$return_html.= '<div class="ppb_header ';
			
			if($current_page_template != 'page_sidebar.php')
			{
				$return_html.= 'fullwidth';
			}
			
			$return_html.= '"><h5 class="header_line ';
			
			if($current_page_template != 'page_sidebar.php')
			{
				$return_html.= 'post_fullwidth';
			}
			
			//if activate category link
			$category_url = '';
			if(!empty($link))
			{
				$category_url = get_category_link($category);
				$title = '<a href="'.$category_url.'">'.$title.'</a>';
			}
			
			$return_html.= '">'.$title.'</h5>';
			
			if(!empty($description))
			{
				$return_html.= '<div class="ppb_desc">'.urldecode($description).'</div>';
			}
			
			$return_html.= '</div>';
		}
		
		$image_thumb = '';
	    
	    //Get first post detail
		if(has_post_thumbnail($posts_arr[0]->ID, 'blog_cat_ft'))
		{
		    $image_id = get_post_thumbnail_id($posts_arr[0]->ID);
		    $image_thumb = wp_get_attachment_image_src($image_id, 'blog_cat_ft', true);
		}
		
		//Check page template
		if($current_page_template == 'page_sidebar.php')
		{
			$return_html.= '<div class="one_half" style="position:relative">';
		}
		else
		{
			$return_html.= '<div class="one_half" style="position:relative">';
		}
	    
	    //Display first post
	    if(!empty($image_thumb))
	    {
	    	if(comments_open($posts_arr[0]->ID))
			{
			    $return_html.= '<div class="post_comment_count fixed"><a href="'.get_permalink($posts_arr[0]->ID).'" title="'.$posts_arr[0]->post_title.'">'.get_comments_number($posts_arr[0]->ID).' ';
			    if(get_comments_number($posts_arr[0]->ID) <= 1)
			    {
			    	$return_html.= __( 'Comment', OF_DOMAIN );
			    }
			    else
			    {
			    	$return_html.= __( 'Comments', OF_DOMAIN );
			    }
			    $return_html.= '</a></div>';
			}
	    
	        $return_html.= '<div class="post_img ';
	        
	        if($current_page_template == 'page_sidebar.php')
			{
				$return_html.= 'ppb_cat_sidebar';
			}
			else
			{
				$return_html.= 'ppb_cat_fullwidth';
			}
	        
	        $return_html.= '" style="margin-top:0;';
	        
	        $return_html.= '">';
	        $return_html.= '<a href="'.get_permalink($posts_arr[0]->ID).'" title="'.$posts_arr[0]->post_title.'">';
	        $return_html.= '<img src="'.$image_thumb[0].'" alt="" class="post_ft" style="width:'.$image_thumb[1].'px;height:'.$image_thumb[2].'px" ';
	        $return_html.= '/>';
	        $return_html.= '</a>';
			
			//Get post type
		    $post_ft_type = get_post_meta($posts_arr[0]->ID, 'post_ft_type', true);
			
			//Get Post review score
			$post_review_score = 0;
			$post_percentage_score = $post_review_score*10;
			
			if(!empty($post_review_score))
			{
			    $return_html.= '<div class="review_score_bg ppb_cat two_cols"><div class="review_point" style="width:'.$post_percentage_score.'%">'.$post_percentage_score.'%</div></div>';
			}
			
	        $return_html.= '</div>';
	    }

	    $return_html.= '<h5 class="ppb_classic_title">';
	    $return_html.= '<a href="'.get_permalink($posts_arr[0]->ID).'" title="'.$posts_arr[0]->post_title.'">'.$posts_arr[0]->post_title.'</a></h5>';
	    $return_html.= '<p>'.pp_substr(strip_tags(strip_shortcodes($posts_arr[0]->post_content)), 160).'</p>';
	    $return_html.= '<div class="post_detail space grey">';
	    
	    $author_firstname = get_the_author_meta('first_name', $posts_arr[0]->post_author);
		$author_url = get_author_posts_url($posts_arr[0]->post_author);
		
		if(!empty($author_firstname))
		{
		    $return_html.= '<a href="'.$author_url.'">'.__( 'By', OF_DOMAIN ).' '.$author_firstname.'</a>&nbsp;/&nbsp;';
		}
		$return_html.= date( 'F j Y', strtotime($posts_arr[0]->post_date));
		$return_html.='</div>';
		
	    $return_html.= '</div>';
		
		if($current_page_template != 'page_sidebar.php')
		{
			//Display second and third posts
			$return_html.= '<div class="one_half ppb_category">';
			
			$return_html.= '<div class="one_half" style="position:relative">';
			//Get second post
			if(has_post_thumbnail($posts_arr[1]->ID, 'related_post'))
			{
			    $image_id = get_post_thumbnail_id($posts_arr[1]->ID);
			    $image_thumb = wp_get_attachment_image_src($image_id, 'related_post', true);
			}
			
			if(!empty($image_thumb))
		    {
		    	if(comments_open($posts_arr[1]->ID))
				{
				    $return_html.= '<div class="post_comment_count fixed"><a href="'.get_permalink($posts_arr[1]->ID).'" title="'.$posts_arr[1]->post_title.'">'.get_comments_number($posts_arr[1]->ID).' ';
				    if(get_comments_number($posts_arr[1]->ID) <= 1)
				    {
				    	$return_html.= __( 'Comment', OF_DOMAIN );
				    }
				    else
				    {
				    	$return_html.= __( 'Comments', OF_DOMAIN );
				    }
				    $return_html.= '</a></div>';
				}
		    
		    	$return_html.= '<div class="post_img ppb_cat">';
		    	$return_html.= '<a href="'.get_permalink($posts_arr[1]->ID).'" title="'.$posts_arr[1]->post_title.'">';
		        $return_html.= '<img src="'.$image_thumb[0].'" alt="" class="post_ft" style="width:'.$image_thumb[1].'px;height:'.$image_thumb[2].'px" ';
		        $return_html.= '/>';
		        $return_html.= '</a>';
		    	$return_html.= '</div>';
		    }
		    $return_html.= '<strong class="title">';
		    $return_html.= '<a href="'.get_permalink($posts_arr[1]->ID).'" title="'.$posts_arr[1]->post_title.'">'.$posts_arr[1]->post_title.'</a></strong>';
		    $return_html.= '<span class="post_attribute ppb_cat_last ';
				
			if($current_page_template != 'page_sidebar.php')
			{
			    $return_html.= 'ppb_cat_last_fullwidth';
			}
			
			$return_html.= '">'.date( 'F j Y', strtotime($posts_arr[1]->post_date)).'</span>';
	
			//Get third post
			if(isset($posts_arr[2]))
			{
				if(has_post_thumbnail($posts_arr[2]->ID, 'related_post'))
				{
				    $image_id = get_post_thumbnail_id($posts_arr[2]->ID);
				    $image_thumb = wp_get_attachment_image_src($image_id, 'related_post', true);
				}
				
				if(!empty($image_thumb))
			    {
			    	if(comments_open($posts_arr[2]->ID))
					{
						$return_html.= '<br class="clear"/><div style="position:relative">';
					    $return_html.= '<div class="post_comment_count fixed"><a href="'.get_permalink($posts_arr[2]->ID).'" title="'.$posts_arr[2]->post_title.'">'.get_comments_number($posts_arr[2]->ID).' ';
					    if(get_comments_number($posts_arr[2]->ID) <= 1)
					    {
					    	$return_html.= __( 'Comment', OF_DOMAIN );
					    }
					    else
					    {
					    	$return_html.= __( 'Comments', OF_DOMAIN );
					    }
					    $return_html.= '</a></div>';
					}
			    
			    	$return_html.= '<div class="post_img ppb_cat">';
			    	$return_html.= '<a href="'.get_permalink($posts_arr[2]->ID).'" title="'.$posts_arr[2]->post_title.'">';
			        $return_html.= '<img src="'.$image_thumb[0].'" alt="" class="post_ft" style="width:'.$image_thumb[1].'px;height:'.$image_thumb[2].'px" ';
			        $return_html.= '/>';
			        $return_html.= '</a>';
			    	$return_html.= '</div>';
			    }
			    $return_html.= '<strong class="title">';
			    $return_html.= '<a href="'.get_permalink($posts_arr[2]->ID).'" title="'.$posts_arr[2]->post_title.'">'.$posts_arr[2]->post_title.'</a></strong>';
			    
			    $return_html.= '<span class="post_attribute ppb_cat_last ';
					
				if($current_page_template != 'page_sidebar.php')
				{
				    $return_html.= 'ppb_cat_last_fullwidth';
				}
				
				$return_html.= '">'.date( 'F j Y', strtotime($posts_arr[2]->post_date)).'</span>';
				$return_html.= '</div>';
				$return_html.= '</div>';
			}
		}
		
		//Get the rest of posts
		$return_html.= '<div class="one_half last ppb_cat_last">';
		$begin_last_column = 2;
		if($current_page_template == 'page_sidebar.php')
		{
			$begin_last_column = 0;
		}
		
		foreach($posts_arr as $key => $post)
		{
	        if($key > $begin_last_column)
	        {
	        	$return_html.= '<div>';
	        	
	        	if($current_page_template == 'page_sidebar.php')
				{
					$image_thumb = '';
			        if(has_post_thumbnail($post->ID, 'related_post'))
					{
					    $image_id = get_post_thumbnail_id($post->ID);
					    $image_thumb = wp_get_attachment_image_src($image_id, 'related_post', true);
					}
	
		    		if(isset($image_thumb[0]) && !empty($image_thumb[0]))
		    		{
		    			$return_html.= '<div class="thumb_img alignleft">';
		    			$return_html.= '<a href="'.get_permalink($post->ID).'" title="'.$post->post_title.'">';
		    			$return_html.= '<img class="post_ft thumb" src="'.$image_thumb[0].'" alt=""/>';
		    			$return_html.= '</a>';
		    			$return_html.= '</div>';
		    		}
				}
	        	
				$return_html.= '<a href="'.get_permalink($post->ID).'" title="'.$post->post_title.'" class="post_title">';
	    		$return_html.= $post->post_title.'</a><br/>';
				$return_html.= '<span class="post_attribute ppb_cat_last ';
				
				if($current_page_template != 'page_sidebar.php')
				{
					$return_html.= 'ppb_cat_last_fullwidth';
				}
				
				$return_html.= '">'.date( 'F j Y', strtotime($post->post_date)).'</span>';
				$return_html.= '</div>';
				
				if($current_page_template == 'page_sidebar.php')
				{
					$return_html.= '<br class="clear"/>';
				}
	        }
			
		}
		
		if($current_page_template != 'page_sidebar.php')
		{
			$return_html.= '</div></div>';
		}
		
		$return_html.= '</div>';
	}
	else
	{
		$return_html.= 'Empty blog post Please make sure you have created it.';
	}

	if($current_page_template == 'page_sidebar.php')
	{
	    $return_html.= '</div>';
	}

	$return_html.= '</div><br class="clear"/>';
	
	if($current_page_template == 'page_sidebar.php')
	{
	    $return_html.= '<br class="clear"/>';
	}
	

	return $return_html;

}

add_shortcode('ppb_category_blog', 'ppb_category_blog_func');


function ppb_category_carousel_func($atts, $content) {

	remove_filter('the_content', 'pp_formatter', 99);

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'title' => '',
		'description' => '',
		'items' => 5,
		'category' => '',
		'link' => '',
	), $atts));
	
	if(!is_numeric($items))
	{
		$items = 1;
	}
	
	//Get current page template
	$current_page_template = basename(get_page_template());

	//Get category posts
	$args = array(
	    'numberposts' => $items,
	    'order' => 'DESC',
	    'orderby' => 'date',
	    'post_type' => array('post'),
	);
	
	if(!empty($category))
	{
		$args['category'] = $category;
	}

	$posts_arr = get_posts($args);
	$return_html = '';
	
	if($current_page_template == 'page_sidebar.php')
	{
		$return_html.= '<input type="hidden" id="post_carousel_column" name="post_carousel_column" value="3"/>';
	}
	else
	{
		$return_html.= '<input type="hidden" id="post_carousel_column" name="post_carousel_column" value="5"/>';
	}

	$return_html.= '<div class="'.$size.' ppb_carousel">';

	if(!empty($posts_arr))
	{	
		$return_html.= '<div class="standard_wrapper">';
	
		if(!empty($title))
		{
			$return_html.= '<div class="ppb_header ';
			
			if($current_page_template != 'page_sidebar.php')
			{
				$return_html.= 'fullwidth';
			}
			
			$return_html.= '"><h5 class="header_line ';
			
			if($current_page_template != 'page_sidebar.php')
			{
				$return_html.= 'post_fullwidth';
			}
			
			//if activate category link
			$category_url = '';
			if(!empty($link))
			{
				$category_url = get_category_link($category);
				$title = '<a href="'.$category_url.'">'.$title.'</a>';
			}
			
			$return_html.= '">'.$title.'</h5>';
			
			if(!empty($description))
			{
				$return_html.= '<div class="ppb_desc">'.urldecode($description).'</div>';
			}
			
			$return_html.='</div>';
		}
		
		$return_html.= '<div class="flexslider post_carousel ';
		
		if($current_page_template != 'page_sidebar.php')
		{
			$return_html.= 'post_fullwidth';
		}
		
		$return_html.= '"><ul class="slides">';
		
		foreach($posts_arr as $key => $post)
		{
			$return_html.= '<li>';
			
			$image_thumb = '';
		    if(has_post_thumbnail($post->ID, 'related_post'))
			{
			    $image_id = get_post_thumbnail_id($post->ID);
			    $image_thumb = wp_get_attachment_image_src($image_id, 'related_post', true);
			}
			
			if(isset($image_thumb[0]) && !empty($image_thumb[0]))
	    	{
	    		$return_html.= '<div class="carousel_img">';
	    	    $return_html.= '<a href="'.get_permalink($post->ID).'" title="'.$post->post_title.'"><img class="post_ft" src="'.$image_thumb[0].'" alt="'.$post->post_title.'" ';
	    	    
	    	    if($current_page_template != 'page_sidebar.php')
				{
					$return_html.= 'style="width:165px;height:auto;"';
				}
	    	    
	    	    $return_html.= '/></a>';
	    	    $return_html.= '</div>';
	    	}
	    	
	    	$return_html.= '<strong class="title"><a href="'.get_permalink($post->ID).'">'.$post->post_title.'</a></strong><br/>';
	    	$return_html.= '<span class="post_attribute">'.date('M d, Y', strtotime($post->post_date)).'</span>';
			
			$return_html.= '</li>';
		}
		
		$return_html.= '</ul></div></div>';
	}
	else
	{
		$return_html.= 'Empty blog post Please make sure you have created it.';
	}

	$return_html.= '</div>';

	return $return_html;

}

add_shortcode('ppb_category_carousel', 'ppb_category_carousel_func');


function ppb_gallery_carousel_func($atts, $content) {

	remove_filter('the_content', 'pp_formatter', 99);

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'title' => '',
		'description' => '',
		'items' => 5,
		'gallery' => '',
	), $atts));
	
	if(!is_numeric($items))
	{
		$items = 1;
	}
	
	//Get current page template
	$current_page_template = basename(get_page_template());

	//Get gallery images
	$images_arr = get_post_meta($gallery, 'wpsimplegallery_gallery', true);
	$return_html = '';

	if($current_page_template == 'page_sidebar.php')
	{
		$return_html.= '<input type="hidden" id="post_carousel_column" name="post_carousel_column" value="3"/>';
	}
	else
	{
		$return_html.= '<input type="hidden" id="post_carousel_column" name="post_carousel_column" value="5"/>';
	}

	$return_html.= '<div class="'.$size.' ppb_carousel">';

	if(!empty($images_arr))
	{	
		$return_html.= '<div class="standard_wrapper">';
	
		if(!empty($title))
		{
			$return_html.= '<div class="ppb_header ';
			
			if($current_page_template != 'page_sidebar.php')
			{
				$return_html.= 'fullwidth';
			}
			
			$return_html.= '"><h5 class="header_line ';
			
			if($current_page_template != 'page_sidebar.php')
			{
				$return_html.= 'post_fullwidth';
			}
			
			$return_html.= '">'.$title.'</h5>';
			
			if(!empty($description))
			{
				$return_html.= '<div class="ppb_desc">'.urldecode($description).'</div>';
			}
			
			$return_html.= '</div>';
		}
		
		$return_html.= '<div class="flexslider post_carousel ';
		
		if($current_page_template != 'page_sidebar.php')
		{
			$return_html.= 'post_fullwidth ';
		}
		
		$return_html.= 'post_type_gallery"><ul class="slides">';
		
		foreach($images_arr as $key => $image)
		{
			$return_html.= '<li>';
			
			$image_thumb = wp_get_attachment_image_src($image,'related_post');
			$full_image_thumb = wp_get_attachment_image_src($image,'original');
			
			//Get image meta data
    		$image_title = get_the_title($image);
    		$image_desc = get_post_field('post_content', $image);

			
			if(isset($image_thumb[0]) && !empty($image_thumb[0]) && isset($full_image_thumb[0]) && !empty($full_image_thumb[0]))
	    	{
	    		$return_html.= '<div class="carousel_img">';
	    	    $return_html.= '<a class="swipebox" title="'.$image_title.'<div class=\'swipe_desc\''.$image_desc.'</div>" href="'.$full_image_thumb[0].'"><img class="post_ft" src="'.$image_thumb[0].'" alt="" ';
	    	    
	    	    if($current_page_template != 'page_sidebar.php')
				{
					$return_html.= 'style="width:165px;height:auto;"';
				}
	    	    
	    	    $return_html.= '/></a>';
	    	    $return_html.= '</div>';
	    	}
			
			$return_html.= '</li>';
		}
		
		$return_html.= '</ul></div></div>';
	}
	else
	{
		$return_html.= 'Empty blog post Please make sure you have created it.';
	}

	$return_html.= '</div>';
	$return_html.= '<br class="clear"/>';

	return $return_html;

}

add_shortcode('ppb_gallery_carousel', 'ppb_gallery_carousel_func');


function ppb_columns_blog_func($atts, $content) {

	remove_filter('the_content', 'pp_formatter', 99);

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'title' => '',
		'description' => '',
		'items' => 3,
		'category' => '',
		'link' => '',
	), $atts));
	
	if(!is_numeric($items))
	{
		$items = 1;
	}
	
	//Get current page template
	if(!empty($template))
	{
		$current_page_template = $template;
	}
	else
	{
		$current_page_template = basename(get_page_template());
	}

	//Get category posts
	$args = array(
	    'numberposts' => $items,
	    'order' => 'DESC',
	    'orderby' => 'date',
	    'post_type' => array('post'),
	);
	
	if(!empty($category))
	{
		$args['category'] = $category;
	}

	$posts_arr = get_posts($args);
	$return_html = '';
	$return_html.= '<div class="'.$size.' ppb_column">';

	if(!empty($posts_arr))
	{	
		$return_html.= '<div class="standard_wrapper">';
		
		if(!empty($title))
		{
			$return_html.= '<div class="ppb_header ';
			
			if($current_page_template != 'page_sidebar.php')
			{
				$return_html.= 'fullwidth';
			}
			
			$return_html.= '"><h5 class="header_line ';
			
			if($current_page_template != 'page_sidebar.php')
			{
				$return_html.= 'post_fullwidth';
			}
			
			//if activate category link
			$category_url = '';
			if(!empty($link))
			{
				$category_url = get_category_link($category);
				$title = '<a href="'.$category_url.'">'.$title.'</a>';
			}
			
			$return_html.= '">'.$title.'</h5>';
			
			if(!empty($description))
			{
				$return_html.= '<div class="ppb_desc">'.urldecode($description).'</div>';
			}
			
			$return_html.= '</div>';
		}
		
		$return_html.= '<div>';
		
		$count = 1;
		foreach($posts_arr as $key => $post)
		{
			$image_thumb = '';
			$return_html.= '<div class="ppb_column_post ppb_column entry_post animated'.$count.' ';
			
			if($current_page_template != 'page_sidebar.php')
			{
				$return_html.= 'masonry ';
			}
			
			if($current_page_template == 'page_sidebar.php')
			{
				if($count%2==0)
				{ 
					$return_html.= 'last'; 
				}
			}
			else
			{
				if($count%3==0)
				{ 
					$return_html.= 'last'; 
				}
			}
			
			$return_html.= '" style="position:relative">';
			
			if(comments_open($post->ID))
			{
			    $return_html.= '<div class="post_comment_count fixed"><a href="'.get_permalink($post->ID).'" title="'.$post->post_title.'">'.get_comments_number($post->ID).' ';
			    if(get_comments_number($post->ID) <= 1)
			    {
			    	$return_html.= __( 'Comment', OF_DOMAIN );
			    }
			    else
			    {
			    	$return_html.= __( 'Comments', OF_DOMAIN );
			    }
			    $return_html.= '</a></div>';
			}
			
			if(has_post_thumbnail($post->ID, 'blog_half_ft'))
			{
			    $image_id = get_post_thumbnail_id($post->ID);
			    $image_thumb = wp_get_attachment_image_src($image_id, 'blog_half_ft', true);
			}
			
			$return_html.= '<div class="post_wrapper full ppb_columns ';
			
			if($current_page_template != 'page_sidebar.php')
			{
				$return_html.= 'masonry ';
			}
			
			if($current_page_template == 'page_sidebar.php')
			{
				if($count%2==0)
				{ 
					$return_html.= 'last'; 
				}
			}
			else
			{
				if($count%3==0)
				{ 
					$return_html.= 'last'; 
				}
			}

			$return_html.= '">';
			
			if($current_page_template == 'page_sidebar.php')
			{
		    	$return_html.= '<div class="post_inner_wrapper half">';
		    }
		    
		    if(isset($image_thumb[0]) && !empty($image_thumb))
			{
				$return_html.= '<div class="post_img ';
				
				if($current_page_template == 'page_sidebar.php')
				{
					$return_html.= 'ppb_column_sidebar';
				}
				else
				{
					$return_html.= 'ppb_column_fullwidth';
				}
				
				$return_html.= ' " style="width:'.$image_thumb[1].'px;height:'.$image_thumb[2].'px">';
				
				$return_html.= '<a href="'.get_permalink($post->ID).'" title="'.$post->post_title.'">';
				$return_html.= '<img src="'.$image_thumb[0].'" alt="" class="post_ft"/></a>';
				
				//Get post type
		        $post_ft_type = get_post_meta($post->ID, 'post_ft_type', true);
				
				//Get Post review score
				$post_review_score = 0;
				$post_percentage_score = $post_review_score*10;
				
				if(!empty($post_review_score))
				{
					$return_html.= '<div class="review_score_bg two_cols"><div class="review_point" style="width:'.$post_percentage_score.'%">'.$post_percentage_score.'%</div></div>';
				}
				
				$return_html.= '</div>';
			}

		    $return_html.= '<div class="post_inner_wrapper half header">';
		    $return_html.= '<div class="post_header_wrapper half">';
		    $return_html.= '<div class="post_header half">';
		    $return_html.= '<h4><a href="'.get_permalink($post->ID).'" title="'.$post->post_title.'">'.$post->post_title.'</a></h4>';
		    $return_html.= '</div></div>';
			$return_html.= '<p>'.pp_substr(strip_tags(strip_shortcodes($post->post_content)), 100).'</p>';
			$return_html.= '<div class="post_detail grey space">';
			
			$author_firstname = get_the_author_meta('first_name', $post->post_author);
			$author_url = get_author_posts_url($post->post_author);
			
			if(!empty($author_firstname))
			{
				$return_html.= '<a href="'.$author_url.'">'.__( 'By', OF_DOMAIN ).' '.$author_firstname.'</a>&nbsp;/&nbsp;';
			}
			$return_html.= date( 'F j Y', strtotime($post->post_date));
			
			$return_html.= '</div></div><br class="clear"/></div>';
			$return_html.= '</div>';
			
			if($current_page_template != 'page_sidebar.php' && $count%3==0)
			{
				$return_html.= '<br class="clear"/>';
			}
			
			if($current_page_template == 'page_sidebar.php' && $count%2==0)
			{
				$return_html.= '<br class="clear"/>';
			}
			
			$count++;
			
			if($current_page_template == 'page_sidebar.php')
			{
		    	$return_html.= '</div>';
		    }
		}
		
		$return_html.= '</div>';
		$return_html.= '</div>';
	}
	else
	{
		$return_html.= 'Empty blog post Please make sure you have created it.';
	}

	$return_html.= '</div>';

	return $return_html;

}

add_shortcode('ppb_columns_blog', 'ppb_columns_blog_func');


function ppb_filter_blog_func($atts, $content) {

	remove_filter('the_content', 'pp_formatter', 99);

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'title' => '',
		'description' => '',
		'items' => 3,
		'category' => '',
	), $atts));
	
	if(!is_numeric($items))
	{
		$items = 1;
	}
	
	//Get current page template
	if(!empty($template))
	{
		$current_page_template = $template;
	}
	else
	{
		$current_page_template = basename(get_page_template());
	}
	
	$category = urldecode($category);
	$category_arr = json_decode($category);

	$return_html = '';
	$return_html.= '<div class="'.$size.' ppb_column">';

	if(!empty($category))
	{	
		$return_html.= '<div class="standard_wrapper">';
		
		//Generate unique ID
		$wrapper_id = 'ppb_filter_blog_'.uniqid();
		
		if(!empty($title))
		{
			$return_html.= '<div class="ppb_header ';
			
			if($current_page_template != 'page_sidebar.php')
			{
				$return_html.= 'fullwidth';
			}
			
			$return_html.= '"><h5 class="header_line ';
			
			if($current_page_template != 'page_sidebar.php')
			{
				$return_html.= 'post_fullwidth';
			}
			
			$return_html.= '">'.$title.'</h5>';
			
			if(!empty($description))
			{
				$return_html.= '<div class="ppb_desc">'.urldecode($description).'</div>';
			}
	
			//Display filterable
			$return_html.= '<ul class="cat_filter">';
			
			$return_html.= '<li><a href="javascript:;" data-wrapper="'.$wrapper_id.'" data-category="0" data-template="'.$current_page_template.'" data-items="'.$items.'" class="selected">'.__( 'All', OF_DOMAIN ).'</li>';
			foreach($category_arr as $category_each)
			{
				$return_html.= '<li><a href="javascript:;"  data-wrapper="'.$wrapper_id.'" data-category="'.$category_each.'" data-template="'.$current_page_template.'" data-items="'.$items.'">'.get_cat_name($category_each).'</a></li>';
			}
			
			$return_html.= '</ul>';
			
			$return_html.= '</div>';
		}
		
		$return_html.= '<div id="'.$wrapper_id.'">';
		
		//Get recent posts
		$args = array(
		    'numberposts' => $items,
		    'order' => 'DESC',
		    'orderby' => 'date',
		    'post_type' => array('post'),
		);
	
		$posts_arr = get_posts($args);
		
		$count = 1;
		foreach($posts_arr as $key => $post)
		{
			$image_thumb = '';
			$return_html.= '<div class="ppb_column_post ppb_column entry_post animated'.$count.' ';
			
			if($current_page_template != 'page_sidebar.php')
			{
				$return_html.= 'masonry ';
			}
			
			if($current_page_template == 'page_sidebar.php')
			{
				if($count%2==0)
				{ 
					$return_html.= 'last'; 
				}
			}
			else
			{
				if($count%3==0)
				{ 
					$return_html.= 'last'; 
				}
			}
			
			$return_html.= '" style="position:relative">';
			
			if(comments_open($post->ID))
			{
			    $return_html.= '<div class="post_comment_count fixed"><a href="'.get_permalink($post->ID).'" title="'.$post->post_title.'">'.get_comments_number($post->ID).' ';
			    if(get_comments_number($post->ID) <= 1)
			    {
			    	$return_html.= __( 'Comment', OF_DOMAIN );
			    }
			    else
			    {
			    	$return_html.= __( 'Comments', OF_DOMAIN );
			    }
			    $return_html.= '</a></div>';
			}
			
			if(has_post_thumbnail($post->ID, 'blog_half_ft'))
			{
			    $image_id = get_post_thumbnail_id($post->ID);
			    $image_thumb = wp_get_attachment_image_src($image_id, 'blog_half_ft', true);
			}
			
			$return_html.= '<div class="post_wrapper full ppb_columns ';
			
			if($current_page_template != 'page_sidebar.php')
			{
				$return_html.= 'masonry ';
			}
			
			if($current_page_template == 'page_sidebar.php')
			{
				if($count%2==0)
				{ 
					$return_html.= 'last'; 
				}
			}
			else
			{
				if($count%3==0)
				{ 
					$return_html.= 'last'; 
				}
			}

			$return_html.= '">';
			
			if($current_page_template == 'page_sidebar.php')
			{
		    	$return_html.= '<div class="post_inner_wrapper half">';
		    }
		    
		    if(isset($image_thumb[0]) && !empty($image_thumb))
			{
				$return_html.= '<div class="post_img ';
				
				if($current_page_template == 'page_sidebar.php')
				{
					$return_html.= 'ppb_column_sidebar';
				}
				else
				{
					$return_html.= 'ppb_column_fullwidth';
				}
				
				$return_html.= ' " style="width:'.$image_thumb[1].'px;height:'.$image_thumb[2].'px">';
				
				$return_html.= '<a href="'.get_permalink($post->ID).'" title="'.$post->post_title.'">';
				$return_html.= '<img src="'.$image_thumb[0].'" alt="" class="post_ft"/></a>';
				
				//Get post type
		        $post_ft_type = get_post_meta($post->ID, 'post_ft_type', true);
				
				//Get Post review score
				//$post_review_score = get_review_score($post->ID);
				$post_review_score = 0;
				$post_percentage_score = $post_review_score*10;
				
				if(!empty($post_review_score))
				{
					$return_html.= '<div class="review_score_bg two_cols"><div class="review_point" style="width:'.$post_percentage_score.'%">'.$post_percentage_score.'%</div></div>';
				}
				
				$return_html.= '</div>';
			}

		    $return_html.= '<div class="post_inner_wrapper half header">';
		    $return_html.= '<div class="post_header_wrapper half">';
		    $return_html.= '<div class="post_header half">';
		    $return_html.= '<h4><a href="'.get_permalink($post->ID).'" title="'.$post->post_title.'">'.$post->post_title.'</a></h4>';
		    $return_html.= '</div></div>';
			$return_html.= '<p>'.pp_substr(strip_tags(strip_shortcodes($post->post_content)), 100).'</p>';
			$return_html.= '<div class="post_detail grey space">';
			
			$author_firstname = get_the_author_meta('first_name', $post->post_author);
			$author_url = get_author_posts_url($post->post_author);
			
			if(!empty($author_firstname))
			{
				$return_html.= '<a href="'.$author_url.'">'.__( 'By', OF_DOMAIN ).' '.$author_firstname.'</a>&nbsp;/&nbsp;';
			}
			$return_html.= date( 'F j Y', strtotime($post->post_date));
			
			$return_html.= '</div></div><br class="clear"/></div>';
			$return_html.= '</div>';
			
			if($current_page_template != 'page_sidebar.php' && $count%3==0)
			{
				$return_html.= '<br class="clear"/>';
			}
			
			if($current_page_template == 'page_sidebar.php' && $count%2==0)
			{
				$return_html.= '<br class="clear"/>';
			}
			
			$count++;
			
			if($current_page_template == 'page_sidebar.php')
			{
		    	$return_html.= '</div>';
		    }
		}
		
		$return_html.= '</div>';
		$return_html.= '</div>';
	}
	else
	{
		$return_html.= 'Empty blog post Please make sure you have created it.';
	}

	$return_html.= '</div>';

	return $return_html;

}

add_shortcode('ppb_filter_blog', 'ppb_filter_blog_func');


function ppb_parallax_bg_func($atts, $content) {

	remove_filter('the_content', 'pp_formatter', 99);

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'title' => '',
		'height' => '300',
		'description' => '',
		'background' => '',
		'link_text' => '',
		'link_url' => '',
	), $atts));
	
	if(!is_numeric($height))
	{
		$height = 300;
	}
	
	$return_html = '';
	$return_html.= '<div class="'.$size.' ppb_parallax_bg" ';
	
	if(!empty($background))
	{
		$return_html.= 'style="background-image: url('.$background.');background-attachment: fixed;background-position: left top;background-repeat: no-repeat;background-size: cover;height:'.$height.'px;" data-type="background" data-speed="10"';
	}
	
	$return_html.= '>';
	
	if(!empty($title))
	{
		$return_html.= '<div style="position:relative;width:100%;height:100%">';
		
		if(!empty($link_url))
		{
			$return_html.= '<a href="'.$link_url.'">';
		}
		
		$return_html.= '<div class="post_title">';
		
		if(!empty($title))
		{
			$return_html.= '<h3>'.$title.'</h3>';
		}
		
		if(!empty($description))
		{
			$return_html.= '<div class="post_excerpt"><div class="content">'.urldecode($description).'</div></div>';
		}
		
		if(!empty($link_text))
		{
			$return_html.= '<div class="read_full"><a href="'.$link_url.'">'.urldecode($link_text).'</a></div>';
		}
		
		if(!empty($link_url))
		{
			$return_html.= '</a>';
		}
		
		$return_html.= '</div>';
		$return_html.= '</div>';
	}

	$return_html.= '</div>';

	return $return_html;

}

add_shortcode('ppb_parallax_bg', 'ppb_parallax_bg_func');


function ppb_video_bg_func($atts, $content) {

	remove_filter('the_content', 'pp_formatter', 99);

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'title' => '',
		'height' => '300',
		'description' => '',
		'video_url' => '',
		'link_text' => '',
		'link_url' => '',
		'preview_img' => '',
	), $atts));
	
	if(!is_numeric($height))
	{
		$height = 300;
	}
	
	$return_html = '';
	$return_html.= '<div class="'.$size.' ppb_video_bg" style="position:relative;height:'.$height.'px;" >';
	
	if(!empty($title))
	{
		if(!empty($link_url))
		{
			$return_html.= '<a href="'.$link_url.'">';
		}
		$return_html.= '<div class="post_title">';
		
		if(!empty($title))
		{
			$return_html.= '<h3>'.$title.'</h3>';
		}
		
		if(!empty($description))
		{
			$return_html.= '<div class="post_excerpt"><div class="content">'.urldecode($description).'</div></div>';
		}
		
		if(!empty($link_text))
		{
			$return_html.= '<div class="read_full"><a href="'.$link_url.'">'.urldecode($link_text).'</a></div>';
		}
		
		$return_html.= '</div>';
		
		if(!empty($link_url))
		{
			$return_html.= '</a>';
		}
	}
	
	$return_html.= '<div style="position:relative;width:100%;height:100%;overflow:hidden">';
	
	if(!empty($video_url))
	{
		//Generate unique ID
		$wrapper_id = 'ppb_video_'.uniqid();
		$return_html.= '<video  ';
		
		if(!empty($preview_img))
		{
			$return_html.= 'poster="'.$preview_img.'" ';
		}
		$return_html.= 'src="'.$video_url.'" loop="true" autoplay="true" muted="muted"/>';
		
		wp_enqueue_script("script-ppb-video-bg".$wrapper_id, get_stylesheet_directory_uri()."/templates/script-ppb-video-bg.php?video_id=".$wrapper_id."&height=".$height, false, '', true);
	}

	$return_html.= '</div>';

	$return_html.= '</div>';

	return $return_html;

}

add_shortcode('ppb_video_bg', 'ppb_video_bg_func');


function ppb_transparent_video_bg_func($atts, $content) {

	remove_filter('the_content', 'pp_formatter', 99);

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'title' => '',
		'height' => '300',
		'description' => '',
		'video_url' => '',
		'link_text' => '',
		'link_url' => '',
		'preview_img' => '',
	), $atts));
	
	if(!is_numeric($height))
	{
		$height = 300;
	}
	
	$return_html = '';
	$return_html.= '<div class="'.$size.' ppb_transparent_video_bg" style="position:relative;height:'.$height.'px;" >';
	$return_html.= '<div class="ppb_video_bg_mask"></div>';
	
	if(!empty($title))
	{
		$return_html.= '<div class="post_title entry_post">';
		
		if(!empty($title))
		{
			$return_html.= '<h3>'.$title.'</h3>';
		}
		
		if(!empty($description))
		{
			$return_html.= '<div class="post_excerpt"><div class="content">'.urldecode($description).'</div></div>';
		}
		
		if(!empty($link_text))
		{
			$return_html.= '<div class="read_full"><a class="button" href="'.$link_url.'">'.urldecode($link_text).'</a></div>';
		}
		
		$return_html.= '</div>';
	}
	
	$return_html.= '<div style="position:relative;width:100%;height:100%;overflow:hidden">';
	
	if(!empty($video_url))
	{
		//Generate unique ID
		$wrapper_id = 'ppb_video_'.uniqid();
		$return_html.= '<video  ';
		
		if(!empty($preview_img))
		{
			$return_html.= 'poster="'.$preview_img.'" ';
		}
		$return_html.= 'src="'.$video_url.'" loop="true" autoplay="true" muted="muted"/>';
		
		wp_enqueue_script("script-ppb-video-bg".$wrapper_id, get_stylesheet_directory_uri()."/templates/script-ppb-video-bg.php?video_id=".$wrapper_id."&height=".$height, false, '', true);
	}

	$return_html.= '</div>';

	$return_html.= '</div>';

	return $return_html;

}

add_shortcode('ppb_transparent_video_bg', 'ppb_transparent_video_bg_func');