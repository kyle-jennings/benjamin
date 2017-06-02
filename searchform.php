<?php
/**
 * The search form for our theme
 *
 * @link https://developer.wordpress.org/reference/functions/get_search_form/
 *
 * @package Benjamin
 */

$uswds_search = uswds_digital_search();

?>
<form role="search" method="get" class="usa-search usa-search-small js-search-form"
    action="<?php echo $uswds_search['action']; ?>">
  <div role="search">
    <label class="usa-sr-only" for="search-field-small">
        <?php echo _x( 'Search for:', 'search lable', 'uswds' ); ?>
    </label>

    <input id="search-field-small" type="search" name="<?php echo $uswds_search['name']; ?>"
    placeholder="<?php echo esc_attr_x( 'Search ...', 'placeholder', 'uswds' ); ?>"
    value="<?php echo get_search_query() ?>" name="s"
    title="<?php echo esc_attr_x( 'Search for:', 'title','uswds' ) ?>" />

    <?php echo $uswds_search['hidden']; ?>

    <button type="submit" value="<?php echo esc_attr_x( 'Search', 'submit button', 'uswds' ); ?>">
      <span class="usa-sr-only">Search</span>
    </button>
  </div>
</form>
