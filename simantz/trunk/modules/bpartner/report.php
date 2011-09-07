mb<?php

include "system.php";
/* Section 1
 * initialize required object for run report (SelectControl, Report Element or Searchlayer)
 * It shall use include_once cause parent's report and menu.php include it too, make sure menu.php using include_once too
 */
include_once('../bpartner/class/SearchLayer.inc.php');
include_once '../simantz/class/ReportElement.inc.php';
$sl=new SearchLayer();//this variable name must fix
$re = new ReportElement();
include_once '../bpartner/class/BPartnerReportElement.inc.php';
$bpre= new BPartnerReportElement();
include_once '../simantz/class/SelectCtrl.inc.php';
$ctrl = new SelectCtrl();
include_once '../bpartner/class/BPSelectCtrl.inc.php';
$bpctrl=new BPSelectCtrl();
/*
 * section 2
 * Call report centralize report function
 */
include "../simantz/report.php";

/*
 * section 3
 * call required javascript for search layer
 */
$sl->showBPartnerJS();
