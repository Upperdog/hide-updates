# Hide Updates

This plugin hides update notifications for WordPress core, plugin, and theme updates in WordPress admin for all users except site admins or specified users (see example below). It's useful for developers and agencies who take care of updates and maintenance of their clients sites and wants to hide the notices for other users.

* Hides Wordpress core update notices.
* Hides plugin update notices.
* Hides theme update notices.
* Hides Updates link in admin menu and admin bar.
* Blocks users who are not allowed to see updates from accessing the updates page.

___This plugin is intended for developers and agencies who have good reasons for hiding the updates.___

## Plugin filter for developers

Developers can use the `hide_updates_allowed_users` filter to specify which users are allowed to see update notifications. Add the username of each allowed user to an array like in the following example: 

```
function site_hide_updates_allowed_users() {
    $allowed_users = array( 'charlotte', 'bob' );
    return $allowed_users;
}
add_filter( 'hide_updates_allowed_users', 'site_hide_updates_allowed_users' );
```

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

### 1.1

* Release date: 2018-10-21
* Add filter to define users allowed to see updates.
* Hide update notifications using CSS to enable usage of remote management services like ManageWP and others. Previous solution used pre_site_transient_update_* filters and nulled all values making it impossible for remote management services to read updates.

### 1.0

* Initial release.