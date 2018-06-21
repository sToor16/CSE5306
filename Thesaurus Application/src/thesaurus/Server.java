package thesaurus;

import java.awt.FlowLayout;
import java.io.BufferedReader;
import java.io.File;
import java.io.FileNotFoundException;
import java.io.FileReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.PrintStream;
import java.net.ServerSocket;
import java.net.Socket;
import java.net.SocketException;
import java.util.Arrays;

import javax.swing.JFrame;
import javax.swing.JOptionPane;
import javax.swing.JScrollPane;
import javax.swing.JTextArea;

/**
 * @author Shubhpreet Singh Toor - UTA ID : 1001564975
 * @author Shashank Gaikaiwari - UTA ID : 1001165812
 * Server Program for the Thesaurus Application.
 */

public class Server
{
	//Modify the File Location as per your directory.
	//private static final String FILENAME = "ThesaurusFile.txt";
	
	//Specifies the port number on which the Server will be running. This port will be used by the client to connect to the server.
	private int portNumber = 6467;
	private ServerSocket server = null;
	private Socket clientSocket;
	
	//UI Declarations
	private JTextArea serverLog;
	private JFrame serverWindow;
	private JScrollPane scrollPane;
	
	/**
	 * This Method is called by the main method.
	 * It is used to define the UI of the Server.
	 * Internally the startServer() method is called.
	 */
	public void createServer(){
		try
		{
			/*
			 * UI Components used :
			 * JFrame for the base Window Frame
			 * Text Area, that acts as a server log displaying the details
			 * of connections, requests and disconnections.
			 * ScrollPane for the TextArea because the logs can get very long if the server has been running for long
			 */
			serverWindow = new JFrame("Thesaurus Server");
			serverWindow.setSize(650,400);
			serverWindow.setLayout(new FlowLayout());
			// Resizable is set to false, to avoid the possibility of the UI getting messed up. 
			serverWindow.setResizable(false);
			serverLog = new JTextArea(22,50);
			// Editable is set to false, so that even the server cannot edit the details to improve credibility.
			serverLog.setEditable(false);
			scrollPane = new JScrollPane(serverLog);
			serverWindow.add(scrollPane);
			serverWindow.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
			serverWindow.setVisible(true);
			startServer();
		}
		catch (Exception e)
		{
			JOptionPane.showMessageDialog(serverWindow,"Some problem with server, please try again later!","Error",JOptionPane.ERROR_MESSAGE);
			System.exit(0);
		} 
	}
	
	/**
	 * This method starts the Server and listens to the portNumber as defined in the class declaration.
	 * For each client trying to connect to the server, an instance of the SocketHandler is created.
	 */
	private void startServer()
	{
		try
		{
			serverLog.append("Connecting to port " + portNumber + " ....\n");
			server = new ServerSocket(portNumber);
			serverLog.append("Server is now running ..\n");
			
			while(true) {
				//Whenever the Client tries to connect to the server, the server has to accept the connection.
				clientSocket = server.accept();
				serverLog.append(clientSocket+" has connected.\n");
				//Creating an Instance for the SocketHandler to handle each client separately.
				SocketHandler c = new SocketHandler(clientSocket);
				c.start();
			}
		}
		catch (SocketException se)
		{
			JOptionPane.showMessageDialog(serverWindow,"Server already running!","Error",JOptionPane.ERROR_MESSAGE);
			System.exit(0);
		}
		catch (Exception e)
		{
			JOptionPane.showMessageDialog(serverWindow,"Unable to connect to specified port, please try again!","Error",JOptionPane.ERROR_MESSAGE);
			System.exit(0);
		}
		finally
		{
			if(server!=null)
				try
			{
					server.close();
			}
			catch (IOException e)
			{
				JOptionPane.showMessageDialog(serverWindow,"Problem occured while running server, please try again!","Error",JOptionPane.ERROR_MESSAGE);
				System.exit(0);
			}
		}       
	}
	
	/**
	 * Instance created in the startServer() method.
	 * A thread is created for each client that connects to the server.
	 * Each thread takes care of the communication between the client and the server.
	 * Constructor uses the clientSocket object as its argument.
	 */
	private class SocketHandler extends Thread
	{
		private Socket clientSocket;

		public SocketHandler(Socket clientSocket)
		{            
			super("socketHandler");
			this.clientSocket = clientSocket;
		}
		public synchronized void run()
		{
			try{
				//To read the input from the client
				BufferedReader streamIn = new BufferedReader(new InputStreamReader(clientSocket.getInputStream()));
				//To respond to the client's request
				PrintStream streamOut = new PrintStream(clientSocket.getOutputStream(), true);
				while(true){
					//Reading input from the client
					String searchKey = streamIn.readLine();
					if(searchKey != null){
						serverLog.append(clientSocket+" has requested for the synonym of "+searchKey+".\n");
					}
					//Fetching the list of all synonyms for the word entered by the client.
					String searchResult = thesaurusSearch(searchKey);
					//Writes the output of the search Result back to the client.
				 	streamOut.println(searchResult);
					
				}
			}
			catch(Exception e)
			{
				serverLog.append(clientSocket+ " has disconnected.\n");
			}
			finally
			{
				try
				{
					clientSocket.close();
				}
				catch(IOException e){
					serverLog.append(clientSocket+ " has disconnected.\n");
				}
			}
		}
	}
	
	/**
	 * 
	 * @param searchKey
	 * @return sb.toString()
	 * This method returns a list of synonyms if the input word is found in the thesaurus file
	 */
	private String thesaurusSearch(String searchKey) {
		StringBuilder sb = new StringBuilder();
		BufferedReader br = null;
		try {
			//For Windows
			String filePath = new File("").getAbsolutePath()+"\\src\\thesaurus\\ThesaurusFile.txt";
			//To read the Thesaurus File
			File file = new File(filePath);
			if(file.exists())
				br = new BufferedReader(new FileReader(filePath));
			else {
				//For MAC OS/Linux
				filePath = new File("").getAbsolutePath()+"/src/thesaurus/ThesaurusFile.txt";
				file = new File(filePath);
				if(file.exists())
					br = new BufferedReader(new FileReader(filePath));
			}
			String line = "";
			//Reading each line of the Thesaurus File
			while((line = br.readLine())!=null) {
				//Converting both the searchKey and line being read in lowercase for case insensitive comparison
				line = line.toLowerCase();
				searchKey = searchKey.toLowerCase();
				//Logic to make a comma separated list of synonyms based on the input - START
				if(line.contains(searchKey)) {
					String[] words = line.split(",");
					//Remove all the spaces from the words.
					for(int j=0;j<words.length;j++) {
						words[j] = words[j].trim();
					}
					/* Checking if the List of words contains the searchKey or not to avoid partial Matches
					 * For example, single letter searches or substring match
					 */
					if(Arrays.asList(words).contains(searchKey)) {
						for(int i=0;i<words.length;i++) {
							String word = words[i];
							//Adding all the words except the searchKey to the StringBuilder to generate the output
							if(!word.equalsIgnoreCase(searchKey)) {
								if(sb.length()==0) {
									sb.append(word);
								}else {
									sb.append(", "+word);
								}
							}
						}
					}
				}
				//Logic to make a comma separated list of synonyms based on the input - END
			}
		}
		catch(FileNotFoundException fe) {
			JOptionPane.showMessageDialog(serverWindow,"Unable to find the Thesaurus File, Kindly check the path !","Error",JOptionPane.ERROR_MESSAGE);
		}
		catch (IOException e) {
			e.printStackTrace();
		}
		finally {
			try {
				br.close();
			} catch (IOException e) {
				e.printStackTrace();
			}
		}
		return sb.toString();
	}
	
	/**
	 * Main method of the Server program. Calls the createServer() method
	 * @param args
	 */
	public static void main(String[] args) {
		new Server().createServer();
	}
}