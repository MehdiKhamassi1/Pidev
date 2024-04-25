package services;


import Util.DataSource;
import entities.DossierMedical;
import entities.Statut;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;

import java.sql.*;
import java.util.ArrayList;
import java.util.List;
import java.util.logging.Level;
import java.util.logging.Logger;
import java.util.stream.Collectors;

public class ServiceDossierMedical implements Iservice<DossierMedical> {
    Connection conn = DataSource.getInstance().getConn();

    public ServiceDossierMedical() {
    }
    public void ajouter(DossierMedical t) {
        Connection conn = DataSource.getInstance().getConn();
        try {
            String query = "INSERT INTO `dossiermedical`(`patient_id`, `groupesang`, `maladie_chronique`, `resultat_analyse`) VALUES (?, ?, ?, ?)";

            // Prepare the statement with parameters to avoid SQL injection
            try (PreparedStatement pst = conn.prepareStatement(query)) {
                if (t.getResultat_analyse() == Statut.NEGATIVE) {
                    pst.setString(4, "NEGATIVE");
                } else if (t.getResultat_analyse() == Statut.POSITIVE ) {
                    pst.setString(4, "POSITIVE");
                }
                pst.setString(2, t.getGroupesang());
                pst.setString(3, t.getMaladie_chronique());
                pst.setString(1, String.valueOf(t.getPatient_id()));


                System.out.println("Query: " + pst); // Print the query for debugging

                // Execute the query
                pst.executeUpdate();
                System.out.println("Medical file added successfully!");
            }
        } catch (SQLException ex) {
            System.err.println("Error adding medical file: " + ex.getMessage());
        }
    }

    public void modifier(DossierMedical t, int id) {
        try {
            String query = "UPDATE `dossiermedical` SET `patient_id`='" + t.getPatient_id() + "',`groupesang`='" + t.getGroupesang() + "',`maladie_chronique`='" + t.getMaladie_chronique() + "',`resultat_analyse`='" + t.getResultat_analyse() + "' WHERE id=" + id;
            Statement st = this.conn.createStatement();
            st.executeUpdate(query);
        } catch (SQLException var5) {
            Logger.getLogger(ServiceDossierMedical.class.getName()).log(Level.SEVERE, (String)null, var5);
        }

    }

    public Statut retrieveStatutById(int statutId) {
        Statut statut = null;

        try {
            String qry = "SELECT * FROM statut WHERE id = ?";
            System.out.println(qry);
            this.conn = DataSource.getInstance().getConn();
            PreparedStatement stm = this.conn.prepareStatement(qry);
            stm.setInt(1, statutId);
            ResultSet rs = stm.executeQuery();
            if (rs.next()) {
                int id = rs.getInt("id");
                String libelle = rs.getString("libelle");
                statut = Statut.valueOf(rs.getString("libelle"));
            }
        } catch (SQLException var8) {
            System.out.println(var8.getMessage());
        }

        return statut;
    }

   /* public ObservableList<DossierMedical> getAllTriTitre() {
        ObservableList<DossierMedical> list = FXCollections.observableArrayList();

        try {
            String qry = "SELECT * FROM dossiermedical ORDER BY groupsang";
            System.out.println(qry);
            this.conn = DataSource.getInstance().getConn();
            Statement stm = this.conn.createStatement();
            ResultSet rs = stm.executeQuery(qry);

            while(rs.next()) {

                int patient_id = rs.getInt("patient_id");
                String groupesang = rs.getString("groupesang");
                int resultat_analyse_id = rs.getInt("resultat_analyse");
                Statut reslutat_analyse = this.retrieveStatutById(resultat_analyse_id);
                String maladie_chronique = rs.getString("maladie_chronique");
                DossierMedical a = new DossierMedical( patient_id,groupesang,reslutat_analyse,maladie_chronique);
                list.add(a);

            }
        } catch (SQLException var13) {
            System.out.println(var13.getMessage());
        }

        return list;
    }*/

    public void supprimer(int id) throws Exception {
        try {
            String query = "DELETE FROM `dossiermedical` WHERE id=" + id;
            Statement st = this.conn.createStatement();
            st.executeUpdate(query);
            System.out.println("Medical file deleted successfully!");
        } catch (SQLException var4) {
            Logger.getLogger(ServiceDossierMedical.class.getName()).log(Level.SEVERE, (String)null, var4);
        }



    }

    public List<DossierMedical> afficher() {
        List<DossierMedical> lr = new ArrayList<>();
        try {
            String query = "SELECT * FROM `dossiermedical`";
            Statement st = this.conn.createStatement();
            ResultSet rs = st.executeQuery(query);
            while (rs.next()) {
                DossierMedical r = new DossierMedical();
                r.setGroupesang(rs.getString("groupesang"));

                String patientIdStr = rs.getString("patient_id");
                if (patientIdStr != null) {
                    try {
                        int patientId = Integer.parseInt(patientIdStr);
                        r.setPatient_id(patientId);
                    } catch (NumberFormatException e) {
                        Logger.getLogger(ServiceDossierMedical.class.getName()).log(Level.WARNING, "Invalid patient_id format: " + patientIdStr, e);
                    }
                } else {

                    Logger.getLogger(ServiceDossierMedical.class.getName()).log(Level.WARNING, "patient_id is null for record");
                    continue;
                }
                r.setMaladie_chronique(rs.getString("maladie_chronique"));
                r.setResultat_analyse(Statut.valueOf(rs.getString("resultat_analyse")));
                r.setId(rs.getInt("id"));
                lr.add(r);
            }

        } catch (SQLException var6) {
            Logger.getLogger(ServiceDossierMedical.class.getName()).log(Level.SEVERE, (String)null, var6);
        }
        return lr;
    }

    public DossierMedical getDossierMedicalById(int id) {
        try {
            String req = "SELECT * FROM dossiermedical WHERE id=?";
            PreparedStatement pst = this.conn.prepareStatement(req);
            pst.setInt(1, id);
            ResultSet rs = pst.executeQuery();
            if (rs.next()) {
                DossierMedical dossierMedical = new DossierMedical();
                dossierMedical.setId(rs.getInt("id"));
                dossierMedical.setPatient_id(rs.getInt("patient_id"));
                dossierMedical.setGroupesang(rs.getString("groupesang"));
                dossierMedical.setMaladie_chronique(rs.getString("maladie_chronique"));
                // Retrieve the string value from the database
                String resultat_analyse = rs.getString("resultat_analyse");
                // Convert the string value to the corresponding enum value
                Statut statut = Statut.valueOf(resultat_analyse);
                dossierMedical.setResultat_analyse(statut);
                return dossierMedical;
            }
        } catch (SQLException e) {
            System.out.println("Error retrieving dossier medical: " + e.getMessage());
        }

        return null;
    }

    public DossierMedical getDossierMedicalByConsultationId(int id) {
        try {
            String req = "SELECT * FROM dossiermedical WHERE id = (SELECT dossiermedical_id FROM consultation WHERE id = ?)";
            PreparedStatement pst = this.conn.prepareStatement(req);
            pst.setInt(1, id);
            ResultSet rs = pst.executeQuery();
            if (rs.next()) {
                DossierMedical dossierMedical = new DossierMedical();
                dossierMedical.setId(rs.getInt("id"));
                dossierMedical.setPatient_id(rs.getInt("patient_id"));
                dossierMedical.setGroupesang(rs.getString("groupesang"));
                dossierMedical.setMaladie_chronique(rs.getString("maladie_chronique"));
                // Retrieve the string value from the database
                String resultat_analyse = rs.getString("resultat_analyse");
                // Convert the string value to the corresponding enum value
                Statut statut = Statut.valueOf(resultat_analyse);
                dossierMedical.setResultat_analyse(statut);
                return dossierMedical;
            }
        } catch (SQLException e) {
            System.out.println("Error retrieving dossier medical by consultation ID: " + e.getMessage());
        }

        return null;
    }



/*
    public List<String> getAllTitre() {
        List<String> ln = (List)this.afficher().stream().map((tr) -> {
            return tr.getTitre_rec();
        }).collect(Collectors.toList());
        return ln;
    }

    public int getdossiermedicalByTitre(String titre) {
        DossierMedical t = (DossierMedical)this.afficher().stream().filter((tr) -> {
            return tr.getTitre_rec().equals(titre);
        }).findFirst().orElse((DossierMedical) null);
        return t != null ? t.getId() : 0;
    }

    public List<DossierMedical> search(String fieldName, String value) {
        List<DossierMedical> result = new ArrayList();

        try {
            String query = "SELECT * FROM `dossiermedical` WHERE " + fieldName + " LIKE ?";
            PreparedStatement st = this.conn.prepareStatement(query);
            st.setString(1, "%" + value + "%");
            ResultSet rs = st.executeQuery();

            while(rs.next()) {
                DossierMedical r = new DossierMedical();
                r.setContenu_rec(rs.getString("contenu_rec"));
                r.setUsername(rs.getString("username"));
                r.setType_rec(rs.getString("type_rec"));
                r.setTitre_rec(rs.getString("titre_rec"));
                r.setStatut_rec(Statut.valueOf(rs.getString("statut_rec")));
                r.setId(rs.getInt("id"));
                result.add(r);
            }
        } catch (SQLException var8) {
            Logger.getLogger(ServiceDossierMedical.class.getName()).log(Level.SEVERE, (String)null, var8);
        }

        return result;
    }

    public List<DossierMedical> affichage_trie() {
        List<DossierMedical> lr = new ArrayList();

        try {
            String query = "SELECT * FROM `dossiermedical` ORDER BY  username";
            Statement st = this.conn.createStatement();
            ResultSet rs = st.executeQuery(query);

            while(rs.next()) {
                DossierMedical r = new DossierMedical();
                r.setContenu_rec(rs.getString("contenu_rec"));
                r.setUsername(rs.getString("username"));
                r.setType_rec(rs.getString("type_rec"));
                r.setTitre_rec(rs.getString("titre_rec"));
                r.setStatut_rec(Statut.valueOf(rs.getString("statut_rec")));
                r.setId(rs.getInt("id"));
                lr.add(r);
            }
        } catch (SQLException var6) {
            Logger.getLogger(ServiceDossierMedical.class.getName()).log(Level.SEVERE, (String)null, var6);
        }

        return lr;
    }

 */
}
