<?php
add_action('admin_menu', 'gochat_config_page');

function gochat_config_page() {
	if (function_exists('add_submenu_page')) {
		add_submenu_page('plugins.php', __('GoChat Configuration'), __('GoChat Configuration'), 'manage_options', 'gochat-configuration', 'gochat_conf');
    }
}

function gochat_conf() {
    $options = array(
        'gochat_enable_video' => 'Enable video chatting.',
        'gochat_enable_admin' => 'Enable Gochat in the admin site',
    );
    if (count($_POST) > 0) {
        foreach ($options as $name => $label) {
            update_option($name, isset($_POST[$name]) ? 'true' : 'false');
        }
    }
?>
<?php if ( !empty($_POST['submit'] ) ) : ?>
<div id="message" class="updated fade"><p><strong><?php _e('Options saved.') ?></strong></p></div>
<?php endif ;?>
<div class="wrap">
    <h2><?php _e('GoChat Configuration'); ?></h2>
    <div class="narrow">
    <form action="" method="post" id="gochatconf" style="margin: auto; width: 400px; ">
        <?php foreach ($options as $name => $label): ?>
            <p><label><input name="<?php echo $name?>" value="true" type="checkbox" <?php if (gochat_get($name)) echo ' checked="checked" '; ?> />
                <?php _e($label); ?>
            </label></p>
        <?php endforeach; ?>
	    <p class="submit"><input type="submit" name="submit" value="<?php _e('Update options &raquo;'); ?>" /></p>
    </form>
    </div>
</div>

<?php
}
