<?php
/**
Description: This program is to Edit the information of the House. 
@package	FracRB
@subpackage	House
@author		Mario González Jiménez
@version	1.0
@license: released under GPL-3.0-or-later
Copyright (C) 2018 Mario González Jiménez.

	EditHouse.php is part of the MY WEB APPLICATION COMMUNITY MANAGER
	
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

//idHouse is supposed to be set before this php.
$catalogHouse = new LoadCatalog;
$resultConcept = $catalogHouse->getElementHouse($idHouse);

$catalogFrac = new LoadCatalog;
$resultUser = $catalogFrac->getFracFromUser($idUser);	
if(pg_numrows($resultUser)>0){
	$idFrac = pg_fetch_result($resultUser,0,1);
	$resultFrac = $catalogFrac->getElementFrac($idFrac);
}
else {
	$resultFrac = $catalogFrac->getCatalog("Frac");
}

$catalogF = new Catalog;
$catalogF->setResultSet($resultFrac);

$catalogStatus = new LoadCatalog;
$resultStatus = $catalogStatus->getCatalog("Status");

$catalog = new Catalog;
$catalog->setResultSet($resultStatus);

$num = pg_numrows($resultConcept); 
$col_num = pg_numfields($resultConcept); 
		if($num == 0) {
			echo "No hay nada que actualizar";
		} else {
			echo "<form name=\"form\" action=\"". JUri::root() . "misphp/UpdateHouse.php\" method=\"post\">\n";
			echo "<input type=\"hidden\" name=\"idHouse\" value=$idHouse>\n";
			for ($i=0; $i<$num; $i++) { 
				$row  = pg_fetch_array($resultConcept, $i, PGSQL_ASSOC); 
				echo "Familia: <input type=\"text\" name=\"familyF\" size=50 maxLength=100 value=\"".$row["Family"]."\">\n";
				echo "Número Casa: <input type =\"text\" name=\"numberF\" size=5 maxLength=5 value=\"".$row["number"]."\">\n";
				//echo "Description: <input type =\"text\" name=\"descriptionF\" size=150 maxLength=250 value=\"".$row["description"]."\">\n";
				$catalogF->showDropListFromTable("idFrac",(int)$row["idFrac"]);
				$catalog->showDropListFromTable("idStatus",(int)$row["idStatus"]);
			}
			echo "<input type=\"Submit\" name=\"Update\" value=\"Actualiza\">\n";
			echo "</form>\n";			
		}












?>