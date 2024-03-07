package RestoSwing;

import javax.swing.*;

public class Restoswing {

    public static void main(String[] args) {
        try {
            UIManager.setLookAndFeel(UIManager.getSystemLookAndFeelClassName());
        } catch (ClassNotFoundException | InstantiationException | IllegalAccessException |
                 UnsupportedLookAndFeelException e) {
        }   // Permet de donner un aspect adapté à l'appareil
        List_commande list_commande = new List_commande();

    }
}