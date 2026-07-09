#  WordPress 7 PHP-Only Block Registration Demo
 
This plugin demonstrates a simple example of *PHP-Only Block Registration* with settings that can be modified in the WP sidebar. This ability has been made available only as of WordPress v7.0. The code here is modified and extended from [examples provided by Brian Coords](https://github.com/bacoords/example-php-block).

The demo is a simple category posts block that retrieves some posts from a specified category, then displays their titles and thumbnails horizontally or vertically.

**Sample Block Admin**

<img alt="Screen grab of Block admin view" src="https://ca-central-1.graphassets.com/ABnvGT5MLQxm59mwdzQhjz/cmrdte3fw466607u1tz9pha4n" width="400">

**Sample Block Front-End**

<img alt="Screen grab of Block front end view" src="https://ca-central-1.graphassets.com/ABnvGT5MLQxm59mwdzQhjz/cmrdubwhh4of807u9cbwnsf35" width="400">

## Installation Instructions

- Download this repo as a .ZIP file and install it as a plugin on any site running **WordPress 7.0 or newer**.

- Activate the plugin *WP7 PHP Block Demo*.

- Publish some posts and assign them to some categories; make sure each post has a featured image.

- Edit a page and add the block named *Simple PHP Block Demo*.

- With the block selected, in the right sidebar, adjust the block settings as desired:

  - `Heading Text` - Text to display in the heading
  - `Category` - Select category to pull posts from
  - `Default Direction` - Select vertical or horizontal
  - `Max Posts` - Select 1, 2, or 3 posts

- With the block selected, in the right sidebar, adjust any default style settings such as font sizes or background colors.

- Publish the post, then view it.

- When viewing, click the *Reverse Order* button at the top-right of any block instance to change the display direction of the posts dynamically.


## Code Structure Notes

The file `php-blocks-demo.php` in the root defines this as a WP plugin, sets some path constants, then loads the block registration code.

The block code is contained in the subfolder `simple-block-demo` which contains 3 files:

- `register.php` - Registers the block, enqueues the CSS and Javascript, defines the properties of the block including the attributes available in the settings sidebar, then renders the block HTML based on those settings.

- `style.css` - CSS to style the block on the front and back-end.

- `view.js` - JaveScript that runs on the front-end after the DOM and blocks have loaded, and then injects a button that enables the display direction of the posts in the block to be changed on-the-fly by adding or removing a class to the block element. **Important note:** This JavaScript will only execute when the block is viewed on the front-end of the website; it will not execute within the WordPress admin panel content editing area.

Inline code comments provide further details.


## What is PHP-Only Block Registration?

Until the release of WordPress 7.0 in early 2026, the creation of all custom WordPress blocks (formerly known as Gutenberg blocks) required working with a Javascript build environment that includes NodeJS, npm, React, and other related build tools. Since the rest of WordPress is built and customized via PHP, this made custom block development cumbersome, bringing along a lot of overhead even for developers who work in both stacks.

[PHP-Only Block Registration](https://make.wordpress.org/core/2026/03/03/php-only-block-registration/) in WordPress 7.0 eliminates the need for this secondary stack when creating simple server-rendered blocks (see below). Specifically, a new `autoRegister` flag in `register_block_type` instructs WordPress to automatically generates the block in the editor, along with the relevant sidebar options.

## Limitations of PHP-Only Block Registration

This method is designed to ease block registration for simpler blocks that do not have any of the following requirements:

- The need for nested blocks, that is, the ability to drop another block into your custom block.

- Sidebar attribute setting types other than `string`, `integer`, `boolean`, and `enum`.

- Advanced media fields like image uploaders or rich text fields.

- Extensive user interaction with a lot of JavaScript that must execute in the WordPress admin area.

Even with these limitatations, this change should open up new customization possibilities for more WordPress developers.
