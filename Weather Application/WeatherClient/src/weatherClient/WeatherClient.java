package weatherClient;

import https.graphical_weather_gov.xml.dwmlgen.schema.dwml.ProductType;
import https.graphical_weather_gov.xml.dwmlgen.schema.dwml.UnitType;
import https.graphical_weather_gov.xml.dwmlgen.schema.dwml.WeatherParametersType;
import https.graphical_weather_gov.xml.dwmlgen.wsdl.ndfdxml.NdfdXML;
import https.graphical_weather_gov.xml.dwmlgen.wsdl.ndfdxml.NdfdXMLPortType;

import javax.swing.*;
import javax.xml.datatype.DatatypeFactory;
import javax.xml.datatype.XMLGregorianCalendar;
import javax.xml.namespace.QName;
import javax.xml.stream.XMLEventReader;
import javax.xml.stream.XMLInputFactory;
import javax.xml.stream.XMLStreamConstants;
import javax.xml.stream.XMLStreamException;
import javax.xml.stream.events.Attribute;
import javax.xml.stream.events.Characters;
import javax.xml.stream.events.StartElement;
import javax.xml.stream.events.XMLEvent;
import java.awt.*;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.awt.event.WindowEvent;
import java.awt.event.WindowListener;
import java.io.StringReader;
import java.math.BigDecimal;
import java.util.Calendar;
import java.util.Date;
import java.util.GregorianCalendar;

/**
 * @author Shubhpreet Singh Toor UTA ID: 1001564975
 * @author Shashank UTA ID : 1001165812
 *  Weather Client to fetch the max temperature, minimum temperature, dew point temperature and 12 hourly precipitation
 *  values of a location based on user provided coordinates.
 */
public class WeatherClient implements WindowListener {
	
	
		//UI Declarations
		private JLabel weatherInformationLabel, latitudeInputLabel, longitudeInputLabel, maxTempLabel, minTempLabel, dewLabel, precipitationLabel;
		private JTextField latitudeInput, longitudeInput, maxTemp, minTemp, dew, precipitation;
		private JButton requestButton;
		private JFrame weatherUI;
		
		//UI Definition - Builds the UI for the Weather Client
		public void createUI() {
			//JFrame
			weatherUI = new JFrame("Weather Client");
			weatherUI.setLayout(new FlowLayout());
			weatherUI.setSize(300, 350);
			weatherUI.setResizable(false);
			//Heading for the Window.
			weatherInformationLabel = new JLabel("Weather Information");
			weatherInformationLabel.setFont(new Font("Serif", Font.BOLD, 24));
			weatherUI.add(weatherInformationLabel);
			
			//Input Components for the Weather Client
			//Getting the Latitude and Longitude Values from the user
			latitudeInputLabel = new JLabel("Enter Latitude : ");
			weatherUI.add(latitudeInputLabel);
			latitudeInput = new JTextField(15);
			weatherUI.add(latitudeInput);
			
			longitudeInputLabel = new JLabel("Enter Longitude : ");
			weatherUI.add(longitudeInputLabel);
			longitudeInput = new JTextField(15);
			weatherUI.add(longitudeInput);
			
			//Button to get the values of parameters
			requestButton = new JButton("Fetch Details/Refresh");
			requestButton.addActionListener(new ActionListener()
			{
				public void actionPerformed(ActionEvent e){
						getWeatherInfo();
					} 
			});
			weatherUI.add(requestButton);
			
			//Display the values of the parameters.
			//The Text Fields are disabled so that the user cannot edit them.\
			
			//Max Temperature
			maxTempLabel = new JLabel("Maximum Temperature");
			weatherUI.add(maxTempLabel);
			maxTemp = new JTextField(10);
			maxTemp.setEditable(false);
			weatherUI.add(maxTemp);
			
			//Min Temperature
			minTempLabel = new JLabel("Minimum Temperature");
			weatherUI.add(minTempLabel);
			minTemp = new JTextField(10);
			minTemp.setEditable(false);
			weatherUI.add(minTemp);
			
			//Dew Point
			dewLabel = new JLabel("Dew Point");
			weatherUI.add(dewLabel);
			dew = new JTextField(10);
			dew.setEditable(false);
			weatherUI.add(dew);
			
			//Precipitation
			precipitationLabel = new JLabel("12 Hourly Probability of Precipitation");
			weatherUI.add(precipitationLabel);
			precipitation = new JTextField(5);
			precipitation.setEditable(false);
			weatherUI.add(precipitation);
			
			//Setting defaults
			weatherUI.setVisible(true);
			weatherUI.setDefaultCloseOperation(JFrame.DO_NOTHING_ON_CLOSE);
			weatherUI.addWindowListener(this);
	}
	
	/**
	 * Fetches the data using the Webservice.
	 * Uses the values from the latitude text box and longitude text box.
	 */
	public void getWeatherInfo() {
		try {
			//Setting the Start Calendar
			GregorianCalendar startCalendar = new GregorianCalendar(2017,11,30);
			startCalendar.setTime(new Date());
			startCalendar.set(Calendar.MILLISECOND, 0);
			startCalendar.set(Calendar.SECOND, 0);
			startCalendar.set(Calendar.MINUTE, 0);
			startCalendar.set(Calendar.HOUR, 0);
			XMLGregorianCalendar startGregorianCalendar = DatatypeFactory.newInstance().newXMLGregorianCalendar(startCalendar);
			
			//Setting the End Calendar
			GregorianCalendar endCalendar = new GregorianCalendar(2017,12,10);
			startCalendar.setTime(new Date());
			endCalendar.set(Calendar.MILLISECOND, 0);
			endCalendar.set(Calendar.SECOND, 0);
			endCalendar.set(Calendar.MINUTE, 0);
			endCalendar.set(Calendar.HOUR, 0);
			XMLGregorianCalendar endGregorianCalendar = DatatypeFactory.newInstance().newXMLGregorianCalendar(endCalendar);
			
			//Fetch the latitude and longitude values from the TextField
			BigDecimal latitude = new BigDecimal(latitudeInput.getText());
			BigDecimal longitude = new BigDecimal(longitudeInput.getText());
			//Connecting to the Webservice
			NdfdXML ndfdXML = new NdfdXML();
			//Getting a port object to invoke the ndfDgen Method
			NdfdXMLPortType ndfdXMLPortType = ndfdXML.getNdfdXMLPort();
			
			//Setting the weather parameters required as true
			WeatherParametersType weatherParametersType = new WeatherParametersType();
			weatherParametersType.setMint(true);
			weatherParametersType.setMaxt(true);
			weatherParametersType.setDew(true);
			weatherParametersType.setPop12(true);
			
			//Store the XML returned by the ndfDgen Method
			String xml = ndfdXMLPortType.ndfDgen(latitude, longitude, ProductType.TIME_SERIES, startGregorianCalendar, endGregorianCalendar, UnitType.E, weatherParametersType);
			//Parsing the XML
			parse(xml);
		}
		catch (Exception e) {
			// TODO: handle exception
			//If the entered co-ordinates are not a part of the NDFD Grid
			if(e.getMessage().contains("Point is not on an NDFD grid")) {
				JOptionPane.showMessageDialog(weatherUI, "Given Latitude and Longitude are out of the NDFD Grid.","ERROR",JOptionPane.ERROR_MESSAGE);
			} else {
				JOptionPane.showMessageDialog(weatherUI, "Error connecting. Please Try Again Later.","ERROR",JOptionPane.ERROR_MESSAGE);
			}
		}
	}
	
	private void parse(String xml) {
		//Declaring the boolean values
		boolean bMax = false;
		boolean bMinTemp = false;
		boolean bDewPoint = false;
		boolean bPrecipitation = false;
		boolean bName = false;
		boolean bValue = false;
		
		 try {
			 //Get the XMLInputFactory in order to create an XMLEventReader
	         XMLInputFactory factory = XMLInputFactory.newInstance();
	         //Creating the EventReader to read the content of the XML
	         XMLEventReader eventReader = factory.createXMLEventReader(new StringReader(xml));
	         
	         //Reads each Tag
	         while(eventReader.hasNext()) {
	             XMLEvent event = eventReader.nextEvent();
	             switch(event.getEventType()) {
	                case XMLStreamConstants.START_ELEMENT:
	                		StartElement startElement = event.asStartElement();
	                		String qName = startElement.getName().getLocalPart();
	                		
	                		//If temperature tag is found, setting the boolean value of the appropriate type. 
	                		if(qName.equalsIgnoreCase("temperature")) {
	                	   		Attribute typeAttribute = startElement.getAttributeByName(new QName("type"));
	                	   		String type = typeAttribute.getValue();
	                	   		if(type.equals("maximum")) {
	                	   			bMax = true;
	                    	   }
	                	   		if(type.equals("minimum")) {
	                	   			bMinTemp = true;
	                	   		}
	                	   		if(type.equals("dew point")) {
	                	   			bDewPoint = true;
	                	   		}
	                		}
	                		//If probability-of-precipitation tag is found, setting the boolean value of the appropriate type. 
	                		else if(qName.equalsIgnoreCase("probability-of-precipitation")) {
	                			Attribute typeAttribute = startElement.getAttributeByName(new QName("type"));
	                	   		String type = typeAttribute.getValue();
	                	   		if(type.equals("12 hour")) {
	                	   			bPrecipitation = true;
	                	   		}
	                		}
	                		//If Name Tag is found, setting the boolean value of the name.
		                   if (qName.equalsIgnoreCase("name")) {
		                       bName = true;
		                    }
		                   
		                   //If Value Tag is found, setting the boolean value of the value.
		                   if(qName.equalsIgnoreCase("value")) {
		                       bValue = true;
		                    }
		                   break;
		                 
		                //Gets the value present within the Tag
		                case XMLStreamConstants.CHARACTERS:Characters characters = event.asCharacters();
		                //Gets the respective Maximum Temperature Value.
		                if(bMax && bName & bValue){
		                	maxTemp.setText(characters.getData());
            	 			bMax = false; 
							bName = false;
							bValue = false;
		                 }
		                
		                //Gets the respective Min Temperature Value.
		                 if(bMinTemp && bName && bValue){
		                	minTemp.setText(characters.getData());
            	 			bMinTemp = false; 
							bName = false;
							bValue = false;
		                 }
		               
		                 //Gets the respective Dew Temperature Value.
		                 if(bDewPoint && bName && bValue) {
		                	dew.setText(characters.getData()); 
 							bDewPoint = false; 
 							bName = false;
 							bValue = false;
		                 }

		                 //Gets the respective Precipitation Value.
		                 if(bPrecipitation && bName && bValue) {
		                	precipitation.setText(characters.getData()); 
 							bPrecipitation = false; 
 							bName = false;
 							bValue = false;
			             }
		                 break;
		                
		                 //At the end of the element, set bValue as false otherwise, the next parameter value fetched will be incorrect.
		                case XMLStreamConstants.END_ELEMENT:
		                    bValue = false;
		                 break;
		             } 
		         }
		      }  catch (XMLStreamException e1) {
		         e1.printStackTrace();
		      }
		   }
	
	@Override
	public void windowOpened(WindowEvent e) {}
	@Override
	public void windowClosing(WindowEvent e) {
		weatherUI.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
	}
	@Override
	public void windowClosed(WindowEvent e) {}
	@Override
	public void windowIconified(WindowEvent e) {}
	@Override
	public void windowDeiconified(WindowEvent e) {}
	@Override
	public void windowActivated(WindowEvent e) {}
	@Override
	public void windowDeactivated(WindowEvent e) {}
	
	/**
	 * Main Method for the Weather Client.
	 * Calls the createUI() method to build the Client UI
	*/
	public static void main(String[] args) {
		new WeatherClient().createUI();
	}
}
