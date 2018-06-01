<?php
/**
Description: This program is to generate a dropDown list of Users that don't have assigned Community.
@package	FracRB
@subpackage	Settings
@author		Mario González Jiménez
@version	1.0
@license: released under GPL-3.0-or-later
Copyright (C) 2018 Mario González Jiménez.

	ListUsers.php is part of the MY WEB APPLICATION COMMUNITY MANAGER
	
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
*/

require_once 'LoadCatalog.php';
require_once 'Catalog.php';

$missingFrac = 0;
$allUserOk = 0;


$catalogFrac = new LoadCatalog;
$resultFrac = $catalogFrac->getCatalog("Frac");
$catalogFracShow = new Catalog;
$catalogFracShow->setResultSet($resultFrac);

$catalogUserNoFrac = new LoadCatalog;
$resultUserNoFrac =	$catalogUserNoFrac->getCatalogUserNoFrac();
$catalogNoFrac = new Catalog;
$catalogNoFrac->setResultSet($resultUserNoFrac);

if(pg_numrows($resultFrac)>0 && pg_num_rows($resultUserNoFrac)>0) {
	echo "<form name=\"form\" action=\"". JUri::root() . "misphp/AddUserFrac.php\" method=\"post\">\n";
	$catalogNoFrac->showDropListFromTable("idUser",null,2);
	$catalogFracShow->showDropListFromTable("idFrac");
	echo "<input type=\"Submit\" name=\"Agrega\" value=\"Relaciona\">\n";
	echo "</form>\n";			
	
} else if(pg_numrows($resultFrac)==0) {
	$mssingFrac = 1;
} else {
	$allUserOk = 1;
}

// Get the catalog Users from Joomla structure and the relationship with the Frac id on this Webapp.
$catalogUser = new LoadCatalog;
$resultUsers = $catalogUser->getCatalogUserExt();

$catalog = new Catalog;
$catalog->setResultSet($resultUsers);
$catalog->showInHtmlTable("Usuarios");
echo "<br>";


?>