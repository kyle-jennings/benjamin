<?php

    $width = (isset($_SERVER['REQUEST_SCHEME']) && $_SERVER['REQUEST_SCHEME'] == 'https') ? 'usa-width-one-half' : 'usa-width-one-whole';
    $favicon = get_template_directory_uri() . '/assets/img/favicons/favicon-57.png';
    $dot_gov_icon = get_template_directory_uri() . '/assets/img/icon-dot-gov.svg';
    $ssl_icon = get_template_directory_uri() . '/assets/img/icon-https.svg';
?>
<!-- Gov banner BEGIN -->
<div class="usa-banner">

    <div class="usa-accordion">
        <header class="usa-banner-header">
            <div class="usa-grid usa-banner-inner">
                <img src="<?php echo esc_url($favicon); ?>" alt="U.S. flag">
                <p>An official website of the United States government</p>
                <button class="usa-accordion-button usa-banner-button"
                aria-expanded="false" aria-controls="gov-banner">
                    <span class="usa-banner-button-text">Here's how you know</span>
                </button>
            </div>
        </header>  <!-- end accordion header -->

        <div class="usa-banner-content usa-grid usa-accordion-content" id="gov-banner">
            <div class="usa-banner-guidance-gov <?php echo esc_attr($width); ?>">
                <img class="usa-banner-icon usa-media_block-img"
                src="<?php echo esc_url($dot_gov_icon)?>"
                alt="Dot gov">
                <div class="usa-media_block-body">
                    <p>
                        <strong>The .gov means it's official.</strong>
                        <br>
                        Federal government websites always use a .gov or .mil domain.
                        Before sharing sensitive information online, make sure
                        you're on a .gov or .mil site by inspecting your browser's
                        address (or "location") bar.
                    </p>
                </div>
            </div>  <!-- end accordion first half-->

            <?php if(isset($_SERVER['REQUEST_SCHEME']) && $_SERVER['REQUEST_SCHEME'] == 'https'): ?>
            <div class="usa-banner-guidance-ssl usa-width-one-half">
                <img class="usa-banner-icon usa-media_block-img"
                src="<?php echo esc_url($ssl_icon); ?>" alt="SSL">
                <div class="usa-media_block-body">
                    <p>This site is also protected by an SSL (Secure Sockets Layer)
                        certificate that's been signed by the U.S. government.
                        The <strong>https://</strong> means all transmitted data
                        is encrypted - in other words, any information or
                        browsing history that you provide is transmitted securely.</p>
                </div>
            </div>  <!-- end accordion content seconf half -->
            <?php endif;?>

        </div> <!-- end accordion content -->

    </div> <!-- end accordion -->
</div>

<!-- Gov banner END -->
