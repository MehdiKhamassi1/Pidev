package entities;


public class DossierMedical {
    private int patient_id;
    private int id;
    
    private String groupesang;
    private String maladie_chronique;
    private Statut resultat_analyse;


    public DossierMedical() {
    }

    public DossierMedical(int patient_id,String groupesang, Statut resultat_analyse, String maladie_chronique) {
        this.groupesang = groupesang;
        this.maladie_chronique = maladie_chronique;
        this.patient_id = patient_id;
        this.resultat_analyse = resultat_analyse;

    }

    public int getId() {
        return this.id;
    }

    public void setId(int id) {
        this.id = id;
    }
    public int getPatient_id() {
        return this.patient_id;
    }

    public void setPatient_id(int patient_id) {
        this.patient_id=patient_id;
    }

    public String getGroupesang() {
        return this.groupesang;
    }

    public void setGroupesang(String groupsang) {
        this.groupesang = groupsang;
    }

    public String getMaladie_chronique() {
        return this.maladie_chronique;
    }

    public void setMaladie_chronique(String maladie_chronique) {
        this.maladie_chronique = maladie_chronique;
    }


    public Statut getResultat_analyse() {
        return this.resultat_analyse;
    }

    public void setResultat_analyse(Statut resultat_analyse) {
        this.resultat_analyse = resultat_analyse;
    }



    public String toString() {
        return "Dossier{id=" + this.id + ",patient_id=" + this.patient_id + ", groupsang=" + this.groupesang + ", maladie_chronique=" + this.maladie_chronique + ", resultat_analyse=" + this.resultat_analyse  + "}";
    }
}
