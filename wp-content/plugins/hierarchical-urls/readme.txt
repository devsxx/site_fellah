=== Hierarchical URLs ===

Contributors: vmassuchetto
Tags: rewrite rules, templates
Requires at least: 3.0
Tested up to: 3.5
Stable tag: 0.02
License: GPLv2 or later

Will generate hierarchical URLs like
<code>category-name/subcategory-name/subsubcategory-name/post-slug</code> for all post
types and taxonomies.

== Description ==

Enables hierarchical URLs, making posts follow categories and parent categories
to define their permalink. Assume a blog with the following category structure
for posts:

* Music
  - Rock
  - Pop
* Food
  - Indian
  - Italian

By default, their URLs will be <code>category/%category-name%</code>. Activating this
plugin will end up in URLs like:

* Music: `music`
  - Rock: `music/rock`
  - Pop: `music/pop`
* Food `food`
  - Indian: `food/indian`
  - Italian: `food/italian`

For posts inside the Italian food category, for example, the URL will be
<code>food/italian/%postname%</code>.

== Installation ==

Upload the plugin to your `wp-content/plugins` and activate it.

== TODO ==

* Flush rules on term creating
* Reflect post URL in the admin slug edit section

== Changelog ==

= 0.01 =

* First version with some functional code.
