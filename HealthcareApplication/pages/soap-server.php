<?php
    ini_set("soap.wsdl_cache_enabled", "0");
    
    require_once('nusoap/lib/nusoap.php');
    require_once('class.person.php');
    require_once("class.database.php");
    require_once("class.web_service.php");
    
    // Create the server instance
    $server = new soap_server();
    
    // Initialize WSDL support
    $server->configureWSDL('temperatureService', 'urn:temperatureService');
    
    // Put the WSDL schema types in the namespace with the tns prefix
    $server->wsdl->schemaTargetNamespace = 'urn:temperatureService';
    
    // Register the method to expose
    $server->register('WebService.authenticateUser',                                   // method name
        array('username' => 'xsd:string','password'=>'xsd:string'),         // input parameters
        array('authResult' => 'xsd:string'),                                   // output parameters
        'urn:authenticateUser',                                             // namespace
        'urn:authenticateUser#authenticateUser',                            // soapaction
        'rpc',                                  // style
        'encoded',                              // use
        'Authenticates the user'                // documentation
    );
    
    $server->register('WebService.addTemperature',                                 // method name
        array('userId' => 'xsd:int','temperature'=>'xsd:float'),        // input parameters
        array('tempResult' => 'xsd:int'),                               // output parameters
        'urn:addTemperature',                                           // namespace
        'urn:addTemperature#addTemperature',                            // soapaction
        'rpc',                                  // style
        'encoded',                              // use
        'Inserts temperature'                   // documentation
    );
    
    $server->register('WebService.sendSMS',                             // method name
        array('userId' => 'xsd:int','temperature'=>'xsd:float'),        // input parameters
        array('smsResult' => 'xsd:string'),                             // output parameters
        'urn:sendSMS',                                                  // namespace
        'urn:sendSMS#sendSMS',                                          // soapaction
        'rpc',                                  // style
        'encoded',                              // use
        'Sends SMS'                             // documentation
    );
    
    // Use the request to (try to) invoke the service
    $HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
    $server->service($HTTP_RAW_POST_DATA);
?>