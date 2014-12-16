Media Assembly Kit
===

* Licensed under GPLv2 or later. :) Use it to make something cool.

Getting Started
---------------
Required : gulp and bower.

`
$ npm install --global bower gulp
`
next step
`
$ cd path/to/wp-content/themes/media-assembly-kit
$ bower install
$ npm install
$ gulp init
`

If you want to set things up manually, download `mak` from GitHub. The first thing you want to do is copy the `mak` directory and change the name to something else (like, say, `mytheme`), and then you'll need to do a five-step find and replace on the name in all the templates.

1. Search for `'mak'` (inside single quotations) to capture the text domain.
2. Search for `mak_` to capture all the function names.
3. Search for `Text Domain: mak` in style.css.
4. Search for <code>&nbsp;mak</code> (with a space before it) to capture DocBlocks.
5. Search for `mak-` to capture prefixed handles.

OR

* Search for: `'mak'` and replace with: `'mytheme'`
* Search for: `mak_` and replace with: `mytheme_`
* Search for: `Text Domain: mak` and replace with: `Text Domain: mytheme` in style.css.
* Search for: <code>&nbsp;mak</code> and replace with: <code>&nbsp;Megatherium</code>
* Search for: `mak-` and replace with: `mytheme-`


Good luck!
