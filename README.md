# WDS React Post Search

Power up the basic WordPress search with React. This plugin taps into the WP REST API and uses React to power a real-time search of posts.

<a href="https://webdevstudios.com/contact/"><img src="https://webdevstudios.com/wp-content/uploads/2018/04/wds-github-banner.png" alt="WebDevStudios. WordPress for big brands."></a>

## How does it work?

This taps into the `search-form` class (or whatever class you filter to above) to display results when you begin typing in any search input matching that same class.

![](https://dl.dropbox.com/s/8ahiplrbr8cghfh/react-post-search-clearing-fixed.gif?dl=0)

## Options

### Search more than just posts

By default, the plugin will search only `posts`. However, you can use a filter like this to provide access to multiple post types. Your posts types must have `show_in_rest` set to `true` when registering your post type.

```php
function _s_filter_post_types_to_query() {
    return array(
        'post_type_slug',
        'page',
    );
}
add_filter( 'wds_react_post_search_filter_post_types', '_s_filter_post_types_to_query' );
```

### Filter the search messages
By default, we're displaying text like `Loading...` when results are loading, `No results found.` when no results are found, and `Please enter at least 3 characters.` when attempting to search with too few characters. These can all be filtered from your theme!

```php
function _s_filter_search_loading_text() {
    return esc_html( 'Give us a second – results are loading!', '_s' );
}
add_filter( 'wds_react_post_search_loading_text', '_s_filter_search_loading_text' );
```

```php
function _s_filter_search_no_results_text() {
    return esc_html( 'There are no results here, buddy.', '_s' );
}
add_filter( 'wds_react_post_search_no_results_text', '_s_filter_search_no_results_text' );
```

```php
function _s_filter_search_length_error_text() {
    return esc_html( 'You need more characters!', '_s' );
}
add_filter( 'wds_react_post_search_length_error_text', '_s_filter_search_length_error_text' );
```

### Change the minimum character limit?
There's a filter for that too. If you want the search to start working as soon as you start typing, just set your value to `0` or `1`. Otherwise, you can set this to whatever number you wish. Remember, this is character count and not letter count – spaces count!

```php
function _s_filter_search_minimum_character_count() {
	return 0;
}
add_filter( 'wds_react_post_search_minimum_character_count', '_s_filter_search_minimum_character_count' );
```

### Does your search form use a different class? No problem!
By default, the plugin will target `search-form` as is set in the `localize_script` call:
```
'search_form_class' => apply_filters( 'wds_react_post_search_search_form_class', esc_attr( 'search-form' ) )
```

However, this can also be filtered if your search form uses another class or you want to target a specific instance of a form on a page:
```
function _s_filter_search_search_form_class() {
	return esc_attr( 'some-other-class' );
}
add_filter( 'wds_react_post_search_search_form_class', '_s_filter_search_search_form_class' );
```

## Development

Clone this repo
```bash
git clone git@github.com:WebDevStudios/WDS-React-Post-Search.git
```

Change directories
```bash
cd WDS-React-Post-Search
```

Install NPM modules
```bash
npm i
```

Kick off development server
```bash
npm run start
```

Build production ready assets
```bash
npm run build
```

## Note

WordPress wont recognize any plugins whose folder is Camel-Case. You'll need to rename this folder to: `wds-react-post-search`

