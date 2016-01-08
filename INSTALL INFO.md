Napmaps Installation Guide
==========
Following file will help you in installation and configuration of Warehouse by Encrypted.pl
I assume that you are PHP developer or at least IT beginner.

Dictionary
==========
W - is name of the folder to which you will copy Napmaps script (whole this folder).
SITE - is web adress of your W. 

Instructions
==========
1. Copy all files from Napmaps folder to your web server (localhost or ftp server).
2. Execute scripts from W/scripts/db.sql on your database (MySQL).
3. Copy file W/application/config/database_DEFAULT.php to W/application/config/database.php
4. Open newly created file W/application/config/database.php and fill your database connection data.
5. Open your SITE in browser.
6. You should be able to login with following data:
	login:		root
	password:	root

Languages
==========
Software is translated english. We can add more language in future.