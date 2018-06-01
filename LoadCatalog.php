<?php
/**
Description: This program is to generate a the inserts, deletes, updates and selects of the information structured in a database tables and relations
Need improvement to ofuscate or hide the user and password data :)
@package	FracRB
@subpackage	Catalog
@author		Mario González Jiménez
@version	1.0
@license: released under GPL-3.0-or-later
Copyright (C) 2018 Mario González Jiménez.

	LoadCatalog.php is part of the MY WEB APPLICATION COMMUNITY MANAGER
	
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

class LoadCatalog {
	var $_appName;
	var $_strinConn;
	var $_host="localhost";
	var $_port="5432";
	var $_dbname="fraccionamiento";
	var $_user="postgres";
	var $_password="oiramg2007";
	
	
	/** Get Connection string */
	function getStringConn($appName) {
		$this->_strinConn = "host=" . $this->_host . " port=".$this->_port." dbname=".$this->_dbname." user=".$this->_user." password=".$this->_password." options='--application_name=$appName'";
		return $this->_strinConn;
	}
	
	/** Get Catalog */
	function getCatalog(String $table){
		$this->_appName = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];	
		$conn = pg_connect($this->getStringConn($this->_appName));

		if (!$conn) {
		  echo "No se pudo conectar.\n";
		  exit;
		}

		$result = pg_query($conn, "SELECT * FROM public.\"$table\"");
		echo pg_last_error($conn);
		if (!$result) {
		  echo "resultado con error.\n";
		  exit;
		}
		return $result;
	}

	
	/** Get Catalog Houses by Frac */
	function getCatalogHouseByFrac(int $idFrac){
		$this->_appName = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];	
		$conn = pg_connect($this->getStringConn($this->_appName));

		if (!$conn) {
		  echo "No se pudo conectar.\n";
		  exit;
		}

		$result = pg_query($conn, "SELECT * FROM public.\"House\" where \"idFrac\"=$idFrac");
		echo pg_last_error($conn);
		if (!$result) {
		  echo "resultado con error.\n";
		  exit;
		}
		return $result;
	}
	
	/** Get Catalog Cars by Frac */
	function getCatalogCarByFrac(int $idFrac){
		$this->_appName = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];	
		$conn = pg_connect($this->getStringConn($this->_appName));

		if (!$conn) {
		  echo "No se pudo conectar.\n";
		  exit;
		}
		$query = "Select public.\"Car\".* from public.\"Car\"
 inner join public.\"House\" on public.\"House\".\"idHouse\" = public.\"Car\".\"idHouse\"
 where public.\"House\".\"idFrac\" = $idFrac";
		$result = pg_query($conn, $query);
		echo pg_last_error($conn);
		if (!$result) {
		  echo "resultado con error.\n";
		  exit;
		}
		return $result;
	}

	/** Get FracFromUser */
	function getFracFromUser(int $idUser){
		$this->_appName = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];	
		$conn = pg_connect($this->getStringConn($this->_appName));

		if (!$conn) {
		  echo "No se pudo conectar.\n";
		  exit;
		}

		$result = pg_query($conn, "SELECT * FROM public.\"User\" where \"idUser\"=$idUser");
		echo pg_last_error($conn);
		if (!$result) {
		  echo "resultado con error.\n";
		  exit;
		}
		return $result;
	}
	
	/** Get CatalogUserExtended */
	function getCatalogUserExt(){
		$this->_appName = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];	
		$conn = pg_connect($this->getStringConn($this->_appName));

		if (!$conn) {
		  echo "No se pudo conectar.\n";
		  exit;
		}
		$query = "Select public.\"p246x_users\".\"id\", public.\"p246x_users\".\"name\",
 public.\"p246x_users\".\"username\",
 public.\"p246x_users\".\"email\", 
 public.\"p246x_users\".\"registerDate\",
 public.\"p246x_users\".\"lastvisitDate\",
 public.\"User\".\"idFrac\"
 from public.\"p246x_users\"
 left join public.\"User\" on public.\"User\".\"idUser\" = public.\"p246x_users\".\"id\"";
		
		$result = pg_query($conn, $query);
		echo pg_last_error($conn);
		if (!$result) {
		  echo "resultado con error.\n";
		  exit;
		}
		return $result;
	}
	
	/** Get CatalogUserExtended Without idFrac*/
	function getCatalogUserNoFrac(){
		$this->_appName = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];	
		$conn = pg_connect($this->getStringConn($this->_appName));

		if (!$conn) {
		  echo "No se pudo conectar.\n";
		  exit;
		}
		$query = "Select public.\"p246x_users\".\"id\", public.\"p246x_users\".\"name\",
 public.\"p246x_users\".\"username\",
 public.\"p246x_users\".\"email\", 
 public.\"p246x_users\".\"registerDate\",
 public.\"p246x_users\".\"lastvisitDate\",
 public.\"User\".\"idFrac\"
 from public.\"p246x_users\"
 left join public.\"User\" on public.\"User\".\"idUser\" = public.\"p246x_users\".\"id\"
 where public.\"User\".\"idFrac\" is null
 ";
		
		$result = pg_query($conn, $query);
		echo pg_last_error($conn);
		if (!$result) {
		  echo "resultado con error.\n";
		  exit;
		}
		return $result;
	}
	
	/** Add User Frac relation */
	function addUserFrac($idUser,$idFrac) {
		$this->_appName = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];	
		$conn = pg_connect($this->getStringConn($this->_appName));
		
		if (!$conn) {
		  echo "No se pudo conectar.\n";
		  exit;
		}

		$query = "insert into public.\"User\" (\"idUser\",\"idFrac\") values($idUser,$idFrac);";
		$result = pg_query($conn, $query);
		echo pg_last_error($conn);
		if (!$result) {
		  echo "resultado con error.\n";
		  exit;
		}
	}
	
	/** Get InputMoney */
	function getInputMoney(int $year,int $month=null, int $idFrac=null){
		$this->_appName = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];	
		$conn = pg_connect($this->getStringConn($this->_appName));

		if (!$conn) {
		  echo "No se pudo conectar.\n";
		  exit;
		}
		
		$strqueryMonth = "";
		$strAndFrac = "";
		
		if(isset($month)) {
			if($month > 0) {
				$strqueryMonth = " and extract(month from \"InputMoney\".\"date\") =  $month";
			}
		}
		
		if(isset($idFrac)) {
			if($idFrac > 0) {
				$strAndFrac = " and \"House\".\"idFrac\" = $idFrac ";
			}
		}
		
		$query = "Select \"InputMoney\".\"date\" as \"Fecha\", \"House\".\"number\" as \"Numero de Casa\",\"Concept\".\"name\" as \"Concepto\",
 \"InputMoney\".\"value\"::numeric as \"Cantidad\", \"p246x_users\".\"username\" as \"Registrado Por\", \"Frac\".\"name\" as \"Fraccionamiento\"
 From \"InputMoney\"
 Inner join \"House\" on \"House\".\"idHouse\" = \"InputMoney\".\"idHouse\"
 Inner join \"Concept\" on \"Concept\".\"idConcept\" = \"InputMoney\".\"idConcept\"
 left join \"p246x_users\" on \"p246x_users\".\"id\" = \"InputMoney\".\"idUser\"
 left join \"Frac\" on \"Frac\".\"idFrac\" = \"House\".\"idFrac\"
 where extract(year from \"InputMoney\".\"date\") =  $year
 $strqueryMonth 
 $strAndFrac
 order by \"InputMoney\".\"date\" asc;";
 
		//echo "$query";
		$result = pg_query($conn, $query);
		echo pg_last_error($conn);
		if (!$result) {
		  echo "resultado con error.\n";
		  exit;
		}
		return $result;
	}
	
	/** Get OutputMoney */
	function getOutputMoney(int $year,int $month=null,int $idFrac=null){
		$this->_appName = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];	
		$conn = pg_connect($this->getStringConn($this->_appName));

		if (!$conn) {
		  echo "No se pudo conectar.\n";
		  exit;
		}
		
		$strqueryMonth = "";
		$strAndFrac = "";
		
		if(isset($month)) {
			if($month > 0) {
				$strqueryMonth = " and extract(month from \"OutputMoney\".\"date\") =  $month";
			}
		}
		
		if(isset($idFrac)) {
			if($idFrac > 0) {
				$strAndFrac = " and \"OutputMoney\".\"idFrac\" = $idFrac ";
			}
		}
		
		$query = "Select \"OutputMoney\".\"date\" as \"Fecha\", \"Supplier\".\"name\" as \"Proveedor\",\"Concept\".\"name\" as \"Concepto\",
 \"OutputMoney\".\"value\"::numeric as \"Cantidad\", \"p246x_users\".\"username\" as \"Registrado Por\", \"Frac\".\"name\" as \"Fraccionamiento\"
 From \"OutputMoney\"
 Inner join \"Supplier\" on \"Supplier\".\"idSupplier\" = \"OutputMoney\".\"idSupplier\"
 Inner join \"Concept\" on \"Concept\".\"idConcept\" = \"OutputMoney\".\"idConcept\"
 left join \"p246x_users\" on \"p246x_users\".\"id\" = \"OutputMoney\".\"idUser\"
 left join \"Frac\" on \"Frac\".\"idFrac\" = \"OutputMoney\".\"idFrac\"
 where extract(year from \"OutputMoney\".\"date\") = $year
 $strqueryMonth
 $strAndFrac
 order by \"OutputMoney\".\"date\" asc;";
 
		//echo "$query";
		$result = pg_query($conn, $query);
		echo pg_last_error($conn);
		if (!$result) {
		  echo "resultado con error.\n";
		  exit;
		}
		return $result;
	}

	/** Get StartingAmount */
	function getCurrentStartingAmount(int $year,int $idFrac){
		$this->_appName = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];	
		$conn = pg_connect($this->getStringConn($this->_appName));

		if (!$conn) {
		  echo "No se pudo conectar.\n";
		  exit;
		}
		
	
		$query = "Select public.\"SaldoInicial\".\"period\", public.\"SaldoInicial\".\"amount\"::numeric, public.\"SaldoInicial\".\"idFrac\" 
		from public.\"SaldoInicial\" where public.\"SaldoInicial\".\"period\"=$year and public.\"SaldoInicial\".\"idFrac\" = $idFrac;";
 
		//echo "$query";
		$result = pg_query($conn, $query);
		echo pg_last_error($conn);
		if (!$result) {
		  echo "resultado con error.\n";
		  exit;
		}
		return $result;
	}
	
	/** Get Total Income in current year by Frac */
	function getTotalIncomes(int $year,int $idFrac){
		$this->_appName = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];	
		$conn = pg_connect($this->getStringConn($this->_appName));

		if (!$conn) {
		  echo "No se pudo conectar.\n";
		  exit;
		}
		
	
		$query = "Select sum(public.\"InputMoney\".\"value\")::numeric as \"Incomes\"
 from public.\"InputMoney\" 
 inner join public.\"House\" on public.\"House\".\"idHouse\" = public.\"InputMoney\".\"idHouse\"
 where extract(year FROM public.\"InputMoney\".\"date\") = $year
 and public.\"House\".\"idFrac\" = $idFrac;";
 
		//echo "$query";
		$result = pg_query($conn, $query);
		echo pg_last_error($conn);
		if (!$result) {
		  echo "resultado con error.\n";
		  exit;
		}
		return $result;
	}

	/** Get Total Expense in current year by Frac */
	function getTotalExpenses(int $year,int $idFrac){
		$this->_appName = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];	
		$conn = pg_connect($this->getStringConn($this->_appName));

		if (!$conn) {
		  echo "No se pudo conectar.\n";
		  exit;
		}
		
	
		$query = "Select sum(public.\"OutputMoney\".\"value\")::numeric as \"Expenses\"
 from public.\"OutputMoney\" 
 where extract(year FROM public.\"OutputMoney\".\"date\") = $year
 and public.\"OutputMoney\".\"idFrac\" = $idFrac;";
 
		//echo "$query";
		$result = pg_query($conn, $query);
		echo pg_last_error($conn);
		if (!$result) {
		  echo "resultado con error.\n";
		  exit;
		}
		return $result;
	}

	/** Get getMaxYearStartAmount */
	function getMaxYearStartAmount(int $year,int $idFrac){
		$this->_appName = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];	
		$conn = pg_connect($this->getStringConn($this->_appName));

		if (!$conn) {
		  echo "No se pudo conectar.\n";
		  exit;
		}

		$query = "Select max(period) as \"MaxRegYear\" from public.\"SaldoInicial\" 
 where public.\"SaldoInicial\".\"period\"=$year and public.\"SaldoInicial\".\"idFrac\" = $idFrac;";
		//echo $query;
		$result = pg_query($conn, $query);
		echo pg_last_error($conn);
		if (!$result) {
		  echo "resultado con error.\n";
		  exit;
		}
		return $result;
	}
	
	/** Get getMinYearIncome */
	function getMinYearIncome(int $idFrac){
		$this->_appName = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];	
		$conn = pg_connect($this->getStringConn($this->_appName));

		if (!$conn) {
		  echo "No se pudo conectar.\n";
		  exit;
		}

		$query = "Select extract(year from min(public.\"InputMoney\".\"date\")) as \"MinRegYear\"
 from public.\"InputMoney\" 
 inner join public.\"House\" on public.\"House\".\"idHouse\" = public.\"InputMoney\".\"idHouse\"
 where public.\"House\".\"idFrac\" = $idFrac;";
		//echo $query;
		$result = pg_query($conn, $query);
		echo pg_last_error($conn);
		if (!$result) {
		  echo "resultado con error.\n";
		  exit;
		}
		return $result;
	}
	
	/** Get getMinYearExpense */
	function getMinYearExpense(int $idFrac){
		$this->_appName = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];	
		$conn = pg_connect($this->getStringConn($this->_appName));

		if (!$conn) {
		  echo "No se pudo conectar.\n";
		  exit;
		}

		$query = "Select extract(year from min(public.\"OutputMoney\".\"date\")) as \"MinRegYear\"
 from public.\"OutputMoney\" 
 where public.\"OutputMoney\".\"idFrac\" = $idFrac;";
 
		$result = pg_query($conn, $query);
		echo pg_last_error($conn);
		if (!$result) {
		  echo "resultado con error.\n";
		  exit;
		}
		return $result;
	}

	/** Add addStartAmount **/
	function addStartAmount(int $year,int $idFrac,int $value) {
		$this->_appName = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];	
		$conn = pg_connect($this->getStringConn($this->_appName));
		
		if (!$conn) {
		  echo "No se pudo conectar.\n";
		  exit;
		}

		$query = "insert into public.\"SaldoInicial\" (\"period\",\"amount\",\"idFrac\") values($year,$value,$idFrac);";
		$result = pg_query($conn, $query);
		echo pg_last_error($conn);
		if (!$result) {
		  echo "resultado con error.\n";
		  exit;
		}
	}
	
	/** Add Frac */
	function addElementFrac($name,$address,$zip,$idCountry) {
		$this->_appName = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];	
		$conn = pg_connect($this->getStringConn($this->_appName));
		
		if (!$conn) {
		  echo "No se pudo conectar.\n";
		  exit;
		}

		$query = "insert into public.\"Frac\" (\"name\",\"address\",\"zipCode\",\"idCountry\") values('$name','$address','$zip',$idCountry);";
		$result = pg_query($conn, $query);
		echo pg_last_error($conn);
		if (!$result) {
		  echo "resultado con error.\n";
		  exit;
		}
	}
	
	/** Delete Frac */
	function delElementFrac($idFrac) {
		$this->_appName = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];	
		$conn = pg_connect($this->getStringConn($this->_appName));
		
		if (!$conn) {
		  echo "No se pudo conectar.\n";
		  exit;
		}

		$query = "delete from public.\"Frac\" where \"idFrac\"=$idFrac;";
		$result = pg_query($conn, $query);
		echo pg_last_error($conn);
		if (!$result) {
		  echo "resultado con error.\n";
		  exit;
		}
	}
	
	/** Get Frac */
	function getElementFrac(int $idFrac){
		$this->_appName = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];	
		$conn = pg_connect($this->getStringConn($this->_appName));

		if (!$conn) {
		  echo "No se pudo conectar.\n";
		  exit;
		}

		$result = pg_query($conn, "SELECT * FROM public.\"Frac\" WHERE \"idFrac\"=$idFrac;");
		echo pg_last_error($conn);
		if (!$result) {
		  echo "resultado con error.\n";
		  exit;
		}
		return $result;
	}
	
	/** Update Frac */
	function updateElementFrac(int $idFrac,$name,$address,$zipCode,int $idCountry) {
		$this->_appName = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];	
		$conn = pg_connect($this->getStringConn($this->_appName));
		
		if (!$conn) {
		  echo "No se pudo conectar.\n";
		  exit;
		}

		$query = "Update public.\"Frac\" set \"name\"='$name', \"address\"='$address', \"zipCode\"='$zipCode',\"idCountry\"=$idCountry  where \"idFrac\"=$idFrac;";
		$result = pg_query($conn, $query);
		echo pg_last_error($conn);
		if (!$result) {
		  echo "resultado con error.\n";
		  exit;
		}
	}	
	
	/** Add Concept **/
	function addElementConcept($name,$description,$idStatus) {
		$this->_appName = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];	
		$conn = pg_connect($this->getStringConn($this->_appName));
		
		if (!$conn) {
		  echo "No se pudo conectar.\n";
		  exit;
		}

		$query = "insert into public.\"Concept\" (\"name\",\"description\",\"idStatus\") values('$name','$description',$idStatus);";
		$result = pg_query($conn, $query);
		echo pg_last_error($conn);
		if (!$result) {
		  echo "resultado con error.\n";
		  exit;
		}
	}

	/** Get Concept */
	function getElementConcept(int $idConcept){
		$this->_appName = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];	
		$conn = pg_connect($this->getStringConn($this->_appName));

		if (!$conn) {
		  echo "No se pudo conectar.\n";
		  exit;
		}

		$result = pg_query($conn, "SELECT * FROM public.\"Concept\" WHERE \"idConcept\"=$idConcept;");
		echo pg_last_error($conn);
		if (!$result) {
		  echo "resultado con error.\n";
		  exit;
		}
		return $result;
	}
	
	/** Update Concept */
	function updateElementConcept(int $idConcept,$name,$description,int $idStatus) {
		$this->_appName = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];	
		$conn = pg_connect($this->getStringConn($this->_appName));
		
		if (!$conn) {
		  echo "No se pudo conectar.\n";
		  exit;
		}

		$query = "Update public.\"Concept\" set \"name\"='$name', \"description\"='$description', \"idStatus\"=$idStatus  where \"idConcept\"=$idConcept;";
		$result = pg_query($conn, $query);
		echo pg_last_error($conn);
		if (!$result) {
		  echo "resultado con error.\n";
		  exit;
		}
	}
	
	/** Delete Concept */
	function delElementConcept($idConcept) {
		$this->_appName = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];	
		$conn = pg_connect($this->getStringConn($this->_appName));
		
		if (!$conn) {
		  echo "No se pudo conectar.\n";
		  exit;
		}

		$query = "delete from public.\"Concept\" where \"idConcept\"=$idConcept;";
		$result = pg_query($conn, $query);
		echo pg_last_error($conn);
		if (!$result) {
		  echo "resultado con error.\n";
		  exit;
		}
	}

	/** Add Supplier **/
	function addElementSupplier($name,$idStatus) {
		$this->_appName = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];	
		$conn = pg_connect($this->getStringConn($this->_appName));
		
		if (!$conn) {
		  echo "No se pudo conectar.\n";
		  exit;
		}

		$query = "insert into public.\"Supplier\" (\"name\",\"idStatus\") values('$name',$idStatus);";
		$result = pg_query($conn, $query);
		echo pg_last_error($conn);
		if (!$result) {
		  echo "resultado con error.\n";
		  exit;
		}
	}
	
	/** Get Supplier */
	function getElementSupplier(int $idSupplier){
		$this->_appName = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];	
		$conn = pg_connect($this->getStringConn($this->_appName));

		if (!$conn) {
		  echo "No se pudo conectar.\n";
		  exit;
		}

		$result = pg_query($conn, "SELECT * FROM public.\"Supplier\" WHERE \"idSupplier\"=$idSupplier;");
		echo pg_last_error($conn);
		if (!$result) {
		  echo "resultado con error.\n";
		  exit;
		}
		return $result;
	}
	
	/** Update Supplier */
	function updateElementSupplier(int $idSupplier,$name,int $idStatus) {
		$this->_appName = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];	
		$conn = pg_connect($this->getStringConn($this->_appName));
		
		if (!$conn) {
		  echo "No se pudo conectar.\n";
		  exit;
		}

		$query = "Update public.\"Supplier\" set \"name\"='$name', \"idStatus\"=$idStatus  where \"idSupplier\"=$idSupplier;";
		$result = pg_query($conn, $query);
		echo pg_last_error($conn);
		if (!$result) {
		  echo "resultado con error.\n";
		  exit;
		}
	}	
	
	/** Delete Supplier */
	function delElementSupplier($idSupplier) {
		$this->_appName = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];	
		$conn = pg_connect($this->getStringConn($this->_appName));
		
		if (!$conn) {
		  echo "No se pudo conectar.\n";
		  exit;
		}

		$query = "delete from public.\"Supplier\" where \"idSupplier\"=$idSupplier;";
		$result = pg_query($conn, $query);
		echo pg_last_error($conn);
		if (!$result) {
		  echo "resultado con error.\n";
		  exit;
		}
	}
	
	/** Add House **/
	function addElementHouse($family,$number,$idFrac,$idStatus) {
		$this->_appName = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];	
		$conn = pg_connect($this->getStringConn($this->_appName));
		
		if (!$conn) {
		  echo "No se pudo conectar.\n";
		  exit;
		}

		$query = "insert into public.\"House\" (\"Family\",\"number\",\"idFrac\",\"idStatus\") values('$family','$number',$idFrac,$idStatus);";
		$result = pg_query($conn, $query);
		echo pg_last_error($conn);
		if (!$result) {
		  echo "resultado con error.\n";
		  exit;
		}
	}
	
	/** Get House */
	function getElementHouse(int $idHouse){
		$this->_appName = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];	
		$conn = pg_connect($this->getStringConn($this->_appName));

		if (!$conn) {
		  echo "No se pudo conectar.\n";
		  exit;
		}

		$result = pg_query($conn, "SELECT * FROM public.\"House\" WHERE \"idHouse\"=$idHouse;");
		echo pg_last_error($conn);
		if (!$result) {
		  echo "resultado con error.\n";
		  exit;
		}
		return $result;
	}
	
	/** Get House by Number */
	function getElementHouseByNumber($number,int $idFrac = null){
		$this->_appName = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];	
		$conn = pg_connect($this->getStringConn($this->_appName));
		$strQueryFrac = "";
		if (!$conn) {
		  echo "No se pudo conectar.\n";
		  exit;
		}
		
		if($idFrac > 0) {
			$strQueryFrac = " and \"idFrac\"=$idFrac";
		}
		
		$query = "SELECT * FROM public.\"House\" WHERE \"number\"='$number' $strQueryFrac;";
		$result = pg_query($conn, $query);
		echo pg_last_error($conn);
		if (!$result) {
		  echo "resultado con error.\n";
		  exit;
		}
		return $result;
	}
	
	/** Update House */
	function updateElementHouse(int $idHouse,$family,$number,int $idFrac,int $idStatus) {
		$this->_appName = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];	
		$conn = pg_connect($this->getStringConn($this->_appName));
		
		if (!$conn) {
		  echo "No se pudo conectar.\n";
		  exit;
		}

		$query = "Update public.\"House\" set \"Family\"='$family', \"number\"=$number, \"idFrac\"=$idFrac, \"idStatus\"=$idStatus  where \"idHouse\"=$idHouse;";
		$result = pg_query($conn, $query);
		echo pg_last_error($conn);
		if (!$result) {
		  echo "resultado con error.\n";
		  exit;
		}
	}	
	
	/** Delete House */
	function delElementHouse($idHouse) {
		$this->_appName = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];	
		$conn = pg_connect($this->getStringConn($this->_appName));
		
		if (!$conn) {
		  echo "No se pudo conectar.\n";
		  exit;
		}

		$query = "delete from public.\"House\" where \"idHouse\"=$idHouse;";
		$result = pg_query($conn, $query);
		echo pg_last_error($conn);
		if (!$result) {
		  echo "resultado con error.\n";
		  exit;
		}
	}
	
	/** Add Car **/
	function addElementCar($licensePlate,$model,$idStatus,$idBrand,$idColor,$idHouse) {
		$this->_appName = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];	
		$conn = pg_connect($this->getStringConn($this->_appName));
		
		if (!$conn) {
		  echo "No se pudo conectar.\n";
		  exit;
		}

		$query = "insert into public.\"Car\" (\"licensePlate\",\"model\",\"idStatus\",\"idBrand\",\"idColor\",\"idHouse\") values('$licensePlate','$model',$idStatus,$idBrand,$idColor,$idHouse);";
		$result = pg_query($conn, $query);
		echo pg_last_error($conn);
		if (!$result) {
		  echo "resultado con error.\n";
		  exit;
		}
	}

	/** Get Car */
	function getElementCar(int $idCar){
		$this->_appName = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];	
		$conn = pg_connect($this->getStringConn($this->_appName));

		if (!$conn) {
		  echo "No se pudo conectar.\n";
		  exit;
		}

		$result = pg_query($conn, "SELECT * FROM public.\"Car\" WHERE \"idCar\"=$idCar;");
		echo pg_last_error($conn);
		if (!$result) {
		  echo "resultado con error.\n";
		  exit;
		}
		return $result;
	}

	/** Update Car */
	function updateElementCar(int $idCar,$licensePlate,$model,int $idStatus,int $idBrand,int $idColor,int $idHouse) {
		$this->_appName = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];	
		$conn = pg_connect($this->getStringConn($this->_appName));
		
		if (!$conn) {
		  echo "No se pudo conectar.\n";
		  exit;
		}

		$query = "Update public.\"Car\" set \"licensePlate\"='$licensePlate', \"model\"='$model', \"idStatus\"=$idStatus, \"idBrand\"=$idBrand, \"idColor\"=$idColor, \"idHouse\"=$idHouse  where \"idCar\"=$idCar;";
		$result = pg_query($conn, $query);
		echo pg_last_error($conn);
		if (!$result) {
		  echo "resultado con error.\n";
		  exit;
		}
	}

	/** Delete Car */
	function delElementCar($idCar) {
		$this->_appName = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];	
		$conn = pg_connect($this->getStringConn($this->_appName));
		
		if (!$conn) {
		  echo "No se pudo conectar.\n";
		  exit;
		}

		$query = "delete from public.\"Car\" where \"idCar\"=$idCar;";
		$result = pg_query($conn, $query);
		echo pg_last_error($conn);
		if (!$result) {
		  echo "resultado con error.\n";
		  exit;
		}
	}

	/** Add InputMoney **/
	function addElementInputMoney($value,$idHouse,$idConcept,$idUser) {
		$this->_appName = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];	
		$conn = pg_connect($this->getStringConn($this->_appName));
		
		if (!$conn) {
		  echo "No se pudo conectar.\n";
		  exit;
		}

		$query = "insert into public.\"InputMoney\" (\"value\",\"date\",\"idHouse\",\"idConcept\",\"idUser\") values($value,now(),$idHouse,$idConcept,$idUser);";
		$result = pg_query($conn, $query);
		echo pg_last_error($conn);
		if (!$result) {
		  echo "resultado con error.\n";
		  exit;
		}
	}
	
	/** Add OutputMoney **/
	function addElementOutputMoney($value,$idSupplier,$idConcept,$idUser,int $idFrac) {
		$this->_appName = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];	
		$conn = pg_connect($this->getStringConn($this->_appName));
		
		if (!$conn) {
		  echo "No se pudo conectar.\n";
		  exit;
		}

		$query = "insert into public.\"OutputMoney\" (\"value\",\"date\",\"idConcept\",\"idUser\",\"idSupplier\",\"idFrac\") values($value,now(),$idConcept,$idUser,$idSupplier,$idFrac);";
		$result = pg_query($conn, $query);
		echo pg_last_error($conn);
		if (!$result) {
		  echo "resultado con error.\n";
		  exit;
		}
	}
}
?>