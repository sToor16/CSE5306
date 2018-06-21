<?php

//  ***************************************************************************
//
//  ndfdXMLclient.php - A client that uses the NDFD XML NuSOAP Server 
//
//  John L. Schattel                    MDL                        5 July 2007
//  Aniesha L. Alford
//  Red Hat Linux                                                 Apache Server
//
//  PURPOSE:  This routine invokes the NDFD XML NuSOAP server to format an DWML
//            document using the exposed server function NDFDgen
//
//  VARIABLES:
//
//     parameters - Associative array composed of the following information 
//        zipCode - User supplied zip code.
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
//     weatherParameters['critfireo']     = TRUE returns Fire Wx risk 
//                                          from wind and relative humidity
//     weatherParameters['dryfireo']      = TRUE returns Fire Wx risk
//                                          from dry thunderstorms.
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
//     None
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

// Initialize array to hold input parameters used by most NDFDgen functions:
$arrayNDFDgen = array('product'=> $_GET['product'],
                      'startTime' => $_GET['begin'],
                      'endTime'=> $_GET['end'],
                      'Unit'=> $_GET['Unit']);

//  Create a seperate input array so functions like the GML generator who don't
//  need the product, start and end times can merge in wx parameters input
$arrayWeather = array('weatherParameters' => array('maxt'         => $_GET['maxt']         == 'maxt',
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
                                                   'critfireo'    => $_GET['critfireo']    == 'critfireo',
                                                   'dryfireo'     => $_GET['dryfireo']     == 'dryfireo',
                                                   'conhazo'      => $_GET['conhazo']      == 'conhazo',
                                                   'ptornado'     => $_GET['ptornado']     == 'ptornado',
                                                   'phail'        => $_GET['phail']        == 'phail',
                                                   'ptstmwinds'   => $_GET['ptstmwinds']   == 'ptstmwinds',
                                                   'pxtornado'    => $_GET['pxtornado']    == 'pxtornado',
                                                   'pxhail'       => $_GET['pxhail']       == 'pxhail',
                                                   'pxtstmwinds'  => $_GET['pxtstmwinds']  == 'pxtstmwinds',
                                                   'ptotsvrtstm'  => $_GET['ptotsvrtstm']  == 'ptotsvrtstm',
                                                   'pxtotsvrtstm' => $_GET['pxtotsvrtstm'] == 'pxtotsvrtstm',
                                                   'tmpabv14d'    => $_GET['tmpabv14d']    == 'tmpabv14d',
                                                   'tmpblw14d'    => $_GET['tmpblw14d']    == 'tmpblw14d',
                                                   'tmpabv30d'    => $_GET['tmpabv30d']    == 'tmpabv30d',
                                                   'tmpblw30d'    => $_GET['tmpblw30d']    == 'tmpblw30d',
                                                   'tmpabv90d'    => $_GET['tmpabv90d']    == 'tmpabv90d',
                                                   'tmpblw90d'    => $_GET['tmpblw90d']    == 'tmpblw90d',
                                                   'prcpabv14d'   => $_GET['prcpabv14d']   == 'prcpabv14d',
                                                   'prcpblw14d'   => $_GET['prcpblw14d']   == 'prcpblw14d',
                                                   'prcpabv30d'   => $_GET['prcpabv30d']   == 'prcpabv30d',
                                                   'prcpblw30d'   => $_GET['prcpblw30d']   == 'prcpblw30d',
                                                   'prcpabv90d'   => $_GET['prcpabv90d']   == 'prcpabv90d',
                                                   'prcpblw90d'   => $_GET['prcpblw90d']   == 'prcpblw90d',
                                                   'precipa_r'    => $_GET['precipa_r']    == 'precipa_r',
                                                   'sky_r'        => $_GET['sky_r']        == 'sky_r',
                                                   'td_r'         => $_GET['td_r']         == 'td_r',
                                                   'temp_r'       => $_GET['temp_r']       == 'temp_r',
                                                   'wdir_r'       => $_GET['wdir_r']       == 'wdir_r',
                                                   'wspd_r'       => $_GET['wspd_r']       == 'wspd_r',
                                                   'wwa'          => $_GET['wwa']          == 'wwa',
                          	                   'wgust'        => $_GET['wgust']        == 'wgust'));

//  This array is used by most functions to merge the location information with
//  the the other NDFDgen specific inputs
$array1 = array_merge($arrayNDFDgen,$arrayWeather);

// Define new object and specify location of wsdl file.
//$soapclient = new nusoap_client('http://' . $_SERVER['SERVER_NAME'] . '/~phershberg/2.0.40/SOAP_server/ndfdXMLserver.php?wsdl');
$soapclient = new nusoap_client('http://' . $_SERVER['SERVER_NAME'] . '/forecasts/xml/SOAP_server/ndfdXMLserver.php?wsdl');

// Output any error conditions from creating the client
$err = $soapclient->getError();
if ($err)
   exit("<error><h2>Constructor error</h2><pre>$err</pre></error>\n");

//  *****************************************************************************
//  Processing a SINGLE POINT call for an NDFDgen product (time-series or glance)
//  *****************************************************************************
if (array_key_exists('lat',$_GET) && ($_GET['lat'] != "")) 
{
   //  Initialize user supplied location input variables
   $array2 = array('latitude'  => $_GET['lat'],
                   'longitude' => $_GET['lon']);
   // Merge array1 and array2
   $parameters = array_merge($array2, $array1);

   // call the method and get the result.
   $result = $soapclient->call('NDFDgen',$parameters,
                               'uri:DWMLgen',
                               'uri:DWMLgen/NDFDgen');
}
//  *****************************************************************************
//  Processing a MULTI POINT call for an NDFDgen product (time-series or glance)
//  *****************************************************************************
elseif (array_key_exists('listLatLon',$_GET) && ($_GET['listLatLon'] != ""))
{
   //  Initialize user supplied location input variables
   $array2 = array('listLatLon' => $_GET['listLatLon']);
    
   // Merge array1 and array2
   $parameters = array_merge($array2, $array1);

   // call the method and get the result.
   $result = $soapclient->call('NDFDgenLatLonList',$parameters,
                               'uri:DWMLgen',
                               'uri:DWMLgen/NDFDgenLatLonList');
}
//  *****************************************************************************
//  Processing a SUBGRID call for an NDFDgen product (time-series or glance)
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

      //  Determine if the user's points are on any NDFD grids
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
                                   'uri:DWMLgen',
                                   'uri:DWMLgen/LatLonListSubgrid');

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
   $result = $soapclient->call('NDFDgenLatLonList',$parameters,
                               'uri:DWMLgen',
                               'uri:DWMLgen/NDFDgenLatLonList');
}
//  *****************************************************************************
//  Processing a request for a LIST LAT LON for NDFD points in a SUBGRID
//  *****************************************************************************
elseif (array_key_exists('listLat1',$_GET) && ($_GET['listLat1'] != ""))
{
   //  This routine determines the default resolution for a given sector
   require_once('../lib/conversion/getDefaultResolution.inc');

   //  Convert subgrid corners to component latitude and longitude values
   $listLat1 = $_GET['listLat1'];
   $listLon1 = $_GET['listLon1'];
   $listLat2 = $_GET['listLat2'];
   $listLon2 = $_GET['listLon2'];

   //  Some times the client will be called without a resolution so check for it
   if (array_key_exists('resolutionList',$_GET) && ($_GET['resolutionList'] != ""))
      $resolution = $_GET['resolutionList'];
   else
   {
      //  Get code to determine if we have a matching sector
      require_once('selectSector.php');

      //  Determine if the user's points are on any NDFD grids
      exec("/www/ndfd/public/bin/degrib_DP.cur -Sector -pnt $listLat1,$listLon1", $sector1, $returnValue);

      //  Accommodate RTMA conus 2.5km res.
      $numSectorsForPoint = count($sector1);
      for ($k = 0; $k < $numSectorsForPoint; $k++)
      {
         if (($sector1[$k] == "conus5") || ($sector1[$k] == "conus2_5"))
            $sector1[$k] = "conus";
      }

      //  Determine if the user's points are on any NDFD grids
      exec("/www/ndfd/public/bin/degrib_DP.cur -Sector -pnt $listLat2,$listLon2", $sector2, $returnValue);

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
         exit("<error><h2>ERROR</h2><pre>Subgrid corners must be in same sector.  Point \"$listLat1,$listLon1\" in \"$sector1List\" and point \"$listLat2,$listLon2\" in \"$sector2List\"</pre></error>\n");

      $resolution = getDefaultResolution($sector);

      if ("$resolution" == "Bad Sector")
         exit("<error><h2>ERROR</h2><pre>Bad Sector \"$sector\"</pre></error>\n");
      else
         $resolution = $resolution / 1000.0;

      $_GET['resolutionList'] = $resolution;
   }

   $parameters = array('lowerLeftLatitude'   => $listLat1,
                       'lowerLeftLongitude'  => $listLon1,
                       'upperRightLatitude'  => $listLat2,
                       'upperRightLongitude' => $listLon2,
                       'resolution'          => $_GET['resolutionList']);

   // call the method and get the result.
   $result = $soapclient->call('LatLonListSubgrid',$parameters,
                               'uri:DWMLgen',
                               'uri:DWMLgen/LatLonListSubgrid');
}
//  *****************************************************************************
//  Processing a LINE OF POINTS call for an NDFDgen product (time-series or glance)
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

   // call the method and get the result.
   $LatLonList = $soapclient->call('LatLonListLine',$parameters,
                                   'uri:DWMLgen',
                                   'uri:DWMLgen/LatLonListLine');

   //  Processes any SOAP fault information we get back from the server
   if ($soapclient->fault)
   {
      echo "<error><h2>SOAP ERROR</h2><pre>";
      print_r($LatLonList);
      echo "</pre></error>\n";
      exit;
   }
   else
   {
      //  Capture any client errors
      $err = $soapclient->getError();

      if ($err)
         exit("<error><h2>CLIENT ERROR</h2><pre>$err</pre></error>\n");
   }

   //  Extract the latitude and longitude list
   $LatLonList = parseDWMLelement($LatLonList,"<latLonList>","</latLonList>");

   //  Initialize user supplied location input variables
   $array2 = array('listLatLon' => $LatLonList);
    
   // Merge array1 and array2
   $parameters = array_merge($array2, $array1);

   // call the method and get the result.
   $result = $soapclient->call('NDFDgenLatLonList',$parameters,
                               'uri:DWMLgen',
                               'uri:DWMLgen/NDFDgenLatLonList');
}
//  *****************************************************************************
//  Processing a LIST LAT LON call for LINE OF POINTS
//  *****************************************************************************
elseif (array_key_exists('listEndPoint1Lat',$_GET) && ($_GET['listEndPoint1Lat'] != ""))
{
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
   $parameters = array('endPoint1Lat' => $_GET['listEndPoint1Lat'],
                       'endPoint1Lon' => $_GET['listEndPoint1Lon'],
                       'endPoint2Lat' => $_GET['listEndPoint2Lat'],
                       'endPoint2Lon' => $_GET['listEndPoint2Lon']);

   // call the method and get the result.
   $result = $soapclient->call('LatLonListLine',$parameters,
                               'uri:DWMLgen',
                               'uri:DWMLgen/LatLonListLine');
}
//  *****************************************************************************
//  Processing a ZIP CODE call for an NDFDgen product (time-series or glance)
//  *****************************************************************************
elseif (array_key_exists('zipCodeList',$_GET) && ($_GET['zipCodeList'] != ""))
{
   //  This routine to extract the contents of the <latLonList> element
   require_once('../lib/conversion/parseDWMLelement.inc');

   // Define new object and specify location of wsdl file.
   //$soapclient = new nusoap_client('http://' . $_SERVER['SERVER_NAME'] . '/~phershberg/2.0.40/SOAP_server/ndfdXMLserver.php?wsdl');
   $soapclient = new nusoap_client('http://' . $_SERVER['SERVER_NAME'] . '/forecasts/xml/SOAP_server/ndfdXMLserver.php?wsdl');
   //  Initialize user supplied location input variables
   $parameters = array('zipCodeList' => $_GET['zipCodeList']);

   // call the method and get the result.
   $LatLonList = $soapclient->call('LatLonListZipCode',$parameters,
                                   'uri:DWMLgen',
                                   'uri:DWMLgen/LatLonListZipCode');
	
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
      $result = $soapclient->call('NDFDgenLatLonList',$parameters,
                                  'uri:DWMLgen',
                                  'uri:DWMLgen/NDFDgenLatLonList');
   }
}
//  *****************************************************************************
//  Processing a LIST LAT LON for ZIP CODES call
//  *****************************************************************************
elseif (array_key_exists('listZipCodeList',$_GET) && ($_GET['listZipCodeList'] != ""))
{
	//echo $_GET['listZipCodeList']; exit;
   //  Initialize user supplied location input variables
   $parameters = array('listZipCodeList' => $_GET['listZipCodeList']);
   // call the method and get the result.
   $result = $soapclient->call('LatLonListZipCode',$parameters,
                               'uri:DWMLgen',
                               'uri:DWMLgen/LatLonListZipCode');
}


//  *****************************************************************************
//  Processing a CITIES call for an NDFDgen product (time-series or glance)
//  *****************************************************************************
elseif (array_key_exists('citiesLevel',$_GET) && ($_GET['citiesLevel'] != ""))
{
   //  This routine to extract the contents of the <latLonList> element
   require_once('../lib/conversion/parseDWMLelement.inc');

   //  This routine inserts a <city> element in place of a <point> element
   require_once('../lib/conversion/insertCityNames.inc');

   // Define new object and specify location of wsdl file.
   //$soapclient = new nusoap_client('http://' . $_SERVER['SERVER_NAME'] . '/~phershberg/2.0.40/SOAP_server/ndfdXMLserver.php?wsdl');
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
   $result = $soapclient->call('NDFDgenLatLonList',$parameters,
                               'uri:DWMLgen',
                               'uri:DWMLgen/NDFDgenLatLonList');

   $result = insertCityNames($result,$citiesList);
}
//  *****************************************************************************
//  Processing a LIST LAT LON for CITIES call
//  *****************************************************************************
elseif (array_key_exists('listCitiesLevel',$_GET) && ($_GET['listCitiesLevel'] != ""))
{
   //  Initialize user supplied display level input variables
   //  1 = main cities 
   //  2 = Cities to fill in some of the empty geography
   //  3 = Cities for greater area coverage
   $parameters = array('displayLevel' => $_GET['listCitiesLevel']);

   // call the method and get the result.
   $result = $soapclient->call('LatLonListCityNames',$parameters,
                               'uri:DWMLgen',
                               'uri:DWMLgen/LatLonListCityNames');
}


//  *****************************************************************************
//  Processing a SQUARE (central point and direction) call for an NDFDgen product (time-series or glance)
//  *****************************************************************************
elseif (array_key_exists('centerPointLat',$_GET) && ($_GET['centerPointLat'] != ""))
{                       
   //  This routine determines the default resolution for a given sector
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
   //$soapclient = new nusoap_client('http://' . $_SERVER['SERVER_NAME'] . '/~phershberg/2.0.40/SOAP_server/ndfdXMLserver.php?wsdl');
   $soapclient = new nusoap_client('http://' . $_SERVER['SERVER_NAME'] . '/forecasts/xml/SOAP_server/ndfdXMLserver.php?wsdl');

   $parameters = array('centerPointLat' => $centerPointLat,
                       'centerPointLon' => $centerPointLon,
                       'distanceLat' => $distanceLat,
                       'distanceLon' => $distanceLon,
                       'resolution'  => $_GET['resolutionSquare']);

   // call the method and get the result.
   $LatLonList = $soapclient->call('LatLonListSquare',$parameters,
                                    'uri:DWMLgen',
                                    'uri:DWMLgen/LatLonListSquare');

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
   $result = $soapclient->call('NDFDgenLatLonList',$parameters,
                               'uri:DWMLgen',
                               'uri:DWMLgen/NDFDgenLatLonList');
}
//  *****************************************************************************
//  Processing a LIST LAT LON for SQUARE (central point and direction) call
//  *****************************************************************************
elseif (array_key_exists('listCenterPointLat',$_GET) && ($_GET['listCenterPointLat'] != ""))
{
   //  This routine determines the degrib -XMLFormatOnly command line input
   require_once('../lib/conversion/getDefaultResolution.inc');

   //  Convert subgrid corners to component latitude and longitude values
   $listCenterPointLat  = $_GET['listCenterPointLat'];
   $listCenterPointLon  = $_GET['listCenterPointLon'];
   $listDistanceLat     = $_GET['listDistanceLat'];
   $listDistanceLon     = $_GET['listDistanceLon'];

   //  Some times the client will be called without a resolution so check for it
   if (array_key_exists('listResolutionSquare',$_GET) && ($_GET['listResolutionSquare'] != ""))
      $resolution = $_GET['listResolutionSquare'];
   else
   {

      //  Determine if the user's points are on any NDFD grids
      exec("/www/ndfd/public/bin/degrib_DP.cur -Sector -pnt $listCenterPointLat,$listCenterPointLon", $sector1, $returnValue);

      //  Accommodate RTMA conus 2.5km res.
      $numSectorsForPoint = count($sector1);
      for ($k = 0; $k < $numSectorsForPoint; $k++)
      {
         if (($sector1[$k] == "conus5") || ($sector1[$k] == "conus2_5"))
            $sector1[$k] = "conus";
      }

      // check to ensure that both points are on the same NDFD sector
      if ($sector1[0] == "")
         exit("<error><h2>ERROR</h2><pre>Center point must be on NDFD sector \"$listCenterPointLat,$listCenterPointLon\" in \"no NDFD sector\"</pre></error>\n");

      $resolution = getDefaultResolution($sector1[0]);

      if ("$resolution" == "Bad Sector")
         exit("<error><h2>ERROR</h2><pre>Bad Sector \"{$sector1[0]}\"</pre></error>\n");
      else
         $resolution = $resolution / 1000.0;

      $_GET['listResolutionSquare'] = $resolution;
   }

   $parameters = array('listCenterPointLat' => $listCenterPointLat,
                       'listCenterPointLon' => $listCenterPointLon,
                       'listDistanceLat' => $listDistanceLat,
                       'listDistanceLon' => $listDistanceLon,
                       'resolution'      => $_GET['listResolutionSquare']);

   // call the method and get the result.
   $result = $soapclient->call('LatLonListSquare',$parameters,
                               'uri:DWMLgen',
                               'uri:DWMLgen/LatLonListSquare');
}
//  *****************************************************************************
//  Processing a request for the corner points of an NDFD grid
//  *****************************************************************************
elseif (array_key_exists('sector',$_GET) && ($_GET['sector'] != ""))
{
   //  Create service input using user provide sector
   $parameters = array('sector' => $_GET['sector']);

   // call the method and get the result.
   $result = $soapclient->call('CornerPoints',$parameters,
                               'uri:DWMLgen',
                               'uri:DWMLgen/CornerPoints');
}
//  *****************************************************************************
//  Processing a call for GML encoded data
//  *****************************************************************************
elseif (array_key_exists('gmlListLatLon',$_GET) && ($_GET['gmlListLatLon'] != ""))
{
   if (array_key_exists('startTime',$_GET) && ($_GET['startTime'] != "") ||
       array_key_exists('endTime',$_GET)   && ($_GET['endTime']   != ""))
   {
      //  Initialize user supplied location input variables
      $parameters = array('listLatLon'   => $_GET['gmlListLatLon'],
                          'startTime'    => $_GET['startTime'],
                          'endTime'      => $_GET['endTime'],
                          'compType'     => $_GET['compType'],
                          'featureType'  => $_GET['featureType'],
                          'propertyName' => $_GET['propertyName']);

      // call the method and get the result.
      $result = $soapclient->call('GmlTimeSeries',$parameters,
                                  'uri:DWMLgen',
                                  'uri:DWMLgen/GmlTimeSeries');
   }
   else
   {
      //  Initialize user supplied location input variables
      $array2 = array('listLatLon'    => $_GET['gmlListLatLon'],
                      'requestedTime' => $_GET['requestedTime'],
                      'featureType'   => $_GET['featureType']);
    
      // Merge array1 and array2
      $parameters = array_merge($array2, $arrayWeather);

      // call the method and get the result.
      $result = $soapclient->call('GmlLatLonList',$parameters,
                                  'uri:DWMLgen',
                                  'uri:DWMLgen/GmlLatLonList');
   }
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
   echo "<error><h2>SOAP ERROR</h2><pre>";
   print_r($result);
   echo "</pre></error>\n";
   exit;
}
else
{
     //  Capture any client errors
     $err = $soapclient->getError();
     if ($err)
        exit("<error><h2>CLIENT ERROR</h2><pre>$err</pre></error>\n");
     else  // we successfully created the DWML document
        echo $result;
        
}

?>
