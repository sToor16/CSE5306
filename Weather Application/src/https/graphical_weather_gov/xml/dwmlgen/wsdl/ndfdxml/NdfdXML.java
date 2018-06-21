
package https.graphical_weather_gov.xml.dwmlgen.wsdl.ndfdxml;

import java.net.MalformedURLException;
import java.net.URL;
import javax.xml.namespace.QName;
import javax.xml.ws.Service;
import javax.xml.ws.WebEndpoint;
import javax.xml.ws.WebServiceClient;
import javax.xml.ws.WebServiceException;
import javax.xml.ws.WebServiceFeature;


/**
 * The service has 12 exposed functions, NDFDgen, NDFDgenLatLonList, NDFDgenByDay, NDFDgenByDayLatLonList, 
 *                   LatLonListSubgrid, LatLonListLine, LatLonListZipCode, CornerPoints, LatLonListSquare, GmlLatLonList, GmlTimeSeries, and LatLonListCityNames. 
 *                   For the NDFDgen function, the client needs to provide a latitude and longitude pair and the product type. The Unit will default
 *                   to U.S. Standard (english) unless Metric is chosen by client. The client also needs to provide the start and end time (Local) 
 *                   of the period that it wants data for (if shorter than the 7 days is wanted).  For the time-series product, the client needs to 
 *                   provide an array of boolean values corresponding to which NDFD values are desired.
 *                   For the NDFDgenByDay function, the client needs to provide a latitude and longitude pair, the date (Local) it wants to start 
 *                   retrieving data for and the number of days worth of data.  The Unit will default to U.S. Standard (english) unless Metric is 
 *                   chosen by client. The client also needs to provide the format that is desired.  
 *                   For the multi point versions, NDFDgenLatLonList and NDFDgenByDayLatLonList a space delimited list of latitude and longitude 
 * 		  pairs are substituted for the single latitude and longitude input.  Each latitude and longitude 
 *                   pair is composed of a latitude and longitude delimited by a comma.  
 * 		  For the LatLonListSubgrid, the user provides a comma delimited latitude and longitude pair for the lower left and for 
 *                   the upper right corners of a rectangular subgrid.  The function can also take a integer 
 *                   resolution to reduce the number of grid points returned. The service then returns a list of 
 *                   latitude and longitude pairs for all the grid points contained in the subgrid. 
 *                   weather values should appear in the time series product.  
 * 		  For the LatLonListLine, The inputs are the same as the function NDFDgen except the latitude and longitude pair is 
 * 		  replaced by two latitude and longitude pairs, one for each end point a line. The two points are delimited with a space.  
 *                   The service then returns data for all the NDFD points on the line formed by the two points.  
 * 		  For the LatLonListZipCode function, the input is the same as the NDFDgen function except the latitude and longitude values 
 * 		  are relaced by a zip code for the 50 United States and Puerto Rico.
 * 		  For the LatLonListSquare function, the input is the same as the NDFDgen function except the latitude and longitude values 
 * 		  are relaced by a zip code for the 50 United States and Puerto Rico.
 * 		  For the CornerPoints function, the service requires a valid NDFD grid name.  The function returns a 
 *                   list of four latitude and longitude pairs, one for each corner of the NDFD grid.  The function 
 *                   also returns the minimum resolution required to return the entire grid below the maximum points 
 *                   threshold.
 *                   For the GmlLatLonList function, the service requires a list of latitude and longitude pairs, the time (UTC) the user 
 * 		  wants data for, the GML feature type and the array of boolean values corresponding to which NDFD values are desired.
 *                   For the GmlTimeSeries function, the service requires a list of latitude and longitude pairs, the start and end time (UTC) the user 
 * 		  wants data for, a comparison type (IsEqual, Between, GreaterThan, GreaterThan, GreaterThanEqualTo, LessThan, and  
 *                   LessThanEqualTo), the GML feature type and The input variable "propertyName" contains a comma delimited string of NDFD element to 
 *                   indicate which weather parameters are being requested.
 *                   For the LatLonListCityNames function, the services requires a detail level that that ranges from 1 to 4.  Level 1 generally represents
 *                   large main cities.  Level 2 represents progressively smaller cities or large cities that are close to another even larger city.  Levels
 *                   3 and 4 are part one and two of a list of cities that help increase the areal coverage of the cities dataset.  This functions
 *                   returns a list of latitude and longitude values along with a seperate list of city name for those point.
 * 
 * This class was generated by the JAX-WS RI.
 * JAX-WS RI 2.2.9-b130926.1035
 * Generated source version: 2.2
 * 
 */
@WebServiceClient(name = "ndfdXML", targetNamespace = "https://graphical.weather.gov/xml/DWMLgen/wsdl/ndfdXML.wsdl", wsdlLocation = "file:/E:/MS%20CS/Sem%20I/Distributed%20Systems/Labs/Lab%203/service/ndfdXML.wsdl")
public class NdfdXML
    extends Service
{

    private final static URL NDFDXML_WSDL_LOCATION;
    private final static WebServiceException NDFDXML_EXCEPTION;
    private final static QName NDFDXML_QNAME = new QName("https://graphical.weather.gov/xml/DWMLgen/wsdl/ndfdXML.wsdl", "ndfdXML");

    static {
        URL url = null;
        WebServiceException e = null;
        try {
            url = new URL("file:/E:/MS%20CS/Sem%20I/Distributed%20Systems/Labs/Lab%203/service/ndfdXML.wsdl");
        } catch (MalformedURLException ex) {
            e = new WebServiceException(ex);
        }
        NDFDXML_WSDL_LOCATION = url;
        NDFDXML_EXCEPTION = e;
    }

    public NdfdXML() {
        super(__getWsdlLocation(), NDFDXML_QNAME);
    }

    public NdfdXML(WebServiceFeature... features) {
        super(__getWsdlLocation(), NDFDXML_QNAME, features);
    }

    public NdfdXML(URL wsdlLocation) {
        super(wsdlLocation, NDFDXML_QNAME);
    }

    public NdfdXML(URL wsdlLocation, WebServiceFeature... features) {
        super(wsdlLocation, NDFDXML_QNAME, features);
    }

    public NdfdXML(URL wsdlLocation, QName serviceName) {
        super(wsdlLocation, serviceName);
    }

    public NdfdXML(URL wsdlLocation, QName serviceName, WebServiceFeature... features) {
        super(wsdlLocation, serviceName, features);
    }

    /**
     * 
     * @return
     *     returns NdfdXMLPortType
     */
    @WebEndpoint(name = "ndfdXMLPort")
    public NdfdXMLPortType getNdfdXMLPort() {
        return super.getPort(new QName("https://graphical.weather.gov/xml/DWMLgen/wsdl/ndfdXML.wsdl", "ndfdXMLPort"), NdfdXMLPortType.class);
    }

    /**
     * 
     * @param features
     *     A list of {@link javax.xml.ws.WebServiceFeature} to configure on the proxy.  Supported features not in the <code>features</code> parameter will have their default values.
     * @return
     *     returns NdfdXMLPortType
     */
    @WebEndpoint(name = "ndfdXMLPort")
    public NdfdXMLPortType getNdfdXMLPort(WebServiceFeature... features) {
        return super.getPort(new QName("https://graphical.weather.gov/xml/DWMLgen/wsdl/ndfdXML.wsdl", "ndfdXMLPort"), NdfdXMLPortType.class, features);
    }

    private static URL __getWsdlLocation() {
        if (NDFDXML_EXCEPTION!= null) {
            throw NDFDXML_EXCEPTION;
        }
        return NDFDXML_WSDL_LOCATION;
    }

}
