<?php
/**
Description: This program is to insert on postgres database new information of cars related to a House of the Community
@package	FracRB
@subpackage	Settings
@author		Mario González Jiménez
@version	1.0
@license: released under GPL-3.0-or-later
Copyright (C) 2018 Mario González Jiménez.

	AddCar.php is part of the MY WEB APPLICATION COMMUNITY MANAGER
	
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
$licensePlate = htmlspecialchars($_POST['licensePlateF']);
$model = htmlspecialchars($_POST['modelF']);
$idStatus = (int)($_POST['idStatus']);
$idBrand = (int)($_POST['idBrand']);
$idColor = (int)($_POST['idColor']);
$idHouse = (int)($_POST['idHouse']);
$resultStatus = $catalogStatus->addElementCar($licensePlate,$model,$idStatus,$idBrand,$idColor,$idHouse);


 $x = $_SERVER['HTTP_REFERER'];
$url = strtok($x, '?');
header("Location: " . $url);
die();



?>