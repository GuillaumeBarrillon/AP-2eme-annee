package RestoSwing;

public class ConvertisseurJson {

    public static String ConveritsseurEtatJson(int idEtat) {
        if (idEtat == 0) {
            return "Commande en attente";
        }
        else if (idEtat == 1)
        {
            return "Commande acceptée";
        }
        else if (idEtat == 2) {
            return "Commande terminée";
        }
        else if(idEtat == 3)
        {
            return "Commande refusée";
        }
        else
        {
            return " ";
        }
    }
}
