<?php if ( ! defined( 'ABSPATH' ) )  { die('You are not allowed to call this page directly.'); } ?>
<?php
$hsa_pluginversion = get_option('hsa_pluginversion');
if ($hsa_pluginversion <> "7.9")
{
	?>
	<div class="error fade">
		<p><strong>Note: You have recently upgraded the plugin. Please "Deactivate" and "Activate" the plugin. This is mandatory and it will not affect your data.</strong></p>
	</div>
	<?php
}

if(isset($_POST['hsa_socail_submit']))
{
	$hsa_fb_page_url = stripslashes(sanitize_text_field($_POST['hsa_fb_page_url']));
	$hsa_youtube_channel_url = stripslashes(sanitize_text_field($_POST['hsa_youtube_channel_url']));
	$hsa_twitter_url = stripslashes(sanitize_text_field($_POST['hsa_twitter_url']));
	$hsa_googlep_url = stripslashes(sanitize_text_field($_POST['hsa_googlep_url']));
	update_option('hsa_fb_page_url', $hsa_fb_page_url );
	update_option('hsa_youtube_channel_url', $hsa_youtube_channel_url );
	update_option('hsa_twitter_url', $hsa_twitter_url );
	update_option('hsa_googlep_url', $hsa_googlep_url );
	?>
	<div class="updated fade">
		  <p><strong><?php echo __('Options saved Successfully.', 'horizontal-scrolling-announcement'); ?></strong></p>
		</div>
<?php
}

$hsa_fb_page_url = get_option('hsa_fb_page_url');
$hsa_youtube_channel_url = get_option('hsa_youtube_channel_url');
$hsa_twitter_url = get_option('hsa_twitter_url');
$hsa_googlep_url = get_option('hsa_googlep_url');


// Form submitted, check the data
if (isset($_POST['frm_hsa_display']) && $_POST['frm_hsa_display'] == 'yes')
{
	$did = isset($_GET['did']) ? intval($_GET['did']) : '0';
	if(!is_numeric($did)) { die('<p>Are you sure you want to do this?</p>'); }
	
	$hsa_success = '';
	$hsa_success_msg = FALSE;
	
	// First check if ID exist with requested ID
	$sSql = $wpdb->prepare(
		"SELECT COUNT(*) AS `count` FROM ".WP_HSA_TABLE."
		WHERE `hsa_id` = %d",
		array($did)
	);
	$result = '0';
	$result = $wpdb->get_var($sSql);
	
	if ($result != '1')
	{
		?>
		<div class="error fade">
		  <p><strong><?php _e('Oops, selected details doesnt exist.', 'horizontal-scrolling-announcement'); ?></strong></p>
		</div>
		<?php
	}
	else
	{
		// Form submitted, check the action
		if (isset($_GET['ac']) && $_GET['ac'] == 'del' && isset($_GET['did']) && $_GET['did'] != '')
		{
			//	Just security thingy that wordpress offers us
			check_admin_referer('hsa_form_show');
			
			//	Delete selected record from the table
			$sSql = $wpdb->prepare("DELETE FROM `".WP_HSA_TABLE."`
					WHERE `hsa_id` = %d
					LIMIT 1", $did);
			$wpdb->query($sSql);
			
			//	Set success message
			$hsa_success_msg = TRUE;
			$hsa_success = __('Selected record was successfully deleted.', 'horizontal-scrolling-announcement');
		}
	}
	
	if ($hsa_success_msg == TRUE)
	{
		?>
		<div class="updated fade">
		  <p><strong><?php echo $hsa_success; ?></strong></p>
		</div>
		<?php
	}
}
?>
<script language="JavaScript" src="<?php echo plugins_url(); ?>/horizontal-scrolling-announcement/pages/setting.js"></script>
<div class="wrap">
  <div id="icon-edit" class="icon32 icon32-posts-post"></div>
	<h2><?php _e(WP_hsa_TITLE, 'horizontal-scrolling-announcement'); ?>
	<a class="add-new-h2" href="<?php echo admin_url(); ?>options-general.php?page=horizontal-scrolling-announcement&amp;ac=add">
		<?php _e('Add New', 'horizontal-scrolling-announcement'); ?>
	</a> 
	</h2>
  <div class="tool-box">
    <?php
		$sSql = "SELECT * FROM `".WP_HSA_TABLE."` where hsa_group!='fixed' order by hsa_id";
		$myData = array();
		$myData = $wpdb->get_results($sSql, ARRAY_A);
	?>
    <form name="frm_hsa_display" method="post">
      <table width="100%" class="widefat" id="straymanage">
        <thead>
          <tr>
            <th width="55%" scope="col"><?php _e('Announcement text', 'horizontal-scrolling-announcement'); ?></th>
            <th scope="col"><?php _e('Order', 'horizontal-scrolling-announcement'); ?></th>
            <th scope="col"><?php _e('Display', 'horizontal-scrolling-announcement'); ?></th>
            <th scope="col"><?php _e('Group', 'horizontal-scrolling-announcement'); ?></th>
            <th scope="col"><?php _e('Start Date', 'horizontal-scrolling-announcement'); ?></th>
			<th scope="col"><?php _e('Expiration', 'horizontal-scrolling-announcement'); ?></th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th scope="col"><?php _e('Announcement text', 'horizontal-scrolling-announcement'); ?></th>
            <th scope="col"><?php _e('Order', 'horizontal-scrolling-announcement'); ?></th>
            <th scope="col"><?php _e('Display', 'horizontal-scrolling-announcement'); ?></th>
            <th scope="col"><?php _e('Group', 'horizontal-scrolling-announcement'); ?></th>
			<th scope="col"><?php _e('Start Date', 'horizontal-scrolling-announcement'); ?></th>
            <th scope="col"><?php _e('Expiration', 'horizontal-scrolling-announcement'); ?></th>
          </tr>
        </tfoot>
        <tbody>
          <?php 
			$i = 0;
			if(count($myData) > 0 )
			{
				foreach ($myData as $data)
				{
				?>
				<tr class="<?php if ($i&1) { echo 'alternate'; } else { echo ''; }?>">
					<td><?php echo stripslashes($data['hsa_text']); ?>
					<div class="row-actions"> <span class="edit"> <a title="Edit" href="<?php echo admin_url(); ?>options-general.php?page=horizontal-scrolling-announcement&amp;ac=edit&amp;did=<?php echo $data['hsa_id']; ?>">
					<?php _e('Edit', 'horizontal-scrolling-announcement'); ?>
					</a> | </span> <span class="trash"> <a onClick="javascript:hsa_delete('<?php echo $data['hsa_id']; ?>')" href="javascript:void(0);">
					<?php _e('Delete', 'horizontal-scrolling-announcement'); ?>
					</a> </span> </div>
					</td>
					<td><?php echo stripslashes($data['hsa_order']); ?></td>
					<td><?php echo stripslashes($data['hsa_status']); ?></td>
					<td><?php echo stripslashes($data['hsa_group']); ?></td>
					<td><?php echo substr($data['hsa_datestart'],0,10); ?></td>
					<td><?php echo substr($data['hsa_dateend'],0,10); ?></td>
				</tr>
				<?php 
				$i = $i+1; 
				} 
			}
			else
			{
				?>
				<tr>
					<td colspan="6" align="center"><?php _e('No records available.', 'horizontal-scrolling-announcement'); ?></td>
				</tr>
				<?php 
			}
			?>
        </tbody>
      </table>
      <?php wp_nonce_field('hsa_form_show'); ?>
      <input type="hidden" name="frm_hsa_display" value="yes"/>
    </form>
    <div class="tablenav bottom">
		<div class="alignleft actions">
			<a href="<?php echo admin_url(); ?>options-general.php?page=horizontal-scrolling-announcement&amp;ac=add"><input class="button action" type="button" value="<?php _e('Add New', 'horizontal-scrolling-announcement'); ?>" /></a> 
			<a href="<?php echo admin_url(); ?>options-general.php?page=horizontal-scrolling-announcement&amp;ac=set"><input class="button action" type="button" value="<?php _e('Default Settings', 'horizontal-scrolling-announcement'); ?>" /></a> 
			<a target="_blank" href="<?php echo WP_hsa_FAV; ?>"><input class="button action" type="button" value="<?php _e('Help', 'horizontal-scrolling-announcement'); ?>" /></a> 
		</div>
    </div>
   	
  </div>
  
</div>


<div class="wrap">
  <div id="icon-edit" class="icon32 icon32-posts-post"></div>
	<h2><?php _e('Fixed Position Announcement', 'horizontal-scrolling-announcement'); ?>
	<a class="add-new-h2" href="<?php echo admin_url(); ?>options-general.php?page=horizontal-scrolling-announcement&amp;ac=add_fixed">
		<?php _e('Add New', 'horizontal-scrolling-announcement'); ?>
	</a> 
	</h2>
  <div class="tool-box">
    <?php
		$sSql = "SELECT * FROM `".WP_HSA_TABLE."` where hsa_group='fixed' order by hsa_id";
		$myData = array();
		$myData = $wpdb->get_results($sSql, ARRAY_A);
	?>

      <table width="100%" class="widefat" id="straymanage">
        <thead>
          <tr>
            <th width="55%" scope="col"><?php _e('Announcement text', 'horizontal-scrolling-announcement'); ?></th>
            <th scope="col"><?php _e('Order', 'horizontal-scrolling-announcement'); ?></th>
			<th scope="col"><?php _e('Home Page Only', 'horizontal-scrolling-announcement'); ?></th>
            <th scope="col"><?php _e('Whole Website', 'horizontal-scrolling-announcement'); ?></th>
            <th scope="col"><?php _e('Start Date', 'horizontal-scrolling-announcement'); ?></th>
			<th scope="col"><?php _e('Expiration', 'horizontal-scrolling-announcement'); ?></th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th scope="col"><?php _e('Announcement text', 'horizontal-scrolling-announcement'); ?></th>
            <th scope="col"><?php _e('Order', 'horizontal-scrolling-announcement'); ?></th>
			<th scope="col"><?php _e('Home Page Only', 'horizontal-scrolling-announcement'); ?></th>
            <th scope="col"><?php _e('Whole Website', 'horizontal-scrolling-announcement'); ?></th>
            <th scope="col"><?php _e('Start Date', 'horizontal-scrolling-announcement'); ?></th>
            <th scope="col"><?php _e('Expiration', 'horizontal-scrolling-announcement'); ?></th>
          </tr>
        </tfoot>
        <tbody>
          <?php 
			$i = 0;
			if(count($myData) > 0 )
			{
				foreach ($myData as $data)
				{
					$hsa_options=unserialize($data['hsa_options']);
					
					
				?>
				<tr class="<?php if ($i&1) { echo 'alternate'; } else { echo ''; }?>">
					<td><?php echo stripslashes($data['hsa_text']); ?>
					<div class="row-actions"> <span class="edit"> <a title="Edit" href="<?php echo admin_url(); ?>options-general.php?page=horizontal-scrolling-announcement&amp;ac=edit_fixed&amp;did=<?php echo $data['hsa_id']; ?>">
					<?php _e('Edit', 'horizontal-scrolling-announcement'); ?>
					</a> | </span> <span class="trash"> <a onClick="javascript:hsa_delete('<?php echo $data['hsa_id']; ?>')" href="javascript:void(0);">
					<?php _e('Delete', 'horizontal-scrolling-announcement'); ?>
					</a> </span> </div>
					</td>
					<td><?php echo stripslashes($data['hsa_order']); ?></td>
					<td><?php echo ($hsa_options['hsa_homepage']=="1")?'Yes':'No'; ?></td>
					<td><?php echo ($hsa_options['hsa_whole_site']=="1")?'Yes':'No'; ?></td>
					<td><?php echo substr($data['hsa_datestart'],0,10); ?></td>
					<td><?php echo substr($data['hsa_dateend'],0,10); ?></td>
				</tr>
				<?php 
				$i = $i+1; 
				} 
			}
			else
			{
				?>
				<tr>
					<td colspan="6" align="center"><?php _e('No records available.', 'horizontal-scrolling-announcement'); ?></td>
				</tr>
				<?php 
			}
			?>
        </tbody>
      </table>
      <?php wp_nonce_field('hsa_form_show'); ?>
    
    <div class="tablenav bottom">
		<div class="alignleft actions">
			<a href="<?php echo admin_url(); ?>options-general.php?page=horizontal-scrolling-announcement&amp;ac=add_fixed"><input class="button action" type="button" value="<?php _e('Add New', 'horizontal-scrolling-announcement'); ?>" /></a> 
		
		</div>
    </div>
   
    <h3><?php _e('Plugin configuration option', 'horizontal-scrolling-announcement'); ?></h3>
    <ol>
      <li><?php _e('Drag and drop the widget to your sidebar.', 'horizontal-scrolling-announcement'); ?></li>
      <li><?php _e('Add the plugin in the posts or pages using short code.', 'horizontal-scrolling-announcement'); ?></li>
      <li><?php _e('Add directly in to the theme using PHP code.', 'horizontal-scrolling-announcement'); ?></li>
    </ol>
    <p class="description"><?php echo WP_hsa_LINK; ?></p>
	
	 <form action="" method="post" name="hsa_socail_form"> 
  <label for="tag-width"><?php _e('Facebook page url:', 'horizontal-scrolling-announcement'); ?></label>
		<input name="hsa_fb_page_url" type="text" value="<?php echo $hsa_fb_page_url; ?>"  id="hsa_fb_page_url" >
	
		
		<label for="tag-width"><?php _e('Youtube channel url:', 'horizontal-scrolling-announcement'); ?></label>
		<input name="hsa_youtube_channel_url" type="text" value="<?php echo $hsa_youtube_channel_url; ?>"  id="hsa_youtube_channel_url" >
	
		
		<label for="tag-width"><?php _e('Twitter:', 'horizontal-scrolling-announcement'); ?></label>
		<input name="hsa_twitter_url" type="text" value="<?php echo $hsa_twitter_url; ?>"  id="hsa_twitter_url" >
	
		
		<label for="tag-width"><?php _e('Google +:', 'horizontal-scrolling-announcement'); ?></label>
		<input name="hsa_googlep_url" type="text" value="<?php echo $hsa_googlep_url; ?>"  id="hsa_googlep_url" >
		
		<input type="submit" name="hsa_socail_submit" />
		
   </form>	
   
  </div>
</div>