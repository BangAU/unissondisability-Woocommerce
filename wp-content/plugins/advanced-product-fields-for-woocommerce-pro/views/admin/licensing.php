<?php
 /** @var array $model */
$nonce = 'deactivate-pro';
?>
<div class="mabel-wapf-license">
    <table class="form-table">
        <tr valign="top">
            <th scope="row" class="titledesc">
                <label for="wapf_license"><?php _e('Plugin license key','sw-wapf'); ?></label>
            </th>
            <td class="forminp">
                <input type="hidden" name="_wapfnonce" value="<?php echo wp_create_nonce($nonce); ?>">
                <input class="input-text regular-input"
                       type="text"
                       name="wapf_license"
                       id="wapf_license"
                       value="<?php echo $model['has_license'] ? '***************' : ''; ?>" />
                    <button name="wapf_license_activate" class="button-secondary" type="submit" value="wapf"><?php _e('Deactivate','sw-wapf'); ?></button>
            </td>
        </tr>
    </table>
</div>