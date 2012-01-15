/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

package Logic;

import javax.microedition.lcdui.Font;
import javax.microedition.lcdui.Graphics;

/**
 *
 * @author Sarbodaya Kandel
 */
public class PersonalInformation {
    private String personalDetail[];
    private String legend[][] = new String[3][2];
    private int marginY = 5;
    private int marginX = 5;
    private int currentHeight = 5;

    public PersonalInformation(String personalDetail[]){
        this.personalDetail = personalDetail;

        legend[0][0] = "Normal";
        legend[0][1] = String.valueOf(Constant.COLOR_NORMAL);

        legend[1][0] = "Warning";
        legend[1][1] = String.valueOf(Constant.COLOR_WARNING);

        legend[2][0] = "Critical";
        legend[2][1] = String.valueOf(Constant.COLOR_CRITICAL);
    }

    private int setTitle(String title, Graphics g, int dy){
        g.setColor(255, 255, 255);
        g.setFont(Font.getFont(Font.FACE_PROPORTIONAL, Font.STYLE_BOLD, Font.SIZE_MEDIUM));
        g.drawString(title, marginX, dy, Graphics.LEFT | Graphics.TOP);
        dy = dy + g.getFont().getHeight();
        return dy;
    }

    public void displayPersonalInformation(Graphics g){
        int dy = marginY;

        if(personalDetail != null){
            dy = setTitle("Personal information", g, dy);
            g.setColor(125, 125, 125);
            g.setFont(Font.getFont(Font.FACE_PROPORTIONAL, Font.STYLE_PLAIN, Font.SIZE_SMALL));

            for(int i = 0; i < personalDetail.length - 1; i++){
                if(personalDetail[i] != null){
                    g.drawString(personalDetail[i], marginX , dy, Graphics.LEFT | Graphics.TOP);
                    dy = dy + g.getFont().getHeight();
                }
            }
        }
        currentHeight = dy;
    }

    public void displayLegend(Graphics g){
        int dy = setTitle("Legend", g, currentHeight);
        g.setFont(Font.getFont(Font.FACE_PROPORTIONAL, Font.STYLE_PLAIN, Font.SIZE_SMALL));
        
        for(int i = 0; i < legend.length; i++){
            g.setColor(Integer.parseInt(legend[i][1]));
            g.fillRect(5, dy + g.getFont().getHeight() / 4, 4, g.getFont().getHeight() / 2);

            g.setColor(125, 125, 125);
            g.drawString(legend[i][0], marginX + 10, dy, Graphics.LEFT | Graphics.TOP);

            dy = dy + g.getFont().getHeight();
        }
    }
}
