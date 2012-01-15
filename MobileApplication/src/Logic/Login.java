/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package Logic;

import UserInterface.LoginScreen;
import UserInterface.MessageDisplay;

import java.io.IOException;
import javax.microedition.lcdui.*;

import org.ksoap2.transport.HttpTransport;
import org.ksoap2.serialization.SoapObject;
import org.ksoap2.SoapEnvelope;
import org.ksoap2.serialization.SoapSerializationEnvelope;
/**
 *
 * @author Sarbodaya Kandel
 */
public class Login {
    private SoapObject soapRequest;
    private HttpTransport httpTransport;
    private SoapSerializationEnvelope soapEnvelope;
    private SoapObject body;
    private int userId = 0;
    private LoginScreen loginScreen;
    private String credentials[] = new String[4];

    public Login(LoginScreen loginScreen){
        this.loginScreen = loginScreen;
    }

    public int getUserId(){
        return userId;
    }

    public void processCommand(Command cmd){
        if(cmd == loginScreen.getExitCommand()){
            loginScreen.exitMidlet();
            
        }else if(cmd == loginScreen.getLoginCommand()){
            userId = validateUser();
            
            if(userId == -1){
                MessageDisplay messageDisplay = new MessageDisplay(loginScreen, Constant.DISPLAY_TYPE_FAILURE);
                messageDisplay.setMessage(Constant.LOGIN_FAILED);
                Display.getDisplay(loginScreen).setCurrent(messageDisplay);

            }else if(userId > 0){
                MessageDisplay messageDisplay = new MessageDisplay(loginScreen, Constant.DISPLAY_TYPE_SUCCESS);
                messageDisplay.setMessage(Constant.LOGIN_SUCCESSFUL);
                messageDisplay.setPersonalInformation(new PersonalInformation(credentials));
                messageDisplay.setUserId(userId);
                Display.getDisplay(loginScreen).setCurrent(messageDisplay);
            }
        }
    }

    private int validateUser(){
        int status = 0;
        soapEnvelope = new SoapSerializationEnvelope(SoapEnvelope.VER11);
        soapEnvelope.dotNet = false;
        soapRequest = new SoapObject("urn:temperatureService","WebService.authenticateUser");

        soapRequest.addProperty("username", loginScreen.getUsernameField().getString());
        soapRequest.addProperty("password", loginScreen.getPasswordField().getString());
        
        soapEnvelope.setOutputSoapObject(soapRequest);
        httpTransport = new HttpTransport(Constant.WEB_SERVICE_URI);

        try{
            httpTransport.call("", soapEnvelope);
            body = (SoapObject)soapEnvelope.bodyIn;

            String rawInfo = body.getProperty(0).toString();
            if(rawInfo.length() > 0){
                for(int i = 0; i < credentials.length; i++){
                    credentials[i] = rawInfo.substring(0, rawInfo.indexOf("~"));
                    rawInfo = rawInfo.substring(rawInfo.indexOf("~") + 1, rawInfo.length());
                }
                status = Integer.parseInt(credentials[3]);//person id
            }else{
                status = -1;
            }
            
        }catch (Exception e){
            MessageDisplay messageDisplay = new MessageDisplay(loginScreen, Constant.DISPLAY_TYPE_FAILURE);
            messageDisplay.setMessage(Constant.SERVER_NOT_AVAILABLE);
            Display.getDisplay(loginScreen).setCurrent(messageDisplay);
        }
        return status;
    }
}
