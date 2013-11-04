<?php

require_once('libciteproc/CiteProc.php');

class CitationStyle
{
    const ABNT = "abnt";
    const AMERICAN_MEDICAL_ASSOCIATION = "american-medical-association";
    const AMERICAN_PHYSIOLOGICAL_SOCIETY = "american-physiological-society";
    const APA = "apa";
    const APSA = "apsa";
    const ASA = "asa";
    const CHICAGO_AUTHOR_DATE = "chicago-author-date";
    const CHICAGO_FULLNOTE_BIBLIOGRAPHY = "chicago-fullnote-bibliography";
    const HARVARD1 = "harvard1";
    const IEEE = "ieee";
    const MLA = "mla";
    const NATURE = "nature";
};

class CiteProcFacade
{
    public function render($data, $style) {
        $styleXML = file_get_contents('libciteproc/style/'.$style.'.csl');
        $o = new citeproc($styleXML);
        return $o->render($data);
    }
}

?>
