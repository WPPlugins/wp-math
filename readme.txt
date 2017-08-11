=== WP Math ===
Contributors: Mikoviny
Donate link: http://wpmath.g6.cz/
Tags: math, math publishing, math publisher, counting, calculation
Requires at least: 2.7
Tested up to: 3.0
Stable tag: 0.2.1

Publishing and solving mathematical documents. Plugin is using <a href="http://www.xm1math.net/phpmathpublisher/">PhpMathPublisher.</a>

== Description ==

This is just Beta version of this Plugin with some Bugs, but I need to report them (<a href="http://wpmath.g6.cz/">http://wpmath.g6.cz/</a>).

**What this plugin can do:**

1. Display mathematical documents. Plugin is using PhpMathPublisher
2. Add, Subtract, Multiply, Divide.
3. Show results.
4. If you add "==" on the end of formula at first it inserted variables and than show result.
5. Converting e-mail in posts and pages to *.png picture.
6. Add form with custom variables for page visitors.
7. Multiple inputs.
8. Static counting
9. Use multiple functions (Ceil, ceil, Floor, floor, Round, round, acos, acosh, asin, asinh,  atan, atanh, base_convert, bindec, ceil, cos, cosh, decbin, 
dechex, decoct, exp, floor, fmod, getrandmax, hexdec, hypot, is_finite, is_infinite, is_nan, lcg_value, log, max, min, mt_getrandmax, mt_rand, mt_srand, octdec, pi, pow, rand, round, sin, sinh, sqrt, srand, tan, tanh). I did not test them all, so i don´t know if they realy works. Manual will be on my page in few days.
10. Basic units.

**How it works**

1. PhpMathPublisher Help.
2. Type normal page or post. Formula must be in tags &lt;m&gt;&lt;/m&gt; or &lt;x&gt;a=10+15=&lt;/x&gt;
3. Add "=" on the end to show result
4. Add "==" on the end to insert variables


**What I want to do:**
 
1. Add units
2. Add some other math functions like root, square, sum and others.
3. Add some TinyMC buttons


= Contact: =
* site: http://wpmath.g6.cz

== Installation ==


1. Upload wp-math.zip to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Set CHMOD 777 for `/wp-content/plugins/wp-math/img/`

== Screenshots ==

1. Formulas
2. E-mails
3. Tags

== Changelog ==
= 0.2.1 =
* Php functions checked. <a href="http://www.wpmath.g6.cz/functions/">Online manual</a>
* Add basic units.
* Add functions Floor,Ceil,Round,Random,a^x, root{10}{1024}, log(number,base), cot()

= 0.2.0 =
* Add functions (acos, acosh, asin, asinh,  atan, atanh, baseconvert, bindec, ceil, cos, cosh, decbin, 
dechex, decoct, exp, floor, fmod, getrandmax, hexdec, hypot, isfinite, isinfinite, isnan, lcgvalue, log, max, 
min, mtgetrandmax, mtrand, mtsrand, octdec, pi, pow, rand, round, sin, sinh, sqrt, srand, tan, tanh)
 

= 0.1.6 beta =
* Optimalizing calculations. Add [static*all] to convert all formulas in document to static formulas. Or surround some formulas with [static][/static] to convert just them. 
* Solved security for [form][/form] 
* Add some settings

= 0.1.3 beta =
* Page visitors can add own variables
* Multiple formulas in one &lt;m&gt;&lt;/m&gt;

= 0.1.2 beta =
* Customize font size
* Solved bug with url

= 0.1.1 beta =
* E-mails in pages and posts replaced by *.png picture
* Some bugs with TinyMC solved

= 0.1 beta =
* Add, Subtract, Multiply, Divide
* = -> show result
* == -> show unknown

