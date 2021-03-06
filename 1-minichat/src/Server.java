import java.util.*;
import java.net.*;

/**
 * Created by bratzie on 24/01/14.
 */
public class Server implements Runnable {
    private final int PORT = 1234;
    private ArrayList<ServerThread> clients;
    private ServerSocket server;
    private Thread thread;

    public static void main(String[] args) throws Exception {
        new Server();
    }

    public Server() throws Exception {
        server = new ServerSocket(PORT);
        clients = new ArrayList<ServerThread>();
        thread = new Thread(this);
        thread.start();
    }

    @Override
    public void run() {
        while (true) {
            try {
                addClient(server.accept());
            } catch (Exception e) {
                System.out.println(e);
            }
        }
    }

    private void addClient (Socket socket) throws Exception {
        ServerThread st = new ServerThread(this, socket);
        st.start();
        clients.add(st);
        System.out.println("Client " + st.getName() + " joined.");
    }

    public void sendToAll (String message) {
        System.out.println("Message recieved: " + message);
        for (ServerThread client : clients) {
            client.send(message);
        }
    }
}
