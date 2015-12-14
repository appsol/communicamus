Communicamus
============

*"Communicamus ergo sum" ('We relate, therefore I am')*
-----------------------------------------------------

A Wordpress theme based on _S (Underscores) using Bootstrap 3 intended as a base for developers and designers to create lightweight semantic Wordpress themes.

A build system using Grunt (http://gruntjs.com/) and Bower (http://bower.io/) allows for a compressed and optimised /dist directory to be created.

How to use this parent theme.

1. Create a child theme in a directory at the same level as communicamus/, e.g. themes/mychildtheme.

2. Create 2 files within this them style.css and functions.php. The functions.php need only be a blank php file (e.g. only add opening php brackets <?php), while the style.css needs to have the theme header for wordpress, e.g.:

```
/*
Theme Name: My Child Theme
Template: communicamus
Theme URI: http://www.mynewwebsite.co.uk/
Author: My Name
Author URI: http://www.mypersonalsite.co.uk/
Description: Site specific theme for My New Website
Version: 0.1.0
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: mychildtheme

This theme, like WordPress, is licensed under the GPL.
*/
```

3. Move the following files from communicamus to your new theme directory:
    * package.json
    * bower.json
    * Gruntfile.js
    * less/ (the directory and contents)

4. Install Node and npm globally on your system (see https://nodejs.org/en/download/ for instructions specific to your system), Communicamus requires version 4.0.0 or above

5. Install Grunt globally on your system via the command line:
```
npm install -g grunt-cli
```

6. Install Bower globally on your system
```
npm install -g bower
```

7. Initialise the Node and Bower packages locally:
```
cd /path/to/wordpress/wp-content/themes/mychildtheme
npm install
bower install
```

8. Initialise the theme by running Grunt. This will create a dist/ directory in your theme and will them watch your /less, /js, images/ and fonts/ directories for changes, and will re-create the dist/ directory each time a change is detected.

