<?php
/**
 * The search form for our theme
 *
 * @link https://developer.wordpress.org/reference/functions/get_search_form/
 *
 * @package Benjamin
 */

?>
<form role="search" method="get" class="usa-search usa-search-small js-search-form" 
    action="<?php echo esc_url(home_url('/')); ?>">
  <div role="search">
    <label class="usa-sr-only" for="search-field-small">
        <?php echo esc_attr_x('Search for:', 'search lable', 'benjamin'); ?>
    </label>
    <input id="search-field-small" type="search" name="s"
    placeholder="<?php echo esc_attr_x('Search ...', 'placeholder', 'benjamin'); ?>"
    value="<?php echo get_search_query() ?>" name="s"
    title="<?php echo esc_attr_x('Search for:', 'title', 'benjamin') ?>" />
    <button type="submit" value="<?php echo esc_attr_x('Search', 'submit button', 'benjamin'); ?>">
        <span class="usa-sr-only">
            <?php echo __('Search', 'benjamin'); // WPCS: xss ok. ?>    
        </span>
    </button>
  </div>
</form>
