import javax.net.ssl.*;
import java.io.*;
import java.security.*;

public class Server{

    public static void main(String[] args) {
        // init stuff
        KeyStore ks; // the KeyStore is used for the server certificate
        InputStream is; // used for reading the "key" file in order to use it

        try {
            ks = KeyStore.getInstance("JKS", "SUN"); // JKS is type, SUN is provider. Specifies which type of keys are used
            is = new FileInputStream(new File("key")); // Read our certificate from the key file

            ks.load(is, "rootroot".toCharArray()); // load certificate with the keystore password

            // create a kmf with default algorithm, SunX509.
            KeyManagerFactory kmf = KeyManagerFactory.getInstance(KeyManagerFactory.getDefaultAlgorithm()); //SunX509?
            kmf.init(ks, "hejsan".toCharArray()); // init kmf with our keystore using its password

            /*
            kmf and ks passwords are different because we specified different passwords when
            creating and exporting the keys
            */

            // get context using TLS (one of the most used standards)
            SSLContext context = SSLContext.getInstance("TLS");
            context.init(kmf.getKeyManagers(), null, null); // init the context with our kmf => certs saved in context

            // create SSLServerSocketFactory
            SSLServerSocketFactory factory = context.getServerSocketFactory(); // get SSF from context
            SSLServerSocket serverSocket = (SSLServerSocket) factory.createServerSocket(4711); // bind sS to port 4711

            // input all of the ciphers! To be able to decrypt information.
            serverSocket.setEnabledCipherSuites(factory.getSupportedCipherSuites()); // adds every cipher the SSF supports to the sS

            SSLSocket socket = null;
            BufferedWriter out = null;

            while (true) {
                try {
                    socket = (SSLSocket) serverSocket.accept();

                    try {
                        // perform a handshake to see if connection is encrypted
                        socket.startHandshake();
                    } catch (SSLException e) {
                        // connection is not encrypted, print message on server, close connection and continue listning for other connections.
                        System.out.println("Unrecognized SSL message, plaintext connection? " +
                                "Closing connection, listening for more juicy safe stuff.");
                        socket.close();
                        continue;
                    }

                    // create a new BufferedWriter to write to the socket.
                    out = new BufferedWriter(new OutputStreamWriter(socket.getOutputStream()));

                    // print som HTML to display using the BufferedWriter
                    System.out.println("Client " + socket.hashCode() + " connected. Writing message 'Hello World'");
                    out.write("HTTP/1.0 200 OK");
                    out.newLine();
                    out.write("Content-Type: text/html");
                    out.newLine();
                    out.newLine();
                    out.write("<html><body>");
                    out.write("<span style=\"text-decoration: blink\">");
                    out.write("<h1 style=\"color: red; text-align: center; font-family: sans-serif; font-size: 300%;\">Hello world!</h1>");
                    out.write("</span>");
                    out.write("</body></html>");
                    out.newLine();

                    // send everything to socket
                    out.flush();
                    // close Writer as we won't need it.
                    out.close();
                } catch (SSLHandshakeException e) {
                    e.printStackTrace();
                } finally {
                    if (socket != null)
                        socket.close();
                }
            }
        } catch (Exception e) {
            // one catch to rule them all
            e.printStackTrace();
        }
    }
}
