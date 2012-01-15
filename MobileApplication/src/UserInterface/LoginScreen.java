package UserInterface;
import Logic.Login;
import javax.microedition.midlet.*;
import javax.microedition.lcdui.*;

/**
 *
 * @author Sarbodaya Kandel
 */

public class LoginScreen extends MIDlet implements CommandListener{    
    private Form frmLogin;
    private TextField txtUsername;
    private TextField txtPassword;
    private Command cmdLogin, cmdExit; 

    private Display display;
    private Login login;
    
    public Command getLoginCommand(){
        if(cmdLogin == null){
            cmdLogin = new Command("Login", Command.OK, 1);
        }
        return cmdLogin;
    }

    public Command getExitCommand(){
        if(cmdExit == null){
            cmdExit = new Command("Exit", Command.EXIT, 1);
        }
        return cmdExit;
    }

    public void exitMidlet(){
        destroyApp(true);
        notifyDestroyed();
    }

    public TextField getUsernameField(){
        if(txtUsername == null){
            txtUsername = new TextField("Username:", "", 80, TextField.ANY);
        }
        return txtUsername;
    }

    public TextField getPasswordField(){
        if(txtPassword == null){
            txtPassword = new TextField("Password:", "", 80, TextField.PASSWORD);
        }
        return txtPassword;
    }
    
    public LoginScreen(){
        display = Display.getDisplay(this);
        login = new Login(this);
        
        frmLogin = getLoginForm();
        frmLogin.addCommand(getLoginCommand());
        frmLogin.addCommand(getExitCommand());
        frmLogin.setCommandListener(this);
    }

    public Form getLoginForm(){
        if(frmLogin == null){
            frmLogin = new Form("Login Screen", new Item[]{getUsernameField(), getPasswordField()});
        }
        return frmLogin;
    }
    
    protected void destroyApp(boolean arg0){

    }

    protected void pauseApp(){

    }

    protected void startApp(){
        display.setCurrent(frmLogin);
    }

    public void commandAction(Command cmd, Displayable displayable){
        login.processCommand(cmd);
    }
   
    public void clearInputFields(){
        txtUsername.delete(0, txtUsername.getString().length());
        txtPassword.delete(0, txtPassword.getString().length());
    }
}
