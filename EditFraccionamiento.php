<?php
/**
Description: This program is to Edit the information of the Community name. 
@package	FracRB
@subpackage	Settings
@author		Mario González Jiménez
@version	1.0
@license: released under GPL-3.0-or-later
Copyright (C) 2018 Mario González Jiménez.

	EditFraccionamiento.php is part of the MY WEB APPLICATION COMMUNITY MANAGER
	
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

//idFrac is supposed to be set before this php.
$catalogFrac = new LoadCatalog;
$resultFrac = $catalogFrac->getElementFrac($idFrac);

$catalogStatus = new LoadCatalog;
$resultStatus = $catalogStatus->getCatalog("Country");

$catalog = new Catalog;
$catalog->setResultSet($resultStatus);

$num = pg_numrows($resultFrac); 
$col_num = pg_numfields($resultFrac); 
		if($num == 0) {
			echo "No hay nada que actualizar";
		} else {
			echo "<form name=\"form\" action=\"". JUri::root() . "misphp/UpdateFrac.php\" method=\"post\">\n";
			echo "<input type=\"hidden\" name=\"idFrac\" value=$idFrac>\n";
			for ($i=0; $i<$num; $i++) { 
				$row  = pg_fetch_array($resultFrac, $i, PGSQL_ASSOC); 
				echo "Name: <input type=\"text\" name=\"nombreF\" size=50 maxLength=200 value=\"".$row["name"]."\">\n";
				echo "Address: <input type =\"text\" name=\"addressF\" size=150 maxLength=250 value=\"".$row["address"]."\">\n";
				echo "Zip: <input type =\"text\" name=\"zipF\" size=15 maxLength=15 value=\"".$row["zipCode"]."\">\n";
				$catalog->showDropListFromTable("idCountry",(int)$row["idCountry"]);
			}
			echo "<input type=\"Submit\" name=\"Update\" value=\"Actualiza\">\n";
			echo "</form>\n";			
		}












?>