import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.PrintStream;
import java.net.ServerSocket;
import java.net.Socket;
import java.util.HashMap;
import java.util.StringTokenizer;

/**
 * A webserver hosting a very simple game.
 */
public class HttpServer {

    private static String htmlStart = "<html>";
    private static String htmlForm = "<p>Guess a number between 0-100 <form method = get> <p>Guess a number: <input type=text name=nr> <input type=submit value=\"Send\"></form>";
    private static String htmlEnd = "</html>";

    private static int nextID = 0;

    private static HashMap<Integer, Integer> hiddenNumbers = new HashMap<Integer, Integer>(); // cookieID&hiddenNumber
    private static HashMap<Integer, Integer> numberOfGuesses = new HashMap<Integer, Integer>(); // cookieID&NumberofGuesses

    /**
     * Main method, girl!
     *
     * @param args
     * @throws IOException
     */
    public static void main(String[] args) throws IOException {
        System.out.println("Skapar Serversocket");
        int cookieID;
        int guess;
        boolean unvalidInput;
        ServerSocket ss = new ServerSocket(8080);
        while (true) {
            cookieID = -1;
            guess = -1;
            unvalidInput = false;
            System.out.println("Väntar på klient...");
            Socket s = ss.accept();
            System.out.println("Klient är ansluten");
            BufferedReader request = new BufferedReader(new InputStreamReader(
                    s.getInputStream()));
            String str = request.readLine();
            System.out.println(str);
            if (str.contains("nr")) {
                try {
                    guess = new Integer(str.split("=")[1].split(" ")[0]);
                    if (guess < 0 || guess > 100) {
                        unvalidInput = true;
                    }
                } catch (Exception e) {
                    unvalidInput = true;
                }
            }
            StringTokenizer tokens = new StringTokenizer(str, " ?");
            tokens.nextToken(); // Ordet GET
            String requestedDocument = tokens.nextToken();
            while ((str = request.readLine()) != null && str.length() > 0) {
                System.out.println(str);
                if (str.startsWith("Cookie:")) {
                    cookieID = new Integer(str.split("=")[1]);
                }
            }
            System.out.println("Förfrågan klar.");
            s.shutdownInput();

            PrintStream response = new PrintStream(s.getOutputStream());

            response.println("HTTP/1.1 200 OK");
            response.println("Server : Slask 0.1 Beta");
            if (requestedDocument.contains(".html"))
                response.println("Content-Type: text/html");
            if (requestedDocument.contains(".gif"))
                response.println("Content-Type: image/gif");

            if (cookieID < 0) {
                resetGame(nextID);
                response.println("Set-Cookie: clientId= " + nextID
                        + "; expires=Wednesday,31-Dec-14 21:00:00 GMT");
                nextID++;
            }
            response.println();

            response.print(htmlStart);
            response.print(htmlForm);
            if (guess != -1) {
                try {
                    response.print(dynamic(guess, cookieID));
                    response.print("You have made "
                            + numberOfGuesses.get(cookieID) + "guess(es).");
                } catch (NullPointerException e) {
                }
            } else if (unvalidInput) {
                response.print("Please do only enter digits between 0-100");
            }
            response.print(htmlEnd);

            s.shutdownOutput();
            s.close();
        }
    }

    private static void resetGame(int id) {
        hiddenNumbers.put(id, (int) (Math.random() * 100));
        numberOfGuesses.put(id, 0);
    }

    private static String dynamic(Integer guess, Integer cookieID) throws NullPointerException {
        int hidden = hiddenNumbers.get(cookieID);
        numberOfGuesses.put(cookieID, numberOfGuesses.get(cookieID) + 1);
        if (guess > hidden) {
            return "Guess Lower! (Than your last guess of " + guess + ")\n\n <p>";
        }
        if (guess < hidden) {
            return "Guess Higher! (Than your last guess of " + guess + ")\n\n <p>";
        }
        resetGame(cookieID);
        return "You are correct! Well done! The game is reset\n";
    }
}