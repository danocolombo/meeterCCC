<?php
require_once('authenticate.php'); /* for security purposes */
/*
 * AdMain.php
 * ======================================================
 * this uses pageHead.txt, pageTop.txt & pageBottom.txt
 */

require_once("classPage.php");

$page = new Page();
print $page->getTop();
print <<<EOF

<div id="mainContent" style="padding:15px;"><center>
<h2>Admin Menu</h2>
This is the listing of current features and reports, grouped in categories: 
To get specific information not provided in the reports below, contact Dano<br/><br/>
<hr/>
<h1>Ministry Definition</h1>
<table border='2'><tr><td>
<table id='reporttable'>
<tr>
    <td id='reportcell'><a style='text-decoration:none;' href='teams.php?Action=adminDisplayTeams'>Teams</td>
    <td id='reportcell'><a style='text-decoration:none;' href='reports.php?Report=PrayerInterest'>Random</td>
    <!-- <td id='reportcell'><a style='text-decoration:none;' href='reports.php?Report=NewcomersInterest'>Newcomers (101)</td> -->
</tr>

</table>
</td></tr></table>
<!--
<hr/>
<h1>The Numbers...</h1>
<table border='2'><tr><td>
<table id='reporttable'>
<tr>
    <td id='reportcell'><a style='text-decoration:none;' href='reports.php?Report=MealCnt'>Meal</td>
    <td id='reportcell'><a style='text-decoration:none;' href='reports.php?Report=NurseryCnt'>Nursery</td>
    <td id='reportcell'><a style='text-decoration:none;' href='reports.php?Report=101Cnt'>Newcomers (101)</td>
</tr>
<tr>
    <td id='reportcell'><a style='text-decoration:none;' href='reports.php?Report=CSCnt'>Celebration Place</td>
    <td id='reportcell'><a style='text-decoration:none;' href='reports.php?Report=LandingCnt'>The Landing</td>
    <td id='reportcell'></td>
</tr>
</table>
</td></tr></table>
-->

</center></div>

EOF;
print $page->getBottom();
?>