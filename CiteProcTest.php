<?php

require_once('CiteProcFacade.php');

$data = new stdClass();
$data->author = array();
$data->title = "Laufzeitanalyse von Sortieralgorithmen";

$author = new stdClass();

$issued = new stdClass();
$issued->{'date-parts'} = array();
$issued->{'date-parts'}[] = array("2013", "1", "20");

$data->issued = $issued;

$author->given = "Max";
$author->family = "Mustermann";

$data->author[] = $author;

$facade = new CiteProcFacade();

/*echo $facade->render($data, CitationStyle::ABNT);
echo $facade->render($data, CitationStyle::AMERICAN_MEDICAL_ASSOCIATION);
echo $facade->render($data, CitationStyle::AMERICAN_PHYSIOLOGICAL_SOCIETY);
echo $facade->render($data, CitationStyle::APA);
echo $facade->render($data, CitationStyle::APSA);*/
echo $facade->render($data, CitationStyle::NATURE);
echo $facade->render($data, CitationStyle::CHICAGO_AUTHOR_DATE);
echo $facade->render($data, CitationStyle::CHICAGO_FULLNOTE_BIBLIOGRAPHY);
echo $facade->render($data, CitationStyle::HARVARD1);
echo $facade->render($data, CitationStyle::IEEE);
?>
