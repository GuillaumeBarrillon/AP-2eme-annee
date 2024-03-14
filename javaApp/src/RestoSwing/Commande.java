package RestoSwing;

import java.util.ArrayList;

public class Commande {

    private int id;
    private int idUser;
    private int idEtat;
    private int typeConso;
    private String date;
    private double totalCommande;
    private ArrayList<Ligne> LignesCommande;

    public Commande() {
        this.LignesCommande = new ArrayList<>();
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public int getIdUser() {
        return idUser;
    }

    public void setIdUser(int idUser) {
        this.idUser = idUser;
    }

    public int getIdEtat() {
        return idEtat;
    }

    public void setIdEtat(int idEtat) {
        this.idEtat = idEtat;
    }

    public int getTypeConso() {
        return typeConso;
    }

    public void setTypeConso(int typeConso) {
        this.typeConso = typeConso;
    }

    public String getDate() {
        return date;
    }

    public void setDate(String date) {
        this.date = date;
    }

    public double getTotalCommande() {
        return totalCommande;
    }

    public void setTotalCommande(double totalCommande) {
        this.totalCommande = totalCommande;
    }

    public ArrayList<Ligne> getLignesCommande() {
        return LignesCommande;
    }

    public void setLignesCommande(ArrayList<Ligne> lignesCommande) {
        this.LignesCommande = lignesCommande;
    }
}
