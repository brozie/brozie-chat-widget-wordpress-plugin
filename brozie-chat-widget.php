<?php
/*
Plugin Name: Brozie Chat Widget
Plugin URI: https://github.com/brozie/brozie-chat-widget-wordpress-plugin/
Author: Brozie
Version: 1.0
Author URI: http://www.brozie.com/
*/

function brozie_chat_widget(){
	
	$width = get_option('brz_chatwidget_width');
	$height = get_option('brz_chatwidget_height');
	$skin = get_option('brz_chatwidget_skin');
	$dir = get_option('brz_chatwidget_dir');
	
	// DEFAULT VALUES
	if(!isset($width)) $width = '270';
	if(!isset($height)) $height = '300';
	if(!isset($skin)) $skin = 'clean';
	if(!isset($dir)) $dir = 'br';
	
	?>
	<script>
		(function(d,w,o,s,t){
			s=d.createElement("script");
			s.src="//cf.broziecdn.com/static/widget/brozie-widget.js";
			s.async=true;
			s.onload=s.onreadystatechange=function(r){
				r=this.readyState;
				if((r==null||(/complete|loaded/).test(r))&&((t=w.brozieWidget)&&(t=t.widgetChat)))t.init(o);
			};
			(d.head||d.body).appendChild(s);
		})(document,window,{
			skin:'<?php echo $skin; ?>',
			width:'<?php echo $width; ?>',
			height:'<?php echo $height; ?>',
			dir:'<?php echo $dir; ?>'
		});
	</script>	
	<?php
}

add_action( 'wp_footer', 'brozie_chat_widget' );

add_action( 'admin_menu', 'brozie_menu' );

function brozie_menu(){
	add_options_page( 'Brozie Chat Widget Preferences', 'Brozie Chat Widget', 'manage_options', 'brozieChatWidget', 'brozie_settings' );
}

function brozie_settings(){
	
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	
	if(isset($_POST["action"]) && $_POST["action"] == "update") {
	
		update_option( 'brz_chatwidget_width', $_POST['brz_chatwidget_width']);
		update_option( 'brz_chatwidget_height', $_POST['brz_chatwidget_height']);
		update_option( 'brz_chatwidget_skin', $_POST['brz_chatwidget_skin']);
		update_option( 'brz_chatwidget_dir', $_POST['brz_chatwidget_dir']);
	
		?>
		<div class="updated"><p><?php _e('Settings saved. <strong><a href="' . get_site_url() . '">Visit your site</a></strong> to check your new widget settings.', 'menu-general' ); ?></p></div>
		<?php
	}

	$skin=get_option('brz_chatwidget_skin');
	$dir=get_option('brz_chatwidget_dir');

	?>
    <div class="wrap">
	    <h2><?php echo __('Brozie Chat Widget Preferences', 'menu-general'); ?></h2>
	
		<form name="form1" method="post" action="">
			<input type="hidden" name="action" value="update">
			
			<table style="margin-left:20px">
				<tr>
					<td style="width:160px">Width:</td>
					<td>
						<input name="<?php echo 'brz_chatwidget_width'; ?>" style="width:200px" type="text" value="<?php echo get_option('brz_chatwidget_width'); ?>" />
					</td>
				</tr>
				<tr>
					<td style="width:160px">Height:</td>
					<td>
						<input name="<?php echo 'brz_chatwidget_height'; ?>" style="width:200px" type="text" value="<?php echo get_option('brz_chatwidget_height'); ?>" />
					</td>
				</tr>
				<tr>
					<td style="width:160px">Skin:</td>
					<td>
						<select name="<?php echo 'brz_chatwidget_skin'; ?>" style="width:200px">
							<option <?php if ($skin === 'dark') echo 'selected="selected"' ?> value="dark">dark</option>
							<option <?php if ($skin === 'light') echo 'selected="selected"' ?> value="light">light</option>
							<option <?php if ($skin === 'clean') echo 'selected="selected"' ?> value="clean">clean</option>
						</select>
					</td>
				</tr>
				<tr>
					<td style="width:160px">Direction:</td>
					<td>
						<select name="<?php echo 'brz_chatwidget_dir'; ?>" style="width:200px">
							<option <?php if ($dir === 'tl') echo 'selected="selected"' ?> value="tl">top left</option>
							<option <?php if ($dir === 'tr') echo 'selected="selected"' ?> value="tr">top right</option>
							<option <?php if ($dir === 'bl') echo 'selected="selected"' ?> value="bl">bottom left</option>
							<option <?php if ($dir === 'br') echo 'selected="selected"' ?> value="br">bottom right</option>
						</select>
					</td>
				</tr>
			</table>
			
			<br /><hr />
			
			<p class="submit">
				<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
			</p>
		
		</form>	
	
	</div>
	<?php
}
?>