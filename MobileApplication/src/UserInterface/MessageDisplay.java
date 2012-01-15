/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

package UserInterface;
import Logic.Constant;
import Logic.HealthData;
import Logic.PersonalInformation;
import javax.microedition.lcdui.*;

/**
 *
 * @author Sarbodaya Kandel
 */
public class MessageDisplay extends Canvas implements CommandListener{
    private String message;
    private String buttonLabel;
    
    private LoginScreen loginScreen;
    private Command cmdLogout, cmdMonitor, cmdOK;

    private int displayType;
    private int userId;
    private PersonalInformation personalInformation;

    public MessageDisplay(LoginScreen loginScreen, int displayType){
        this.loginScreen = loginScreen;
        this.displayType = displayType;

        if(displayType == Constant.DISPLAY_TYPE_SUCCESS){
            addCommand(getLogoutCommand());
            addCommand(getMonitorCommand());

        }else if(displayType == Constant.DISPLAY_TYPE_FAILURE){
            addCommand(getOKCommand());
        }
        setCommandListener(this);
    }

    public void setPersonalInformation(PersonalInformation personalInformation){
        this.personalInformation = personalInformation;
    }

    public Command getLogoutCommand(){
        if(cmdLogout == null){
            cmdLogout = new Command("Logout", Command.BACK, 1);
        }
        return cmdLogout;
    }

    public Command getOKCommand(){
        if(cmdOK == null){
            cmdOK = new Command("OK", Command.BACK, 1);
        }
        return cmdOK;
    }

    public Command getMonitorCommand(){
        if(cmdMonitor == null){
            cmdMonitor = new Command("Monitor", Command.BACK, 1);
        }
        return cmdMonitor;
    }

    public void setUserId(int userId){
        this.userId = userId;
    }
    
    public void setMessage(String message){
        this.message = message;
    }
    
    protected void paint(Graphics g){
        g.setColor(0, 0, 0);
        g.fillRect(0, 0, getWidth(), getHeight());
        
        if(personalInformation != null){
            personalInformation.displayPersonalInformation(g);
        }
        g.setFont(Font.getFont(Font.FACE_PROPORTIONAL, Font.STYLE_BOLD, Font.SIZE_LARGE));
        
        if(displayType == Constant.DISPLAY_TYPE_FAILURE){
            g.setColor(255, 0, 0);

        }else if(displayType == Constant.DISPLAY_TYPE_SUCCESS){
            g.setColor(0, 255, 0);
        }
        
        g.drawString(message, getWidth() / 2 , getHeight() / 2, Graphics.BASELINE | Graphics.HCENTER);
    }

    public void commandAction(Command cmd, Displayable displayable){
        if(cmd == cmdLogout){
            loginScreen.clearInputFields();
            Display.getDisplay(loginScreen).setCurrent(loginScreen.getLoginForm());

        }else if(cmd == cmdMonitor){
            switch(displayType){
                case Constant.DISPLAY_TYPE_FAILURE:
                    loginScreen.clearInputFields();
                    Display.getDisplay(loginScreen).setCurrent(loginScreen.getLoginForm());
                    break;

                case Constant.DISPLAY_TYPE_SUCCESS:
                    loginScreen.clearInputFields();
                    SensorDisplay sd = new SensorDisplay(loginScreen, personalInformation, new HealthData(this.userId));
                    Display.getDisplay(loginScreen).setCurrent(sd.getForm());
                    break;
                }

        }else if(cmd == cmdOK){
            loginScreen.clearInputFields();
            Display.getDisplay(loginScreen).setCurrent(loginScreen.getLoginForm());
            
        }
    }
}
