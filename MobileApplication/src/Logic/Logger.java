/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

package Logic;
import javax.microedition.rms.*;
import java.io.*;
import java.util.Date;

/**
 *
 * @author Sarbodaya Kandel
 */
public class Logger {
    private RecordStore recordStore;
    private ByteArrayOutputStream byteArrayOutputStream;
    private DataOutputStream dataOutputStream;
    private float temperature;
    private byte[] record;

    public void setTemperature(float temperature){
        this.temperature =  temperature;
    }
    
    public void saveToDevice(){
        try{
            recordStore = RecordStore.openRecordStore(Constant.RECORD_STORE_NAME, true);

        }catch(Exception e){

        }
        try{
            byteArrayOutputStream = new ByteArrayOutputStream();
            dataOutputStream = new DataOutputStream(byteArrayOutputStream);
           
            dataOutputStream.writeFloat(temperature);
            dataOutputStream.writeLong(new Date().getTime());
            dataOutputStream.flush();

            record = byteArrayOutputStream.toByteArray();
            recordStore.addRecord(record, 0, record.length);
            
            byteArrayOutputStream.reset();
            dataOutputStream.close();
            byteArrayOutputStream.close();

        }catch(Exception e){
            System.out.println(e.getMessage());
        }
    }
}
