package RestoSwing;

public class Ligne {

    private int id_ligne;
    private int id_produit;
    private int qte;
    private String totalLigneHt;

    public Ligne(int id_ligne, int id_produit, int qte, String totalLigneHt) {
        this.id_ligne = id_ligne;
        this.id_produit = id_produit;
        this.qte = qte;
        this.totalLigneHt = totalLigneHt;
    }

    public int getId_ligne() {
        return id_ligne;
    }

    public int getId_produit() {
        return id_produit;
    }

    public int getQte() {
        return qte;
    }

    public String getTotalLigneHt() {
        return totalLigneHt;
    }
}
