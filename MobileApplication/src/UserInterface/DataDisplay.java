/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

package UserInterface;
import Logic.Constant;
import Logic.HealthData;
import Logic.Logger;
import Logic.PersonalInformation;
import javax.microedition.lcdui.*;

/**
 *
 * @author Sarbodaya Kandel
 */
public class DataDisplay extends Canvas implements CommandListener, Runnable{
    private float temperature = 0;
    private int index;
    private boolean cycleLoop = true;
    private boolean loop = true;
    
    private int shiftX = Constant.MARGIN_X;
    private int shiftY = Constant.MARGIN_Y;

    private LoginScreen loginScreen;
    private Thread t;
    private HealthData healthData;
    private PersonalInformation personalInformation;
    private String message ="";
    private Command 
            cmdLogout,
            cmdStart,
            cmdStop,
            cmdExit,
            cmdDisplayModeOptions,
            cmdMonitoringOptions;

    private int graphParameter[][];
    private int timeInterval[];
    private int totalGraphElements = 0;
    private int loopCounter = 0;
    private int colorComponent = 0;
    private long monitoringSpeed;
    private int displayType;
    private SensorDisplay sensorDisplay;

    public void setCycleLoop(boolean cycleLoop){
        this.cycleLoop = cycleLoop;
    }

    public void setThreadLoop(boolean loop){
        this.loop = loop;
    }

    public DataDisplay(LoginScreen loginScreen, PersonalInformation personalInformation, HealthData healthData, SensorDisplay sensorDisplay){
        displayType = Constant.DISPLAY_TYPE_NUMBER;
        monitoringSpeed = Constant.MONITORING_SPEED_TEN_SEC;
        this.loginScreen = loginScreen;
        this.personalInformation = personalInformation;
        this.healthData = healthData;
        this.sensorDisplay = sensorDisplay;
        
        addCommand(getDisplayModeOptionsCommand());
        addCommand(getMonitoringOptionsCommand());

        if(cycleLoop == true){
            addCommand(getStopCommand());
           
        }else{
            addCommand(getStartCommand());
        }
        
        addCommand(getLogoutCommand());
        addCommand(getExitCommand());
        
        setCommandListener(this);
        totalGraphElements = (getWidth() - Constant.MARGIN_X * 2) / Constant.STEP_X;
        graphParameter = new int[totalGraphElements][2];
        timeInterval = new int [totalGraphElements];

        t = new Thread(this, "DataDisplay");
        t.start();
    }

    public void setMonitoringSpeed(long monitoringSpeed){
        this.monitoringSpeed = monitoringSpeed;
    }
    
    public void setDisplayType(int displayType){
        this.displayType = displayType;
    }

    public int getDisplayType(){
        return this.displayType;
    }

    public Command getLogoutCommand(){
        if(cmdLogout == null){
            cmdLogout = new Command("Logout", Command.BACK, 1);
        }
        return cmdLogout;
    }

    public Command getExitCommand(){
        if(cmdExit == null){
            cmdExit = new Command("Exit", Command.BACK, 1);
        }
        return cmdExit;
    }

    public Command getStartCommand(){
        if(cmdStart == null){
            cmdStart = new Command("Start", Command.BACK, 1);
        }
        return cmdStart;
    }

   public Command getStopCommand(){
        if(cmdStop == null){
            cmdStop = new Command("Stop", Command.BACK, 1);
        }
        return cmdStop;
    }

    public Command getMonitoringOptionsCommand(){
        if(cmdMonitoringOptions == null){
            cmdMonitoringOptions = new Command("Monitoring options", Command.BACK, 1);
        }
        return cmdMonitoringOptions;
    }
    
    public Command getDisplayModeOptionsCommand(){
        if(cmdDisplayModeOptions == null){
            cmdDisplayModeOptions = new Command("Display mode", Command.BACK, 1);
        }
        return cmdDisplayModeOptions;
    }

    public void run(){
        while (loop){
            if(cycleLoop){
                sensorDisplay.setCycleLoop(cycleLoop);
                removeCommand(getStartCommand());
                addCommand(getStopCommand());

                temperature = sensorDisplay.getAverageTemperature();

                message = String.valueOf(temperature);
                index = message.indexOf(".");

                if(index > -1 && message.length() > index + 3){
                    message = message.substring(0, index + 3);
                }

                healthData.setHealthData(temperature);
                healthData.saveToDevice();

                switch(healthData.getHealthLevel(temperature)){
                    case Constant.LEVEL_NORMAL:
                        colorComponent = Constant.COLOR_NORMAL;
                        break;

                    case Constant.LEVEL_WARNING:
                        colorComponent = Constant.COLOR_WARNING;
                        healthData.saveToServer();
                        //healthData.sendSMSFromServer();
                        break;

                    case Constant.LEVEL_CRITICAL:
                        colorComponent = Constant.COLOR_CRITICAL;
                        healthData.saveToServer();
                        //healthData.sendSMSFromDevice();
                        break;
                }
                adjustGraphData();
                repaint();

                try {
                    Thread.sleep(monitoringSpeed);

                } catch (InterruptedException ex) {

                }

            }else{
                sensorDisplay.setCycleLoop(cycleLoop);
                removeCommand(getStopCommand());
                addCommand(getStartCommand());
            }
        }
    }

    private int getPeakValue(){
        float height = Float.parseFloat(message) * 1000000;
        int h = (int)height / 10000;
        float percent = ((float)h / 4000) * (getHeight() / 4) ;
        String ht = String.valueOf(percent);
        int idx = ht.indexOf(".");

        return Integer.parseInt(ht.substring(0, idx));
    }

    private void drawAxis(Graphics g){
        g.setColor(125, 125, 125);
        g.setFont(Font.getFont(Font.FACE_PROPORTIONAL, Font.STYLE_PLAIN, Font.SIZE_SMALL));

        //y axis
        g.drawLine(Constant.MARGIN_X - 5, getHeight() - Constant.MARGIN_Y, Constant.MARGIN_X - 5, getHeight() - (getHeight() / 3) - Constant.MARGIN_Y);

        //x axis
        g.drawLine(Constant.MARGIN_X - 5, getHeight() - Constant.MARGIN_Y, getWidth() - Constant.MARGIN_X, getHeight() - Constant.MARGIN_Y);

        int dy = (getHeight() - getHeight() / 3) - Constant.MARGIN_Y;
        int top = (getHeight() - getHeight() / 4) - Constant.MARGIN_Y;
        int bottom = getHeight() - Constant.MARGIN_Y;
        int height = bottom - top;
        int stepY = height / 4;
        int temp = 0;

        //notches and numbers in y axis
        for(int i = bottom; i > dy; i = i - stepY ){
            g.setColor(255, 255, 255);
            g.drawLine(Constant.MARGIN_X - 7, i, Constant.MARGIN_X - 5, i);

            g.setColor(125, 125, 125);
            g.drawString(String.valueOf(temp), Constant.MARGIN_X - 8 - g.getFont().stringWidth(String.valueOf(temp)) , i - g.getFont().getHeight() / 2, Graphics.LEFT | Graphics.TOP);
            temp = temp + 10;
        }

        String yAxisLabel = "Temperature";
        int tempDy = dy - 5;
        g.setColor(255, 255, 255);

        //y axis label
        for(int i = 0; i < yAxisLabel.length(); i++){
            g.drawChar(yAxisLabel.charAt(i), Constant.MARGIN_X - g.getFont().stringWidth(String.valueOf(temp)) - 14 - g.getFont().substringWidth(yAxisLabel, i, 1) / 2, tempDy, Graphics.TOP | Graphics.LEFT);
            tempDy = tempDy + g.getFont().getHeight() - 4;
        }

        //notches and numbers in x axis
        int dx = Constant.MARGIN_X;
        for(int i = 0; i < totalGraphElements; i++){
            g.setColor(255, 255, 255);
            g.drawLine(dx, bottom, dx, bottom + 2);
            
            g.setColor(125, 125, 125);
            g.drawString(String.valueOf(timeInterval[i]), dx - g.getFont().stringWidth(String.valueOf(timeInterval[i])) / 2, getHeight() - Constant.MARGIN_Y + 3, Graphics.LEFT | Graphics.TOP);
            dx = dx + Constant.STEP_X;
        }
        
        String xAxisLabel = "Interval in Sec.";
        int tempDx = Constant.MARGIN_X - 2;
        g.setColor(255, 255, 255);

        //x axis label
        for(int i = 0; i < xAxisLabel.length(); i++){
            g.drawChar(xAxisLabel.charAt(i), tempDx, getHeight() - Constant.MARGIN_Y + g.getFont().getHeight(), Graphics.TOP | Graphics.LEFT);
            tempDx = tempDx + g.getFont().substringWidth(xAxisLabel, i, 1);
        }
    }

    protected void paint(Graphics g){
        if(message.length() > 0){
            g.setColor(0, 0, 0);
            g.fillRect(0, 0, getWidth(), getHeight());

            if(personalInformation != null){
                personalInformation.displayPersonalInformation(g);
                personalInformation.displayLegend(g);
            }

            g.setFont(Font.getFont(Font.FACE_PROPORTIONAL, Font.STYLE_BOLD, Font.SIZE_LARGE));

            switch(displayType){                
                case Constant.DISPLAY_TYPE_BAR_GRAPH:
                    drawAxis(g);
                    drawBarGraph(g);
                    break;

                case Constant.DISPLAY_TYPE_LINE_GRAPH:
                    drawAxis(g);
                    drawLineGraph(g);
                    break;
            }
        }
    }

    private void drawBarGraph(Graphics g){
        int dx = Constant.MARGIN_X;
        for(int i = 0; i < loopCounter; i++){
            g.setColor(graphParameter[i][1]);
            g.drawLine(dx, getHeight() - shiftY, dx, getHeight() - shiftY - graphParameter[i][0]);
            dx = dx + Constant.STEP_X;
        }
    }

    private void drawLineGraph(Graphics g){
        int shift = Constant.MARGIN_X;
        
        for(int i = 1; i < loopCounter; i++){
            g.setColor(255, 255, 255);
            g.drawLine(shift + Constant.STEP_X, getHeight() - shiftY - graphParameter[i][0], shift, getHeight() - shiftY - graphParameter[i - 1][0]);
            shift  = shift + Constant.STEP_X;
        }

        shift = Constant.MARGIN_X;
        for(int i = 0; i < loopCounter; i++){
            g.setColor(graphParameter[i][1]);
            g.fillRect( shift, getHeight() - shiftY - graphParameter[i][0] - 2, 3, 5);
            shift = shift + Constant.STEP_X;
        }
    }

    private void adjustGraphData(){
        int barHeight = getPeakValue();
  
        if(loopCounter < totalGraphElements){
            graphParameter[loopCounter][0] = barHeight;
            graphParameter[loopCounter][1] = colorComponent;
            timeInterval[loopCounter] = (int)monitoringSpeed / 1000;
            shiftX += Constant.STEP_X;
            loopCounter ++;

        }else{
            for(int i = 1; i < totalGraphElements; i++){
                graphParameter[i - 1][0] = graphParameter[i][0];
                graphParameter[i - 1][1] = graphParameter[i][1];
                timeInterval[i -1] = timeInterval[i];
            }
            graphParameter[totalGraphElements - 1][0] = barHeight;
            graphParameter[totalGraphElements - 1][1] = colorComponent;
            timeInterval[totalGraphElements - 1] = (int)monitoringSpeed / 1000;
        }
    }

    public void commandAction(Command cmd, Displayable displayable){
        if(cmd == cmdLogout){
            loop = false;
            cycleLoop = false;
            sensorDisplay.setThreadLoop(loop);
            sensorDisplay.setCycleLoop(cycleLoop);
            
            loginScreen.clearInputFields();
            Display.getDisplay(loginScreen).setCurrent(loginScreen.getLoginForm());
            
        }else if(cmd == cmdExit){
            loop = false;
            cycleLoop = false;
            sensorDisplay.setThreadLoop(loop);
            sensorDisplay.setCycleLoop(cycleLoop);
            loginScreen.exitMidlet();

        }else if(cmd == cmdStop){
            cycleLoop = false;
            sensorDisplay.setCycleLoop(cycleLoop);
            removeCommand(getStopCommand());
            addCommand(getStartCommand());

        }else if(cmd == cmdStart){
            cycleLoop = true;
            sensorDisplay.setCycleLoop(cycleLoop);
            removeCommand(getStartCommand());
            addCommand(getStopCommand());

        }else if(cmd == cmdDisplayModeOptions){
             new DisplayModeOptions(this, loginScreen, sensorDisplay);

        }else if(cmd == cmdMonitoringOptions){
            new MonitoringOptions(sensorDisplay, loginScreen, this);
        }
    }
}
