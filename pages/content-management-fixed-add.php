<?php if ( ! defined( 'ABSPATH' ) )  { die('You are not allowed to call this page directly.'); } ?>
<div class="wrap">
<?php
$hsa_errors = array();
$hsa_success = '';
$hsa_error_found = FALSE;

// Preset the form fields
$form = array(
  'hsa_id' => '',
  'hsa_text' => '',
  'hsa_order' => '',
  'hsa_status' => '',
  'hsa_link' => '',
  'hsa_group' => '',
  'hsa_dateend' => '',
  'hsa_datestart' => '',
  'hsa_target' => ''
);

// Form submitted, check the data
if (isset($_POST['hsa_form_submit']) && $_POST['hsa_form_submit'] == 'yes')
{
  //  Just security thingy that wordpress offers us
  check_admin_referer('hsa_form_add');
  
  $form['hsa_text'] = isset($_POST['hsa_text']) ? wp_filter_post_kses($_POST['hsa_text']) : '';
  if ($form['hsa_text'] == '')
  {
    $hsa_errors[] = __('Please enter the text.', 'horizontal-scrolling-announcement');
    $hsa_error_found = TRUE;
  }

  $form['hsa_order'] = '1';
  
  $form['hsa_status'] = isset($_POST['hsa_status']) ? sanitize_text_field($_POST['hsa_status']) : 'NO';
  
  
  $form['hsa_link'] = isset($_POST['hsa_link']) ? esc_url_raw($_POST['hsa_link']) : '';
  
  $form['hsa_group'] = 'fixed';
  
  $hsa_options=array(
            'hsa_custom_css'=>isset($_POST['hsa_custom_css']) ? sanitize_text_field($_POST['hsa_custom_css']) : '',
            'hsa_show_only_mobile'=>isset($_POST['hsa_show_only_mobile']) ? sanitize_text_field($_POST['hsa_show_only_mobile']) : 0,
            'hsa_hide_only_mobile'=>isset($_POST['hsa_hide_only_mobile']) ? sanitize_text_field($_POST['hsa_hide_only_mobile']) : 0,
            'hsa_show_only_google'=>isset($_POST['hsa_show_only_google']) ? sanitize_text_field($_POST['hsa_show_only_google']) : 0,
            'hsa_show_socail_icons'=>isset($_POST['hsa_show_socail_icons']) ? sanitize_text_field($_POST['hsa_show_socail_icons']) : 0,
            'hsa_align_socail_icons'=>isset($_POST['hsa_align_socail_icons']) ? sanitize_text_field($_POST['hsa_align_socail_icons']) : '',
            'hsa_call_action_text'=>isset($_POST['hsa_call_action_text']) ? sanitize_text_field($_POST['hsa_call_action_text']) : '',
            'hsa_call_action_link'=>isset($_POST['hsa_call_action_link']) ? sanitize_text_field($_POST['hsa_call_action_link']) : '',
            'hsa_call_action_position'=>isset($_POST['hsa_call_action_position']) ? sanitize_text_field($_POST['hsa_call_action_position']) : '',
            'hsa_posts_ids'=>isset($_POST['hsa_posts_ids']) ? sanitize_text_field($_POST['hsa_posts_ids']) : '',
            'hsa_text_alignment'=>isset($_POST['hsa_text_alignment']) ? sanitize_text_field($_POST['hsa_text_alignment']) : '',
            'hsa_fixed_position'=>isset($_POST['hsa_fixed_position']) ? sanitize_text_field($_POST['hsa_fixed_position']) : '',
			'hsa_position'=>isset($_POST['hsa_position']) ? sanitize_text_field($_POST['hsa_position']) : '',			
            'hsa_text_color'=>isset($_POST['hsa_text_color']) ? sanitize_text_field($_POST['hsa_text_color']) : '',
            'hsa_back_color'=>isset($_POST['hsa_back_color']) ? sanitize_text_field($_POST['hsa_back_color']) : '',
			'hsa_textbold'=>isset($_POST['hsa_textbold']) ? sanitize_text_field($_POST['hsa_textbold']) : '',
			'hsa_font_size'=>isset($_POST['hsa_font_size']) ? sanitize_text_field($_POST['hsa_font_size']) : '',			
            'hsa_append_class'=>isset($_POST['hsa_append_class']) ? sanitize_text_field($_POST['hsa_append_class']) : '',
			'hsa_homepage'=>isset($_POST['hsa_homepage']) ? sanitize_text_field($_POST['hsa_homepage']) : '',
			'hsa_whole_site'=>isset($_POST['hsa_whole_site']) ? sanitize_text_field($_POST['hsa_whole_site']) : '',
			'hsa_button_color'=>isset($_POST['hsa_button_color']) ? sanitize_text_field($_POST['hsa_button_color']) : '',
			'hsa_button_text_color'=>isset($_POST['hsa_button_text_color']) ? sanitize_text_field($_POST['hsa_button_text_color']) : '',
			'hsa_author_css'=>isset($_POST['hsa_author_css']) ? sanitize_text_field($_POST['hsa_author_css']) : ''
			
			
			
			
  );





  
  $form['hsa_options']=serialize($hsa_options);
  
  $form['hsa_dateend'] = isset($_POST['hsa_dateend']) ? sanitize_text_field($_POST['hsa_dateend']) : '0000-00-00';
  if (!preg_match("/\d{4}\-\d{2}-\d{2}/", $form['hsa_dateend'])) 
  {
    $hsa_errors[] = __('Please enter announcement display start date in this format YYYY-MM-DD.', 'horizontal-scrolling-announcement');
    $hsa_error_found = TRUE;
  }
  
  $form['hsa_datestart'] = isset($_POST['hsa_datestart']) ? sanitize_text_field($_POST['hsa_datestart']) : '0000-00-00';
  if (!preg_match("/\d{4}\-\d{2}-\d{2}/", $form['hsa_datestart'])) 
  {
    $hsa_errors[] = __('Please enter the expiration date in this format YYYY-MM-DD.', 'horizontal-scrolling-announcement');
    $hsa_error_found = TRUE;
  }
  
  $form['hsa_target'] = isset($_POST['hsa_target']) ? sanitize_text_field($_POST['hsa_target']) : '_self';

  //  No errors found, we can add this Group to the table
  if ($hsa_error_found == FALSE)
  {
  
    $sSql = $wpdb->prepare(
      "INSERT INTO `".WP_HSA_TABLE."`
      (`hsa_text`, `hsa_order`, `hsa_status`, `hsa_link`, `hsa_group`, `hsa_dateend`, `hsa_datestart`, `hsa_target`, `hsa_options`)
      VALUES(%s, %s, %s, %s, %s, %s, %s, %s,%s)",
      array($form['hsa_text'], $form['hsa_order'], $form['hsa_status'], $form['hsa_link'], $form['hsa_group'], 
      $form['hsa_dateend'], $form['hsa_datestart'], $form['hsa_target'],$form['hsa_options'])
    );
    
    
    
    $wpdb->query($sSql);
    $hsa_success = __('New details was successfully added.', 'horizontal-scrolling-announcement');
    
    // Reset the form fields
    $form = array(
      'hsa_id' => '',
      'hsa_text' => '',
      'hsa_order' => '',
      'hsa_status' => '',
      'hsa_link' => '',
      'hsa_group' => '',
      'hsa_dateend' => '',
      'hsa_datestart' => '',
      'hsa_target' => ''
    );
  }
}

if ($hsa_error_found == TRUE && isset($hsa_errors[0]) == TRUE)
{
  ?>
  <div class="error fade">
    <p><strong><?php echo $hsa_errors[0]; ?></strong></p>
  </div>
  <?php
}
if ($hsa_error_found == FALSE && strlen($hsa_success) > 0)
{
  ?>
  <div class="updated fade">
    <p><strong><?php echo $hsa_success; ?> 
    <a href="<?php echo admin_url(); ?>options-general.php?page=horizontal-scrolling-announcement">Click here</a> to view the details</strong></p>
  </div>
  <?php
}

wp_enqueue_style( 'wp-color-picker' ); 
wp_enqueue_script( 'wp-color-picker');
wp_enqueue_script( 'postbox' );
wp_enqueue_style('hsa_fixed_css_handler',plugins_url('style.css',__FILE__));
wp_enqueue_script('hsa_fixed_js_handler',plugins_url('custom_script.js',__FILE__));

?>


<div class="form-wrap">
  <div id="icon-edit" class="icon32 icon32-posts-post"><br></div>
  <h2><?php _e(WP_hsa_TITLE, 'horizontal-scrolling-announcement'); ?></h2>
  <form name="form_hsa" method="post" action="#" onsubmit="return hsa_submit()"  >
    <h3><?php _e('Add details', 'horizontal-scrolling-announcement'); ?></h3>
   
 
<div class="wrap">
    <div id="poststuff">
        <div id="postbox-container" class="postbox-container">
            <div class="meta-box-sortables ui-sortable" id="normal-sortables"> 

<div class="postbox " id="test1">
<div title="Click to toggle" class="handlediv"><br></div><h3 class="hndle"><span>Main Announcement</span></h3>			

<div class="inside">			
<div class="col-8 form-group row option_container enabled">
    <div class="option_section selected_item">
    
     <label for="tag-title"><?php _e('Enter the announcement', 'horizontal-scrolling-announcement'); ?></label>
    <textarea name="hsa_text" cols="80" rows="6" id="hsa_text" class="hsa_input"></textarea>
    <p><?php _e('Please enter your announcement text.', 'horizontal-scrolling-announcement'); ?></p>
   
  </div>
</div>	

<div class="col-8 form-group row option_container enabled">
    <div class="option_section selected_item">
    
    
    <label class="tag-title"><?php _e('Text alignment', 'horizontal-scrolling-announcement'); ?></label>
	
    <select name="hsa_text_alignment" class="hsa_dropdown">
     <option value=''>Select</option>
      <option value="left">Left</option>    
      <option value="right">Right</option>
      <option value="center" selected>Center</option>
	  <option value="justify">Justify</option>
    </select>
    <p><?php _e('Select Text Alignment for this announcement'); ?></p>
    
  </div>
</div></div></div>


<div class="postbox closed" id="test1">
<div title="Click to toggle" class="handlediv"><br></div><h3 class="hndle"><span>Link to Announcement Text </span></h3>			

<div class="inside">	

<div class="col-8 form-group row option_container enabled">
    <div class="option_section selected_item">
    
     <label for="tag-title"><?php _e('Enter target link', 'horizontal-scrolling-announcement'); ?></label>
   <input name="hsa_link" type="text" id="hsa_link" size="82" value="" maxlength="1024" class="hsa_input"/>
    <p><?php _e('When someone clicks on the announcement, where do you want to send them. URL must start with either http or https.', 'horizontal-scrolling-announcement'); ?></p>
   
  </div>
</div>		

	
<div class="col-8 form-group row option_container enabled">
    <div class="option_section selected_item">
    
    
    <label class="tag-title"><?php _e('Select target option', 'horizontal-scrolling-announcement'); ?></label>
    <select name="hsa_target" class="hsa_dropdown">
       <option value='_self'>Open in same window</option>
      <option value='_blank'>Open in new window</option>
    </select>
    <p><?php _e('Do you want to open link in new window?', 'horizontal-scrolling-announcement'); ?></p>
    
  </div>
</div>
</div></div>

<div class="postbox" id="test1">
<div title="Click to toggle" class="handlediv"><br></div><h3 class="hndle"><span>Announcement Color Settings</span></h3>	
<div class="inside">		
<div class="col-8 form-group row option_container enabled">
    <div class="option_section selected_item"  style="display: inline-flex;">
    
    
			   
			   
    <label class="tag-title"><?php _e('Text Color', 'horizontal-scrolling-announcement'); ?>
	<p style=" font-weight: 100; "><?php _e('Select text color for this announcement'); ?></p></label>
	
     <input name="hsa_text_color" type="text" id="hsa_text_color" class="hsa_input" value="#ffffff"/>
   
    
  </div>
</div>		

<div class="col-8 form-group row option_container enabled">
    <div class="option_section selected_item" style="display: inline-flex;">
    
    
    <label class="tag-title"><?php _e('Background Color', 'horizontal-scrolling-announcement'); ?>
	<p style=" font-weight: 100; "><?php _e('Select background color for this announcement'); ?></p></label>
	
	
     <input name="hsa_back_color" type="text" id="hsa_back_color" class="hsa_input" value="#e8562a" />
		

    
  </div>
</div>

<div class="col-8 form-group row option_container enabled">
    <div class="option_section selected_item">
    
    
    <label class="tag-title"><?php _e('Font-Size [px]', 'horizontal-scrolling-announcement'); ?></label>
	
     <input name="hsa_font_size" type="text" id="hsa_font_size" class="hsa_input" value="16" />
    <p><?php _e('Select background color for this announcement | default value: 16'); ?></p>
    
  </div>
</div>

	
	
	
<div class="col-8 form-group row option_container enabled">
    <div class="option_section selected_item" id="option_section_enable_upgrade_admin_notice">

        <label class="forcheckbox">
 <span class="summary"><?php _e('Do you want to make the text Bold?', 'horizontal-scrolling-announcement'); ?></span>

			
            <span class="hsa-switch" style=" margin-left: 140px; ">
                    <input type="checkbox" name="hsa_textbold" id="hsa_textbold" checked value='YES'>
                    <span class="hsa-slider round"></span>
            </span>
           
        </label>
		
		  <p><?php _e('Default: Recommanded'); ?></p>

        <p class="help-block">.</p>
        <div style="clear:both"></div>
    </div>
</div>

	
	

</div></div>

				
<div class="postbox" id="test1">
<div title="Click to toggle" class="handlediv"><br></div><h3 class="hndle"><span>Call to Action Button</span></h3>	
<div class="inside">			
<div class="col-8 form-group row option_container enabled">
    <div class="option_section selected_item">
    
    
    <label class="tag-title"><?php _e('Call to action button text', 'horizontal-scrolling-announcement'); ?></label>
	
     <input name="hsa_call_action_text" type="text" id="hsa_call_action_text" class="hsa_input" />
    <p><?php _e('Enter the call to action text'); ?></p>
    
  </div>
</div>	

<div class="col-8 form-group row option_container enabled">
    <div class="option_section selected_item">
    
    
    <label class="tag-title"><?php _e('Call to action button link', 'horizontal-scrolling-announcement'); ?></label>
	
     <input name="hsa_call_action_link" type="text" id="hsa_call_action_link" class="hsa_input" />
    <p><?php _e('Enter the link for call to action button | start with http:// or https://'); ?></p>
    
  </div>
</div>	

<div class="col-8 form-group row option_container enabled">
    <div class="option_section selected_item">
    
    
    <label class="tag-title"><?php _e('Button position', 'horizontal-scrolling-announcement'); ?></label>
	
    <select name="hsa_call_action_position" class="hsa_dropdown">
      
      <option value="before">Before Text</option>   
	  <option value="after" selected>After Text</option>
      
    </select>
    <p><?php _e('Select alignment for your Button  Positions.'); ?></p>
    
  </div>
</div>	


<div class="col-8 form-group row option_container enabled">
    <div class="option_section selected_item" style="display: inline-flex;">
    
    
    <label class="tag-title"><?php _e('Button color', 'horizontal-scrolling-announcement'); ?>
	<p style=" font-weight: 100; "><?php _e('Select Button Color.'); ?></p> </label>
	
		
	<input type="text" name="hsa_button_color" class="hsa_input" id="hsa_button_color" value="Crimson"/>

		
   
    
  </div>
</div>	


<div class="col-8 form-group row option_container enabled">
    <div class="option_section selected_item" style="display: inline-flex;">
    
    
    <label class="tag-title"><?php _e('Button text color', 'horizontal-scrolling-announcement'); ?>
	<p style=" font-weight: 100; "><?php _e('Select Text color inside button.'); ?></p> </label>
	
	<input type="text" name="hsa_button_text_color" class="hsa_input" id="hsa_button_text_color" value="#ffffff"/>
    
  </div>
</div></div></div>	


<div class="postbox closed" id="test1">
<div title="Click to toggle" class="handlediv"><br></div><h3 class="hndle"><span>Position </span></h3>	
<div class="inside">		

<div class="col-8 form-group row option_container enabled">
    <div class="option_section selected_item">
    
    
    <label class="tag-title"><?php _e('Position style', 'horizontal-scrolling-announcement'); ?></label>
	
    <select name="hsa_position" class="hsa_dropdown">
    <option value='fixed' selected>Fixed</option>
      <option value="absolute">Absolute</option>    
   
    </select>
    <p><?php _e('Select position for this announcement.'); ?></p>
    
  </div>
</div>	


<div class="col-8 form-group row option_container enabled">
    <div class="option_section selected_item">
    
    
    <label class="tag-title"><?php _e('Location', 'horizontal-scrolling-announcement'); ?></label>
	
    <select name="hsa_fixed_position" class="hsa_dropdown">
      <option value="top" selected>Top</option>    
      <option value="bottom">Bottom</option>
    </select>
    <p><?php _e('Select fixed position for this announcement.'); ?></p>
    
  </div>
</div></div></div>	

<div class="postbox closed" id="test1">
<div title="Click to toggle" class="handlediv"><br></div><h3 class="hndle"><span>Social Media Icons</span></h3>	
<div class="inside">		
<div class="col-8 form-group row option_container enabled">
    <div class="option_section selected_item">
    
    
    <label class="tag-title"><?php _e('Align social media icons', 'horizontal-scrolling-announcement'); ?></label>
    <select name="hsa_align_socail_icons" class="hsa_dropdown">
      <option value=''>Select</option>
      <option value="left">Left</option>    
      <option value="right">Right</option>
    </select>
    <p><?php _e('Select alignment for your social icons.'); ?></p>
    
  </div></div>
  
  <div class="col-8 form-group row option_container enabled">
    <div class="option_section selected_item" id="option_section_enable_upgrade_admin_notice">

        <label class="forcheckbox">

            <span class="hsa-switch">
                    <input type="checkbox" name="hsa_show_socail_icons" id="hsa_show_socail_icons" value="1">
                    <span class="hsa-slider round"></span>
            </span>
            <span class="summary"><?php _e('Show Social Media Icons', 'horizontal-scrolling-announcement'); ?></span>

        </label>

        <p class="help-block">Check this option if you want to show show socail icons for this announcement.</p>
      
    </div>
</div>
  
</div></div>
	
<div class="postbox" id="test1">
<div title="Click to toggle" class="handlediv"><br></div><h3 class="hndle"><span>Announcement Location Settings</span></h3>	
<div class="inside">			

<div class="col-8 form-group row option_container enabled">
    <div class="option_section selected_item" id="option_section_enable_upgrade_admin_notice">

        <label class="forcheckbox">

            <span class="hsa-switch">
                    <input type="checkbox" name="hsa_status" id="hsa_status" checked value='YES'>
                    <span class="hsa-slider round"></span>
            </span>
            <span class="summary"><?php _e('Do you want to show this announcement?', 'horizontal-scrolling-announcement'); ?></span>

        </label>

      <p class="help-block">Disabling this will remove this announcement from all Pages. | Default: Enabled</p>
        <div style="clear:both"></div>
    </div>
</div>

<div class="col-8 form-group row option_container enabled">
    <div class="option_section selected_item" id="option_section_enable_upgrade_admin_notice">

        <label class="forcheckbox">

            <span class="hsa-switch">
                    <input type="checkbox" name="hsa_homepage" id="hsa_status"  value='1'>
                    <span class="hsa-slider round"></span>
            </span>
            <span class="summary"><?php _e('Do you want to show only homepage?', 'horizontal-scrolling-announcement'); ?></span>

        </label>

      <p class="help-block">Selecting any below options will override this feature.</p>
        <div style="clear:both"></div>
    </div>
</div>

<div class="col-8 form-group row option_container enabled">
    <div class="option_section selected_item" id="option_section_enable_upgrade_admin_notice">

        <label class="forcheckbox">

            <span class="hsa-switch">
                    <input type="checkbox" name="hsa_whole_site" id="hsa_whole_site"  value='1' checked>
                    <span class="hsa-slider round"></span>
            </span>
            <span class="summary"><?php _e('Do you want to show on whole website?', 'horizontal-scrolling-announcement'); ?></span>

        </label>

        <p class="help-block">.</p>
        <div style="clear:both"></div>
    </div>
</div>	


<div class="col-8 form-group row option_container enabled">
    <div class="option_section selected_item">
    
    
    <label class="tag-title"><?php _e('On Specific Page/Post Ids', 'horizontal-scrolling-announcement'); ?></label>
	
     <input name="hsa_posts_ids" type="text" id="hsa_posts_ids" class="hsa_input" />
    <p><?php _e('Enter the page or posts IDs [comma seprated] This announcement will be displayed in all those specified IDs.'); ?></p>
    
  </div>
</div>	
</div></div>


<div class="postbox closed" id="test1">
<div title="Click to toggle" class="handlediv"><br></div><h3 class="hndle"><span>Device Settings</span></h3>	
<div class="inside">		


<div class="col-8 form-group row option_container enabled">
    <div class="option_section selected_item" id="option_section_enable_upgrade_admin_notice">

        <label class="forcheckbox">

            <span class="hsa-switch">
                    <input type="checkbox" name="hsa_show_only_mobile" id="hsa_show_only_mobile" value="1">
                    <span class="hsa-slider round"></span>
            </span>
            <span class="summary"><?php _e('Show only on mobile devices', 'horizontal-scrolling-announcement'); ?></span>

        </label>

        <p class="help-block">Check this option if you want to show this announcement only on mobile devices.</p>
        <div style="clear:both"></div>
    </div>
</div>
    
    
    <div class="col-8 form-group row option_container enabled">
    <div class="option_section selected_item" id="option_section_enable_upgrade_admin_notice">

        <label class="forcheckbox">

            <span class="hsa-switch">
                    <input type="checkbox" name="hsa_hide_only_mobile" id="hsa_hide_only_mobile" value="1">
                    <span class="hsa-slider round"></span>
            </span>
            <span class="summary"><?php _e('Hide only on mobile devices', 'horizontal-scrolling-announcement'); ?></span>

        </label>

        <p class="help-block">Check this option if you want to hide this announcement on mobile & tablets.</p>
      
    </div>
</div>
    

    
<div class="col-8 form-group row option_container enabled">
    <div class="option_section selected_item" id="option_section_enable_upgrade_admin_notice">

        <label class="forcheckbox">

            <span class="hsa-switch">
                    <input type="checkbox" name="hsa_show_only_google" id="hsa_show_only_google" value="1">
                    <span class="hsa-slider round"></span>
            </span>
            <span class="summary"><?php _e('Show only for Visitors from Google', 'horizontal-scrolling-announcement'); ?></span>

        </label>

        <p class="help-block">Check this option if you want to show this announcement only for visitors from Google.</p>
      
    </div>
</div>
    
    
    



</div></div>


<div class="postbox" id="test1">
<div title="Click to toggle" class="handlediv"><br></div><h3 class="hndle"><span>Announcement Period</span></h3>	
<div class="inside">		

<div class="col-8 form-group row option_container enabled">
    <div class="option_section selected_item">
    
    
    <label class="tag-title"><?php _e('Start date', 'horizontal-scrolling-announcement'); ?></label>
	
	<input name="hsa_datestart" type="text" id="hsa_datestart" value="2016-01-01" maxlength="10" class="hsa_input"/>
    <p><?php _e('Please enter announcement display start date in this format YYYY-MM-DD <br /> 0000-00-00 : Is equal to no start date.', 'horizontal-scrolling-announcement'); ?></p>

    
  </div>
</div>	

<div class="col-8 form-group row option_container enabled">
    <div class="option_section selected_item">
    
    
    <label class="tag-title"><?php _e('Expiration date', 'horizontal-scrolling-announcement'); ?></label>
	 <input name="hsa_dateend" type="text" id="hsa_dateend" value="9999-12-31" maxlength="10" class="hsa_input"/>
    <p><?php _e('Please enter the expiration date in this format YYYY-MM-DD <br /> 9999-12-31 : Is equal to no expire.', 'horizontal-scrolling-announcement'); ?></p>
    
  </div>
</div></div></div>	

<div class="postbox closed" id="test1">
<div title="Click to toggle" class="handlediv"><br></div><h3 class="hndle"><span>Custom CSS</span></h3>	
<div class="inside">		
<div class="col-8 form-group row option_container enabled">
    <div class="option_section selected_item">
    
    
    <label class="tag-title"><?php _e('Append Class', 'horizontal-scrolling-announcement'); ?></label>
	
     <input name="hsa_append_class" type="text" id="hsa_append_class" class="hsa_input" />
    <p><?php _e('Select background color for this announcement'); ?></p>
    
  </div>
</div>		


    
<div class="col-8 form-group row option_container enabled">
    <div class="option_section selected_item">
    
     <label for="tag-title"><?php _e('Custom CSS', 'horizontal-scrolling-announcement'); ?></label>
    <textarea name="hsa_custom_css" cols="80" rows="3" id="hsa_custom_css" class="hsa_input"></textarea>
    <p><?php _e('Add custom css for this announcement.', 'horizontal-scrolling-announcement'); ?></p>
   
  </div>
</div>

<div class="col-8 form-group row option_container enabled">
    <div class="option_section selected_item" id="option_section_enable_upgrade_admin_notice">

        <label class="forcheckbox">
 <span class="summary"><?php _e('Do you want to add author css?', 'horizontal-scrolling-announcement'); ?></span>

			
            <span class="hsa-switch" style=" margin-left: 140px; ">
                    <input type="checkbox" name="hsa_author_css" id="hsa_author_css"  value='1'>
                    <span class="hsa-slider round"></span>
            </span>
           
        </label>
		
		  <p><?php _e('Trying this option "ON" will allow you to use "Community Designed" Announcement bar styles.'); ?></p>

        <p class="help-block">.</p>
        <div style="clear:both"></div>
    </div>
</div>

</div></div>		

      
    <input name="hsa_id" id="hsa_id" type="hidden" value="">
    <input type="hidden" name="hsa_form_submit" value="yes"/>
    <p class="submit">
      <input name="publish" lang="publish" class="button" value="Submit" type="submit" />&nbsp;
      <input name="publish" lang="publish" class="button" onclick="hsa_redirect()" value="Cancel" type="button" />&nbsp;
      <input name="Help" lang="publish" class="button" onclick="hsa_help()" value="<?php _e('Help', 'horizontal-scrolling-announcement'); ?>" type="button" />
    </p>
    <?php wp_nonce_field('hsa_form_add'); ?>
    </form>
	<div id="hsa_preview" class="fixed-announcement" style="display:block;z-index:9999;width:100%;padding: 0.5em;left:0px;"></div>
	 </div>
        </div>
    </div>
</div>
</div>
<p class="description"><?php echo WP_hsa_LINK; ?></p>
</div>