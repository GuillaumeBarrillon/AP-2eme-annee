package RestoSwing;

import javax.swing.*;
import javax.swing.table.DefaultTableModel;
import javax.swing.table.JTableHeader;
import java.awt.*;
import java.util.ArrayList;

public class LigneFrame extends JDialog {
    public LigneFrame(Commande commande) {
        ArrayList<Ligne> lignes = commande.getLignesCommande();
        int idCommande = commande.getId();

        setTitle("Lignes de commande");
        setSize(800, 800);
        setDefaultCloseOperation(JFrame.DISPOSE_ON_CLOSE);
        setLocationRelativeTo(null);
        setResizable(false);
        setLayout(null);
        setVisible(true);

        JPanel panel = new JPanel();
        panel.setLayout(null);


        JLabel titre = new JLabel("RestoSwing", SwingConstants.CENTER);
        titre.setBounds(0, 0, 800, 40);
        titre.setFont(new Font("Arial", Font.BOLD, 30));
        panel.add(titre);

        JLabel sousTitre = new JLabel("Details d'une commande", SwingConstants.CENTER);
        sousTitre.setBounds(0,40, 800, 40);
        sousTitre.setFont(new Font("Arial", Font.PLAIN, 20));
        panel.add(sousTitre);

        JLabel labelID = new JLabel("<html><b>ID commande : <b>" + idCommande);
        labelID.setBounds(10, 100, 150, 20);
        labelID.setFont(new Font("Arial", Font.PLAIN, 15));
        panel.add(labelID);

        JLabel labelDate = new JLabel("<html><b>Date : <b>" + commande.getDate());
        labelDate.setBounds(10, 120, 200, 20);
        labelDate.setFont(new Font("Arial", Font.PLAIN, 15));
        panel.add(labelDate);

        JLabel labelLogin = new JLabel("<html><b>Login : <b>" + commande.getLogin());
        labelLogin.setBounds(10, 140, 200, 20);
        labelLogin.setFont(new Font("Arial", Font.PLAIN, 15));
        panel.add(labelLogin);

        String[] columnNames = {"ID", "Plat", "Quantité"};
        DefaultTableModel tableModel = new DefaultTableModel(columnNames, 0);
        JTable table = new JTable(tableModel);
        for (int i = 0; i < lignes.size(); i++) {
            Ligne ligne = lignes.get(i);
            tableModel.addRow(new Object[]{ligne.getId_ligne(), ligne.getId_produit(), ligne.getQte()});
        }
        table.setBounds(0, 0, 600, 500);

        JTableHeader header = table.getTableHeader();
        JPanel panelTable = new JPanel();
        panelTable.setLayout(new BorderLayout());
        panelTable.add(header, BorderLayout.NORTH);
        panelTable.add(table, BorderLayout.CENTER);
        panelTable.setBounds(10, 200, 600, 500);
        panel.add(panelTable);

        JButton acceptButton = new JButton("Accepter");
        acceptButton.addActionListener((e) -> {
            NetworkUtils.request("http://127.0.0.1/projets/SIO2/AP/AP-2eme-annee/api/commande_accepter.php?id_commande=" + idCommande);
        });
        acceptButton.setBounds(620, 200, 150, 30);
        panel.add(acceptButton);

        JButton refusButton = new JButton("Refuser");
        refusButton.addActionListener((e) -> {
            NetworkUtils.request("http://127.0.0.1/projets/SIO2/AP/AP-2eme-annee/api/commande_refuser.php?id_commande=" + idCommande);
        });
        refusButton.setBounds(620, 250, 150, 30);
        panel.add(refusButton);

        JButton preteButton = new JButton("Prête");
        preteButton.addActionListener((e) -> {
            NetworkUtils.request("http://127.0.0.1/projets/SIO2/AP/AP-2eme-annee/api/commande_terminer.php?id_commande=" + idCommande);
        });
        preteButton.setBounds(620, 300, 150, 30);
        panel.add(preteButton);

        JButton revenirButton = new JButton("Revenir");
        revenirButton.addActionListener((e) -> {
            dispose();
        });
        revenirButton.setBounds(460, 710, 150, 30);
        panel.add(revenirButton);

       setContentPane(panel);
    }
}