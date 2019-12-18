# Hide Updates

This plugin hides update notifications for WordPress core, plugin, and theme updates in WordPress admin for all users except first registered user (the one who installed the site) or specified users (see example below). It's useful for developers and agencies who take care of updates and maintenance of their clients sites and wants to hide the notices for other users.

* Hides Wordpress core update notices.
* Hides plugin update notices.
* Hides theme update notices.
* Hides Updates link in admin menu and admin bar.
* Blocks users who are not allowed to see updates from accessing the updates page.

___This plugin is intended for developers and agencies who have good reasons for hiding the updates.___

## Specify allowed users

Developers can use the `hide_updates_allowed_users` filter to specify which users are allowed to see update notifications. Add the username of each allowed user to an array like in the following example: 

```
function site_hide_updates_allowed_users() {
    $allowed_users = array( 'charlotte', 'bob' );
    return $allowed_users;
}
add_filter( 'hide_updates_allowed_users', 'site_hide_updates_allowed_users' );
```

## Compatibility with remote management services

This plugin has only been tested with ManageWP. ManageWP has to connect to the site with a user account that is allowed to see updates. 

## Manual installation

1. Upload the `hide-updates` directory to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.

## Frequently Asked Questions

### Who is this plugin for?

Developers and agencies who want to hide updates from their clients, or anyone who install plugins with Composer and wants to take care of updates that way.

### Why would you want to hide updates?

If you update WordPress core, plugin, and theme updates through remote management services like ManageWP, or if you install plugins through Composer, you may want to hide updates in the WordPress admin.

### Can I choose to hide only some types of updates?

No, not at the moment. All updates will be hidden.

## Changelog

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