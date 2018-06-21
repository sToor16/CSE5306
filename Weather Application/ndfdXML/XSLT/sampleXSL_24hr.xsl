<?xml version="1.0" encoding="UTF-8" ?>

<!-- Originally written by Greg Reddick. http://www.xoc.net -->
<!-- Modified by John Schattel. -->

<xsl:stylesheet version="1.0" xmlns="http://www.w3.org/1999/xhtml"
                              xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

   <!--  Match the root element -->
   <xsl:template match="/dwml">

      <html>
         <head>
            <title>NOAAs NWS NDFD XML Data</title>
         </head>
         <body style="background-color:#FFF8DC;">

            <xsl:apply-templates />

          </body>
       </html> 
             
   </xsl:template>

   <!--  Match the data element  -->
   <xsl:template match="data">

      <!--  This is the page title  -->
      <div style="color:blue; text-align:center">
         <h1>National Weather Service<br />Digital Daily Forecast</h1>
      </div>

      <!--  Now we set up the table to hold the forecast data  -->
      <table border="1" cellpadding="5" cellspacing="5" align="center">

         <xsl:apply-templates />

      </table>

   </xsl:template>

   <!--  Get the times that the data is valid at  -->
   <xsl:template match="time-layout">

        <!--  Here we are finding the times by using the time information for maximum temperature  -->
        <xsl:if test="/dwml/data/parameters/*[@time-layout=current()/layout-key]/@type = 'maximum' ">

           <tr>

              <!--  We really only have enough data for a 6 day forecast so we only get 6 days of time information  -->
              <xsl:for-each select="/dwml/data/time-layout[position()=1]/start-valid-time[position()]">

                 <td align="center" colspan="2"><xsl:value-of select="concat(substring(.,6,2), '/', substring(.,9,2))" /></td>

              </xsl:for-each>

            </tr>
     
         </xsl:if>

         <tr>
            <xsl:apply-templates />
         </tr>
   </xsl:template>

   <!--  This is where we select the data for the current time information  -->
   <xsl:template match="start-valid-time">

      <xsl:apply-templates select="/dwml/data/parameters/conditions-icon[@time-layout=current()/parent::time-layout/layout-key]">
         <xsl:with-param name="i">
            <xsl:number />
         </xsl:with-param>

      </xsl:apply-templates>

   </xsl:template>

   <!--  Process weather icons  -->
   <xsl:template match="conditions-icon">

      <xsl:param name="i" />

      <td align="center"><img src="{icon-link[position()=$i]}" /></td>
      <td align="center"><xsl:value-of select="../weather/weather-conditions[position()=$i]/@weather-summary" /></td>

   </xsl:template>

   <xsl:template match="*"></xsl:template>

</xsl:stylesheet>