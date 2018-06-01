<?php
/**
Description: This program is to insert on postgreSQL database new information of Income on the community by the Families living there.
@package	FracRB
@subpackage	Income
@author		Mario González Jiménez
@version	1.0
@license: released under GPL-3.0-or-later
Copyright (C) 2018 Mario González Jiménez.

	AddInputMoney.php is part of the MY WEB APPLICATION COMMUNITY MANAGER
	
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

$value = floatval($_POST['valueF']);
$number = htmlspecialchars($_POST['numberF']);
$idConcept = (int)($_POST['idConcept']);
$idUser = (int)($_POST['idUser']);

$resultUser = $catalogStatus->getFracFromUser($idUser);	
if(pg_numrows($resultUser)>0){
	$idFrac = pg_fetch_result($resultUser,0,1);
	$resultTmp = $catalogStatus->getElementHouseByNumber($number,$idFrac);
}
else {
	$resultTmp = $catalogStatus->getElementHouseByNumber($number);
}
$num = pg_numrows($resultTmp); 
$col_num = pg_numfields($resultTmp);
$idHouse = 0;
$error = false;
if($num >0) {
	for ($i=0; $i<$num; $i++) { 
		  $line  = pg_fetch_array($resultTmp, $i, PGSQL_ASSOC); 
			for ($j=0; $j<$col_num; $j++){ 
				list($col_name, $col_value) =each($line);
				if($i==0 && $j==0) {
					$idHouse = $col_value;
				}
			}
	}
	$resultStatus = $catalogStatus->addElementInputMoney($value,$idHouse,$idConcept,$idUser);
} else {
	$error = true;
}

$x = $_SERVER['HTTP_REFERER'];
$url = strtok($x, '?');
If($error) {
	header("Location: " . $url."?modStatus=2");
}  else {
	header("Location: " . $url."?modStatus=1");	
}
die();



?>