# Hide Updates

This plugin hides update notifications for core, plugin, and theme updates in the WordPress admin. It's useful for developers and agencies who manage updates through Composer or remote management services like ManageWP, and therefore wants to hide update notices for other users.

## Features

* Hides Wordpress core update notices.
* Hides plugin update notices.
* Hides theme update notices.
* Hides updates link in admin menu and admin bar.
* Blocks access to the updates page for users who are not allowed to see updates.
* Enables developers to specify which users can see updates.

## Worth noting

This plugin is intended for developers and agencies who have good reasons for hiding the updates, for example if they manage updates through Composer or remote management services like ManageWP. This plugin has been tested with ManageWP and ManageWP needs to connect to the site with a user account that is allowed to see updates.

## Specify who can see updates

By default, the plugin allows the first registered user (the one who installed the site) to see updates. Developers can use the `hide_updates_allowed_users` filter to specify which users are allowed to see update notifications.

The following example will allow only users with usernames bill and melinda to see updates:

```
function site_hide_updates_allowed_users() {
    $allowed_users = array( 'bill', 'melinda' );
    return $allowed_users;
}
add_filter( 'hide_updates_allowed_users', 'site_hide_updates_allowed_users' );
``` 

## Manual installation

1. Upload the `hide-updates` directory to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.

## Frequently Asked Questions

### Who is this plugin for?

This plugin is aimed for developers and agencies who manage core, plugin, and translation updates through Composer or remote management services like ManageWP.

### Why would you want to hide updates?

If you're a developer or agency responsible for updating client sites, you may want to hide updates for other users who should not install updates.

### Can I choose to hide only some types of updates?

No. All updates will be hidden.

## Changelog

### 1.1.6

* Release date: 2020-
* Simplify return statement in allow_current_user(). Thanks Vincent Klaiber (@vinkla) for the help!
* Minor refactoring and coding standards overhaul.

### 1.1.5

* Release date: 2019-12-18
* Minor refactoring and coding standards overhaul.
* Align Github and WordPress.org version release numbers.

### 1.1.4

* Release date: 2019-05-28
* Check if user is logged in before enqueuing plugin CSS. Thanks Vincent Klaiber (@vinkla) for the help!

### 1.1.3

* Release date: 2018-10-28
* Avoid error if default user with ID 1 doesn't exist.

### 1.1.2

* Release date: 2018-10-21
* Add first registered user (usually the one who installed the site) as default user allowed to see updates.
* Add more precise CSS selector for hiding plugin updates in admin menu to avoid breaking other plugins using the .update-plugins class on other notifications.

### 1.1.1

* Release date: 2018-10-21
* Remove include of wp-includes/pluggable.php to be able to use wp_get_current_user(). Unnecessary to include file.

### 1.1

* Release date: 2018-10-21
* Add filter to define users allowed to see updates.
* Hide update notifications using CSS to enable usage of remote management services like ManageWP and others. Previous solution used pre_site_transient_update_* filters and nulled all values making it impossible for remote management services to read updates.

### 1.0

* Initial release.