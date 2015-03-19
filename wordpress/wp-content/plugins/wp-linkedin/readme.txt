=== WP LinkedIn ===
Author: Claude Vedovini
Contributors: cvedovini
Donate link: http://vedovini.net/plugins/?utm_source=wordpress&utm_medium=plugin&utm_campaign=wp-linkedin
Tags: linkedin,resume,recommendations,profile,network updates
Requires at least: 2.7
Tested up to: 4.1.1
Stable tag: 1.18.3
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html


== Description ==

This plugin provides you with shortcodes to insert your full LinkedIn profile
and a rotating scroller of your LinkedIn recommendations in any Wordpress page
or post. Please check <a href="http://vedovini.net/">vedovini.net</a> for
examples.

The following shortcodes are available:

* `[li_recommendations width="480" length="200" interval="1000"]` displays a
rotating scroller with the recommendations you received
* `[li_profile]` displays your LinkedIn profile. Optional attributes
are `fields` and `lang` to overide the general settings.
* `[li_card]` displays a simple LinkedIn card. Optional attributes
are `picture_width` and `summary_length`, and `fields` and `lang` to overide
the general settings.
* `[li_updates]` displays your network updates. Optional attributes are `count`
and `only_self`.
* `[li_picture]` displays the original profile picture (size may vary depending
on what you uploaded to LinkedIn). Optional attributes are `width`, `height`
and `class`.

To customize the rendering of the shortcodes you must create a `linkedin` folder
in your theme and then copy the template file you want to modify.
The default template files are located in the plugin's `templates` folder.

See this post for more details on customization: [Showing more of your LinkedIn
profile with WP-LinkedIn](http://vedovini.net/more-wp-linkedin)

There are also several widgets. One widget displays the recommendations
scroller, one displays your network updates, and two widgets show a "profile
card" - one of which is the standard LinkedIn JavaScript profile widget, the
other uses a customizable template.

**ATTENTION:** Since v1.6 the call to add the javascript for the recommendations
slider to the page as been moved to the `recommendations.php` template. If you
customized that template you must add the following line to the top of your
custom template: `wp_enqueue_script('responsive-scrollable');`

We welcome volunteers to translate that plugin into more languages. If you wish
to help then contact [@cvedovini](https://twitter.com/cvedovini) on Twitter or
use that [contact form](http://vedovini.net/contact/).

Please check the [WP-LinkedIn Multi-Users](http://vedovini.net/downloads/wp-linkedin-multi-users/?utm_source=wordpress&utm_medium=plugin&utm_campaign=wp-linkedin)
extension if you need to show the profiles of multiple users.

And if you need to show company profiles or company updates, please check the
[WP-LinkedIn for Companies](http://vedovini.net/downloads/wp-linkedin-co/?utm_source=wordpress&utm_medium=plugin&utm_campaign=wp-linkedin)
extension.


== Installation ==

This plugin follows the [standard WordPress installation
method](http://codex.wordpress.org/Managing_Plugins#Installing_Plugins):

1. Upload the `wp-linkedin` folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Create a LinkedIn API key/secret pair and register the redirect URI (follow
the instructions on the settings page)
1. Generate an access token for the LinkedIn API (those tokens expire after 60
days so you will have to regenerate them from time to time)
1. The `Profile fields` field is the list of fields that will be available to
the profile template for rendering - see this post for more details on
customization: [Showing more of your LinkedIn profile with
WP-LinkedIn](http://vedovini.net/more-wp-linkedin)


== Frequently Asked Questions ==

= Does the plugin support multiple user profiles? =

No, it doesn't. But there is a premiun extension,
[WP-LinkedIn Multi-Users](http://vedovini.net/downloads/wp-linkedin-multi-users/?utm_source=wordpress&utm_medium=plugin&utm_campaign=wp-linkedin)
that changes the behavior of this plugin so that shortcodes and widgets show
the data of the author of the post or page.

= Does the plugin support company profiles? =

No, it doesn't. But there is a premiun extension,
[WP-LinkedIn for Companies](http://vedovini.net/downloads/wp-linkedin-co/?utm_source=wordpress&utm_medium=plugin&utm_campaign=wp-linkedin)
that provides shortcodes and widgets for company profiles and company updates.

= How to add the volunteer experiences section from my profile? =

The volunteer experiences section is already in the template but is not
activated by default. To activate it you must add the relevant profile fields
to the list of fields, the minimum is `volunteer`. To get the full data
use this:

`volunteer:(volunteer-experiences:(organization,cause,role,start-date,
end-date,description))`

= How to add the projects section to my profile? =

The projects section is already in the template but is not activated by default.
To activate it you must add the relevant profile fields to the list of fields:

`projects:(name,url,start-date,end-date,members:(name,
person:(public-profile-url,first-name,last-name,picture-url,headline)),
description)`

= How to add the publications section to my profile? =

The publications section is already in the template but is not activated by
default. To activate it you must add the relevant profile fields to the list
of fields:

`publications:(title,publisher,authors,date,url,summary)`

= How to add the honors & awards section to my profile? =

The honors & awards section is already in the template but is not activated by
default. To activate it you must add the relevant profile fields to the list
of fields:

`honors-awards:(name,issuer,date,description)`

= How to add other sections to my profile? =

For other sections see [Showing more of your LinkedIn profile with
WP-LinkedIn](http://vedovini.net/more-wp-linkedin).

= I have a slider somewhere and it doesn't work anymore when I add the recommendations' scroller =

It's usually due to an incompatibility between the different javascript
components used. To solve the incompatibility it's better to choose one of the
component and use only this one. To change the component that is used by the
recommendations' scroller you will need to customize the `recommendations.php`
template.

= I am constantly asked to get a new access token =

There can be several reasons to that problem, check the following:

- Make sure your server's time is correct.
- If you are using an external cache system make sure it's properly configured.
- Try to uncheck the `Verify SSL peer` option on the plugin's settings page.

= Since I updated to v1.6 the recommendation slider does not work anymore =

Since v1.6 the call to add the javascript for the recommendations slider to
the page as been moved to the `recommendations.php` template. If you
customized that template you must add the following line to the top of your
custom template: `wp_enqueue_script('responsive-scrollable');`

= The updates shortcode (or the updates widget) doesn't show anything =

Try regenerating the access token from the settings page, the plugin needs new
authorization to access your network updates.

= Profile picture is only 80x80 pixels is there a way to get a bigger one from LinkedIn? =

You can either add `picture-urls::(original)` to the list of fields and output
that field in a customized template or use the `[li_picture]` shortcode.


== Screenshots ==

1. The recommendation shortcode in action (note that the CSS is customized in
that example).
2. Full page using the profile shortcode and displaying the LinkedIn full
profile.
3. LinkedIn profile card added after a post content.


== Upgrade Notice ==

= 1.18 =
*BREAKING CHANGE* The redirect uri that is used to process the OAuth access
token has changed in this version. You must update the redirect urls setting
in you LinkedIn API Application details. See the plugin settings page, API
access section, for more.

= 1.14 =
As of April 11, 2014 LinkedIn requires that redirect uris be registered, thus
forcing every plugin installation to have its own application key/secret pair
and register the corresponding redirect uri. Follow the instructions on the
plugin settings page.


== Changelog ==

= Version 1.18.3 =
- Fixing network updates templates that didn't show "Likes" properly.

= Version 1.18.2 =
- Updated Spanish and Catalan translations.

= Version 1.18.1 =
- Loading the text domain earlier in the plugin loading process so that
translations for widget names are available.
- Updating Portuguese and French translations.
- Now working when fancy permalinks are not activated.


= Version 1.18 =
- Stripped down the jQuery Tools library to the scroller only to avoid clashes with
other jQuery plugins and reduce footprint.
- Added support for honors & awards section to the profile template. If you
want to activate it then make sure to add the following fields to the list of
fields: `honors-awards:(name,issuer,date,description)`
- Added support for the `LI_DEBUG` variable. Set that define to `true` in
the `wp-config.php` file and debug information will be printed by the plugin as
HTML comments (especially usefull when debugging customized templates).
- Added the `li_picture` shortcode that enables you to print the original
profile picture.
- Changed the uri that gets the access token from the API.


= Version 1.17.2 =
- Change in the way urls are built to make sure the correct separator for query
parameters is always used.

= Version 1.17.1 =
- Some changes to the profile templates to remove unwelcomed warnings.

= Version 1.17 =
- Added support for publications section in the profile template. If you want
to add that section to your output make sure to add the following fields to the
list of fields: `publications:(title,publisher,authors,date,url,summary)`.
- Separated the profile template into several different templates to simplify
customisation. Now if you just need to customize one section of the profile then
you will only need to create a custom template for that section.

= Version 1.16 =
- Added Portuguese translations.
- Corrected internationalization bugs in class-admin.php

= Version 1.15 =
- Added Serbian translations.

= Version 1.14 =
- LinkedIn now requires that redirect uris be registered, thus forcing every
user of the plugin to create their own application key/secret pair and register
their redirect uri.

= Version 1.13.1 =
- Fixing display of a project's team members when they are not LinkedIn users or
they don't have a public profile.
- Fixing doc about the list of field to display projects.

= Version 1.13 =
- Added support for projects section in the profile template. If you want to add
that section to your output make sure to add the following fields to the list of
fields: `projects:(name,url,start-date,end-date,members:(name,person:(public-profile-url,
first-name,last-name,picture-url,headline)),description)`.

= Version 1.12.2 =
- Use options API directly instead of the transient API to avoid issues with object cache.
- Defaulting to single-byte API when multi-byte strings support is not enabled.

= Version 1.12.1 =
- Fixed version numbers.

= Version 1.12 =
- Added Catalan translations.

= Version 1.11.2 =
- Fixed a bug in the `Network Updates` template that was messing up the update text.

= Version 1.11.1 =
- Using `esc_url` in templates when printing links.
- Using `nl2br` instead of `wpautop` when printing recommendations text.

= Version 1.11 =
- Added 30mn caching for network updates to avoid API throttling.
- Small fixes.
- Added Spanish translations.

= Version 1.10 =
- Bundled jQueryTools within the plugin instead of using jQueryTools CDN.

= Version 1.9 =
- Fixed some translation issues.
- Fixed the default value for the list of post types to put the card on.
- Simplified the CSS and template for the LinkedIn card.
- Updated Dutch translations.

= Version 1.8 =
- Added a setting to let you choose on which post types your LinkedIn card will
be inserted (before it was only inserted on posts).
- Fallback mechanism to load language files in a smarter way.

= Version 1.7 =
- Added links for volunteer translators.
- Added screenshots.
- Added language proficiencies to the profile template,
use `languages:(language,proficiency)` in the list of fields to activate
it.
- Dutch translations updated.
- Changed the way extensions can hook to the plugin.
- Removed the `jquery.dimensions.etc` plugin.
- Added Italian translations.
- Added Brazilian Portuguese translations.
- Fixed an issue where the recommendation slider won't work when the jQuery
library is included in the footer of the blog.

= Version 1.6 =
- Updated Dutch translations.
- Using `wpautop` instead of `nl2br` in templates.
- Added template loading function with debug output of the template path. You
must have `WP_DEBUG` set to `true` to see what template file is used. The file path will be printed inside an HTML comment just before the template output.
- Error messages are now visible only when `WP_DEBUG` set to `true` otherwise
they are printed as HTML comments.
- Ability to add your LinkedIn card after each of your posts.
- Added hook `linkedin_oauthtoken` to enable extensions to override the
LinkedIn API oauth token.
- Added hook `linkedin_template` to enable extensions to override the template
to be used.
- Made the scroller truly responsive when width is set to `auto`.
- Put the scripts in the footer and moved calls to `wp_enqueue_script` to
templates for more flexibility.
- Added network updates shortcode and widget.

= Version 1.5.5 =
- Bug fix: Invalid url to refresh token in token expiry alert email.

= Version 1.5.4 =
- Better error reporting and specifying ssl_verify parameter when fetching
profile too.

= Version 1.5.3 =
- Fixing wrong name of parameter for wp_remote_get when exchanging code for
token m(

= Version 1.5.2 =
- Tweaking templates and CSS
- Option to disable SSL verification (on some servers the proper ssl
certificates are not installed thus preventing SSL verification).
- Option to have the plugin send an email when the access token becomes
invalid or expires.

= Version 1.5.1 =
- Improved error handling when updating oauth token.
- Using another set of APP key/secret when `WP_DEBUG` is turned on (allows for
having a dev environment without the access token being invalidated each time you switch).
- Allowing to override the APP key and secret by defining `WP_LINKEDIN_APPKEY`
and `WP_LINKEDIN_APPSECRET` in `wp-config.php`.
- Added a profile widget using the LinkedIn JavaScript API.
- Changed the `readme.txt` file to move some details from the "Installation"
page to the "Description" page.
- Changed from using `pre-wrap` in the stylesheet to using `nl2br` in templates
in order to better preserve the text formatting.

= Version 1.5 =
- Changing the way the LinkedIn API keys and token are managed in order to
simplify installation.
- Added a profile cache to improve performances and limit API calls.

= Version 1.4.3 =
- Updating string translations.

= Version 1.4.2 =
- Nice looking option page with donate button and Twitter widget.

= Version 1.4.1 =
- Fixing language codes in settings.
- Simplifying the javascript for the recommendation slider.

= Version 1.4 =
- Corrected link to post about customization in the readme.
- Modified the javascript for the recommendation slider so that it
uses `$(document).ready()`.
- Added a widget and shortcode displaying a simple LinkedIn card.

= Version 1.3.8 =
- Corrected a bug that interfers with other plugins using output buffering.
- Updated French and Dutch localizations.

= Version 1.3.7 =
- Added a 'css' option for the widget width to disable setting the width using
javascript. This allows to set the width using CSS, which is particularly
useful with responsive themes.
- Added a link to the post on vedovini.net about customizing the plugin's
output.

= Version 1.3.6 =
- Fixing how the presence of data is tested and adding error messages when the
profile cannot be retrieved.

= Version 1.3.5 =
- Adding French and Dutch translations (Credit to Jan Spoelstra for the Dutch
translations).
- Fixing path issue while laoding the text domain.
- Added credit section to the readme file.
- Changed name of bundled classes to avoid name colisions.

= Version 1.3.4 =
- Enable an 'auto' mode for the width of the recommendations in order to
accomodate responsive themes. However, it won't work in some occasion where
the width of the parent cannot be calculated. To activate it just use 'auto'
as the recommendations width.

= Version 1.3.3 =
- Updating the css version.

= Version 1.3.2 =
- Forcing `clear: none` on recommendations `blockquote` otherwise the scroller
might not work.
- Adding support for linking to recommender's profiles in the template and
adding the fields in the default list of fields. If you want to add that to
your output make sure to change the `recommendations-recieved` field
to `recommendations-received:(recommendation-text,recommender:(first-name,
last-name,public-profile-url))`.

= Version 1.3.1 =
- Upgrading the widget to use WP_Widget class, enabling several widgets
instances.
- Modified the script and CSS to be more respectful of theming.

= Version 1.3 =
- Added the possibility to select the profile language in the settings and
the `[li_profile]` shortcode.

= Version 1.2.1 =
- Added a test to avoid PHP error when no recommendations.

= Version 1.2.0 =
- Removed some unecessary code that prevented the fetching of some profile
fields.
- Moved the inclusion of the default CSS to the template to enable one to
remove and totally replace it.
- Added the option to provide a `field` attribute to the `[li_profile]`
shortcode to override the list from the settings and enable having several
different profiles.

= Version 1.1.0 =
- Adding the `interval` attribute to the shortcode and the widget to control
the scroller's speed.

= Version 1.0.2 =
- Changing version of jQuery Tools to avoid conflicting with WP's jQuery.
- Adding a sidebar widget with the recommendation slider.

= Version 1.0.1 =
- Removing left over HTML comment in recommendations template file.

= Version 1.0.0 =
- Initial release.


== Credits ==

Following is the list of people and projects who helped me with this plugin,
many thanks to them :)

- [Jan Spoelstra](http://www.linkedin.com/in/janspoelstra): Contributed the
Dutch translations.
- [Nathalie Aynié](http://nathalieaynie.com/): Contributed the Italian
translations.
- [Graciela Morel Centurion](http://ar.linkedin.com/pub/graciela-morel-centurion/4/61b/b9):
Contributed the Brazilian Portuguese translations.
- Andrew Curtiz, from [WebHostingHub](http://www.webhostinghub.com/): Contributed the Spanish
translations.
- [Jaume Villar](http://www.jaumevillar.info/): Contributed the Catalan translations.
- Ogi Djuraskovic, from [First Site Guide](http://firstsiteguide.com/): Contributed the Serbian translations
- [Pedro Gaspar](http://twitter.com/pedro_gaspar): Contributed the Portuguese
translations and corrected internationalization bugs in class-admin.php.
- [Oriol Torrillas](http://www.otorrillas.tk): Contributed Spanish and Catalan translations