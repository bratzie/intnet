import java.io.*;
import java.net.*;

/**
 * A primitive bot that opens up a connection to a host and initializes
 * 100 sessions which linearly guess a number until it is successful.
 *
 * In the end it prints the total amount of guesses as well as the average
 * guess count.
 */
public class Guessbot {

    /**
     * Main method, bro!
     *
     * @param args String host, int port.
     */
    public static void main(String[] args) {
        URL url;
        BufferedReader receiver = null;
        HttpURLConnection con;
        String cookie = ""; // get a cookie and save it so we can send it back later
        int sum = 0;
        final int numberOfGuesses = 100;
        final int numberOfGames = 10;
        int gamesPlayed = 0;

        for (gamesPlayed = 0; gamesPlayed < numberOfGames;) {

            try {
                url = new URL("http",args[0],Integer.parseInt(args[1]),"/");
                con = (HttpURLConnection)url.openConnection();
                con.connect();
                cookie = con.getHeaderField(2).split(";")[0].replace(" ", "");
                System.out.print(cookie + ": ");
            } catch (Exception e){
                System.out.println(e.getMessage());
            }

            for (int i = 0; i <= numberOfGuesses; i++) {
                String guess = "/?nr=" + i;

                try {
                    url = new URL("http","130.229.128.247",8080,guess);
                    con = (HttpURLConnection)url.openConnection();

                    con.setRequestProperty("Cookie", cookie);
                    con.connect();

                    receiver = new BufferedReader(new InputStreamReader(con.getInputStream()));

                    String rad;
                    try {
                        while( (rad=receiver.readLine()) != null){
                            if (rad.contains("Well done")) {
                                System.out.println("You guessed " + i + " times. Game is reset.");
                                sum+=i;
                                gamesPlayed++;
                                i = 101;
                            }
                        }
                    } catch(IOException e){
                        System.out.println(e.getMessage());
                    }

                } catch (Exception e){
                    System.out.println(e.getMessage());
                }
            }
        }

        System.out.println("========================================================");
        System.out.println("FINISHED!");
        System.out.println("");
        System.out.println("You played " + gamesPlayed + " games and guessed " + sum + " times in total.");
        System.out.println("Your average guess was " + sum/gamesPlayed);
        System.out.println("========================================================");
    }
}
