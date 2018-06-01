<?php
/**
Description: This program is to insert on postgreSQL database new information of the House and the Familiy Owner
@package	FracRB
@subpackage	House
@author		Mario González Jiménez
@version	1.0
@license: released under GPL-3.0-or-later
Copyright (C) 2018 Mario González Jiménez.

	AddHouse.php is part of the MY WEB APPLICATION COMMUNITY MANAGER
	
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

include 'LoadCatalog.php';
include 'Catalog.php';

$catalogStatus = new LoadCatalog;
$family = htmlspecialchars($_POST['familyF']);
$number = htmlspecialchars($_POST['numberF']);
$idFrac = (int)($_POST['idFrac']);
$idStatus = (int)($_POST['idStatus']);
$resultStatus = $catalogStatus->addElementHouse($family,$number,$idFrac,$idStatus);


 $x = $_SERVER['HTTP_REFERER'];
$url = strtok($x, '?');
header("Location: " . $url);
die();



?>