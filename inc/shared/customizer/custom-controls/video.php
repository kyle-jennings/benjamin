<?php

if ( ! class_exists( 'WP_Customize_Control' ) )
    return null;


class Benjamin_Video_Control extends WP_Customize_Control
{

    public $type = 'video';
    public $mime_type = 'video';
    public $button_labels = array();


    public function __construct( $manager, $id, $args = array() ) {
        parent::__construct( $manager, $id, $args );

        $this->button_labels = wp_parse_args( $this->button_labels, array(
            'select'       => __( 'Select File', 'benjamin' ),
            'change'       => __( 'Change File', 'benjamin' ),
            'default'      => __( 'Default', 'benjamin' ),
            'remove'       => __( 'Remove', 'benjamin' ),
            'placeholder'  => __( 'No file selected', 'benjamin' ),
            'frame_title'  => __( 'Select File', 'benjamin' ),
            'frame_button' => __( 'Choose File', 'benjamin' ),
        ) );

    }

    /**
     * Enqueue control related scripts/styles.
     *
     * @since 3.4.0
     * @since 4.2.0 Moved from WP_Customize_Upload_Control.
     */
    public function enqueue() {
        wp_enqueue_media();
    }

    public function to_json() {

        parent::to_json();
        $this->json['label'] = html_entity_decode( $this->label, ENT_QUOTES, get_bloginfo( 'charset' ) );
        $this->json['mime_type'] = $this->mime_type;
        $this->json['button_labels'] = $this->button_labels;
        $this->json['canUpload'] = current_user_can( 'upload_files' );
        $this->json['control_name'] = $this->id;
        $this->json['setting_name'] = $this->setting->id;
        $this->json['value'] = $this->value();
        $this->json['localURL'] = $this->is_local_file();
        $this->json['video_type'] = $this->get_type();

        $this->json['video_markup'] = benjamin_get_the_video_markup( $this->value() );
        // if the settings attr is not an object, we do nothing
        if ( !is_object( $this->setting ) )
            return;


    }

    private function is_local_file() {

        // if the file a local file?
        $val = str_replace(array('http://', 'https://'), '', $this->value() );
        $home = str_replace(array('http://', 'https://'), '', home_url() );
        if( strpos( $val, $home ) !== false){
            return true;
        }

        return false;
    }


    private function get_type() {
        $url = $this->value();

        $type = null;
        if('.mp4' == substr( $url, -4 ) ){
            $type = 'mp4';
        } elseif( '.mov' == substr( $url, -4 ) ) {
            $type = 'mov';
        } elseif('.webm' == substr( $url, -5 )) {
            $type = 'webm';
        } elseif ( preg_match( '#^https?://(?:www\.)?(?:youtube\.com/watch|youtu\.be/)#', $url ) ) {
            $type = 'youtube';
        }

        return $type;
    }


    private function url_field() {

        ?>
        <span class="use-url"> - or use URL -</span>
        <input class="js--video-url"
            id="{{ data.control_name }}"
            name="{{ data.control_name }}"
            data-customize-setting-link = "{{ data.setting_name }}"
            data-is-customizer = "yes"
            type="url" value="{{ data.value }}"
        >
        <?php
    }

    public function render_content() {}

    public function content_template() {
    ?>
        <label for="{{ data.settings['default'] }}-button">
            <# if ( data.label ) { #>
                <span class="customize-control-title">{{ data.label }}</span>
            <# } #>
            <# if ( data.description ) { #>
                <span class="description customize-control-description">{{{ data.description }}}</span>
            <# } #>
        </label>
        <div class="js--media-wrapper" data-field-name="{{ data.control_name }}">

            <# if ( data.value ) { #>
                <div class="attachment-media-view">

                    <div class='js--placeholder'>
                        {{{ data.video_markup }}}
                    </div>


                    <div class="actions">
                        <# if ( data.canUpload ) { #>

                        <a class="button js--media-library" data-filter="video" id="{{ data.settings['default'] }}-button">
                            {{ data.button_labels.change }}
                        </a>

                        <a class="button js--clear-video">
                            <span class="dashicons dashicons-no-alt"></span>
                            {{ data.button_labels.remove }}
                        </a>

                        <?php $this->url_field(); ?>
                        <div style="clear:both"></div>
                        <# } #>
                    </div>
                </div>
            <# } else { #>
                <div class="attachment-media-view">
                    <div class="placeholder">{{ data.button_labels.placeholder }}</div>
                    <div class="actions">
                        <# if ( data.defaultAttachment ) { #>

                            <a class="button js--media-library" data-filter="video"
                                id="{{ data.settings['default'] }}-button">
                                <span class="dashicons dashicons-video-alt3"></span>
                                {{ data.button_labels['default'] }}
                            </a>
                            <?php $this->url_field(); ?>
                        <# } #>
                        <# if ( data.canUpload ) { #>

                        <a class="button js--media-library" data-filter="video"
                            id="{{ data.settings['default'] }}-button">
                            <span class="dashicons dashicons-video-alt3"></span>
                            {{ data.button_labels.select }}
                        </a>

                        <a class="button js--clear-video">
                            <span class="dashicons dashicons-no-alt"></span>
                            {{ data.button_labels.remove }}
                        </a>
                        <?php $this->url_field(); ?>
                        <# } #>

                        <div style="clear:both"></div>
                    </div>
                </div>
            <# } #>
        </div>
        <?php
    }
}
