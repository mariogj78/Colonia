<?php
/**
Description: This program is to generate the lists of the Basic Catalogs for the system. The information is given by sql scripts
@package	FracRB
@subpackage	Catalog
@author		Mario González Jiménez
@version	1.0
@license: released under GPL-3.0-or-later
Copyright (C) 2018 Mario González Jiménez.

	ShowCatalog.php is part of the MY WEB APPLICATION COMMUNITY MANAGER
	
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
$resultStatus = $catalogStatus->getCatalog("Status");

$catalogCountry = new LoadCatalog;
$resultCountry = $catalogCountry->getCatalog("Country");

$catalogBrand = new LoadCatalog;
$resultBrand = $catalogBrand->getCatalog("Brand");

$catalogColor = new LoadCatalog;
$resultColor = $catalogColor->getCatalog("Color");

$catalog = new Catalog;
echo "<table border=\"0\">\n";
echo "<tr>\n";
$catalog->setResultSet($resultBrand);
echo "<td valign=\"TOP\" width=\"25%\">\n";
$catalog->showInHtmlTable("Brand");
echo "</td>\n";
$catalog->setResultSet($resultColor);
echo "<td valign=\"TOP\" width=\"25%\">\n";
$catalog->showInHtmlTable("Color");
echo "</td>\n";
$catalog->setResultSet($resultCountry);
echo "<td valign=\"TOP\" width=\"25%\">\n";
$catalog->showInHtmlTable("Country");
echo "</td>\n";
$catalog->setResultSet($resultStatus);
echo "<td valign=\"TOP\" width=\"25%\">\n";
$catalog->showInHtmlTable("Status");
echo "</td>\n";
echo "</tr>\n";
echo "</table>\n";

?>