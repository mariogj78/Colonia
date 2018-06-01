<?php
/**
Description: This program is to generate a list of Cars of the community  
@package	FracRB
@subpackage	Car
@author		Mario González Jiménez
@version	1.0
@license: released under GPL-3.0-or-later
Copyright (C) 2018 Mario González Jiménez.

	ListCars.php is part of the MY WEB APPLICATION COMMUNITY MANAGER
	
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

$user = JFactory::getUser();
$idUser = $user->id;
$idFrac = 0;

$catalogStatus = new LoadCatalog;
$resultUser = $catalogStatus->getFracFromUser($idUser);	
if(pg_numrows($resultUser)>0){
	$idFrac = pg_fetch_result($resultUser,0,1);
	$resultStatus = $catalogStatus->getCatalogCarByFrac($idFrac);
} else {
	$resultStatus = $catalogStatus->getCatalog("Car");
}

$catalog = new Catalog;
$catalog->setResultSet($resultStatus);
$catalog->showManagerTable("Car");
echo "<br>";


?>