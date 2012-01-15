package Logic;

import java.util.Random;
import javax.microedition.io.Connector;
import javax.wireless.messaging.*;
import org.ksoap2.transport.HttpTransport;
import org.ksoap2.serialization.SoapObject;
import org.ksoap2.SoapEnvelope;
import org.ksoap2.serialization.SoapSerializationEnvelope;
/**
 *
 * @author Sarbodaya Kandel
 */

public class HealthData{
    private SoapObject soapRequest;
    private HttpTransport httpTransport;
    private SoapSerializationEnvelope soapEnvelope;
    private SoapObject body;
    private Random r;
    private float temperature;
    private int userId;
    Logger logger;
    
    public HealthData(int userId){
        r = new Random();
        this.userId = userId;
        logger = new Logger();
    }

    public void setHealthData(float temperature){
        this.temperature = temperature;
        logger.setTemperature(temperature);
    }

    public void saveToDevice(){
        logger.saveToDevice();
    }

    public void sendSMSFromDevice(){
        String receiver = "+610402511276";
        String port = "1234";
        String address = "sms://" + receiver + ":" + port;
        MessageConnection c = null;
        try {
            c = (MessageConnection) Connector.open(address);
            TextMessage t = (TextMessage) c.newMessage(
            MessageConnection.TEXT_MESSAGE);
            t.setAddress(address);
            t.setPayloadText("Hello world!");
            c.send(t);
        } catch (Exception e) {}
        finally {
            if (c != null) {
                try {
                    c.close();
                } catch (Exception e) {}
            }
        }
    }

    public String sendSMSFromServer(){
        String status = "";
        soapEnvelope = new SoapSerializationEnvelope(SoapEnvelope.VER11);
        soapEnvelope.dotNet = false;
        soapRequest = new SoapObject("urn:temperatureService","WebService.sendSMS");

        soapRequest.addProperty("userId", String.valueOf(userId));
        soapRequest.addProperty("temperature", String.valueOf(temperature));
        soapEnvelope.setOutputSoapObject(soapRequest);
        httpTransport = new HttpTransport(Constant.WEB_SERVICE_URI);

        try{
            httpTransport.call("", soapEnvelope);
            body = (SoapObject)soapEnvelope.bodyIn;
            status = body.getProperty(0).toString();
        }
        catch(Exception e){
            
        }
        return status;
    }

    public int saveToServer(){
        int status = 0;
        soapEnvelope = new SoapSerializationEnvelope(SoapEnvelope.VER11);
        soapEnvelope.dotNet = false;
        soapRequest = new SoapObject("urn:temperatureService","WebService.addTemperature");

        soapRequest.addProperty("userId", String.valueOf(userId));
        soapRequest.addProperty("temperature", String.valueOf(temperature));
        soapEnvelope.setOutputSoapObject(soapRequest);
        httpTransport = new HttpTransport(Constant.WEB_SERVICE_URI);

        try {
            httpTransport.call("", soapEnvelope);
            body = (SoapObject)soapEnvelope.bodyIn;
            status = Integer.parseInt(body.getProperty(0).toString());
            
        }catch(Exception e){
            
        }
        return status;
    }

    public float getTemperature(){
        return Math.abs(r.nextFloat() * 100) % 6 + 34;
    }
   
    public float getAverageTemperature(){
        float temp = 0;
        for (int i = 0; i < Constant.TOTAL_SENSORS; i++){
            temp = temp + Math.abs(r.nextFloat() * 100) % 6 + 34;
        }
        return (temp / Constant.TOTAL_SENSORS);
    }

    public int getHealthLevel(float temperature){
        if (temperature > Constant.HEALTH_DATA_CRITICAL_MAX || temperature < Constant.HEALTH_DATA_CRITICAL_MIN){
            return Constant.LEVEL_CRITICAL;
        }

        if(temperature > Constant.HEALTH_DATA_WARNING_MAX || temperature < Constant.HEALTH_DATA_WARNING_MIN){
            return Constant.LEVEL_WARNING;
        }
        return Constant.LEVEL_NORMAL;
    }
}


    