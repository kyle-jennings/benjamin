<?php
function benjamin_widget_sidebar_content() {

    ?>
    <div class="benjamin-widget-area-options">
		<label
			for="benjamin-widget-area-options_visiblity"
			class="cs-tool btn-replaceable"
			data-action="replaceable"
			data-on="<?php _e( 'This sidebar can be replaced on certain pages', 'benjamin' ); ?>"
			data-off="<?php _e( 'This sidebar will always be same on all pages', 'benjamin' ); ?>"
			>
			<span class="icon"></span>
			<input
				type="checkbox"
				id="benjamin-widget-area-options_visiblity"
				class=""
				/>
			<span class="is-label">
				<?php _e( 'Allow this sidebar to be replaced', 'benjamin' ); ?>
			</span>
		</label>
    </div>

    <?php
}
// add_action( 'widgets_admin_page', 'benjamin_widget_sidebar_content' );
