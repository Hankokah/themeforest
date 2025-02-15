<div class="vp-field vp-textarea" data-vp-type="vp-textarea">
    <div class="label">
        <label>
			<?php esc_html_e( 'Import', 'crazyblog' ) ?>
        </label>
        <div class="description">
            <p><?php esc_html_e( 'Import Options', 'crazyblog' ) ?></p>
        </div>
    </div>
    <div class="field">
        <div class="input">
            <textarea id="vp-js-import_text"></textarea>
            <div class="buttons">
                <input id="vp-js-import" class="vp-button button" type="button" value="<?php esc_html_e( 'Import', 'crazyblog' ) ?>" />
                <span style="margin-left: 10px;">
                    <span id="vp-js-import-loader" class="vp-field-loader" style="display: none;"><img src="<?php VP_Util_Res::img_out( 'ajax-loader.gif', '' ); ?>" style="vertical-align: middle;"></span>
                    <span id="vp-js-import-status" style="display: none;"></span>
                </span>
            </div>
        </div>
    </div>
</div>

<div class="vp-field vp-textarea" data-vp-type="vp-textarea">
    <div class="label">
        <label>
			<?php esc_html_e( 'Export', 'crazyblog' ) ?>
        </label>
        <div class="description">
            <p><?php esc_html_e( 'Export Options', 'crazyblog' ) ?></p>
        </div>
    </div>
    <div class="field">
        <div class="input">
            <textarea id="vp-js-export_text" onclick="this.focus();
                    this.select()" readonly="readonly"></textarea>
            <div class="buttons">
                <input id="vp-js-export" class="vp-button button" type="button" value="<?php esc_html_e( 'Export', 'crazyblog' ) ?>" />
                <span style="margin-left: 10px;">
                    <span id="vp-js-export-loader" class="vp-field-loader" style="display: none;"><img src="<?php VP_Util_Res::img_out( 'ajax-loader.gif', '' ); ?>" style="vertical-align: middle;"></span>
                    <span id="vp-js-export-status" style="display: none;"></span>
                </span>
            </div>
        </div>
    </div>
</div>