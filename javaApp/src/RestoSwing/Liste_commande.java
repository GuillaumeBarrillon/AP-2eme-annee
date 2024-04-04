package RestoSwing;

import javax.swing.*;
import javax.swing.table.DefaultTableModel;
import java.awt.*;
import java.util.ArrayList;

public class Liste_commande extends JFrame {
    private ArrayList<Commande> listCommandes;
    private JTable jTable3;

    public Liste_commande(ArrayList<Commande> commandesList) {
        this.listCommandes = commandesList;
        setTitle("RestoSwing");
        setSize(800, 600);
        setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        setLocationRelativeTo(null);
        setResizable(false);
        setLayout(null); // Set layout to null

        JLabel jLabel1 = new JLabel("Commande", SwingConstants.CENTER);
        jLabel1.setFont(new Font("Segoe UI", Font.BOLD, 36));
        jLabel1.setBounds(280, 0, 200, 50); // Set position and size
        add(jLabel1);

        jTable3 = new JTable();
        JScrollPane jScrollPane3 = new JScrollPane(jTable3);
        jScrollPane3.setBounds(10, 60, 600, 450); // Set position and size
        add(jScrollPane3);

        JButton BoutonDetails = new JButton("Détail");
        BoutonDetails.addActionListener(e -> {
            if(jTable3.getSelectedRow() != -1){
                new LigneFrame(listCommandes.get(jTable3.getSelectedRow()));
            }
        });
        BoutonDetails.setBounds(620, 150, 100, 30);
        add(BoutonDetails);

        JButton quitButton = new JButton("Quitter");
        quitButton.addActionListener(e -> System.exit(0));
        quitButton.setBounds(510, 520, 100, 30);
        add(quitButton);

        populateTable();
        setVisible(true);
    }

    private void populateTable() {
        Object[][] donneesTableau = new Object[listCommandes.size()][6];
        for (int i = 0; i < listCommandes.size(); i++) {
            Commande commande = listCommandes.get(i);
            donneesTableau[i][0] = commande.getId();
            donneesTableau[i][1] = commande.getDate().split(" ")[0];
            donneesTableau[i][2] = commande.getDate().split(" ")[1];
            donneesTableau[i][3] = ConvertisseurJson.ConveritsseurEtatJson(commande.getIdEtat());
            donneesTableau[i][4] = commande.getLignesCommande().size();
            donneesTableau[i][5] = commande.getTotalCommande();
        }
        jTable3.setModel(new DefaultTableModel(
                donneesTableau,
                new String [] {
                        "id", "date", "heure", "etat", "nombre plat", "montant"
                }
        ));
    }
}