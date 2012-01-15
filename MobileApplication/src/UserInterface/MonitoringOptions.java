/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

package UserInterface;
import Logic.Constant;
import javax.microedition.lcdui.*;

/**
 *
 * @author Sarbodaya Kandel
 */
public class MonitoringOptions implements CommandListener{
    private List list;
    private Command cmdOk;
    private DataDisplay dataDisplay;
    private SensorDisplay sensorDisplay;
    private LoginScreen loginScreen;

    public MonitoringOptions(SensorDisplay sensorDisplay, LoginScreen loginScreen, DataDisplay dataDisplay){
        this.sensorDisplay = sensorDisplay;
        this.loginScreen = loginScreen;
        this.dataDisplay = dataDisplay;
    
        Display.getDisplay(loginScreen).setCurrent(getList());
    }
    
    public Command getOkCommand(){
        if(cmdOk == null){
            cmdOk = new Command("OK", Command.BACK, 1);
        }
        return cmdOk;
    }

    public List getList(){
        if(list == null){
            list = new List("Monitoring options", List.IMPLICIT);
            list.append("Continuous monitoring", null);
            list.append("Interval monitoring", null);
            list.addCommand(getOkCommand());
            list.setCommandListener(this);
        }
        return list;
    }

    public void commandAction(Command cmd, Displayable displayable){
        if(cmd == cmdOk){
            switch(list.getSelectedIndex()){
                case 0:
                    sensorDisplay.setMonitoringSpeed(Constant.MONITORING_SPEED_CONTINUOUS);
                    dataDisplay.setMonitoringSpeed(Constant.MONITORING_SPEED_CONTINUOUS);
                    break;
                    
                case 1:
                    sensorDisplay.setMonitoringSpeed(Constant.MONITORING_SPEED_TEN_SEC);
                    dataDisplay.setMonitoringSpeed(Constant.MONITORING_SPEED_TEN_SEC);
                    break;
            }
            
            if(sensorDisplay.getDisplayType() == Constant.DISPLAY_TYPE_NUMBER){
                 Display.getDisplay(loginScreen).setCurrent(sensorDisplay.getForm());

            }else{
                 Display.getDisplay(loginScreen).setCurrent(dataDisplay);
            }
        }
    }
}
