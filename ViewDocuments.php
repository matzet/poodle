<?php

class ViewDocuments
{
    private $documents = array();
    
    public function __construct($documents) {
        $this->documents = $documents;
    }
    
    public function display() {
        global $OUTPUT;
        echo $OUTPUT->header();
        echo '<div class="container_documents" style="margin-left:100px; 
                          margin-right:100px;border-width:2px;border-color:gray;
                          border-style:solid; background-color:#dbdbdb;">';
        foreach($this->documents as $doc) {
            echo 
                '<div class="container_post" style="margin-left:auto;
                            margin-right:auto;margin-bottom:15px;
                            margin-top:15px; background-color:#eaeaea;
                            border-style:solid; border-width:0px; 
                            border-color:gray; max-width:450px;
                            padding: 10px;">
                    <div class="post_title">'.$doc->title.'</div>
                    <div class="post_author">'.$doc->author.'</div>
                    <div class="post_year">'.$doc->year.'</div>
                </div>';
        }
        echo '</div>';
        echo $OUTPUT->footer();
    }
}

?>
