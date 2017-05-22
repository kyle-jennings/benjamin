<?php
/**
 * This is a template part for displaying the footer widgets
 *
 * @link https://developer.wordpress.org/reference/functions/get_template_part/
 * @link https://codex.wordpress.org/Widgetizing_Themes
 *
 * @package Benjamin
 */

$f1Active = is_active_sidebar( 'footer-widget-1' );
$f2Active = is_active_sidebar( 'footer-widget-2' );
$f3Active = is_active_sidebar( 'footer-widget-3' );

if ( !$f1Active && !$f2Active && !$f3Active ) { ?>
  <div class="usa-footer-secondary_section">
    <div class="usa-grid">
      <div class="usa-width-one-third">
        <p>Footer Widget 1</p>
      </div>
      <div class="usa-width-one-third">
        <p>Footer Widget 2</p>
      </div>
      <div class="usa-width-one-third">
        <p>Footer Widget 3</p>
      </div>
    </div>
  </div><!-- .usa-footer-secondary_section -->
<?php } else { ?>
  <div class="usa-footer-secondary_section">
    <?php if ( $f1Active && !$f2Active && !$f3Active ) { ?>
    <div class="usa-grid-full">
      <?php dynamic_sidebar( 'footer-widget-1' ); ?>
    </div>
    <?php } elseif ( $f2Active && !$f1Active && !$f3Active ) { ?>
    <div class="usa-grid-full">
      <?php dynamic_sidebar( 'footer-widget-2' ); ?>
    </div>
    <?php } elseif ( $f3Active && !$f2Active && !$f1Active ) { ?>
    <div class="usa-grid-full">
      <?php dynamic_sidebar( 'footer-widget-3' ); ?>
    </div>
    <?php } elseif ( $f2Active && !$f3Active ) { ?>
    <div class="usa-grid">
      <div class="usa-width-one-half">
        <?php dynamic_sidebar( 'footer-widget-1' ); ?>
      </div>
      <div class="usa-width-one-half">
        <?php dynamic_sidebar( 'footer-widget-2' ); ?>
      </div>
    </div>
    <?php } elseif ( $f3Active && !$f2Active ) { ?>
    <div class="usa-grid">
      <div class="usa-width-one-half">
        <?php dynamic_sidebar( 'footer-widget-1' ); ?>
      </div>
      <div class="usa-width-one-half">
        <?php dynamic_sidebar( 'footer-widget-3' ); ?>
      </div>
    </div>
    <?php } elseif ( $f2Active && $f3Active && !$f1Active ) { ?>
    <div class="usa-grid">
      <div class="usa-width-one-half">
        <?php dynamic_sidebar( 'footer-widget-2' ); ?>
      </div>
      <div class="usa-width-one-half">
        <?php dynamic_sidebar( 'footer-widget-3' ); ?>
      </div>
    </div>
    <?php } elseif ( $f1Active && $f2Active && $f3Active ) { ?>
    <div class="usa-grid">
      <div class="usa-width-one-third">
        <?php dynamic_sidebar( 'footer-widget-1' ); ?>
      </div>
      <div class="usa-width-one-third">
        <?php dynamic_sidebar( 'footer-widget-2' ); ?>
      </div>
      <div class="usa-width-one-third">
        <?php dynamic_sidebar( 'footer-widget-3' ); ?>
      </div>
    </div>
    <?php } ?>
  </div><!-- .usa-footer-secondary_section -->
<?php } ?>
