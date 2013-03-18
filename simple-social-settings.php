<div class="wrap">
<h2><?php __('Simple Social', 'simple-social'); ?></h2>

<form method="post" action="options.php">
    <?php
        settings_fields( 'simple-social-settings-group' );
    ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row"><?php _e('Facebook App ID', 'simple-social');?></th>
        <td>
            <input type="text" name="simple-social-fb_app_id" value="<?php echo get_option('simple-social-fb_app_id'); ?>" />          
        </tr>
         
        <tr valign="top">
        <th scope="row"><?php _e('Twitter name', 'simple-social');?></th>
        <td><input type="text" name="simple-social-twitter_name" value="<?php echo get_option('simple-social-twitter_name'); ?>" /></td>
        </tr>
        
    </table>
    
    <p class="submit">
    <input type="submit" class="button-primary" value="<?php _e('Save Changes', 'simple-social') ?>" />
    </p>

</form>
</div>