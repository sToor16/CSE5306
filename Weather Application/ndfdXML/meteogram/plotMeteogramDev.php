<?php

//  ***************************************************************************
//
//  plotMeteogramDev.php - A client that creates a graph of NDFD temperature 
//
//  John L. Schattel                    MDL                        5 March 2004
//  Red Hat Linux                                                 Apache Server
//
//  PURPOSE:  This routine invokes the NDFD XML NuSOAP server to format a DWML
//            document using the exposed server function NDFDgen.  The returned
//            data is then parsed and graphed.
//
//  VARIABLES:
//
//     TimeValues - An array of time values for the NDFD data
//     dayValues - An array of day of the week names corresponding to the 
//                 timeValues
//     hourlyTempValues - This is the 3 hourly NDFD temperature data that we 
//                        are graphing
//     maxTempValues - These are the NDFD maximum temperature values
//     minTempValues - These are the NDFD minimum temperature values
//     layoutKey - This the key that relates the time information to the
//                 temperature data within the XML document
//     timeCount - Index for the time value that we are processing
//     tempCount - Index for the temperature value that we are processing
//     typeCurrent - This in an attribute in the temperature element that 
//                   describes what kind of temperature it is (i.e. hourly)
//     currentTag - This the NDFD XML tag that is currrently being proceesed
//     parameters - Associative array composed of the following information 
//        latitude - User supplied latitude (South latitude is negative)
//        longitude - User supplied longitude (West Longitude is negative)
//        product - User supplied product (time-series, glance, etc.)
//        startTime - User supplied local time they want data for.  This
//                    input is entered as a XML string 
//                    (ex. 2004-04-13T12:00:00)
//        endTime - User supplied local time they want data for.  This
//                  input is entered as a XML string 
//                  (ex. 2004-04-13T12:00:00)
//        weatherParameters - Associative array of strings to indicate
//                            which NDFD parameters they want returned.
//                            Possible values include the following:
//
//     weatherParameters['maxt']  = TRUE returns maximum temperature
//     weatherParameters['mint']  = TRUE returns minimum temperature
//     weatherParameters['temp']  = TRUE returns 3 hourly temperature
//     weatherParameters['dew']   = TRUE returns dewpoint temperature
//     weatherParameters['pop12'] = TRUE returns POP12
//     weatherParameters['qpf']   = TRUE returns QPF
//     weatherParameters['sky']   = TRUE returns sky cover
//     weatherParameters['snow']  = TRUE returns snow amount
//     weatherParameters['wspd']  = TRUE returns wind speed
//     weatherParameters['wdir']  = TRUE returns wind direction
//     weatherParameters['wx']    = TRUE returns weather
//     weatherParameters['waveh'] = TRUE returns wave height
//     weatherParameters['icons'] = TRUE returns weather icon links
//     weatherParameters['rh']    = TRUE returns relative humidity
//     weatherParameters['appt']  = TRUE returns apparent temperature
//     weatherParameters['incw34']  = TRUE returns Probability of a 
//                                    Tropical Cyclone Wind Speed >34 
//                                    Knots (Incremental)
//     weatherParameters['incw50']  = TRUE returns Probability of a 
//                                    Tropical Cyclone Wind Speed >50 
//                                    Knots (Incremental)
//     weatherParameters['incw64']  = TRUE returns Probability of a 
//                                    Tropical Cyclone Wind Speed >64 
//                                    Knots (Incremental)
//     weatherParameters['cumw34']  = TRUE returns Probability of a 
//                                    Tropical Cyclone Wind Speed >34 
//                                    Knots (Cumulative)
//     weatherParameters['cumw50']  = TRUE returns Probability of a 
//                                    Tropical Cyclone Wind Speed >50 
//                                    Knots (Cumulative)
//     weatherParameters['cumw64']  = TRUE returns Probability of a 
//                                    Tropical Cyclone Wind Speed >64 
//                                    Knots (Cumulative)
//     weatherParameters['conhazo']       = TRUE returns probability of
//                                          convection.
//     weatherParameters['ptornado']      = TRUE returns probability of
//                                          tornadoes.
//     weatherParameters['phail']         = TRUE returns probability of
//                                          hail.
//     weatherParameters['ptstmwinds']    = TRUE returns probability of
//                                          damaging thunderstorms.
//     weatherParameters['pxtornado']     = TRUE returns probability of
//                                          extreme tornadoes.
//     weatherParameters['pxhail']        = TRUE returns probability of
//                                          extreme hail.
//     weatherParameters['pxtstmwinds']   = TRUE returns probability of
//                                          extreme thunderstorm winds.
//     weatherParameters['ptotsvrtstm']   = TRUE returns probability of
//                                          severe thunderstorms.
//     weatherParameters['pxtotsvrtstm']  = TRUE returns probability of
//                                          extreme severe thunderstorms.
//     weatherParameters['wgust']      = TRUE returns wind gust
//     
//     soapclient - A SOAP client object
//     err - The returned error conditions from the SOAP client
//     results - The DWML document
//
//  CALLED ROUTINES:
//
//     NDFDgen() - This program retrieves the NDFD data requested by
//                 the user and then formats it as NDFD XML.
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

// Include Nusoap.php file
require_once('/www/html/nusoap/prod/nusoap.php');

// GLOBAL Variables
$TimeValues = array();
$dayValues = array();
$hourlyTempValues = array();
$maxTempValues = array();
$minTempValues = array();
$layoutKey = array();
$timeCount = 0;
$tempCount = 0;
$typeCurrent = 'start';
$currentTag = 'start';

function getHourOfDay($timeString)
{
   $year = substr($timeString,0,4);
   $month = substr($timeString,5,2);
   $day = substr($timeString,8,2);
   $hour = substr($timeString,11,2);
            
   $integerTime = mktime($hour,0,0,$month,$day,$year);
   $hourName = date("H",$integerTime);

   return $hourName;
}

function getDayOfWeek($timeString)
{
   $year = substr($timeString,0,4);
   $month = substr($timeString,5,2);
   $day = substr($timeString,8,2);
   $hour = substr($timeString,11,2);
            
   $integerTime = mktime($hour,0,0,$month,$day,$year);
   $dayName = date("D",$integerTime);

   return $dayName;
}

function createParser()
{
   $xmlParser = xml_parser_create();
   if ($xmlParser == false)
   {
      die('Cannot create an XML parser handle.');
   }
   return $xmlParser;
}

function setOptions($xmlParser)
{
   xml_parser_set_option($xmlParser, XML_OPTION_CASE_FOLDING, false);
}

function setHandlers($xmlParser)
{
   xml_set_element_handler($xmlParser, 'handleBeginTag', 'handleEndTag');
   xml_set_character_data_handler($xmlParser, 'HandleCharacterData');
}

function parse($xmlParser, $xmlOut)
{
   $parsedOkay = xml_parse($xmlParser, $xmlOut);

   if ( ! $paredOkay && xml_get_error_code($xmlParser) != XML_ERROR_NONE)
   {
      die('xmlParse error: ' . xml_error_string(xml_get_erro_code($xmlParser)) . 
          ' at line ' . xml_get_current_line_number($xmlParser));
   }
}

function freeParser($xmlParser)
{
   $freeOkay = xml_parser_free($xmlParser);

   if( ! $freeOkay)
   {
      die('You did not pass a proper XML pareser to this function.');
   }
}

function handleBeginTag($parser, $name, $attribs)
{
   global $currentTag;
   global $typeCurrent;
   global $tempCount;
   global $timeCount;

   $currentTag = $name;
      
   switch($name)
   {
      case "temperature" :
         $typeCurrent = $attribs['type'];
         $tempCount = 0;
         break;

      case "time-layout" :
         $timeCount = 0;
         break;

      case "value" :
         break;

      default :
         break;
   }
}

function handleCharacterData($xmlParser, $data)
{
   global $TimeValues;
   global $dayValues;
   global $hourlyTempValues;
   global $layoutKey;
   global $currentTag;
   global $typeCurrent;
   global $tempCount;
   global $timeCount;

   switch($currentTag)
   {

      case "value" :
         if ($typeCurrent == "hourly")
         {
            $hourlyTempValues[$tempCount] = $data;
         }
         break;

      case "layout-key" :
         $layoutKey[$timeCount] = $data;
         break;

      case "start-valid-time" :
         $TimeValues[$timeCount] = getHourOfDay($data);
         $dayValues[$timeCount] = getDayOfWeek($data);
         break;

      default :
         break;

   }      
}

function handleEndTag($xmlParser, $name)
{
   global $currentTag;
   global $typeCurrent;
   global $tempCount;
   global $timeCount;

   switch($name)
   {
      case "temperature" :
         $typeCurrent = "none";
         break;

      case "name" :
         break;

      case "value" :
         $tempCount = $tempCount + 1;
         break;

      case "start-valid-time" :
         $timeCount = $timeCount + 1;

      default :
         break;

   }
}

$timeArray = array();
$tempArray = array();

$parameters = array('latitude' => $_GET['lat'],
                    'longitude'  => $_GET['lon'],
                    'product' => $_GET['product'],
                    'startTime' => $_GET['begin'],
                    'endTime' => $_GET['end'],
                    'weatherParameters' => array('maxt'         => $_GET['maxt']         == 'maxt',
                                                 'mint'         => $_GET['mint']         == 'mint',
                                                 'temp'         => $_GET['temp']         == 'temp',
                                                 'dew'          => $_GET['dew']          == 'dew',
                                                 'pop12'        => $_GET['pop12']        == 'pop12',
                                                 'qpf'          => $_GET['qpf']          == 'qpf',
                                                 'sky'          => $_GET['sky']          == 'sky',
                                                 'snow'         => $_GET['snow']         == 'snow',
                                                 'wspd'         => $_GET['wspd']         == 'wspd',
                                                 'wdir'         => $_GET['wdir']         == 'wdir',
                                                 'wx'           => $_GET['wx']           == 'wx',
                                                 'waveh'        => $_GET['waveh']        == 'waveh',
                                                 'icons'        => $_GET['icons']        == 'icons',
                                                 'rh'           => $_GET['rh']           == 'rh',
                                                 'appt'         => $_GET['appt']         == 'appt',
                                                 'incw34'       => $_GET['incw34']       == 'incw34',
                                                 'incw50'       => $_GET['incw50']       == 'incw50',
                                                 'incw64'       => $_GET['incw64']       == 'incw64',
                                                 'cumw34'       => $_GET['cumw34']       == 'cumw34',
                                                 'cumw50'       => $_GET['cumw50']       == 'cumw50',
                                                 'cumw64'       => $_GET['cumw64']       == 'cumw64',
                                                 'conhazo'      => $_GET['conhazo']      == 'conhazo',
                                                 'ptornado'     => $_GET['ptornado']     == 'ptornado',
                                                 'phail'        => $_GET['phail']        == 'phail',
                                                 'ptstmwinds'   => $_GET['ptstmwinds']   == 'ptstmwinds',
                                                 'pxtornado'    => $_GET['pxtornado']    == 'pxtornado',
                                                 'pxhail'       => $_GET['pxhail']       == 'pxhail',
                                                 'pxtstmwinds'  => $_GET['pxtstmwinds']  == 'pxtstmwinds',
                                                 'ptotsvrtstm'  => $_GET['ptotsvrtstm']  == 'ptotsvrtstm',
                                                 'pxtotsvrtstm' => $_GET['pxtotsvrtstm'] == 'pxtotsvrtstm',
                                                 'wgust'        => $_GET['wgust']        == 'wgust'
                                                )
                    );

// Define new object and specify location of wsdl file.  This works when the client is on
// the client is on a machine that is different from the machine hosting the SOAP server 
// $soapclient = new soapclient('http://www.weather.gov/forecasts/xml/SOAP_server/ndfdXMLserver.php');
// Define new object and specify location of wsdl file.  This works when the client is on
// the same machine as the SOAP server. 
$soapclient = new soapclient('http://localhost/forecasts/xml/SOAP_server/ndfdXMLserver.php');

//  Handle any error encountered while creating the client
$err = $soapclient->getError();
if ($err) 
{
 echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
}

// call the method and get the result.
$result = $soapclient->call('NDFDgen',$parameters,
                            'uri:DWMLgen',
                            'uri:DWMLgen/NDFDgen');

// Parse the resulting XML from the SOAP service ($result)
$xmlParser = createParser();
setOptions($xmlParser);
setHandlers($xmlParser);
parse($xmlParser, $result);
freeParser($xmlParser);

// Plot the temperatures

include('./class.graph1');

$currentDay = "";
for ($index = 0; $index < $timeCount; $index++)
{
   if ((($index % 4) == 0) || ($index == 0))
      if ($currentDay == $dayValues[$index])
         $timeArray[$index] = $TimeValues[$index];
      else
      {
         $timeArray[$index] = $dayValues[$index] . "/" . $TimeValues[$index];
         $currentDay = $dayValues[$index];
      }
   else
      $timeArray[$index] = "";
   $tempArray[$index] = $hourlyTempValues[$index];
}

//  Create an array with the data that we want graphed
$a = array($timeArray, $tempArray);

//  Initialize the plotting routine configurable parameter
phpplot(array(
    "box_showbox"=> true,
    "transparent"=> true,
    "background" => "",
    "grid"=> true,
    "grid_xgrid" => true,
    "grid_xdash" => true,
    "colorset" => array("purple","blue"),
    "title_text"=> "NDFD Temperatures",
    "yaxis_labeltext"=> "Fahrenheit",
    "xaxis_labeltext"=> "Hour (Local Time)",
    "size"=> array(650,250) ));

//  Provide the graphics routines with the data we want graphed
phpdata($a);

//  Create the chart
phpdraw("linepoints",array(
    "drawsets" => array(1),
    "showpoint"=> true,
    "showvalue"=> false ));

//  Output the chart to a file as a .png
phpshow('/www/html/xml/images/out.png');
//  output the chart to the browser
/* phpshow(); */

//  Format the output for display by the browser 
include 'output.php';

?>
