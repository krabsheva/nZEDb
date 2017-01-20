<?php
require_once './config.php';

use nzedb\PreDb;

$page = new AdminPage();
$predb = new PreDb();

$offset = (isset($_REQUEST["offset"]) && ctype_digit($_REQUEST['offset'])) ? $_REQUEST["offset"] : 0;

if (isset($_REQUEST['presearch'])) {
	$lastSearch = $_REQUEST['presearch'];
	$parr = $predb->getAll($offset, ITEMS_PER_PAGE, $_REQUEST['presearch']);
} else {
	$lastSearch = '';
	$parr = $predb->getAll($offset, ITEMS_PER_PAGE);
}

$pageno = (isset($_REQUEST['page']) ? $_REQUEST['page'] : 1);
$page->smarty->assign(
	[
		'pagecurrent'     => $pageno,
		'pagemaximum'     => (int)($parr['count'] / ITEMS_PER_PAGE) + 1,
	]
);

$page->smarty->assign('pagertotalitems', $parr['count']);
$page->smarty->assign('pageroffset', $offset);
$page->smarty->assign('pageritemsperpage', ITEMS_PER_PAGE);
$page->smarty->assign('pagerquerybase', WWW_TOP . "/predb.php?page=");
$page->smarty->assign('pagerquerysuffix', "#results");
$page->smarty->assign('lastSearch', $lastSearch);

$page->smarty->assign('pager', $page->smarty->fetch("pager.tpl"));
$page->smarty->assign('results', $parr['arr']);


$page->title = "Browse PreDb";
$page->meta_title = "View PreDb info";
$page->meta_keywords = "view,predb,info,description,details";
$page->meta_description = "View PreDb info";

$page->content = $page->smarty->fetch('predb.tpl');
$page->render();
