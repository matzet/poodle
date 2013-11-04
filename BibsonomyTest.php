<?php


set_include_path(get_include_path() . PATH_SEPARATOR . '../../lib/zend');

require_once('BibsonomyFacade.php');
require_once('ViewDocuments.php');

class TestOutput {
    
    public function header() {}
    public function footer() {}
}

$o = new BibsonomyFacade($_REQUEST['user'], $_REQUEST['key']);
$OUTPUT = new TestOutput();
$docs = $o->fetchPublications('hotho');
$view = new ViewDocuments($docs);
$view->display();

?>
