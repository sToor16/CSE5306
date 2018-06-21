package thesaurus;

//For UI Components
import java.awt.FlowLayout;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.awt.event.WindowEvent;
import java.awt.event.WindowListener;
import javax.swing.JButton;
import javax.swing.JFrame;
import javax.swing.JLabel;
import javax.swing.JOptionPane;
import javax.swing.JTextArea;
import javax.swing.JTextField;

//For Read/Write Actions
import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.PrintStream;

//For Connection
import java.net.ConnectException;
import java.net.Socket;


/**
 * @author Shubhpreet Singh Toor - UTA ID : 1001564975
 * @author Shashank Gaikaiwari - UTA ID : 1001165812
 * Client Program for the Thesaurus Application.
 */

public class Client implements WindowListener 
{
	//Port Number of the server to which it needs to connect
	private int portNumber = 6467;
	//Address of the server
	//In our case - "localhost" as server and client run on the same machine
	private String hostAddress = "localhost";
	
	//UI Declarations
	private JTextArea synonymArea;
	private JTextField userInputField;
	private JFrame clientUI;
	private JLabel userInputAreaLabel,synonymAreaLabel;
	private JButton searchButton;
	
	//To send data to the server
	private PrintStream streamOut;
	
	public void createClient(){
		try 
		{
			/*
			 * UI Components used :
			 * JFrame for the base Client Window.
			 * JLabel for text
			 * JTextField for getting the input from the user
			 * JTextArea for displaying the synonyms received from the server
			 * JButton for the search button
			 */
			clientUI = new JFrame("Thesaurus Client");
			searchButton = new JButton("Get Synonyms");
			clientUI.setSize(300,300);
			clientUI.setLayout(new FlowLayout());
			// Resizable is set to false, to avoid the possibility of the UI getting messed up.
			clientUI.setResizable(false);
			userInputField = new JTextField(15);
			userInputAreaLabel = new JLabel("Enter the Word : ");
			clientUI.getContentPane().add(userInputAreaLabel);
			clientUI.add(userInputField);
			clientUI.getContentPane().add(searchButton);
			synonymAreaLabel = new JLabel("Following are synonyms for the input word");
			clientUI.getContentPane().add(synonymAreaLabel);
			synonymArea = new JTextArea(10,25);
			synonymArea.setWrapStyleWord(true);
			synonymArea.setEditable(false);
			clientUI.add(synonymArea);
			
			searchButton.addActionListener(new ActionListener()
			{
				public void actionPerformed(ActionEvent e){
					/*The client sends the user input to the server when the button is clicked
					  Matches function is used to check if the user enters valid data.
					  If he enters anything except alphabets, it will throw an error.
					*/
					if(userInputField.getText().trim().matches("[a-zA-Z]*")) {
						streamOut.println(userInputField.getText().trim());
					} else {
						userInputField.setText("");
						JOptionPane.showMessageDialog(clientUI,"No Special Characters or Numbers allowed.","ERROR",JOptionPane.ERROR_MESSAGE);
					}
					
					//Flushes the TextArea everytime the button is clicked.
					synonymArea.setText("");
				} 
			});
			clientUI.setVisible(true);
			clientUI.setDefaultCloseOperation(JFrame.DO_NOTHING_ON_CLOSE);
			clientUI.addWindowListener(this);
			executeClient();
		}
		catch (Exception e)
		{
			e.printStackTrace();
			JOptionPane.showMessageDialog(clientUI,"Unable to Connect server, please try again later","ERROR",JOptionPane.ERROR_MESSAGE);
			System.exit(0);
		}
	}

	/**
	 * Called from the createClient() method
	 * This method is to get the server's response and display it on the UI.
	 */
	private void executeClient() throws IOException,ConnectException {
		Socket clientSocket = null;
		try
		{
			//To establish connection with the server using the Address and Port Number
			clientSocket = new Socket(hostAddress, portNumber);
			//For reading the response of the server
			BufferedReader inputStream = new BufferedReader(new InputStreamReader(clientSocket.getInputStream()));
			
			streamOut = new PrintStream(clientSocket.getOutputStream(), true);
			
			while(true){
				//To read the List of synonyms returned by the server.
				String line = inputStream.readLine();
				//If no synonyms for the entered word are found, the server sends an empty message
				if(!line.equals("")) {
					synonymArea.setText(line);
				}else {
					synonymArea.setText("No synonyms are found for the word entered.");
				}
			}
		}
		catch (Exception e){
			clientSocket.close();
			JOptionPane.showMessageDialog(clientUI,"Unable to Connect server, please try again later","ERROR",JOptionPane.ERROR_MESSAGE);
			System.exit(0);
		}
	}

	/**
	 * Main method of the Client program. Calls the createClient() method.
	 * @param args
	 */
	public static void main(String[] args){
		new Client().createClient();
	}

	public void windowClosing(WindowEvent e){
		clientUI.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
	}
	public void windowOpened(WindowEvent e) {}
	public void windowClosed(WindowEvent e) {}
	public void windowIconified(WindowEvent e) {}
	public void windowDeiconified(WindowEvent e) {}
	public void windowActivated(WindowEvent e) {}
	public void windowDeactivated(WindowEvent e) {}
}
 