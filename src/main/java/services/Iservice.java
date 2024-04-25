package services;
import java.util.List;

public interface Iservice<T> {
    void ajouter(T var1);

    void modifier(T var1, int var2);

    void supprimer(int var1) throws Exception;

    List<T> afficher();
}
