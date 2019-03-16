=== Benjamin ===

Requires at least: 4.5
Tested up to: 4.9.4
Stable tag: 2.0.9.5
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html
Copyright 2017 Kyle Jennings
Benjamin is distributed under the terms of the GNU GPL

== !! JS console error note !! ==
When navigating to the 404 section in the customizer, there is an intentional JS error:
"Failed to load resource: the server responded with a status of 404 (Not Found)"

This occurs because the customizer previewer is loading a non-existent page so the 404 page
can be previewed while be customized!

== Description ==

Benjamin is built with _s and the 18f US Web Design Standards.  The Web Design
Standards are a library of design guidelines and code to help government
developers and designers quickly create trustworthy, accessible, and consistent
digital government services.



== Installation ==

1. In your admin panel, go to Appearance > Themes and click the Add New button.
2. Click Upload and Choose File, then select the theme's .zip file. Click Install Now.
3. Click Activate to use your new theme right away.

== Customizer ==
* The following default settings have been removed as they are not implemented in this theme
** Colors - link and background colors are not configurable
** Background - Background wallpapers are not visible in this theme
** Custom Headers are not implemented.  Arguably a similar feature exists, but is implemented different and is also logically grouped in with the template settings sections.

== Documentation for site identity  ==
* The color scheme settings will change Benjamin's colors to a series of preset combinations.
* The logo is used for the navbar brand (if the navbar brand setting is changed.)

== Documentation for menus ==
* the menus only go 2 levels deep, the top level and a single dropdown

== Documentation for header settings and navbar ==
* The header order is a draggable, sortable setting which lets you select the position of the hero, navbar, and banner (banner is available if and only if your site domain is a .gov or .mil)
* Search location allows you to place a search field in the navbar
* You can change the navbar color scheme from light (default) to dark (kind of inverted)
* The navbar can be set to stick to the top of the window when scrolling down
* As mentioned in the site identity section, the brand can be set from text (default) to the logo

== Documentation for templates setup ==
* There are template which can be configured: default, the feed (archive, search, ect), frontpage, single post, single page, and widgetized page
* Each template can be activated to override defaulttemplate settings
* The hero image can be set
* the hero size can be set to predefined sizes include a fullscreen size
* the position can be hidden, or set to th left or right of the page
* The sidebar size setting has 2 options, wide (1/3rd page) and narrow (1/4th)
* the sizebar's visibility can be hidden or shown on different screen sizes

== Documentation for frontpage setup ==
* the "hero callout" button can be set to point to a specific page
* There are draggable, sortable widget areas which can be ordered
* 3 widget area rows
* a row to display the page contents

== Documentation for frontpage setup ==
* the "hero callout" button can be set to point to a specific page

== Documentation for widgetized page ==
* There are draggable, sortable widget areas which can be ordered
* Sortables include:
* 3 widget area rows
* a row to display the page contents


== Documentation for footer settings ==
* There are draggable, sortable widget areas which can be ordered
* Sortables include:
* a return to top row
* a footer menu row (set by the "footer" menu location)
* and 2 widget area rows


== Copyrights and License ==

Unless otherwise specified, all the theme files, scripts and images are licensed
under GPLv2 or later


== Credits ==

* Benjamin Franklin by David Martin ( Banner image in screenshot )
https://upload.wikimedia.org/wikipedia/commons/a/a3/Benjamin_Franklin_1767.jpg
This work is in the public domain in the United States because it was published (or registered with the U.S. Copyright Office) before January 1, 1923.
License: PD-1923 
URL: https://commons.wikimedia.org/wiki/Template:PD-1923

* Underscores
http://underscores.me/
(C) 2012-2016 Automattic, Inc.
License: [GPLv2 or later]
URL: https://www.gnu.org/licenses/gpl-2.0.html


* US Web Design Standards (USWDS)
(USWDS) v1.2.0 (https://standards.usa.gov/)
Mixed License (https://github.com/18F/web-design-standards/blob/develop/LICENSE.md)


*  This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

== Changelog ==

* 1.2
* Namespaced all functions, classes, and constants
* Properly sanitized all customizer and settings API
* Replaced the screenshot
* Included unminified JS alongside the minified JS
* Added support for custom post types
* Added support for co-authors plus plugin
* Moved contact settings to Franklin as customizer settings
* Changed footer settings to sortable components
* Choose your 404 page content

* 1.3
* Re-namespaced everything to use theme slug, and not the uswds acronymn
* Added options to hide parts of a given page

* 1.4
* Added some additional settings to the 404 page
* Added permalink to the hero area featured post title
* Fixed a JS bug in the customizer caused by using 404 as an array index
* Fixed the preview for changing the sidebar width
* Used built in customizer settings for my layout activate setting
* Added some toggles to the various customizer fields
* Added styles for CF7 validations
* Prepped settings for the eventual hero area video BGs

* 1.5
* Video hero (header) backgrounds now work
* Refactored hero functions into a class
* Cleaned up files
* Fixed some bugs
* Customizer 404 section opens a non-existent page for styling
* Added labels to customizer section groups

* 1.6
* Fixed some debug warnings

* 1.7
* Addressed all concerns in https://themes.trac.wordpress.org/ticket/43531#comment:7
* Added additional widget areas in the banner
* Translated, and escaped all the things

* 1.9
* Translated all the things
* Added "default" layout settings and made the "feed/archive" settings optional
* Moved some page specific non "template layout" settings to the top level of customizer
* Removed the red color scheme
* Removed the video banner and moved it to the Franklin theme
* Customizer Bug fixes
* Refactored some code
* Updated licensing information

* 2.0.2
* Added support for post formats
* Refactored the customizer
* Bug fixes
* More translations

* 2.0.3
* Fixed a customizer bug where the 404 preview wouldnt load if the defauly permalinks were used
* Fixed bug toggling the banner uin the customizer preview

* 2.0.4
* Stop hiding the text editor when using the status post format
* Small code cleanup

* 2.0.5
* Fixed post format saving bug

* 2.0.6
* Fixed more untranslated text
* Refactored some files to be more legible
* Moved the post format markup out of the hero to just before the content

* 2.0.7
* removed some unused vars from the primary menu

* 2.0.9
* moved post format admin forms over to the franklin plugin
* replaced some code with WordPress specific functions
* escaped some WP functions
* added a notice to download Franklin

* 2.0.9.3
* Fixed default footer and header bugs
* fixed page template content bug

* 2.0.9.4
* Fixed header background image bug

* 2.0.9.5
* Fixed franklin install button bug