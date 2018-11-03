SimpleChat! 1.3

homepage: http://hot-things.net


DESCRIPTION

SimpleChat! 1.3 is a nice and fast HTML based chatroom written in PHP3/4.
The output produced by SimpleChat! 1.3 is small, 100% HTML 4.01 compliant
and also looks fine with any modern browser which supports HTML 4 and
JavaScript 1.2.


FEATURES

 - Fast loading - about 3-9kB per refresh (depending on the last 12 entries).
 - Easy to install. No MySQL database required.
 - 100% HTML 4.01 compliant output.
 - Best viewed with any browser - MSIE 4+, Netscape 4+, Opera 4+, Mozilla (any).
 - Text formatting - bold, italic and colored text.
 - 20 pretty color schemes at choice.
 - Different icons at choice, smilies, links.
 - HTML tags filter.
 - 150 lines history (the number can be changed easily - index.php, line #45).
 - Sound alert when a new message arrives.
 - List of the users online.
 - Refresh rates - 5, 10, 20 30, 60 sec
 - Translated in different languages.


INSTALLATION

Just extract all files in a directory (keeping the directory structure), 
run a web server, a browser and type the URL, e.g.
http://localhost/SimpleChat/index.php .

 * Do not forget to CHMOD the directory "/data" to 777 on LINUX based systems.
 (CHMOD means to change the permissions/attributes of a file or a directory usually by an FTP program)

The newest PHP4.x.x distributions come with a default 'register_globals' variable set to '0'.
If you cannot  login, post messages or change color schemes or you should enable 
this variable in php.ini: register_globals=On 
or just add a line at the beginning of incl/hdr.inc: 

ini_set('error_reporting',7);import_request_variables("GPC");

SimpleChat! is synchronized to the GREENWICH MEAN TIME. 
Synchronize it to your local time by replacing '0' (incl/hdr.inc, line #1) with +/- any number you wish.

The default password for clearing is 12345 . Change it (clear.php, line #7) if necessary.

It is recommended to hide the IP addresses of your users by uploading and 
then renaming the file < htaccess > in the directory "/data" to < .htaccess >.

TRANSLATION 

Translating SimpleChat! into any language is as easy as possible.
Language files are simple ASCII text files - lang-en.inc, lang-bg.inc and so on.
Create your own file or/and set SimpleChat! which one to load: (incl/hdr.inc, line #23).

If you are going to use a non-English alphabet it is strongly recommended to
change the 'charset' tag in your language file to the proper one: (lang/lang-xx.inc file, line #5). 
It would decrease the loading time 6-7 times per refresh and prevent 
some browsers from displaying incorrect letters.


HISTORY

version 1.3 - list of users instead of "login/logout" messages
              sound when a new message arrives

version 1.2 - version 1.2 is completely rewritten
              some changes in the appearance

version 1.1 - some bugs fixed
              displaying 'log out' messages 
              possibility to change the refresh rate
              multilanguage support

version 1.0 - First public release


LICENSE

SimpleChat! 1.3 is distributed under a GNU General Public License (GPL): 
http://www.gnu.org/copyleft/gpl.html


-------------------------------


WHO'S ONLINE?

Here you have some instructions how to print 
a list of the users online on any page of your site.

1. Add this line at the beginning of a PHP file:

  <?php $pth='xxx';include "$pth/incl/users.inc"; ?>

  where 'xxx' should be a correct relative path to your chat directory.
  If you'd like to print the list on your main page - http://your-site.com/index.php ,
  and the chat lives in a directory: http://your-site.com/friends/simple-chat/ ,
  you should set $pth='friends/simple-chat'; 

2. Call the function whos_online(); using one argument which would separate the users.
   <?php whos_online('<br>'); ?>


The following lines are a simple example of http://your-site.com/index.php 


--- INDEX.PHP starts here --- 


<?php $pth='friends/simple-chat';include "$pth/incl/users.inc"; ?>

<html><head>
<title>MY MAIN PAGE</title>
</head><body>


<!-- who's online list in a row -->
<div style="background-color:#cccccc">
<?php whos_online(''); ?>
</div><br>


<!-- who's online list in a column -->
<div style="background-color:#aaaaaa">
<?php whos_online('<br>'); ?>
</div><br>


</body></html>


--- INDEX.PHP ends here --- 