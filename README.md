Dyluni for Wordpress
====================

## Naked boilerplate HTML5 theme for Wordpress 3.x

Hi! Thanks for checking this out. Dyluni for Wordpress is a naked theme for use in Wordpress projects, where you just want a totally clean theme to start out from. Its styling is based on my [Dyluni Framework](https://github.com/johanbrook/dyluni "Go to my Sass framework") (which makes use of Sass).

An ever so present note is that this is how *I* build my Wordpress sites – I'm not claiming that everything is 100% correct and most efficient, so therefore I'm gladly except suggestions.

## Crash course

The theme is written in HTML5, so you'll find the new semantic elements where appropriate. All the necessary theme files I use are included, as well as an extensive `functions.php`. I've tried to adhere to the different code standards and practices. 

The theme got one template part (in the folder `partials`), `post.php` where the main post code lives. That one is used in index and archive files, as well as in `single.php`.

### Functions.php

In `functions.php` you'll find lots of handy Wordpress functions I personally can't live without. Note that once again this is my basic setup: go ahead and remove the stuff you don't need/want.

## Dyluni Framework

I use my personal website boilerplate framework in this theme, [Dyluni](https://github.com/johanbrook/dyluni#readme), which relies on [Sass](http://sass-lang.com). Please go ahead and check it out; once you go Sass you'll never go back!

For production I recommend using `style-compressed.css` since it's way smaller than the uncompressed development version.

