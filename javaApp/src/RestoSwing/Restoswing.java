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

        // Ici, nous définissons l'URL de notre JSON. Nous avons changé le nom pour "test1".
        String jsonUrl = "http://localhost/projets/SIO2/AP/AP-2eme-annee/api/commandes_en_attente.php";

        // Nous utilisons l'URL pour faire une requête et obtenir une réponse.
        String jsonResponse = NetworkUtils.request(jsonUrl);

        // Nous vérifions si la réponse n'est pas nulle.
        if (jsonResponse != null) {

            try {
                // Nous convertissons la réponse en un objet JSON.
                JSONObject json = new JSONObject(jsonResponse);
                System.out.println(json);

                // Nous obtenons le tableau "commandes" de l'objet JSON.
                JSONArray commandesArray = json.getJSONArray("commandes");

                // Nous parcourons le tableau "commandes".
                for (int i = 0; i < commandesArray.length(); i++) {

                    // Pour chaque élément du tableau, nous créons un nouvel objet Commande.
                    JSONObject commandeObject = commandesArray.getJSONObject(i);
                    Commande commande = new Commande();

                    // Nous définissons les propriétés de l'objet Commande.
                    commande.setId(commandeObject.getInt("id_commande"));
                    commande.setIdUser(commandeObject.getInt("id_user"));
                    commande.setIdEtat(commandeObject.getInt("id_etat"));
                    commande.setTypeConso(commandeObject.getInt("type_conso"));
                    commande.setDate(commandeObject.getString("date"));
                    commande.setTotalCommande(commandeObject.getDouble("total_commande"));
                    commande.setLogin(commandeObject.getString("login"));

                    // Nous obtenons le tableau "lignes" de l'objet Commande.
                    JSONArray lignesArray = commandeObject.getJSONArray("lignes");
                    ArrayList<Ligne> lignesList = new ArrayList<>();

                    // Nous parcourons le tableau "lignes".
                    for (int j = 0; j < lignesArray.length(); j++) {
                        // Pour chaque élément du tableau, nous créons un nouvel objet Ligne.
                        JSONObject ligneObject = lignesArray.getJSONObject(j);
                        Ligne ligne = new Ligne(
                                ligneObject.getInt("id_ligne"),
                                ligneObject.getInt("id_produit"),
                                ligneObject.getInt("qte"),
                                ligneObject.getString("total_ligne_ht")
                        );
                        // Nous ajoutons l'objet Ligne à la liste des lignes.
                        lignesList.add(ligne);

                        System.out.println(commandesList);
                        System.out.println(lignesList);
                    }

                    // Nous définissons les lignes de la commande.
                    commande.setLignesCommande(lignesList);
                    // Nous ajoutons la commande à la liste des commandes.
                    commandesList.add(commande);

                }

                // Nous créons un nouvel objet Liste_commande avec la liste des commandes.
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