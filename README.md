# WDS React Post Search
## Power up the basic WordPress search with React

This plugin taps into the WP REST API and uses React to power a real-time search of posts.

### Want to search more than just posts?

We've got you covered! By default, the plugin will search only `posts`. However, you can use a filter like this to provide access to multiple post types. Your posts types must have `show_in_rest` set to `true` when registering your post type.

```
function _s_filter_post_types_to_query() {
    return array(
        'post_type_slug',
        'page',
    );
}
add_filter( 'wds_react_post_search_filter_post_types', '_s_filter_post_types_to_query' );
```

### Want to filter the search messages?
By default, we're displaying text like `Loading...` when results are loading, `No results found.` when no results are found, and `Please enter at least 3 characters.` when attempting to search with too few characters. These can all be filtered from your theme!

```
function _s_filter_search_loading_text() {
    return esc_html( 'Give us a second – results are loading!', '_s' );
}
add_filter( 'wds_react_post_search_loading_text', '_s_filter_search_loading_text' );
```

```
function _s_filter_search_no_results_text() {
    return esc_html( 'There are no results here, buddy.', '_s' );
}
add_filter( 'wds_react_post_search_no_results_text', '_s_filter_search_no_results_text' );
```

```
function _s_filter_search_length_error_text() {
    return esc_html( 'You need more characters!', '_s' );
}
add_filter( 'wds_react_post_search_length_error_text', '_s_filter_search_length_error_text' );
```

### How does it work?

This taps into the `search-form` class to display results when you begin typing in any search input. If your search form is using a different class name, you will need to update `/assets/js/public.js` with the necessary class.

![](https://dl.dropbox.com/s/8ahiplrbr8cghfh/react-post-search-clearing-fixed.gif?dl=0)
