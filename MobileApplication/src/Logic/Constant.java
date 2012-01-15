/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

package Logic;

/**
 *
 * @author Sarbodaya Kandel
 */
public class Constant {
    public static final int DISPLAY_TYPE_FAILURE = 0;
    public static final int DISPLAY_TYPE_SUCCESS = 1;

    public static final int DISPLAY_TYPE_BAR_GRAPH = 0;
    public static final int DISPLAY_TYPE_LINE_GRAPH = 1;
    public static final int DISPLAY_TYPE_NUMBER = 2;

    public static final long MONITORING_SPEED_CONTINUOUS = 1000;//1 sec
    public static final long MONITORING_SPEED_TEN_SEC = 10000;//10 sec
    
    public static final String WEB_SERVICE_URI = "http://localhost:80/healthcare/pages/soap-server.php";
    //public static final String WEB_SERVICE_URI = "http://169.254.168.175:80/healthcare/pages/soap-server.php";
    //public static final String WEB_SERVICE_URI = "http://138.25.210.175:80/healthcare/pages/soap-server.php";

    public static final String LOGIN_FAILED = "Login failed.";
    public static final String LOGIN_SUCCESSFUL = "Login successful.";
    public static final String SERVER_NOT_AVAILABLE = "Server is not available.";

    public static final float HEALTH_DATA_WARNING_MAX = (float)37.5;
    public static final float HEALTH_DATA_WARNING_MIN = (float)36.2;
    public static final float TOTAL_SENSORS = 4;

    public static final float HEALTH_DATA_CRITICAL_MAX = (float)39.0;
    public static final float HEALTH_DATA_CRITICAL_MIN = (float)34.0;

    public static final int LEVEL_NORMAL = 0;
    public static final int LEVEL_WARNING = 1;
    public static final int LEVEL_CRITICAL = 2;

    public static final int MARGIN_X = 35;
    public static final int MARGIN_Y = 25;
    public static final int STEP_X = 20;

    public static final int COLOR_NORMAL = 65280;
    public static final int COLOR_WARNING = 16776960;
    public static final int COLOR_CRITICAL = 16711680;

    public static final String RECORD_STORE_NAME = "HealthcareSupportSystem";
}
