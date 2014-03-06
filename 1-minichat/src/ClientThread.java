import java.io.*;
import java.net.Socket;

/**
 * Created by bratzie on 27/01/14.
 */
public class ClientThread extends Thread {
    private Socket socket;
    private String alias;
    private BufferedReader in;

    public ClientThread(Socket socket, String alias) throws Exception {
        this.socket = socket;
        this.alias = alias;
        in = new BufferedReader(new InputStreamReader(socket.getInputStream()));
    }

    public void run() {
        String message = "";

        while (true) {
            try {
                message = in.readLine();
                String filter = message.split(": ")[0];
                if (!filter.equals(alias)) {
                    System.out.println(message);
                }
            } catch (Exception e) {
                System.out.println(e);
            }
        }
    }
}
