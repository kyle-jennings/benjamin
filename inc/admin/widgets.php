<?php
function uswds_widget_sidebar_content() {

    ?>
    <div class="uswds-widget-area-options">
		<label
			for="uswds-widget-area-options_visiblity"
			class="cs-tool btn-replaceable"
			data-action="replaceable"
			data-on="<?php _e( 'This sidebar can be replaced on certain pages', 'uswds' ); ?>"
			data-off="<?php _e( 'This sidebar will always be same on all pages', 'uswds' ); ?>"
			>
			<span class="icon"></span>
			<input
				type="checkbox"
				id="uswds-widget-area-options_visiblity"
				class=""
				/>
			<span class="is-label">
				<?php _e( 'Allow this sidebar to be replaced', 'uswds' ); ?>
			</span>
		</label>
    </div>

    <?php
}
// add_action( 'widgets_admin_page', 'uswds_widget_sidebar_content' );
