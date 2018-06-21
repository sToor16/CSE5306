#!/usr/bin/perl -w
#
#  ***************************************************************************
#
#  xmlReader.pl - A script to process National Weather Service forecast 
#                 high temperatures 
#
#  John L. Schattel                    MDL                       23 July 2004
#  Red Hat Linux                                                 Apache Server
#
#  PURPOSE:  The routine inputs National Weather Service National Digital 
#            forecast data and summarized the high temperatures.  The output
#            provides the average high expected through the forecast period
#            as well as the highest and lowest high temperatures.
#
#  VARIABLES:
#
#     holdTemps = An array of hold the National Digital Forecast Database 
#                 high temperatures.
#     processingTempData = A flag to indicate that we are processing the
#                          high temperature XML element.
#     tempCounter = Counter used to index into the array processingTempData.
#     counter = A counter used index through the array of high temperatures
#     numTemps = The number of high temperatures.
#     sum = The sum of all the high temperatures.
#     maxTemp = The highest high temperature.
#     minTemp = The lowest high temperature.
#
#  EXTERNALLY CALLED ROUTINES:
#
#     None.
#     
#  SOURCE CODE CONTROL INFORMATION
#
#      Name:
#         %PM%
#         %PID%
#  
#      Status:
#         %PS%
#  
#      History:
#         %PL%
#  
#      Change Document History:
#         %PIRC%
#
#  ***************************************************************************
#
#   create array to hold the high temperature data
#
my @holdTemps = ();

#
#  Setup SAX
#
package MyContentHandler;
use base qw(XML::SAX::Base);

#
#  Initialize the temperature flag to false and the counter to 0
#
my $processingTempData = 0;
my $tempCounter = 0;

#
#  This function is called when SAX detects the start of the document
#
sub start_document {
   my $self = shift;
   $self->{text} = '';
}

#
#  This function is called when SAX detects the start of an XML element
#
sub start_element {

   my $self = shift;
   my $el = shift;

   #  
   #  Look for the temperature element
   #
   if ( $el->{LocalName} eq "temperature" )
   {

      $self->{text} = '';

      #
      #  We need to make sure this is a high temperature element.
      #  So loop over all the temperature element attributes and look 
      #  for the "type" attribute with a value of "maximum"
      #
      foreach my $attributeKeys ( keys %{ $el->{Attributes} } )
      {

         my $attribute = $el->{Attributes}->{$attributeKeys};
         
         #
         #  Check for the "type" attribute with whose value is "maximum"
         #
         if ( $attribute->{Name} eq "type" && $attribute->{Value} eq "maximum" )
         {
            $processingTempData = 1;  # set flag so we get the data value
         }

      }

   }

   #
   #  To get the high temperature data, we need to access the contents
   #  of the value element when we have found the high temperature element
   #
   if ( $el->{LocalName} eq "value" && $processingTempData)
   {
      $holdTemps[$tempCounter] = $self->get_text();
   }

}

#
#  This function is called when SAX detects the end of an XML element
#
sub end_element {

   my $self = shift;
   my $el = shift;

   #
   #  We have finished with a temperature element so we need to signal
   #  that we are no longer processing them
   #
   if ( $el->{LocalName} eq "temperature" )
   {

      $processingTempData = 0;

   }

   #
   #  As we process each temperature value count how many we get
   #
   if ( $el->{LocalName} eq "value" && $processingTempData)
   {

      $tempCounter++;

   }

}

#
#  This function is used to retrieve the contents of an XML element
#
sub get_text {

   my $self = shift;

   if ( defined( $self->{text} ) && $self->{text} ne "" )
   {
      $theText = $self->{text};
      $self->{text} = '';
      return $theText;
   }

}

#
#  This function is called when SAX detects the content of an XML element
#
sub characters {

   my $self = shift;
   my $text = shift;

   $self->{text} .= $text->{Data};

}

#
#  This function is called when SAX detects the end of an XML docuemnt
#
sub end_document {
   my $self = shift;
}

package main;

#
#  Pull in SAX and SOAP functionality
#
use XML::SAX;
use SOAP::Lite;
#use SOAP::Lite + trace => 'debug';

$XML::SAX::ParserPackage = 'XML::SAX::Expat';

#
#  Create a SAX parser
#
my $factory = XML::SAX::ParserFactory->new();
my $parser = $factory->parser( Handler => MyContentHandler->new() );

#
#  Set up the input required by the NDFD web service
# 
$latitude = 38.99;
$longitude = -77.99;
$product = "time-series";
$startTime = "2004-01-01T00:00:00";
$endTime = "2009-12-25T00:00:00";

#
#  Use SOAP::Lite to retrieve the NDFD XML data
#     We use the web service's WSDL as input into creating the SOAP message
#     We call the exposed function NDFDgen using SOAP::Data to ensure SOAP::Lite 
#     gets the types correct
#  The XML returned by the web service is saved as a string in $NDFD_XML for later
#     parsing
#
$NDFD_XML =  SOAP::Lite
                 ->service('http://www.weather.gov/forecasts/xml/DWMLgen/wsdl/ndfdXML.wsdl')
                 ->NDFDgen(SOAP::Data->name("latitude" => $latitude), 
                           SOAP::Data->name("longitude" => $longitude),
                           SOAP::Data->name("product" => $product),
                           SOAP::Data->name("startTime" => $startTime),
                           SOAP::Data->name("endTime" => $endTime),
                           SOAP::Data->name("weatherParameters" => 
                               \SOAP::Data->value(SOAP::Data->type('boolean')->name("maxt" => 1),
                                                  SOAP::Data->type('boolean')->name("mint" => 0),
                                                  SOAP::Data->type('boolean')->name("temp" => 0),
                                                  SOAP::Data->type('boolean')->name("dew" => 0),
                                                  SOAP::Data->type('boolean')->name("pop12" => 0),
                                                  SOAP::Data->type('boolean')->name("qpf" => 0),
                                                  SOAP::Data->type('boolean')->name("sky" => 0),
                                                  SOAP::Data->type('boolean')->name("snow" => 0),
                                                  SOAP::Data->type('boolean')->name("wspd" => 0),
                                                  SOAP::Data->type('boolean')->name("wdir" => 0),
                                                  SOAP::Data->type('boolean')->name("ws" => 0),
                                                  SOAP::Data->type('boolean')->name("waveh" => 0),
                                                  SOAP::Data->type('boolean')->name("icons" => 0),
                                                  SOAP::Data->type('boolean')->name("rh" => 0),
                                                  SOAP::Data->type('boolean')->name("appt" => 0),
                                                  SOAP::Data->type('boolean')->name("incw34" => 0),
                                                  SOAP::Data->type('boolean')->name("incw50" => 0),
                                                  SOAP::Data->type('boolean')->name("incw64" => 0),
                                                  SOAP::Data->type('boolean')->name("cumw34" => 0),
                                                  SOAP::Data->type('boolean')->name("cumw50" => 0),
                                                  SOAP::Data->type('boolean')->name("cumw64" => 0))));

#
#  We parse the string returned from the NDFD webservice.  However,
#  you can also use $parser->parse_uri('latest.xml'); to parse a uri or
#  $p->parse_file($fh); to parse a file $p->parse_string("<foo/>") 
#  example:  eval { $parser->parse_uri('latest.xml'); };
#
$parser->parse_string("$NDFD_XML");


#
#  After the parser is finished and our functions have parsed the XML elements of interested 
#  in, we have the data in the high temperature array.  So, lets process the temperatures.
#
$counter = 0;
$numTemps = 0;
$sum = 0;
$maxTemp = 0;
$minTemp = 10000;

#
#  Calcuate the sum of all high temperature data plus get the highest
#  and lowest high temperature
# 
foreach $temp (@holdTemps) 
{
   if ($counter gt 0)
   {
      $sum = $sum + $temp;
      if ($maxTemp < $temp )
      {
         $maxTemp = $temp;
      }

      if ($minTemp > $temp )
      {
         $minTemp = $temp;
      }

      $numTemps++;
   }
   $counter++;
}


$average = $sum/$numTemps;  #  calcuate the average high temperature
$maxTemp =~ s/^\s+|\s+$//g;  # strip off spaces before and after the data
$minTemp =~ s/^\s+|\s+$//g;  # strip off spaces before and after the data

#
#   Output the high temperature information
#
print "************************************************************************************\n";
print "* National Weather Service Forecast for the next $numTemps days: \n";
print "* Average high temperature = $average \n";
print "* Hottest high temperature = $maxTemp \n";
print "* Coldest high temperature = $minTemp \n";
print "************************************************************************************\n";







