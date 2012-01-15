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
public class DisplayModeOptions implements CommandListener{
    private List list;
    private Command cmdOk;
    private DataDisplay dataDisplay;
    private SensorDisplay sensorDisplay;
    private LoginScreen loginScreen;
    
    public DisplayModeOptions(DataDisplay dataDisplay, LoginScreen loginScreen, SensorDisplay sensorDisplay){
        this.dataDisplay = dataDisplay;
        this.loginScreen = loginScreen;
        this.sensorDisplay = sensorDisplay;

        list = getList();
        Display.getDisplay(loginScreen).setCurrent(list);
    }

    public Command getOkCommand(){
        if(cmdOk == null){
            cmdOk = new Command("OK", Command.BACK, 1);
        }
        return cmdOk;
    }

    public List getList(){
        if(list == null){
            list = new List("Display options", List.IMPLICIT);
            list.append("Bar graph", null);
            list.append("Line graph", null);
            list.append("Number", null);
            list.addCommand(getOkCommand());
            list.setCommandListener(this);
        }
        return list;
    }
    
    public void commandAction(Command cmd, Displayable displayable){
        if(cmd == cmdOk){
            sensorDisplay.setDisplayType(list.getSelectedIndex());
         
            if(sensorDisplay.getDisplayType() == Constant.DISPLAY_TYPE_NUMBER){
                Display.getDisplay(loginScreen).setCurrent(sensorDisplay.getForm());
                
            }else if(sensorDisplay.getDisplayType() == Constant.DISPLAY_TYPE_BAR_GRAPH){
                dataDisplay.setDisplayType(Constant.DISPLAY_TYPE_BAR_GRAPH);
                Display.getDisplay(loginScreen).setCurrent(dataDisplay);

            }else if(sensorDisplay.getDisplayType() == Constant.DISPLAY_TYPE_LINE_GRAPH){
                dataDisplay.setDisplayType(Constant.DISPLAY_TYPE_LINE_GRAPH);
                Display.getDisplay(loginScreen).setCurrent(dataDisplay);
                
            }
        }
    }
}
