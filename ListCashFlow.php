<?php
/**
Description: This program is for listing all the cash flow by Frac community and also manage the specific search on the screen.
All programs need to be included in the article corresponded in Joomla content manager to give the design and flexibility of the content manager.
@package	FracRB
@subpackage	Accounting
@author		Mario González Jiménez
@version	1.0
@license: released under GPL-3.0-or-later
Copyright (C) 2018 Mario González Jiménez.

	ListCashFlow.php is part of the MY WEB APPLICATION COMMUNITY MANAGER
	
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

/** To calculate the steps of Starting amount + incomes - expenses = Total amount status
1) First check if there is the Starting amount of the year.
2) If no information on table "SaldoInicial" then go to next step (3) if you have information then go to step (7)
3) Get the max year on the table "SaldoInicial". If no result go to next step (4) else skip to the step (6)
4) Get the minimun year of registries in tables "InputMoney" and "OutputMoney". Take the lower of both tables by Frac
5) Insert this year with 0 on table "SaldoInicial"
6) Make a for iteration from the lower year on SaldoInicial to the current year to fill the SaldoInicial Table until current year.
7) Take the last year on "SaldoInicial" add the sum of the InputMoney table by idFrac and substract the sume of the OutputMoney table by idFrac
8) Show the Total and the value of SaldoInicial of last year and both sum (InputMoney and OutputMoney)
*/

$numStartYear = 0;
$numIncomeYear = 0;
$numExpenseYear = 0;
$numTotalAmount = 0;
$minRegYearIncome = 0;
$minRegYearExpense = 0;
$minRegYear = $year;
$i = 0;
if($idFrac > 0) {
	//Step 1
	$resultStartAmount = $catalogStatus->getCurrentStartingAmount($year,$idFrac);
	//echo "Step 1 <br>\n";
	if(pg_numrows($resultStartAmount)>0) {
		//Step 2
		//echo "Step 2 <br>\n";
		$numStartYear = pg_fetch_result($resultStartAmount,0,1);
	} 
	else {
		$resultMaxYearStartAmount = $catalogStatus->getMaxYearStartAmount($year,$idFrac);
		if(pg_numrows($resultMaxYearStartAmount)>0) {
			//Step 3
			$minRegYear = pg_fetch_result($resultMaxYearStartAmount,0,0);
			if(!$minRegYear) {
				$minRegYear = 0;
			}
			//echo "Step 3: min year $minRegYear <br>\n";
		} 
		if($minRegYear == 0) {
			//Step 4
			//echo "Step 4 <br>\n";
			$resultMinYearIncome = $catalogStatus->getMinYearIncome($idFrac);
			if(pg_numrows($resultMinYearIncome)>0) {
				$minRegYearIncome = pg_fetch_result($resultMinYearIncome,0,0);
			} 
			if($minRegYearIncome == 0) {
				$minRegYearIncome = $year;
			}
			
			//echo "esto es minRegYearIncome: $minRegYearIncome<br>\n";
			$resultMinYearExpense = $catalogStatus->getMinYearExpense($idFrac);
			if(pg_numrows($resultMinYearExpense)>0) {
				$minRegYearExpense = pg_fetch_result($resultMinYearExpense,0,0);
			} 
			if($minRegYearExpense == 0) {
				$minRegYearExpense = $year;
			}
			//echo "esto es minRegYearExpense: $minRegYearExpense<br>\n";
			// compare the minimun year registered between incomes and expenses
			if($minRegYearIncome>$minRegYearExpense) {
				$minRegYear = $minRegYearExpense;
			} else {
				$minRegYear = $minRegYearIncome;
			}
			//echo "step4 after compare $minRegYear<br>\n";
			//Step 5 Add the data on SaldoInicial table with 0 as first value
			$numStartYear = 0;
			//echo "step5 Insert SaldoInicial = $numStartYear<br>\n";
			$resultAddStartAmount = $catalogStatus->addStartAmount($minRegYear,$idFrac,$numStartYear);

		}
		//Step 6 Iteration to actual year
		if($minRegYear < $year) {
			//echo "step 6: iteration <br>\n";
			for($i=$minRegYear;$i<$year;$i++) {
				$resultIncomeYearTmp = $catalogStatus->getTotalIncomes($i,$idFrac);
				if(pg_numrows($resultIncomeYearTmp)>0) {
					$numIncomeYear = pg_fetch_result($resultIncomeYearTmp,0,0);
				} 
				if(!$numIncomeYear){
					$numIncomeYear = 0;
				}
				$resultExpenseYearTmp = $catalogStatus->getTotalExpenses($i,$idFrac);
				if(pg_numrows($resultExpenseYearTmp)>0) {
					$numExpenseYear = pg_fetch_result($resultExpenseYearTmp,0,0);
				} 
				if(!$numExpenseYear) {
					$numExpenseYear = 0;
				}
				$numTotalAmount = $numStartYear + $numIncomeYear - $numExpenseYear;
				$resultAddStartAmount = $catalogStatus->addStartAmount($i+1,$idFrac,$numTotalAmount);
				$numStartYear = $numTotalAmount;
			}
		}
	}
	//echo "step 7: final current <br>\n";
	//Step 7 a
	$resultIncomeYear = $catalogStatus->getTotalIncomes($year,$idFrac);
	if(pg_numrows($resultIncomeYear)>0) {
		$numIncomeYear = pg_fetch_result($resultIncomeYear,0,0);
	}
	//Step 7 b
	$resultExpenseYear = $catalogStatus->getTotalExpenses($year,$idFrac);
	if(pg_numrows($resultExpenseYear)>0) {
		$numExpenseYear = pg_fetch_result($resultExpenseYear,0,0);
	}
	//Step 8
	//echo "step 8: Total <br>\n";
	$numTotalAmount = $numStartYear + $numIncomeYear - $numExpenseYear;
	echo "Año: $year<br>\n";
	echo "Saldo Inicial: $numStartYear <br> Entradas: $numIncomeYear <br> Salidas: $numExpenseYear<br> Total: $numTotalAmount.\n";
} else {
	echo "<p>Solo usuarios con asignación de fraccionamiento pueden ver esta información sensible.</p>";
}


echo "<br>";


?>