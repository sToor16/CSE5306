The tar file ndfdXML.tar contains the following:

A.  Basic Client 

    PURPOSE:  returns NDFD XML to the browser.

    ndfdXML.htm  -  Web page that runs the client by providing the required NDFDgen() inputs.
    ndfdXMLclient.php  -  Client code that calls a NuSOAP SOAP server and its exposed function NDFDgen().
    ndfdSOAPByDay.htm  -  Web page that runs the client by providing the required NDFDgenByDay inputs.
    ndfdSOAPclientByDay.php  -  Client code that calls a NuSOAP SOAP server and its exposed function NDFDgen().

B.  Temperature Graphing Client 

    PURPOSE:  returns a web page containing an image showing a plot of temperature data.

    DWML_graph.htm  -  Web page that runs the client by providing the required inputs.
    plotMeteogramDev.php  -  Client code that calls a NuSoap SOAP server.
    class.graph1 -  A freeware graph package called VH Graph.

    For both sets of files, you ** may ** need to do the following:

    1.  Acquire and install a copy of NuSoap.

        Try http://dietrich.ganx4.com/nusoap/index.php to download a copy.

    2.  Change the location of NuSoap in the code to its local path.

        change the following line to reflect your local setup:
 
        require_once('/var/www/html/nusoap.php'); 

    3.  Change "localhost" to "www.weather.gov" in the following line of code:

        $soapclient = new soapclient('http://localhost/forecasts/xml/SOAP_server/ndfdXMLserver.php');

    For addition information on VH Graph visit the following URL:

    http://codingtheweb.users.phpclasses.org/browse.html/class/11.html

C.  XSLT example

    PURPOSE:  Used with a XSLT aware browser to demonstrate how XSLT can transform the DWMLgenByDay product.

    DWML2Glance.htm - Web page to access a PHP client that performs the XSLT conversion
    ndfdSOAPclient_XSLT.php - PHP client that retrieves the data and reformats it with a XSLT script.
    sampleXML_24hr.xml - Holds the 24 hour formatted DWML that uses the following xsl file
    sampleXML_24hr.xsl - Formats the weather and icons into table
    sampleXML_12hr.xml - Holds the 12 hour formatted DWML that used the following xsl file
    sampleXML_12hr.xsl - Formats the weather and icon into table

D.  Perl example

    PURPOSE: shows how Perl can be used to access the SOAP service to calculate information about the returned high temperatures

    xmlReader.pl - Perl script that calcuates the average high temperature, the warmest and coldest high temperature during the next 7 days.
