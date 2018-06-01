# Colonia
This web application is for managing the information regarding to a Community like my other project but this is much simple and use PostgresSQL
MY WEB APPLICATION COMMUNITY MANAGER 
Short: My WebApp Community Manager 
Abbreviation: MWACM

INTRODUCTION:
This is my second contribution as open source with GPL license. 
This web application is for managing the information regarding to a Community. You can register Community address, Houses, cars, incomes
Given by the neighbors and the expenses done for the Colony improvements. You can also see the cash flow and the report for the input and output money.
I hope you enjoy and be useful for your projects or your Community management. 

LICENSE:
All my code as documented author "Mario Gonzalez Jimenez" is released under GPL-3.0-or-later.
All the files inside the folder misphp documented as author "Mario Gonzalez Jimenez" are
Released under GPL-3.0-or-later (except the files includes from Spreadsheet_Excel_Writer and their references inclusions).
See COPYING.txt file on the same folder of this README.txt for the text version of the GPL

Spreadsheet license is under  LGPL-2.1-or-later

Joomla 3.8.x license is under GPL-2.0-or-later

license released under GPL-3.0-or-later

	README.txt is part of the MY WEB APPLICATION COMMUNITY MANAGER
	
	MY WEB APPLICATION COMMUNITY MANAGER is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    MY WEB APPLICATION COMMUNITY MANAGER is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with MY WEB APPLICATION COMMUNITY MANAGER.  If not, see <http://www.gnu.org/licenses/>.

COPYRIGHT: 
MY WEB APPLICATION COMMUNITY MANAGER
Copyright (C) 2018 Mario González Jiménez.

Spreadsheet_Excel_Writer:  A library for generating Excel Spreadsheets
Copyright (c) 2002-2003 Xavier Noguer xnoguer@rezebra.com
Spreadsheet::WriteExcel module is John McNamara <jmcnamara@cpan.org>

JOOMLA 3.8.x
Copyright (C) 2005 - 2018 Open Source Matters. All rights reserved.
Special Thanks: https://docs.joomla.org/Special:MyLanguage/Joomla!_Credits_and_Thanks
Distributed under the GNU General Public License version 2 or later
See Licenses details at https://docs.joomla.org/Special:MyLanguage/Joomla_Licenses

SOURCERER v7.2.0
author          Peter van Westen <info@regularlabs.com>
link            http://www.regularlabs.com
copyright       Copyright © 2018 Regular Labs All Rights Reserved
license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

VERSIONS:
I made two versions depending on database: MySQL version is the most complete and Postgres version that missed password encryption for connecting to database.
Comunity.zip Version 1.0 (MySQL)
Colonia.zip  Version 1.0 (PostgreSQL)

SETUP AND INSTALLATION:
#######################################################################################################################################
APPLICATION WITH MYSQL VERSION:
I. Prerequisites:
1) Maria DB 10.2 or MySQL 5.5 (for the Database)
2) Apache 2.4.29 or above (for the Web Server application)
3) PHP 7.1.2 or above (I tested on php.7.2.2) (for the language on the web server application

II. Setup:

Files Required:
- Joomla_3.8.7-Stable-Full_Package.zip
- CreateFraccionamientoMySQLDB.sql
- Comunity.zip
- sourcerer-v7.2.0.zip
- changeString.php

1) Unzip Joomla_3.8.7-Stable-Full_Package.zip into htdocs folder (or whatever your hosting provider gives you)
2) Follow the setup for Joomla installation (remember to choose mysqli) but you will need to identify the database and tables prefix as follow:
	- db: fraccionamiento (if your hosting provider or database administrator cannot give you this name then 
			you have to change the loadScript for MySQL database creation file: CreateFraccionamientoMySQLDB.sql lines 16 and 17)
	- dbprefix: p246x_ (mandatory prefix for assigning relationship with users privileges on Community project)

3) Load database backup CreateFraccionamientoMySQLDB.sql with your favorite MySQL IDE (Recommended HeidiSQL)
4) Unzip Comunity.zip into htdocs folder
5) Change Configuration.php file on Community folder with the data for the same Configuration.php file on the Joomla folder. 
	(because it has the database data connection parameters)
6) Create at least 1 user and 1 superuser on Joomla Content manager. 
	You can enter the Administrator section URL in my case was http://localhost:8080/Comunity/Administrator/
7) Install by Upload Package file option when you enter on the top Menu: Extensions / Manager path on Joomla Content Manager.
8) Change the parameters of the database on the LoadCatalog.php file inside Community/misphp
9) For the password you need to use the file changeString.php and enter in the first input text your real password for database connection 
	and push Cambia Button (first button on left), this will give you the encrypted password on the second input text. 
	You need to paste it in the line 21 for the variable assignment.
	I recommend checking your file editor regarding change of charset. If you are using windows use notepad to edit the file.
10) Test the application and check if missing configuration. You can use the php.ini and httpd.conf files included on the zip distribution to check
	minimal options required or use HelloWorld.php and HelloDatabase.php to check if the prerequisites and database connection works fine.
	
Enjoy.

#######################################################################################################################################
APPLICATION WITH POSTGRESQL VERSION:
I. Prerequisites:
1) PostgreSQL 10  (for the Database)
2) Apache 2.4.29 or above (for the Web Server application)
3) PHP 7.1.2 or above (I tested on php.7.2.2) (for the language on the web server application

II. Setup:

Files Required:
- Joomla_3.8.7-Stable-Full_Package.zip
- backupFracc.sql
- Colonia.zip
- sourcerer-v7.2.0.zip

1) Unzip Joomla_3.8.7-Stable-Full_Package.zip into htdocs folder (or whatever your hosting provider gives you)
2) Follow the setup for Joomla installation (remember to choose PostgreSQL) but you will need to identify the database and tables prefix as follow:
	- db: fraccionamiento (if your hosting provider or database administrator cannot give you this name then 
			you have to change the loadScript for PostgreSQL database creation file: 
			backupFracc.sql and add the use database name; and replace owner postgres with your user)
	- dbprefix: p246x_ (mandatory prefix for assigning relationship with users privileges on Colonia project)

3) Load database backup modified above for backupFracc.sql with your favorite PostgreSQL IDE (Recommended pgAdmin 4)
4) Unzip Colonia.zip into htdocs folder
5) Change Configuration.php file on Colonia folder with the data for the same Configuration.php file on the Joomla folder. 
	(because it has the database data connection parameters)
6) Create at least 1 user and 1 superuser on Joomla Content manager. 
	You can enter the Administrator section URL in my case was http://localhost:8080/Colonia/Administrator/
7) Install by Upload Package file option when you enter on the top Menu: Extensions / Manager path on Joomla Content Manager.
8) Change the parameters of the database on the LoadCatalog.php file inside Colonia/misphp
9) Test the application and check if missing configuration. You can use the php.ini and httpd.conf files included on the zip distribution to check
	minimal options required or use HelloWorld.php to check if the prerequisites work fine.
	
Enjoy.
