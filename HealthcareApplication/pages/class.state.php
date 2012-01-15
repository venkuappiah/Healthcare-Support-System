<?php
class State{
    private $_stateList;
    
    public function __construct(){
        $this->_stateList =
            array(
                "Australian Capital Territory",
                "New South Wales",
                "Victoria",
                "Queensland",
                "South Australia",
                "Western Australia",
                "Tasmania",
                "Northern Territory"
                );
    }
    
    public function getStateList(){
        return $this->_stateList;
    }
}
?>