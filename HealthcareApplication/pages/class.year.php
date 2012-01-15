<?php
    class Year{
        private $_counter;
        private $_year;
        private $_month;
        private $_days;
        
        public function __construct($initial,$final){
            for ($this->_counter = $initial; $this->_counter <= $final; ++$this->_counter){
                $this->_year[] = $this->_counter;
            }
            
            for ($id = 1; $id <= 31; ++$id){
                $this->_days[] = $id;
            }
            $this->_month =
            array(
                  "January"=>1,
                  "February"=>2,
                  "March"=>3,
                  "April"=>4,
                  "May"=>5,
                  "June"=>6,
                  "July"=>7,
                  "August"=>8,
                  "September"=>9,
                  "October"=>10,
                  "November"=>11,
                  "December"=>12
                  );
        }
        
        public function getYearList(){
            return $this->_year;
        }
        
        public function getMonthList(){
            return $this->_month;   
        }
        
        public function getDaysList(){
            return $this->_days;
        }
    }
?>