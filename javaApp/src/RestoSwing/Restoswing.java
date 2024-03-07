package RestoSwing;

import netscape.javascript.JSObject;
import org.json.JSONArray;
import org.json.JSONObject;

import java.util.ArrayList;

import javax.swing.*;
import java.net.URL;

public class Restoswing {

    public static void main(String[] args) {
        try {
            UIManager.setLookAndFeel(UIManager.getSystemLookAndFeelClassName());
        } catch (ClassNotFoundException | InstantiationException | IllegalAccessException |
                 UnsupportedLookAndFeelException e) {
        }   // Permet de donner un aspect adapté à l'appareil
        List_commande list_commande = new List_commande(); // Créer l'application

        ArrayList<Commande> commandesList = new ArrayList<>();
        String jsonUrl = "127.0.0.1/projets/SIO2/AP/AP-2eme-annee/api/commandes_en_attente.php";
        String jsonResponse = NetworkUtils.request(jsonUrl);

        if (jsonResponse != null) {

            try {
                JSONObject json = new JSONObject(jsonResponse);

                JSONArray commandesArray = json.getJSONArray("commandes");

                for (int i = 0; i < commandesArray.length(); i++) {

                    JSONObject commandeObject = commandesArray.getJSONObject(i);
                    Commande commande = new Commande();

                    commande.setId(commandeObject.getInt("id"));
                    commande.setIdUser(commandeObject.getInt("id_user"));
                    commande.setIdEtat(commandeObject.getInt("id_etat"));
                    commande.setTypeConso(commandeObject.getInt("type_conso"));
                    commande.setDate(commandeObject.getString("date"));
                    commande.setTotalCommande(commandeObject.getDouble("total_commande"));

                    JSONArray lignesArray = commandeObject.getJSONArray("lignes");
                    ArrayList<List_commande> lignesList = new ArrayList<>();

                    for (int j = 0; j < lignesArray.length(); j++) {
                        JSONObject ligneObject = lignesArray.getJSONObject(j);
                        List_commande ListCommande = new List_commande();

                        ListCommande.setId(ligneObject.getInt("id"));
                        JSONObject produitObject = ligneObject.getJSONObject("produit");
                        ListCommande.setIdProduit(produitObject.getInt("id"));
                        ListCommande.setLibProduit(produitObject.getString("libelle"));
                        ListCommande.setPrixHT(produitObject.getDouble("prix_ht"));
                        ListCommande.setPhoto(produitObject.getString("photo"));
                        ListCommande.setQte(ligneObject.getInt("qte"));

                        lignesList.add(ListCommande);

                        System.out.println(commandesList);
                        System.out.println(lignesList);
                    }

                    commande.setLignesCommande(lignesList);
                    commandesList.add(commande);

                }
            } catch (Exception e) {
                System.out.println(e);
            }
        } else {
            System.out.println("Erreur");
        }


    }
}