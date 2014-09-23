<?php


/**
 * A class which is designed to aid the table on the Seminar_home page. 
 */
class Seminar_OverView_Row{
    
    protected $Seminar_ID;  // the type of seminar, at the moment its only 1 or 2 (1= proposal, 2 = final)
    protected $Cohort;  // a string which identifies the unique cohort group
    
    public function __construct($ID,$Cohort){
        $this->Cohort = $Cohort;
        $this->Seminar_ID = $ID;
    }

    public function return_Seminar_ID(){
        
    }
    
    public function return_Cohort(){
        
    }
}

