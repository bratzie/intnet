import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.io.PrintStream;
import java.net.Socket;

/**
 * Created by bratzie on 27/01/14.
 */
public class Client implements Runnable {
    private String alias;

    // network related constants
    private Socket socket;
    private BufferedReader in;
    private PrintStream out;
    private Thread thread;
    private ClientThread client;

    public static void main(String[] args) throws Exception {
    }

    public Client(String host, int port, String alias) throws Exception {
        this.alias = alias;
        socket = new Socket(host, port);
        in = new BufferedReader(new InputStreamReader(System.in));
        out = new PrintStream(socket.getOutputStream());
        client = new ClientThread(socket);
        client.start();
        thread = new Thread(this);
        thread.start();
    }

    public void run() {
        String message = "";

        while (true) {
            try {
                message = in.readLine();
                out.println(message);
            } catch (Exception e) {
                System.out.println(e);
            }
        }
    }
}
