import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.net.Socket;

/**
 * Created by bratzie on 27/01/14.
 */
public class ClientThread extends Thread {
    private Socket socket;
    private BufferedReader in;

    public ClientThread(Socket socket) throws Exception {
        this.socket = socket;
        in = new BufferedReader(new InputStreamReader(socket.getInputStream()));
    }

    public void run() {
        while (true) {
            try {
                System.out.println(in.readLine());
            } catch (Exception e) {
                System.out.println(e);
            }
        }
    }
}
