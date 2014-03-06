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
	    is = new FileInputStream(new File("./keystore"));
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

