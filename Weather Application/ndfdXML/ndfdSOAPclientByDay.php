<?php

//  ***************************************************************************
//
//  ndfdSOAPclientByDay.php - Client for viewing NDFD XML in a browser 
//
//  John L. Schattel                    MDL                        5 July 2007
//  Aniesha L. Alford
//  Red Hat Linux                                                 Apache Server
//
//  PURPOSE:  This code serves to call the NDFD XML SOAP server and display the
//            resulting DWML document in the browser
//
//  VARIABLES:
//
//     parameters - Array holding the SOAP input information
//        zipCode: User supplied zip code
//        latitude: User supplied latitude (South latitude is negative)
//        longitude: User supplied longitude (West Longitude is negative)
//        startDate: User supplied local time they want data for.  This
//                         input is entered as a XML string 
//                         (ex. 2004-04-13T06:00:00)
//        numDays: User supplied number of days worth of data they want
//                 returned.
//        format: User supplied product ("24 hourly" and "12 hourly")
//     soapclient - A SOAP client object
//     err - The returned error conditions from the SOAP client
//     results - The DWML document
//
//  CALLED ROUTINES:
//
//     None.
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

// Send the appropriate mime type for XML
header("Content-Type: text/xml");

// Include Nusoap.php file
require_once('/www/html/nusoap/prod/nusoap.php');

// Initialize array to hold constant parameters
$array1 = array('startDate' => $_GET['startDate'],
                'numDays'   => $_GET['numDays'],
                'Unit'      => $_GET['Unit'],
                'format'    => $_GET['format']);

// Define new object and specify location of wsdl file.
$soapclient = new nusoap_client('http://' . $_SERVER['SERVER_NAME'] . '/forecasts/xml/SOAP_server/ndfdXMLserver.php?wsdl');

// Output any error conditions from creating the client
$err = $soapclient->getError();
if ($err) 
   exit("<error><h2>Constructor error</h2><pre>$err</pre></error>\n");

//  *****************************************************************************
//  Processing a SINGLE POINT call for an NDFDgenByDay product (24- and 12-hourly)
//  *****************************************************************************
if (array_key_exists('lat',$_GET) && ($_GET['lat'] != "")) 
{
   //  Initialize user supplied location input variables
   $array2 = array('latitude'  => $_GET['lat'],
                   'longitude' => $_GET['lon']);

   // Merge array1 and array2
   $parameters = array_merge($array2, $array1);

   // call the method and get the result.
   $result = $soapclient->call('NDFDgenByDay',$parameters,
                               'uri:DWMLgenByDay',
                               'uri:DWMLgenByDay/NDFDgenByDay');
}
//  *****************************************************************************
//  Processing a MULTI POINT call for an NDFDgenByDay product (24- and 12-hourly)
//  *****************************************************************************
elseif (array_key_exists('listLatLon',$_GET) && ($_GET['listLatLon'] != ""))
{
   //  Initialize user supplied location input variables
   $array2 = array('listLatLon' => $_GET['listLatLon']);
    
   // Merge array1 and array2
   $parameters = array_merge($array2, $array1);

   // call the method and get the result.
   $result = $soapclient->call('NDFDgenByDayLatLonList',$parameters,
                               'uri:DWMLgenByDay',
                               'uri:DWMLgenByDay/NDFDgenByDayLatLonList');
}
//  *****************************************************************************
//  Processing a SUBGRID call for an NDFDgenByDay product (24- and 12-hourly)
//  *****************************************************************************
elseif (array_key_exists('lat1',$_GET) && ($_GET['lat1'] != ""))
{                       
   //  This routine determines a default resolution needed for the subgrid
   require_once('../lib/conversion/getDefaultResolution.inc');

   //  This routine lists the four corner latitude and longitude pairs for an
   //  NDFD grid.
   require_once('../subgrid/generateCornerLatLonPairs.inc');

   //  This routine to extract the contents of the <latLonList> element
   require_once('../lib/conversion/parseDWMLelement.inc');

   //  This not a situation where the user provided us a resolution, so we will
   //  need the sector that their points are on
   if ((! isSet($_GET['resolutionSub'])) || ($_GET['resolutionSub'] == "") || ($_GET['resolutionSub'] == "default"))
   {
      //  Get code to determine if we have a matching sector
      require_once('selectSector.php');

      //  Convert subgrid corners to component latitude and longitude values
      $lowerLeftLat  = $_GET['lat1'];
      $lowerLeftLon  = $_GET['lon1'];
      $upperRightLat = $_GET['lat2'];
      $upperRightLon = $_GET['lon2'];

      //  Determine if the user's points are on any NDFD grids
      exec("/www/ndfd/public/bin/degrib_DP.cur -Sector -pnt $lowerLeftLat,$lowerLeftLon", $sector1, $returnValue);

      //  Accommodate RTMA conus 2.5km res.
      $numSectorsForPoint = count($sector1);
      for ($k = 0; $k < $numSectorsForPoint; $k++)
      {
         if (($sector1[$k] == "conus5") || ($sector1[$k] == "conus2_5"))
            $sector1[$k] = "conus";
      }

      exec("/www/ndfd/public/bin/degrib_DP.cur -Sector -pnt $upperRightLat,$upperRightLon", $sector2, $returnValue);

      //  Accommodate RTMA conus 2.5km res.
      $numSectorsForPoint = count($sector2);
      for ($k = 0; $k < $numSectorsForPoint; $k++)
      {
         if (($sector2[$k] == "conus5") || ($sector2[$k] == "conus2_5"))
            $sector2[$k] = "conus";
      }

      //  Get the matching sector
      $sectorsDoNotMatch = selectSector($sector1,$sector2,$sector,$sector1List,$sector2List);

      // check to ensure that both points are on the same NDFD sector
      if ($sectorsDoNotMatch)
         exit("<error><h2>ERROR</h2><pre>Subgrid corners must be in same sector. Point \"$lowerLeftLat,$lowerLeftLon\" in \"$sector1List\" and point \"$upperRightLat,$upperRightLon\" in \"$sector2List\"</pre></error>\n");
   }

   //  Now lets deal with user who didn't give us any resolution input
   if ((! isSet($_GET['resolutionSub'])) || ($_GET['resolutionSub'] == ""))
   {
      $_GET['resolutionSub'] = getDefaultResolution($sector);
   }

   //  Now we handle the rare case where the user wants the whole grid
   //  Of course they are only going to get the max allowed grid points
   else if ($_GET['resolutionSub'] == "default")
   {
      //  Tell generateCornerLatLonPairs.inc that its being invoked by the SOAP server
      $callingType = "soap";

      //  Get the resolution
      $LatLonList = generateCornerLatLonPairs($sector,$callingType);
      $LatLonListwResolution = $LatLonList;

      //  Extract the latitude and longitude list
      $LatLonList = parseDWMLelement($LatLonList,"<latLonList>","</latLonList>");

      //  We want the zeroth (lower left) and 2nd (upper right) array elements
      $newCorners = explode(" ",$LatLonList);

      $lowerLeftPoint = explode(",",$newCorners[0]);
      $_GET['lat1']  = $lowerLeftPoint[0];
      $_GET['lon1']  = $lowerLeftPoint[1];

      $upperRightPoint = explode(",",$newCorners[0]);
      $_GET['lat2'] = $upperRightPoint[0];
      $_GET['lon2'] = $upperRightPoint[1];

      //  Extract the resolution
      $_GET['resolutionSub'] = parseDWMLelement($LatLonListwResolution,"<minResolution>","</minResolution>");
   }

   //  Get the latitude and longitude list using user provide subgrid points
   $parameters = array('lowerLeftLatitude'   => $_GET['lat1'],
                       'lowerLeftLongitude'  => $_GET['lon1'],
                       'upperRightLatitude'  => $_GET['lat2'],
                       'upperRightLongitude' => $_GET['lon2'],
                       'resolution'          => $_GET['resolutionSub']);

   // call the method and get the result.
   $LatLonList = $soapclient->call('LatLonListSubgrid',$parameters,
                                   'uri:DWMLgenByDay',
                                   'uri:DWMLgenByDay/LatLonListSubgrid');

   //  Processes any SOAP fault information we get back from the server
   if ($soapclient->fault)
   {
      echo "<error><h2>ERROR</h2><pre>";
      print_r($LatLonList);
      echo "</pre></error>\n";
      exit;
   }
   else
   {
      //  Capture any client errors
      $err = $soapclient->getError();

      if ($err) 
         exit("<error><h2>ERROR</h2><pre>$err</pre></error>\n");
   }

   //  Extract the latitude and longitude list
   $LatLonList = parseDWMLelement($LatLonList,"<latLonList>","</latLonList>");

   //  Initialize user supplied location input variables
   $array2 = array('latLonList' => $LatLonList);
    
   // Merge array1 and array2
   $parameters = array_merge($array2, $array1);

   // call the method and get the result.
   $result = $soapclient->call('NDFDgenByDayLatLonList',$parameters,
                               'uri:DWMLgenByDay',
                               'uri:DWMLgenByDay/NDFDgenByDayLatLonList');
}
//  *****************************************************************************
//  Processing a LINE OF POINTS call for an NDFDgenByDay product (24- and 12-hourly)
//  *****************************************************************************
elseif (array_key_exists('endPoint1Lat',$_GET) && ($_GET['endPoint1Lat'] != ""))
{
   //  This routine to extract the contents of the <latLonList> element
   require_once('../lib/conversion/parseDWMLelement.inc');

   //  Get code to determine if we have a matching sector
   require_once('selectSector.php');

   //  Determine if the user's points are on any NDFD grids
   exec("/www/ndfd/public/bin/degrib_DP.cur -Sector -pnt {$_GET['endPoint1Lat']},{$_GET['endPoint1Lon']}", $sector1, $returnValue);

   //  Accommodate RTMA conus 2.5km res.
   $numSectorsForPoint = count($sector1);
   for ($k = 0; $k < $numSectorsForPoint; $k++)
   {
      if (($sector1[$k] == "conus5") || ($sector1[$k] == "conus2_5"))
         $sector1[$k] = "conus";
   }

   //  Determine if the user's points are on any NDFD grids
   exec("/www/ndfd/public/bin/degrib_DP.cur -Sector -pnt {$_GET['endPoint2Lat']},{$_GET['endPoint2Lon']}", $sector2, $returnValue);

   //  Accommodate RTMA conus 2.5km res.
   $numSectorsForPoint = count($sector2);
   for ($k = 0; $k < $numSectorsForPoint; $k++)
   {
      if (($sector2[$k] == "conus5") || ($sector2[$k] == "conus2_5"))
         $sector2[$k] = "conus";
   }

   //  Get the matching sector
   $sectorsDoNotMatch = selectSector($sector1,$sector2,$sector,$sector1List,$sector2List);

   // check to ensure that both points are on the same NDFD sector
   if ($sectorsDoNotMatch)
      exit("<error><h2>ERROR</h2><pre>End points must be in same NDFD sector.  Point {$_GET['endPoint1Lat']},{$_GET['endPoint1Lon']} in \"$sector1List\" and point {$_GET['endPoint2Lat']},{$_GET['endPoint2Lon']} in \"$sector2List\"</pre></error>\n");

   //  Initialize user supplied location input variables
   $parameters = array('endPoint1Lat' => $_GET['endPoint1Lat'],
                       'endPoint1Lon' => $_GET['endPoint1Lon'],
                       'endPoint2Lat' => $_GET['endPoint2Lat'],
                       'endPoint2Lon' => $_GET['endPoint2Lon']);

   // call the method and get the LatLonList.
   $LatLonList = $soapclient->call('LatLonListLine',$parameters,
                                   'uri:DWMLgenByDay',
                                   'uri:DWMLgenByDay/LatLonListLine');

   //  Processes any SOAP fault information we get back from the server
   if ($soapclient->fault)
   {
      echo "<error><h2>ERROR</h2><pre>";
      print_r($LatLonList);
      echo "</pre></error>\n";
      exit;
   }
   else
   {
      //  Capture any client errors
      $err = $soapclient->getError();

      if ($err)
         exit("<error><h2>ERROR</h2><pre>$err</pre></error>\n");
   }

   //  Extract the latitude and longitude list
   $LatLonList = parseDWMLelement($LatLonList,"<latLonList>","</latLonList>");

   //  Initialize user supplied location input variables
   $array2 = array('listLatLon' => $LatLonList);
    
   // Merge array1 and array2
   $parameters = array_merge($array2, $array1);

   // call the method and get the result.
   $result = $soapclient->call('NDFDgenByDayLatLonList',$parameters,
                               'uri:DWMLgenByDay',
                               'uri:DWMLgenByDay/NDFDgenByDayLatLonList');
}
//  *****************************************************************************
//  Processing a ZIP CODE call for an NDFDgenByDay product (24- and 12-hourly)
//  *****************************************************************************
elseif (array_key_exists('zipCodeList',$_GET) && ($_GET['zipCodeList'] != ""))
{
   //  This routine to extract the contents of the <latLonList> element
   require_once('../lib/conversion/parseDWMLelement.inc');

   // Define new object and specify location of wsdl file.
$soapclient = new nusoap_client('http://' . $_SERVER['SERVER_NAME'] . '/forecasts/xml/SOAP_server/ndfdXMLserver.php?wsdl');

   //  Initialize user supplied location input variables
   $parameters = array('zipCodeList' => $_GET['zipCodeList']);

   // call the method and get the LatLonList.
   $LatLonList = $soapclient->call('LatLonListZipCode',$parameters,
                                   'uri:DWMLgenByDay',
                                   'uri:DWMLgenByDay/LatLonListZipCode');
   if ($soapclient->fault)
   {
      $result = $LatLonList;
   }
   else
   {
      //  Extract the latitude and longitude list
      $LatLonList = parseDWMLelement($LatLonList,"<latLonList>","</latLonList>");

      //  Initialize user supplied location input variables
      $array2 = array('listLatLon' => $LatLonList);
    
      // Merge array1 and array2
      $parameters = array_merge($array2, $array1);

     // call the method and get the result.
      $result = $soapclient->call('NDFDgenByDayLatLonList',$parameters,
                                  'uri:DWMLgenByDay',
                                  'uri:DWMLgenByDay/NDFDgenByDayLatLonList');
   }
}



//  *****************************************************************************
//  Processing a CITIES call for an NDFDgenByDay product (24- and 12-hourly)
//  *****************************************************************************
elseif (array_key_exists('citiesLevel',$_GET) && ($_GET['citiesLevel'] != ""))
{
   //  This routine to extract the contents of the <latLonList> element
   require_once('../lib/conversion/parseDWMLelement.inc');

   //  This routine inserts a <city> element in place of a <point> element
   require_once('../lib/conversion/insertCityNames.inc');

   // Define new object and specify location of wsdl file.
$soapclient = new nusoap_client('http://' . $_SERVER['SERVER_NAME'] . '/forecasts/xml/SOAP_server/ndfdXMLserver.php?wsdl');

   //  Initialize user supplied display level input variables 
   //  1 = main cities 
   //  2 = Cities to fill in some of the empty geography
   //  3 and 4 = Cities for greater area coverage
   $parameters = array('displayLevel' => $_GET['citiesLevel']);

   // call the method and get the result.
   $listOutput = $soapclient->call('LatLonListCityNames',$parameters,
                                   'uri:DWMLgen',
                                   'uri:DWMLgen/LatLonListCityNames');

   //  Extract the latitude and longitude list
   $LatLonList = parseDWMLelement($listOutput,"<latLonList>","</latLonList>");

   //  Extract the city name list
   $citiesList = parseDWMLelement($listOutput,"<cityNameList>","</cityNameList>");

   //  Initialize user supplied location input variables
   $array2 = array('listLatLon' => $LatLonList);
    
   // Merge array1 and array2
   $parameters = array_merge($array2, $array1);

   // call the method and get the result.
   $result = $soapclient->call('NDFDgenByDayLatLonList',$parameters,
                               'uri:DWMLgenByDay',
                               'uri:DWMLgenByDay/NDFDgenByDayLatLonList');

   $result = insertCityNames($result,$citiesList);
}


//  *****************************************************************************
//  Processing a SQUARE (central point and direction) call for an NDFDgenByDay product (24- and 12-hourly)
//  *****************************************************************************
elseif (array_key_exists('centerPointLat',$_GET) && ($_GET['centerPointLat'] != ""))
{                       
   //  This routine determines the degrib -XMLFormatOnly command line input
   require_once('../lib/conversion/getDefaultResolution.inc');

   //  This routine to extract the contents of the <latLonList> element
   require_once('../lib/conversion/parseDWMLelement.inc');

   //  Convert subgrid corners to component latitude and longitude values
   $centerPointLat  = $_GET['centerPointLat'];
   $centerPointLon  = $_GET['centerPointLon'];
   $distanceLat     = $_GET['distanceLat'];
   $distanceLon     = $_GET['distanceLon'];

   //  Some times the client will be called without a resolution so check for it
   if (array_key_exists('resolutionSquare',$_GET) && ($_GET['resolutionSquare'] != ""))
      $resolution = $_GET['resolutionSquare'];
   else
   {
      //  Determine if the user's points are on any NDFD grids
      exec("/www/ndfd/public/bin/degrib_DP.cur -Sector -pnt $centerPointLat,$centerPointLon", $sector1, $returnValue);

      //  Accommodate RTMA conus 2.5km res.
      $numSectorsForPoint = count($sector1);
      for ($k = 0; $k < $numSectorsForPoint; $k++)
      {
         if (($sector1[$k] == "conus5") || ($sector1[$k] == "conus2_5"))
            $sector1[$k] = "conus";
      }

      // check to ensure that both points are on the same NDFD sector
      if ($sector1[0] == "")
         exit("<error><h2>ERROR</h2><pre>Center point must be on NDFD sector. \"$centerPointLat,$centerPointLon\" in \"no NDFD sector\"</pre></error>\n");

      $resolution = getDefaultResolution($sector1[0]);

      if ("$resolution" == "Bad Sector")
         exit("<error><h2>ERROR</h2><pre>Center point must be on NDFD sector.  \"$centerPointLat,$centerPointLon\" in \"{$sector1[0]}\"</pre></error>\n");
      else
         $resolution = $resolution / 1000.0;

      $_GET['resolutionSquare'] = $resolution;
   }

   // Define new object and specify location of wsdl file.
$soapclient = new nusoap_client('http://' . $_SERVER['SERVER_NAME'] . '/forecasts/xml/SOAP_server/ndfdXMLserver.php?wsdl');

   $parameters = array('centerPointLat' => $centerPointLat,
                       'centerPointLon' => $centerPointLon,
                       'distanceLat'    => $distanceLat,
                       'distanceLon'    => $distanceLon,
                       'resolution'     => $_GET['resolutionSquare']);

   // call the method and get the LatLonList.
   $LatLonList = $soapclient->call('LatLonListSquare',$parameters,
                                'uri:DWMLgenByDay',
                                'uri:DWMLgenByDay/LatLonListSquare');

   //  Processes any SOAP fault information we get back from the server
   if ($soapclient->fault)
   {
      echo "<error><h2>ERROR</h2><pre>";
      print_r($LatLonList);
      echo "</pre></error>\n";
      exit;
   }
   else
   {
      //  Capture any client errors
      $err = $soapclient->getError();

      if ($err) 
         exit("<error><h2>ERROR</h2><pre>$err</pre></error>\n");
   }

   //  Extract the latitude and longitude list
   $LatLonList = parseDWMLelement($LatLonList,"<latLonList>","</latLonList>");

   //  Initialize user supplied location input variables
   $array2 = array('listLatLon' => $LatLonList);
    
   // Merge array1 and array2
   $parameters = array_merge($array2, $array1);

   // call the method and get the result.
   $result = $soapclient->call('NDFDgenByDayLatLonList',$parameters,
                               'uri:DWMLgenByDay',
                               'uri:DWMLgenByDay/NDFDgenByDayLatLonList');
}
//  *****************************************************************************
//  We didn't find input that we were expecting, so tell the user of the error
//  *****************************************************************************
else
{
   echo "<error><h2>ERROR: Bad input(s) to service</h2><pre>";
   print_r($_GET);
   echo "</pre></error>\n";
   exit;
}

//  Processes any SOAP fault information we get back from the server
if ($soapclient->fault)
{
   echo "<error><h2>ERROR</h2><pre>";
   print_r($result);
   echo "</pre></error>\n";
   exit;
}
else
{
     //  Capture any client errors
     $err = $soapclient->getError();
     if ($err) 
        exit("<error><h2>ERROR</h2><pre>$err</pre></error>\n");
     else  // we successfully created the DWML document
        echo $result;
}

?>
