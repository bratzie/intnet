import java.io.*;
import java.net.*;

/**
 * Created by bratzie on 27/01/14.
 */
public class ServerThread extends Thread {
    private Server server;
    private Socket socket;
    private BufferedReader in;
    private PrintStream out;

    public ServerThread (Server server, Socket socket) throws Exception {
        super();
        this.server = server;
        this.socket = socket;
        in = new BufferedReader(new InputStreamReader(socket.getInputStream()));
        out = new PrintStream(socket.getOutputStream());
    }

    public void send(String message) {
        try {
            out.println(message);
        } catch (Exception e) {
            System.out.println(e);
        }
    }

    @Override
    public void run() {
        // initialize string to avoid sending null value.
        String message = "";
        while(true) {
            try {
                message = in.readLine();
                server.sendToAll(message);
            } catch (Exception e) {
                System.out.println(e);
            }
        }
    }
}
