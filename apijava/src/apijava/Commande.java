/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package apijava;

/**
 *
 * @author CN503273
 */
public class Commande {
    
    private int id_commande;
    private int id_user;
    private int id_etat;
    private String date;
    private double total_commande;
    private int type_conso;
    
    public Commande(int id_commande, int id_user, int id_etat, String date, double total_commande, int type_conso){
        this.id_commande = id_commande;
        this.id_user = id_user;
        this.id_etat = id_etat;
        this.date = date;
        this.total_commande = total_commande;
        this.type_conso = type_conso;
    }
    
    public void set_commande(int id_commande){
        this.id_commande = id_commande;
    }
    
    public int get_commande(){
        return id_commande;
    }
    
    public void set_user(int id_user){
        this.id_user = id_user;
    }
    
    public int get_user(){
        return id_user;
    }
    
    public void set_etat(int id_etat){
        this.id_etat = id_etat;
    }
    
    public int get_etat(){
        return id_etat;
    }
    
    public void set_date(String date){
        this.date = date;
    }
    
    public String get_date(){
        return date;
    }
    
    public void set_total(double total_commande){
        this.total_commande = total_commande;
    }
    
    public double get_total(){
        return total_commande;
    }
    
    public void set_conso(int type_conso){
        this.type_conso = type_conso;
    }
    
    public int get_conso(){
        return type_conso;
    }
    
    public void afficher(){
        System.out.println("ID noces : "+id_commande);
        System.out.println("Durée : "+id_user);
        System.out.println("Libellé : "+id_etat);
        System.out.println("Libellé : "+date);
        System.out.println("Libellé : "+total_commande);
        System.out.println("Libellé : "+type_conso);
    }
}
