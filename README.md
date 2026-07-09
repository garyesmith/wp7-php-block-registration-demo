#  WordPress 7 PHP-Only Block Registration Demo
 
This plugin demonstrates a simple example of PHP-only registration of a block with settings that can be modified in the WP sidebar. This ability has been made available only as of WordPress v7.0. The code here is modified and extended from [examples provided by Brian Coords](https://github.com/bacoords/example-php-block).

The block pulls between 1 and 3 posts from a specified category, then displays their titles and thumbnails, either horizontally or vertically.

---
**Block admin view screen shot:**

<img alt="Screen grab of Block admin view" src="https://ca-central-1.graphassets.com/ABnvGT5MLQxm59mwdzQhjz/cmrdq4jr62azl07u1udf7n81a" width="440">

---

**Block front-end render screen shot:**

<img alt="Screen grab of Block front end view" src="https://ca-central-1.graphassets.com/ABnvGT5MLQxm59mwdzQhjz/cmrdq4jvx2azs07u106a159cd" width="440">

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

- With the block selected, adjust any default style settings such as font sizes or background colors.

- Publish the post, then view it.

- When viewing, click the *Rotate* button at the top-right of any block instance to change the display direction of the posts dynamically.


## Code Structure Notes

The file `php-blocks-demo.php` in the root defines this as a WP plugin, sets some path constants, then loads the block registration code.

The block code is contained in the subfolder `simple-block-demo` which contains 3 files:

- `register.php` - Registers the block, enqueues the CSS and Javascript, defines the properties of the block including the attributes available in the settings sidebar, then renders the block HTML based on those settings.

- `style.css` - CSS to style the block on the front and back-end.

- `view.js` - JS that runs on the front-end after the DOM and blocks have loaded, and then injects a button that enables the display direction of the posts in the block to be changed on-the-fly by adding or removing a class to the block element.

Inline code comments provide further details.
