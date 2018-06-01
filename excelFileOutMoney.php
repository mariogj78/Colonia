<?php
/**
This program is for listing in Excel file all the outputs of money and also manage the specific search on the screen.
This is call by ListOutputMoney.php
@package	FracRB
@subpackage	Outcome
@author		Mario González Jiménez
@version	1.0
@license: released under GPL-3.0-or-later
Copyright (C) 2018 Mario González Jiménez.

	excelFileOutMoney.php is part of the MY WEB APPLICATION COMMUNITY MANAGER
	
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
	
Spreadsheet license is under  LGPL-2.1-or-later
Spreadsheet_Excel_Writer:  A library for generating Excel Spreadsheets
Copyright (c) 2002-2003 Xavier Noguer xnoguer@rezebra.com
Spreadsheet::WriteExcel module is John McNamara <jmcnamara@cpan.org>
*/

require_once 'LoadCatalog.php';
require_once 'Catalog.php';
require_once 'Spreadsheet/Excel/Writer.php';

$year = $_POST['year'];
$month = $_POST['month'];
$idFrac = $_POST['idFrac'];
$nombreMes = null;

$catalogStatus = new LoadCatalog;

if(!isset($year)) {
	$year = date("Y");
	$month = date("n");
}

if(!isset($month)) {
	if($idFrac > 0) {
		$resultStatus = $catalogStatus->getOutputMoney($year,null,$idFrac);
	} else {
		$resultStatus = $catalogStatus->getOutputMoney($year);
	}
} else {
	if($idFrac > 0) {
		$resultStatus = $catalogStatus->getOutputMoney($year,$month,$idFrac);
	} else {
		$resultStatus = $catalogStatus->getOutputMoney($year,$month);
	}
	if($month > 0) {
		$fecha=date_create("$year-$month-01");
		$nombreMes = "_". date_format($fecha, "M");
	}
}
$catalog = new Catalog;
$catalog->setResultSet($resultStatus);
$catalog->showExcelDownload("Salidas_$year$nombreMes.xls","Salidas");

?>