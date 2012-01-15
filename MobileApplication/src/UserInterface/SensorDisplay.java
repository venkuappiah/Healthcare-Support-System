package UserInterface;

import Logic.Constant;
import Logic.HealthData;
import Logic.PersonalInformation;
import javax.microedition.io.* ;
import java.io.* ;
import java.io.InputStream ;
import java.io.OutputStream ;
import java.io.PrintStream ;
import javax.microedition.lcdui.*;

/**
 * @author researcher
 */
public class SensorDisplay implements CommandListener, Runnable {    
    private Form form;
    private TextField textField2;
    private TextField textField1;
    private TextField textField;
    private TextField textField3;
    private TextField textField6;
    private TextField textField5;
    private TextField textField4;
   
    private int count ;
    private Alert alert;
    private LoginScreen loginScreen;
    private boolean loop = true;
    private boolean cycleLoop = true;
    private Command 
            stopCommand,
            startCommand,
            exitCommand,
            monitoringOptionCommand,
            displayModeOptionCommand,
            logoutCommand;
   
    private SocketConnection sgEndP ;
    private InputStream  is ;
    private OutputStream os ;
    private PrintStream send ;
    private String datavalue ;
    private Thread th;
    private long monitoringSpeed;
    private int displayType;
    private HealthData healthData;
    private PersonalInformation personalInformation;
    private DataDisplay dataDisplay;

    public void run(){
        if (displayType == Constant.DISPLAY_TYPE_BAR_GRAPH){
            dataDisplay.setDisplayType(Constant.DISPLAY_TYPE_BAR_GRAPH);
            Display.getDisplay(loginScreen).setCurrent(dataDisplay);

        }else if(displayType == Constant.DISPLAY_TYPE_LINE_GRAPH){
            dataDisplay.setDisplayType(Constant.DISPLAY_TYPE_LINE_GRAPH);
            Display.getDisplay(loginScreen).setCurrent(dataDisplay);
        }
        
        while(loop){
            if(cycleLoop){
                dataDisplay.setCycleLoop(cycleLoop);
                form.removeCommand(getStartCommand());
                form.addCommand(getStopCommand());
                CycleReceiving();
                
            }else{
                dataDisplay.setCycleLoop(cycleLoop);
                form.removeCommand(getStopCommand());
                form.addCommand(getStartCommand());

            }
            try {
                Thread.sleep(this.monitoringSpeed);
                
            } catch (InterruptedException ex) {
                ex.printStackTrace();
            }
        }
    }

    public void setDisplayType(int displayType){
        this.displayType = displayType;
    }

    public int getDisplayType(){
        return this.displayType;
    }
   
    public SensorDisplay(LoginScreen loginScreen, PersonalInformation personalInformation, HealthData healthData) {
        this.dataDisplay = new DataDisplay(loginScreen, personalInformation, healthData, this);
        this.dataDisplay.setCycleLoop(cycleLoop);
        this.dataDisplay.setThreadLoop(loop);
        
        this.healthData = healthData;
        this.personalInformation = personalInformation;
        
        startCommand = getStartCommand();
        this.loginScreen = loginScreen;
        
        this.monitoringSpeed = Constant.MONITORING_SPEED_TEN_SEC;
        this.displayType = Constant.DISPLAY_TYPE_NUMBER;

        th = new Thread(this, "SensorDisplay");
        th.start();
    }

    public float getAverageTemperature(){
        float s1, s2, s3;
        s1 = Float.parseFloat(getTextField4().getString());
        s2 = Float.parseFloat(getTextField5().getString());
        s3 = Float.parseFloat(getTextField6().getString());
      
        return (s1 + s2 + s3)/3;
    }
    
    public Command getStopCommand(){
        if(stopCommand == null){
            stopCommand = new Command("Stop", Command.STOP, 0);
        }
        return stopCommand;
    }

    public Command getLogoutCommand(){
        if(logoutCommand == null){
            logoutCommand = new Command("Log out", Command.STOP, 0);
        }
        return logoutCommand;
    }

    public Command getExitCommand() {
        if (exitCommand == null) {
            exitCommand = new Command("Exit", Command.EXIT, 0);
        }
        return exitCommand;
    }

    public Command getStartCommand() {
        if (startCommand == null) {
            startCommand = new Command("Start", Command.OK, 0);
        }
        return startCommand;
    }

    public Command getMonitoringOptionCommand(){
        if(monitoringOptionCommand == null){
            monitoringOptionCommand = new Command("MonitoringOptions", Command.STOP, 0);
        }
        return monitoringOptionCommand;
    }

    public Command getDisplayModeOptionCommand(){
        if(displayModeOptionCommand == null){
            displayModeOptionCommand = new Command("Display Mode", Command.STOP, 0);
        }
        return displayModeOptionCommand;
    }

    public void setMonitoringSpeed(long monitoringSpeed){
        this.monitoringSpeed = monitoringSpeed;
    }

    public void setCycleLoop(boolean cycleLoop){
        this.cycleLoop = cycleLoop;
    }

    public void setThreadLoop(boolean loop){
        this.loop = loop;
    }

    public void commandAction(Command command, Displayable displayable) {
        if (displayable == form) {
            if (command == exitCommand) {
                loop = false;
                cycleLoop = false;
                dataDisplay.setThreadLoop(loop);
                dataDisplay.setCycleLoop(cycleLoop);

                loginScreen.exitMidlet();
                
            }else if(command == stopCommand){
                cycleLoop = false;
                dataDisplay.setCycleLoop(cycleLoop);

                form.removeCommand(stopCommand);
                form.addCommand(startCommand);
                
            }else if(command == logoutCommand){
                loop = false;
                cycleLoop = false;
                dataDisplay.setThreadLoop(loop);
                dataDisplay.setCycleLoop(cycleLoop);
                
                Display.getDisplay(loginScreen).setCurrent(loginScreen.getLoginForm());

            }else if(command == monitoringOptionCommand){
                new MonitoringOptions(this, loginScreen, dataDisplay);

            }else if(command == displayModeOptionCommand){
                new DisplayModeOptions(dataDisplay, loginScreen, this);

            }else if (command == startCommand) {
                cycleLoop = true;
                dataDisplay.setCycleLoop(cycleLoop);
              
                form.removeCommand(startCommand);
                form.addCommand(stopCommand);
              
              /*
               try {                 
                    alert = new Alert("Info","Test",null,AlertType.INFO);
                    sgEndP = (SocketConnection) Connector.open("socket://169.254.168.175:9001") ;
                    sgEndP.setSocketOption(sgEndP.DELAY, 0) ;
                    sgEndP.setSocketOption(sgEndP.KEEPALIVE, 0) ;

                    is = sgEndP.openInputStream() ;
                    os = sgEndP.openOutputStream() ;
                    send = new PrintStream(os) ;

              }
              catch (Exception e){
                  alert.setString("Error 1 " + e.toString());
                  alert.setTimeout(Alert.FOREVER) ;
                  Display.getDisplay(loginScreen).setCurrent(alert);
                  //display.setCurrent(alert);
              }

             try {

                   char[] us = new char[2];
                   us[0] = 'T';
                   us[1] = '!';

                   send.print(us) ;
                   send.flush();
                   if (send.checkError() == true) {
                        alert.setString("Error 1 Sending Data ");
                        alert.setTimeout(Alert.FOREVER) ;
                        Display.getDisplay(loginScreen).setCurrent(alert);
                   }

                   byte[] check = new byte[2] ;
                   is.read(check, 0, check.length) ;
     */
     
                   //textField.setString(check[1] + " " + check[0]);
                   //getTextField().setString("Ack Returned");
                   /*
                   byte[] nonceRem = new byte[4] ;
                   is.read(nonceRem, 0, nonceRem.length) ;
                   textField1.setString(nonceRem[3]+ " " +nonceRem[2]+" "+nonceRem[1]+" "+nonceRem[0]);
                   */
                   //getTextField1().setString("Platform Info");
                   /*
                   int platform = 3 ;
                   char[] nonce = new char[4];

                   nonce[0] = ((char)(platform));
                   nonce[1] = ((char)(platform >> 8));
                   nonce[2] = ((char)(platform >> 16));
                   nonce[3] = ((char)(platform >> 24));

                   send.print(nonce) ;
                   send.flush() ;
                   if (send.checkError() == true) {
                        alert.setString("Error 2 Sending Data ");
                        alert.setTimeout(Alert.FOREVER) ;
                        Display.getDisplay(loginScreen).setCurrent(alert);
                   }

                   byte[] datalen = new byte[2];
                   byte[] datapay ;
                   is.read(datalen, 0, 1) ;
      
      
                   textField2.setString(datalen[1] + " " +datalen[0]) ;
                   */
                   //getTextField2().setString("Data Length");

                   /*
                   int lenofdata = (int) datalen[0] ;
                   datapay = new byte[lenofdata]    ;
                   is.read(datapay,0,lenofdata) ;
                   count = 0 ;
                   datavalue = "" ;
                   while (lenofdata > count) {
                       datavalue = datavalue + datapay[count] + " " ;
                       count++ ;
                   }
                   textField3.setString(datavalue) ;
                   switch (datapay[7]) {
                       case 1:
                   */
                            //textField4.setString(""+datapay[5]);
                          //getTextField4().setString(String.valueOf(healthData.getAverageTemperature()));
                          /*
                            break;
                       case 2:
                            textField5.setString(""+datapay[5]);
                        */
                          //getTextField5().setString(String.valueOf(healthData.getAverageTemperature()));

                         /*
                            break;
                       case 3:
                            textField6.setString(""+datapay[5]);
                          */
                          //getTextField6().setString(String.valueOf(healthData.getAverageTemperature()));
                          /*
                            break;
                   }
                  }

                  catch (IOException e){
                        alert.setString("Error 2  IO : "+ e.toString());
                        alert.setTimeout(Alert.FOREVER) ;
                        Display.getDisplay(loginScreen).setCurrent(alert);
                  }
                  catch (NullPointerException e){
                        alert.setString("Error 3  NP : "+ e.toString());
                        alert.setTimeout(Alert.FOREVER) ;
                        Display.getDisplay(loginScreen).setCurrent(alert);
                  }
                 */
            }
        }       
    }

   private void CycleReceiving(){
       /*
        System.out.println("Cycle receiving");
        byte[] datalen = new byte[1];
        byte[] datapay ;

           try {
                 is.read(datalen, 0, 1) ;
                 textField2.setString(datalen[1] + " " +datalen[0]) ;
        */
                 //getTextField1().setString("Platform Info");
                 //getTextField2().setString("Inside Cycle Receiving");
          /* }
           catch (Exception e){
                  alert.setString("Error 4  "+ e.toString());
                  alert.setTimeout(Alert.FOREVER) ;
                  Display.getDisplay(loginScreen).setCurrent(alert);
           }
           try {
                  int lenofdata = (int) datalen[0] ;
                  datapay = new byte[lenofdata]    ;
                  is.read(datapay,0,lenofdata) ;
                  count = 0 ;
                  datavalue = "" ;
                  while (lenofdata > count) {
                       datavalue = datavalue + datapay[count] + " " ;
                       count++ ;
                  }
       
                 textField3.setString(datavalue) ;
           */
                 //getTextField3().setString("Data In Cycle Receiving");
                 /*
                 switch (datapay[7]) {
                      case 1:
                           textField4.setString(""+datapay[5]);
                           */
                           getTextField4().setString(String.valueOf(healthData.getAverageTemperature()));
                           //break ;
                      //case 2:
                          // textField5.setString(""+datapay[5]);
                           getTextField5().setString(String.valueOf(healthData.getAverageTemperature()));
                          /* break ;
                      case 3:
                           textField6.setString(""+datapay[5]);
                           */
                           getTextField6().setString(String.valueOf(healthData.getAverageTemperature()));
                         //break ;
                  //}

            //}
            /*
            catch (NullPointerException e){
                  alert.setString("Error 5  NP : " + datalen[0] + sgEndP + e.toString());
                  alert.setTimeout(Alert.FOREVER) ;
                  Display.getDisplay(loginScreen).setCurrent(alert);
            }
            catch (IOException e){
                  alert.setString("Error 6  IO : "+ e.toString());
                  alert.setTimeout(Alert.FOREVER) ;
                  Display.getDisplay(loginScreen).setCurrent(alert);
            }
         */
     }

    public Form getForm() {
        if (form == null) {
            form = new Form("form", new Item[] { getTextField(), getTextField1(), getTextField2(), getTextField3(), getTextField4(), getTextField5(), getTextField6() });//GEN-BEGIN:|22-getter|1|22-postInit

            form.addCommand(getLogoutCommand());
            form.addCommand(getExitCommand());
            form.addCommand(getStopCommand());
            form.addCommand(getDisplayModeOptionCommand());
            form.addCommand(getMonitoringOptionCommand());
            form.setCommandListener(this);
        }
        return form;
    }
    
    public TextField getTextField() {
        if (textField == null) {
            textField = new TextField("Packet Ack", "Packet Ack", 32, TextField.ANY);
            textField.setLayout(ImageItem.LAYOUT_DEFAULT);
        }
        return textField;
    }
   
    public TextField getTextField1() {
        if (textField1 == null) {
            textField1 = new TextField("Platform Info", "Platform Info", 32, TextField.ANY);
        }
        return textField1;
    }

    public TextField getTextField2() {
        if (textField2 == null) {
            textField2 = new TextField("Data Length", "Data Length", 32, TextField.ANY);
        }
        return textField2;
    }
    
    public TextField getTextField3() {
        if (textField3 == null) {
            textField3 = new TextField("Captured Data", "Captured Data", 64, TextField.ANY);
        }
        return textField3;
    }
   
    public TextField getTextField4() {
        if (textField4 == null) {
            textField4 = new TextField("Sensor 1", String.valueOf(healthData.getAverageTemperature()), 32, TextField.DECIMAL);
        }
        return textField4;
    }
    
    public TextField getTextField5() {
        if (textField5 == null) {
            textField5 = new TextField("Sensor 2", String.valueOf(healthData.getAverageTemperature()), 32, TextField.DECIMAL);
        }
        return textField5;
    }
    
    public TextField getTextField6() {
        if (textField6 == null){
            textField6 = new TextField("Sensor 3", String.valueOf(healthData.getAverageTemperature()), 32, TextField.DECIMAL);
        }
        return textField6;
    }
}