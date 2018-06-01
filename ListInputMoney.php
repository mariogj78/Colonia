<?php
/**
Description: This program is to generate a managed list of Incomes. Depends on the filters of the search by default use current year and month
@package	FracRB
@subpackage	Income
@author		Mario González Jiménez
@version	1.0
@license: released under GPL-3.0-or-later
Copyright (C) 2018 Mario González Jiménez.

	ListInputMoney.php is part of the MY WEB APPLICATION COMMUNITY MANAGER
	
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
}

if(!isset($year)) {
	$year = date("Y");
	$month = date("n");
}

if(!isset($month)) {
	if($idFrac > 0) {
		$resultStatus = $catalogStatus->getInputMoney($year,null,$idFrac);
	} else {
		$resultStatus = $catalogStatus->getInputMoney($year);
	}
	
} else {
	if($idFrac > 0) {
		$resultStatus = $catalogStatus->getInputMoney($year,$month,$idFrac);
	} else {
		$resultStatus = $catalogStatus->getInputMoney($year,$month);	
	}
}

if(pg_numrows($resultStatus)>0) {
echo "<form name=\"forma2\" action=\"" . JUri::root() . "misphp/excelFile.php\" method=\"post\">";
echo "<input type=\"hidden\" name=\"year\" value=\"$year\">";
echo "<input type=\"hidden\" name=\"month\" value=\"$month\">";
echo "<input type=\"hidden\" name=\"idFrac\" value=\"$idFrac\">";
echo "<input type=\"submit\" name=\"Excel\" value=\"Excel\">";
echo "</form>";

$catalog = new Catalog;
$catalog->setResultSet($resultStatus);
$catalog->showInHtmlTable("Entradas de Dinero");
}
else {
	echo "<p>No se encontraron resultados</p>\n";
}
echo "<br>";


?>