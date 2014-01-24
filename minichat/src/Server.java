/**
 * Created by bratzie on 24/01/14.
 */

import java.io.*;
import java.net.Socket;
import java.net.ServerSocket;

public class Server {
    public static void main(String[] args) throws Exception {
        ServerSocket ss = new ServerSocket(1234);
        Socket s = null;
        String text = "";

        while( (s = ss.accept()) != null) {
            System.out.println(text);
        }

        s.shutdownInput();
    }
}
