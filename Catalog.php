<?php
/**
Description: This program is to transform the catalog or table from database or a resultset to an specific web component like lists, tables, 
dropdown menus, etc.
@package	FracRB
@subpackage	Catalogs
@author		Mario González Jiménez
@version	1.0
@license: released under GPL-3.0-or-later
Copyright (C) 2018 Mario González Jiménez.

	Catalog.php is part of the MY WEB APPLICATION COMMUNITY MANAGER
	
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

class Catalog {
	var $_result;
	function setResultSet($CatalogResult) {
		$this->_result = $CatalogResult;
	} 
	function getResultSet() {
		return $this->_result;
	}
	
	function showInHtmlTable($tablename) {
		$strRow0 = "";
		$firstcol_Value = 0;
		$num = pg_numrows($this->_result); 
		$col_num = pg_numfields($this->_result); 
		if($num == 0) {
			echo "<p>No hay registros en $tablename</p>";
		}
		$x = $_SERVER['REQUEST_URI'];
		$url = strtok($x, '?');
		
		echo "<table border=\"1\">\n";
		echo "<th colspan=\"100%\" style=\"color:white;text-align:center;background:steelblue;\">$tablename</th>\n";
		for ($i=0; $i<$num; $i++) { 
		  $line  = pg_fetch_array($this->_result, $i, PGSQL_ASSOC); 
		  echo "\t<tr>\n"; 
			for ($j=0; $j<$col_num; $j++){ 
				list($col_name, $col_value) =each($line);
				if($i==0) {

					echo "\t\t<TD style=\"color:blue;text-align:center\">" .strtoupper($col_name) ."</TD>\n"; 
					$strRow0 .= "\t\t<TD ALIGN=CENTER>$col_value</TD>\n";
					if($j==($col_num-1) && !$firstcol_Value && $num==1) {
						echo  "\t</tr>\n\t<tr bgcolor=#ffffff>\n" . $strRow0 ;
						$firstcol_Value = 1;
					}
				} else {

					if($i==1 && !$firstcol_Value) {
						echo $strRow0 . "\t</tr>\n\t<tr bgcolor=#ffffff>\n";
						$firstcol_Value = 1;
					}
					
					echo "\t\t<TD ALIGN=CENTER>$col_value</TD>\n"; 
				}
				
			} 
		  echo "\t</tr>\n"; 
		}
		echo "</table>";
	}
	
	function showExcelDownload($excelName,$type) {
		// Creating a workbook
		$workbook = new Spreadsheet_Excel_Writer();
		
		$format_bold = $workbook->addFormat();
		$format_bold->setBold();
		
		// sending HTTP headers
		$workbook->send($excelName);

		// Creating a worksheet
		$worksheet = $workbook->addWorksheet($type);

		$num = pg_numrows($this->_result); 
		$col_num = pg_numfields($this->_result); 
		for ($i=0; $i<$num; $i++) { 
		  $line  = pg_fetch_array($this->_result, $i, PGSQL_ASSOC); 
			for ($j=0; $j<$col_num; $j++){ 
				list($col_name, $col_value) =each($line);
				if($i==0) {
					$worksheet->write($i, $j,strtoupper($col_name),$format_bold);
					$worksheet->write($i+1, $j, $col_value);
				} else {
					$worksheet->write($i+1, $j, $col_value);
				}
			}
		}
		
		// Let's send the file
		$workbook->close();
	}
	
	function showManagerTable($tablename) {
		$strRow0 = "";
		$firstcol_Value = 0;
		$num = pg_numrows($this->_result); 
		$col_num = pg_numfields($this->_result); 
		if($num == 0) {
			echo "<p>No hay registros en $tablename</p>";
		}
		$x = $_SERVER['REQUEST_URI'];
		$url = strtok($x, '?');
		$urlInArray = explode("/",$url,3);
		$firstCarpet = $urlInArray[1];
		$strHref = "<a href=\"". $url ."?modAct=";
		
		$strImageEdit = "<img src=\"images/fracc_images/Modify.png\" height=\"20\" width=\"20\">";
		$strImageDelete = "<img src=\"images/fracc_images/Delete.png\" height=\"20\" width=\"20\">";
		
		echo "<table border=\"1\">\n";
		echo "<th colspan=\"100%\" style=\"color:white;text-align:center;background:steelblue;\">$tablename</th>\n";
		for ($i=0; $i<$num; $i++) { 
		  $line  = pg_fetch_array($this->_result, $i, PGSQL_ASSOC); 
		  echo "\t<tr>\n"; 
			for ($j=0; $j<$col_num; $j++){ 
				list($col_name, $col_value) =each($line);
				if($i==0) {
					if($j==0) {
						echo "\t\t<TD style=\"color:blue;text-align:center\">EDIT</TD>\n";
						echo "\t\t<TD style=\"color:blue;text-align:center\">DELETE</TD>\n";
						$strRow0 .= "\t\t<TD ALIGN=CENTER>" . $strHref . "2&".$col_name. "=".$col_value."\">$strImageEdit</a></TD>\n";
						$strRow0 .= "\t\t<TD ALIGN=CENTER>" . $strHref . "3&".$col_name. "=".$col_value."\">$strImageDelete</a></TD>\n";
					}
					echo "\t\t<TD style=\"color:blue;text-align:center\">" .strtoupper($col_name) ."</TD>\n"; 
					$strRow0 .= "\t\t<TD ALIGN=CENTER>$col_value</TD>\n";
					if($j==($col_num-1) && !$firstcol_Value && $num==1) {
						echo  "\t</tr>\n\t<tr bgcolor=#ffffff>\n" . $strRow0 ;
						$firstcol_Value = 1;
					}
				} else {

					if($i==1 && !$firstcol_Value) {
						echo $strRow0 . "\t</tr>\n\t<tr bgcolor=#ffffff>\n";
						$firstcol_Value = 1;
					}
					
					if($j==0 && $firstcol_Value) {
						echo "\t\t<TD ALIGN=CENTER>" . $strHref."2&".$col_name. "=".$col_value."\">$strImageEdit</a></TD>\n";
						echo "\t\t<TD ALIGN=CENTER>" . $strHref."3&".$col_name. "=".$col_value."\">$strImageDelete</a></TD>\n";
					}
					echo "\t\t<TD ALIGN=CENTER>$col_value</TD>\n"; 
				}
				
			} 
		  echo "\t</tr>\n"; 
		}
		echo "</table>";
	}
	
	function showDropListFromTable(String $nameList,int $idSelected=null, int $idColumShow=null) {
		$strRow0 = "";
		$firstcol_Value = 0;
		$num = pg_numrows($this->_result); 
		$col_num = pg_numfields($this->_result); 
		if($num == 0) {
			echo "<option value=1>No hay registros</option>";
		}
		if(!$idColumShow) {
			$idColumShow = 1;
		}
		echo "<select name=$nameList>\n";
		for ($i=0; $i<$num; $i++) { 
		  $line  = pg_fetch_array($this->_result, $i, PGSQL_ASSOC); 
			for ($j=0; $j<$col_num; $j++){ 
				list($col_name, $col_value) =each($line);
				if($j==0) {
					if($idSelected == $col_value) {
						echo "<option value=$col_value selected>\n";
					} else {
						echo "<option value=$col_value>\n";
					}
				}
				if($j==$idColumShow) {
					echo "$col_value</option>\n";
				}
			}
		}
		echo "</select>";
	}
	
}
?>