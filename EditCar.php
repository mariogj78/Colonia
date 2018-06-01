<?php
/**
Description: This program is to Edit the information of the Cars. 
@package	FracRB
@subpackage	Car
@author		Mario González Jiménez
@version	1.0
@license: released under GPL-3.0-or-later
Copyright (C) 2018 Mario González Jiménez.

	EditCar.php is part of the MY WEB APPLICATION COMMUNITY MANAGER
	
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

//idCar is supposed to be set before this php.
$catalogCar = new LoadCatalog;
$resultCar = $catalogCar->getElementCar($idCar);


/** Catalog Status */
$catalogStatus = new LoadCatalog;
$resultStatus = $catalogStatus->getCatalog("Status");

$catalog = new Catalog;
$catalog->setResultSet($resultStatus);

/** Catalog Brand */
$catalogBrand = new LoadCatalog;
$resultBrand = $catalogBrand->getCatalog("Brand");

$catalogB = new Catalog;
$catalogB->setResultSet($resultBrand);

/** Catalog Color */
$catalogColor = new LoadCatalog;
$resultColor = $catalogColor->getCatalog("Color");

$catalogC = new Catalog;
$catalogC->setResultSet($resultColor);

/** Catalog House */
$catalogHouse = new LoadCatalog;
$resultUser = $catalogHouse->getFracFromUser($idUser);	
if(pg_numrows($resultUser)>0){
	$idFrac = pg_fetch_result($resultUser,0,1);
	$resultHouse = $catalogHouse->getCatalogHouseByFrac($idFrac);
} else {
	$resultHouse = $catalogHouse->getCatalog("House");
}
$catalogH = new Catalog;
$catalogH->setResultSet($resultHouse);


$num = pg_numrows($resultCar); 
$col_num = pg_numfields($resultCar); 
		if($num == 0) {
			echo "No hay nada que actualizar";
		} else {
			echo "<form name=\"form\" action=\"". JUri::root() . "misphp/UpdateCar.php\" method=\"post\">\n";
			echo "<input type=\"hidden\" name=\"idCar\" value=$idCar>\n";
			for ($i=0; $i<$num; $i++) { 
				$row  = pg_fetch_array($resultCar, $i, PGSQL_ASSOC); 
				echo "Placa: <input type=\"text\" name=\"licensePlateF\" size=10 maxLength=10 value=\"".$row["licensePlate"]."\">\n";
				echo "Modelo: <input type =\"text\" name=\"modelF\" size=100 maxLength=100 value=\"".$row["model"]."\">\n";
				echo "Status:\n";
				$catalog->showDropListFromTable("idStatus",(int)$row["idStatus"]);
				echo "Marca:\n";
				$catalogB->showDropListFromTable("idBrand",(int)$row["idBrand"]);
				echo "<br>Color:\n";
				$catalogC->showDropListFromTable("idColor",(int)$row["idColor"]);
				echo "Casa:\n";
				$catalogH->showDropListFromTable("idHouse",(int)$row["idHouse"],2);
			}
			echo "<input type=\"Submit\" name=\"Update\" value=\"Actualiza\">\n";
			echo "</form>\n";			
		}












?>