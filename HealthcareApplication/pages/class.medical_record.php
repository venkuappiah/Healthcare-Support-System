<?php
require_once("class.database.php");

class MedicalRecord
{
    private $_id;
    
    public function __construct($id)
    {
        $this->_id = $id;
    }
    
    public function getMedicalRecord()
    {
        $sql = "SELECT DISTINCT DATE(datetime) AS datetime FROM medicalRecord WHERE personId = {$this->_id} ORDER BY datetime DESC";
        return Database::getInstance()->getTable($sql);
    }
    
    public function getMedicalRecordDetails($id,$date)
    {
        $sql = "SELECT recordId, TIME(datetime) AS datetime, temperature FROM medicalRecord WHERE personId = $id ";
        $sql = $sql."AND DATE(datetime) = '$date' ORDER BY datetime DESC";
        return Database::getInstance()->getTable($sql);
    }
}
?>