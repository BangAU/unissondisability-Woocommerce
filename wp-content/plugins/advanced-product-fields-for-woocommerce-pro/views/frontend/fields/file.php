<?php
use \SW_WAPF_PRO\Includes\Classes\File_Upload;

if(File_Upload::can_upload()) {
    if ( File_Upload::is_ajax_upload() ) {
        $field_id = esc_attr($model['field']->id);
        $nonce =  wp_create_nonce('wapf_fupload');
        ?>
        <div class="dzone" id="wapf-dz-<?php echo $field_id;?>">
            <div class="dz-message" data-dz-message>
                    <?php _e('Drag files here or <span>browse</span>','sw-wapf'); ?>
            </div>
        </div>
        <div class="wapf-dz-error wapf-dz-error-<?php echo $field_id;?>"></div>
        <input type="hidden" <?php echo $model['field_attributes']; ?> name="wapf[field_<?php echo $field_id;?>]" />
        <script>
            jQuery(function($) {
                var ajaxUrl = wapf_config.ajax;
                Dropzone.autoDiscover = false;

                window.initWapfFileUpload = window.initWapfFileUpload || [];
                if(!window.initWapfFileUpload['<?php echo $field_id; ?>'])
                    window.initWapfFileUpload['<?php echo $field_id; ?>'] = function(fieldId) {
                        var uploaded = {};
                        var toVal = function() {
                            var tmpArr = [];
                            Object.keys(uploaded).forEach(function(k){ tmpArr.push(uploaded[k]['path']); });
                            $('[name="wapf[field_'+fieldId+']"]').val(tmpArr.join(',')).trigger('change');
                        };
                        $('#wapf-dz-'+fieldId+' .wapf-dz-btn').on('click',function(e){e.preventDefault();});
                        if($('#wapf-dz-'+fieldId)[0].dropzone)
                            return;
                        $('#wapf-dz-'+fieldId).dropzone({
                            url: ajaxUrl,
		                    <?php if(!empty($model['raw_field_attributes']['accept'])) echo "acceptedFiles: " . esc_attr($model['raw_field_attributes']['accept']) . ","; ?>
                            maxFiles: <?php echo isset($model['field']->options['multiple']) && $model['field']->options['multiple'] ? 99 : 1 ?>,
                            maxFilesize: <?php echo intval($model['field']->get_option('maxsize',1)); ?>,
                            thumbnailWidth: 100,
                            thumbnailHeight: 100,
                            paramName: 'wapf[field_'+fieldId+']',
                            uploadMultiple:  true,
                            parallelUploads: 1,
                            dictFileTooBig: "<?php _e('File is too big ({{filesize}}MB). Max filesize is {{maxFilesize}}MB.','sw-wapf');?>",
                            dictInvalidFileType: "<?php _e("You can't upload files of this type.",'sw-wapf');?>",
                            dictMaxFilesExceeded: "<?php _e("You can't upload any more files.",'sw-wapf');?>",
                            previewTemplate: '<div class="dz-preview"><div class="dz-filename" data-dz-name></div><div class="dz-left"><div class="dz-progress-wrapper"><div class="dz-progress"></div><div class="dz-upload" data-dz-uploadprogress></div></div><div class="dz-remove" data-dz-remove>&times;</div></div>',
                            params: function() {
                                return {
                                    action : 'wapf_upload',
                                    nonce: '<?php echo $nonce; ?>',
                                    field_groups: $('[name=wapf_field_groups]').val()
                                };
                            },
                            init: function() {
                                this.on('sending', function() {
                                    $('form.cart .single_add_to_cart_button').prop('disabled',true);
                                });
                                this.on('complete', function() {
                                    $('form.cart .single_add_to_cart_button').prop('disabled',false);
                                });
                                this.on('success', function(file, response) {
                                    uploaded[file.upload.uuid] = response.data[0];
                                    $(document).trigger('wapf/file_uploaded',[response.data,file,fieldId]);
                                    toVal();
                                });
                                this.on('error', function( file, msg ) {
                                    var $wrapper = $('.wapf-dz-error-'+fieldId);
                                    var error = ( typeof msg === 'string' ? msg : (!msg.success && msg.data ? msg.data : '') );
                                    if(error) {
                                        this.removeFile(file);
                                        var $e = $('<div>'+error+'</div>').prependTo($wrapper);
                                        setTimeout( function(){$e.hide('fast',function(){$e.remove()}); }, 9000);
                                    }
                                });
                                this.on('removedfile', function( file ) {
                                    if(uploaded[file.upload.uuid]) {
                                        $.getJSON(wapf_config.ajax + '?action=wapf_upload_remove&nonce=<?php echo $nonce; ?>&file=' + decodeURIComponent(uploaded[file.upload.uuid].path));
                                        delete uploaded[file.upload.uuid];
                                        $(document).trigger('wapf/uploaded_file_deleted',[uploaded[file.upload.uuid],file,fieldId]);
                                        toVal();
                                    }
                                });
                            }
                        });
                    };
                    window.initWapfFileUpload['<?php echo $field_id; ?>']('<?php echo $field_id; ?>');
                    $(document).on('wapf/cloned', function(e,fieldId,idx,$clone){
                        var isSection = $('[for='+fieldId+']').hasClass('wapf-section');
                        if(!isSection && fieldId !== '<?php echo $field_id;?>') return;
                        var $f = $clone.find((isSection ? '[for=<?php echo $field_id;?>] ' : '')+'input');
                        $f.val('');
                        var newId = '<?php echo $field_id;?>_clone_' + idx;
                        $clone.find('.dzone').attr('id','wapf-dz-'+newId).children().not('.dz-message').html('');
                        $clone.find('.wapf-dz-error').removeClass('wapf-dz-error-'+fieldId).addClass('wapf-dz-error-'+newId);
                        window.initWapfFileUpload['<?php echo $field_id;?>'](newId);
                    });

            });
        </script>
        <?php
    } else {
        echo '<input type="file" ' . $model['field_attributes'] . ' />';
    }
}
else {
    echo esc_html(get_option('wapf_settings_upload_msg'));
}