<?php
    date_default_timezone_set('Australia/Melbourne');
    if(isset($_POST['selDoctor']))
    {
        require_once("class.discussion.php");
        
        $discussionSubject = trim($_POST['txtSubject']);
        $discussionContent = trim($_POST['txtMessage']);
        $datetime = date("Y-m-d H:i:s");
        $recordId = $_POST['recordIdHidden'];
        $postedBy = $_POST['idHidden'];
        $idAndName = explode("+",$_POST['selDoctor']);
        
        $postedTo = $idAndName[0];
                
        $patientName = $_POST['nameHidden'];
        $patientType = $_POST['typeHidden'];
        
        $discussionData = 
        array
        (
            'discussionSubject'=>$discussionSubject,
            'discussionContent'=>$discussionContent,
            'datetime'=>$datetime,
            'recordId'=>$recordId,
            'postedBy'=>$postedBy,
            'postedTo'=>$postedTo
        );
        
        $objDiscussion = new Discussion($discussionData);
        $objDiscussion->validateInput();
        
        //sends new Id if the submission is successful, -1 if not successful, error array if invalid data were sent
        $status = $objDiscussion->save();
        
        //all data are valid
        if(!(is_array($status)))
        {
            if($status)
            {
                //submission successful: go to the patient_medical_record page
                header("Location:patient_medical_record.php?post=t");
            }
            else
            {
                //submission failed: go to the patient_medical_record page
                header("Location:patient_medical_record.php?post=f");
            }
        }
    }
    
    if(isset($_POST['selPatient']))
    {
        require_once("class.discussion.php");
        
        $discussionSubject = trim($_POST['txtSubject']);
        $discussionContent = trim($_POST['txtMessage']);
        $datetime = date("Y-m-d H:i:s");
        $recordId = $_POST['recordIdHidden'];
        $postedBy = $_POST['dIdHidden'];
        $idAndName = explode("+",$_POST['selPatient']);
        
        $postedTo = $idAndName[0];
        $patientName = $idAndName[1];
                
        $dName = $_POST['dNameHidden'];
        $dType = $_POST['dTypeHidden'];
        $dId = $_POST['dIdHidden'];
        
        $discussionData = 
        array
        (
            'discussionSubject'=>$discussionSubject,
            'discussionContent'=>$discussionContent,
            'datetime'=>$datetime,
            'recordId'=>$recordId,
            'postedBy'=>$postedBy,
            'postedTo'=>$postedTo
        );
        
        $objDiscussion = new Discussion($discussionData);
        $objDiscussion->validateInput();
        
        //sends new Id if the submission is successful, -1 if not successful, error array if invalid data were sent
        $status = $objDiscussion->save();
        
        //all data are valid
        if(!(is_array($status)))
        {
            if($status)
            {
                //submission successful: go to the patient_medical_record page
                header("Location:doctor_medical_record.php?pname=$patientName&pid=$postedTo&ptype=$patientType&post=t");
            }
            else
            {
                //submission failed: go to the patient_medical_record page
                header("Location:doctor_medical_record.php?pname=$patientName&pid=$postedTo&ptype=$patientType&post=f");
            }
        }
    }
?>