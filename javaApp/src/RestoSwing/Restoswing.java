package RestoSwing;

import org.json.JSONArray;
import org.json.JSONObject;

import java.util.ArrayList;

import javax.swing.*;

public class Restoswing {

    public static void main(String[] args) {
        try {
            UIManager.setLookAndFeel(UIManager.getSystemLookAndFeelClassName());
        } catch (ClassNotFoundException | InstantiationException | IllegalAccessException |
                 UnsupportedLookAndFeelException e) {
        }   // Permet de donner un aspect adapté à l'appareil

        ArrayList<Commande> commandesList = new ArrayList<>();
        String jsonUrl = "http://127.0.0.1/projets/SIO2/AP/AP-2eme-annee/api/commandes_en_attente.php";
        String jsonResponse = NetworkUtils.request(jsonUrl);

        if (jsonResponse != null) {

            try {
                JSONObject json = new JSONObject(jsonResponse);
                System.out.println(json);

                JSONArray commandesArray = json.getJSONArray("commandes");

                for (int i = 0; i < commandesArray.length(); i++) {

                    JSONObject commandeObject = commandesArray.getJSONObject(i);
                    Commande commande = new Commande();

                    commande.setId(commandeObject.getInt("id_commande"));
                    commande.setIdUser(commandeObject.getInt("id_user"));
                    commande.setIdEtat(commandeObject.getInt("id_etat"));
                    commande.setTypeConso(commandeObject.getInt("type_conso"));
                    commande.setDate(commandeObject.getString("date"));
                    commande.setTotalCommande(commandeObject.getDouble("total_commande"));

                    JSONArray lignesArray = commandeObject.getJSONArray("lignes");
                    ArrayList<Ligne> lignesList = new ArrayList<>();

                    for (int j = 0; j < lignesArray.length(); j++) {
                        JSONObject ligneObject = lignesArray.getJSONObject(j);
                        Ligne ligne = new Ligne(
                                ligneObject.getInt("id_ligne"),
                                ligneObject.getInt("id_produit"),
                                ligneObject.getInt("qte"),
                                ligneObject.getString("total_ligne_ht")
                        );
                        lignesList.add(ligne);

                        System.out.println(commandesList);
                        System.out.println(lignesList);
                    }

                    commande.setLignesCommande(lignesList);
                    commandesList.add(commande);

                }

                Liste_commande listCommande = new Liste_commande(commandesList);

            } catch (Exception e) {
                e.printStackTrace();
                System.out.println(e);
            }
        } else {
            System.out.println("Erreur");
        }


    }
}