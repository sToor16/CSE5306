<?php

//  ***************************************************************************
//
//  ndfdXMLclient.php - Client for viewing NDFD XML in a browser 
//
//  John L. Schattel                    MDL                        5 March 2004
//  Red Hat Linux                                                 Apache Server
//
//  PURPOSE:  This code serves to call the NDFD XML SOAP server and display the
//            resulting DWML document in the browser
//
//  VARIABLES:
//
//     xmlOut - This is the string that holds the NDFD XML (DWML) output
//     latitude - User supplied latitude (South latitude is negative)
//     longitude - User supplied longitude (West Longitude is negative)
//     product - User supplied product (time-series, glance, etc.)
//     startTime - User supplied local time they want data for.  This
//                         input is entered as a XML string 
//                         (ex. 2004-04-13T12:00:00)
//     endTime - User supplied local time they want data for.  This
//                         input is entered as a XML string 
//                         (ex. 2004-04-13T12:00:00)
//     weatherParameters - Associative array of strings to indicate
//                         which NDFD parameters they want returned.
//                         Possible values include the following:
//
//            weatherParameters['maxt']  = maxt
//            weatherParameters['mint']  = mint
//            weatherParameters['temp']  = temp
//            weatherParameters['dew']   = dew
//            weatherParameters['pop12'] = pop12
//            weatherParameters['qpf']   = qpf
//            weatherParameters['sky']   = sky
//            weatherParameters['snow']  = snow
//            weatherParameters['wspd']  = wspd
//            weatherParameters['wdir']  = wdir
//            weatherParameters['wx']    = wx
//            weatherParameters['waveh'] = waveh
//            weatherParameters['icons'] = icons
//
//     callingType - Flag to indicate that we want to have the DWML displayed in the browser
//
//  CALLED ROUTINES:
//
//     generateDWML() - This program retrieves the NDFD data requested by
//                      the user and then formats it as NDFD XML.
//     
//  SOURCE CODE CONTROL INFORMATION
//
//      Name:
//         %PM%
//         %PID%
//  
//      Status:
//         %PS%
//  
//      History:
//         %PL%
//  
//      Change Document History:
//         %PIRC%
//
//  ***************************************************************************

//  ==================  FUNCTIONS  ============================================

//  ***************************************************************************
//
//  getmicrotime - gets the current system time in micro seconds
//
//  John L. Schattel          MDL                5 March 2004
//  Red Hat Linux                                Apache Server
//
//  PURPOSE:   This function retrieves the current system time
//             using the build in function microtime.
//
//  VARIABLES:
//
//             sec - Seconds returned by PHP built in function microtime
//             usec - Micro seconds returned by PHP built in function 
//                    microtime
//
//  RETURN VALUE:  Returns an float value representing the 
//                 current system time in microseconds
// 
//  ***************************************************************************

function getmicrotime() 
{ 
   list($usec, $sec) = explode(" ", microtime()); 
   return ((float)$usec + (float)$sec); 
}

//  ==================  MAIN PROGRAM  =========================================

// Send the appropriate mime type for XML
header("Content-Type: text/xml");

// Include Nusoap.php file
require_once('/www/html/nusoap/prod/nusoap.php');

$parameters = array('latitude' => $_GET['lat'],
                    'longitude'  => $_GET['lon'],
                    'startDate' => $_GET['startDate'],
                    'numDays' => $_GET['numDays'],
                    'format' => $_GET['format']);

// Define new object and specify location of wsdl file.
$soapclient = new soapclient('http://localhost/forecasts/xml/SOAP_server/ndfdXMLserver.php');

// Output any error conditions from creating the client
$err = $soapclient->getError();
if ($err) 
{
 echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
}

// call the method and get the result.
$result = $soapclient->call('NDFDgenByDay',$parameters);

//  Processes any SOAP fault information we get back from the server
if ($soapclient->fault)
{
   echo '<h2>Fault</h2><pre>';
   print_r($result);
   echo '</pre>';
}
else
{
   //  Capture any client errors
   $err = $soapclient->getError();
   if ($err) 
   {
     // Display the error
     echo '<p><b>Error: ' . $err . '</b></p>';
     echo '<h2>Debug</h2>';
     echo '<pre>' . htmlspecialchars($client->debug_str, ENT_QUOTES) . '</pre>';
   }
   else  // we successfully created the DWML document
   {
      header("Content-Type: text/xml");
      $twoPieces = explode("?>",$result);
      if ($_GET['format'] == "12 hourly")
         $resultWithXSLT = $twoPieces[0] . "?>" . "<?xml-stylesheet type=\"text/xsl\" href=\"sampleXSL_12hr.xsl\"?>" . $twoPieces[1];
      elseif ($_GET['format'] == "24 hourly")
         $resultWithXSLT = $twoPieces[0] . "?>" . "<?xml-stylesheet type=\"text/xsl\" href=\"sampleXSL_24hr.xsl\"?>" . $twoPieces[1];
      echo $resultWithXSLT;
   }
}
/*
echo '<h2>Request</h2><pre>' . htmlspecialchars($soapclient->request, ENT_QUOTES) . '</pre>';
echo '<h2>Response</h2><pre>' . htmlspecialchars($soapclient->response, ENT_QUOTES) . '</pre>';
echo '<h2>Debug</h2><pre>' . htmlspecialchars($soapclient->debug_str, ENT_QUOTES) . '</pre>';
*/
?>
