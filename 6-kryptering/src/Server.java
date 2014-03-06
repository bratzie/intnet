import javax.net.ssl.*;
import java.io.*;
import java.security.*;
import java.security.cert.*;

public class Server{

    public static void main(String[] args) {
        SSLServerSocketFactory ssf = (SSLServerSocketFactory)SSLServerSocketFactory.getDefault();
        System.out.println("Stöder:");

        for (int i = 0; i < ssf.getSupportedCipherSuites().length; i++)
            System.out.println(ssf.getSupportedCipherSuites()[i]);

        SSLServerSocket ss = null;

        try{
            ss = (SSLServerSocket)ssf.createServerSocket(1234);
            String[] cipher = {"SSL_DH_anon_WITH_RC4_128_MD5"};
            ss.setEnabledCipherSuites(cipher);
            System.out.println("Vald:");

            for(int i = 0; i < ss.getEnabledCipherSuites().length; i++)
                System.out.println(ss.getEnabledCipherSuites()[i]);

            SSLSocket s = (SSLSocket)ss.accept();

            checkCertificate();

            BufferedReader infil = new BufferedReader(new InputStreamReader(s.getInputStream()));
            String rad = null;

            while( (rad=infil.readLine()) != null)
                System.out.println(rad);

            infil.close();
        }

        catch(IOException e){
            System.out.println(e.getMessage());
        }
    }

    static private void checkCertificate() {
        try{

            InputStream infil = new FileInputStream("server.cer");
            CertificateFactory cf = CertificateFactory.getInstance("X.509");
            X509Certificate cert = (X509Certificate)cf.generateCertificate(infil);
            infil.close();
        }
        catch(CertificateException e){
            System.out.println(e.getMessage());
        }
        catch(IOException e){
            System.out.println(e.getMessage());
        }

        KeyStore ks = null;
        try{
            ks = KeyStore.getInstance("JKS", "SUN");
        }
        catch(KeyStoreException e){
            System.out.println(e.getMessage());
        }
        catch(NoSuchProviderException e){
            System.out.println(e.getMessage());
        }
        InputStream is = null;
        try{
            is = new FileInputStream(new File("/Users/bratzie/repos/intnet/6-kryptering/src/.keystore"));
        }
        catch(FileNotFoundException e){
            System.out.println(e.getMessage());
        }
        try{
            ks.load(is,"rootroot".toCharArray());
        }
        catch(IOException e){
            System.out.println(e.getMessage());
        }
        catch(NoSuchAlgorithmException e){
            System.out.println(e.getMessage());
        }
        catch(CertificateException e){
            System.out.println(e.getMessage());
        }
        catch(NullPointerException e){
            System.out.println(e.getMessage());
        }
    }
}
