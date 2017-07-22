# Anva Framwork: WordPress Theme Framework Library

Anva Framework is a library for developing WordPress themes. It allows theme developers to build themes without having to code much of the complex "logic" or other complicated functionality often needed in themes. The framework takes care of a lot of these things so theme authors can get back to doing what matter the most: developing and designing cool themes.  

The framework was built to make it easy for developers to include (or not include) specific, pre-coded features.  Themes handle all the markup, style, and scripts while the framework handles the logic.

## FAQ

### How do I install Hybrid Core?

The most basic method is to add the framework folder to your theme folder.  Assuming a folder name of `anva-framework` (you can name the folder anything), you'd add this code to your theme's `functions.php` file:

    // Launch the Anva Framework.
    require_once( trailingslashit( get_template_directory() ) . 'anva-framework/anva.php' );
    new Anva();

That will load and initialize the framework. You'll have to learn the ins-and-outs of the framework though to actually make use of it. The code itself is very well documented.

## Copyright and License

This project is licensed under the [GNU GPL](http://www.gnu.org/licenses/old-licenses/gpl-2.0.html), version 2 or later.

2017 &copy; [Anthuan Vásquez](https://anthuanvasquez.net).
