
package https.graphical_weather_gov.xml.dwmlgen.schema.dwml;

import javax.xml.bind.annotation.XmlEnum;
import javax.xml.bind.annotation.XmlEnumValue;
import javax.xml.bind.annotation.XmlType;


/**
 * <p>Java class for featureTypeType.
 * 
 * <p>The following schema fragment specifies the expected content contained within this class.
 * <p>
 * <pre>
 * &lt;simpleType name="featureTypeType">
 *   &lt;restriction base="{http://www.w3.org/2001/XMLSchema}string">
 *     &lt;enumeration value="Forecast_Gml2Point"/>
 *     &lt;enumeration value="Forecast_Gml2AllWx"/>
 *     &lt;enumeration value="Forecast_GmlsfPoint"/>
 *     &lt;enumeration value="Forecast_GmlObs"/>
 *     &lt;enumeration value="NdfdMultiPointCoverage"/>
 *     &lt;enumeration value="Ndfd_KmlPoint"/>
 *   &lt;/restriction>
 * &lt;/simpleType>
 * </pre>
 * 
 */
@XmlType(name = "featureTypeType")
@XmlEnum
public enum FeatureTypeType {

    @XmlEnumValue("Forecast_Gml2Point")
    FORECAST_GML_2_POINT("Forecast_Gml2Point"),
    @XmlEnumValue("Forecast_Gml2AllWx")
    FORECAST_GML_2_ALL_WX("Forecast_Gml2AllWx"),
    @XmlEnumValue("Forecast_GmlsfPoint")
    FORECAST_GMLSF_POINT("Forecast_GmlsfPoint"),
    @XmlEnumValue("Forecast_GmlObs")
    FORECAST_GML_OBS("Forecast_GmlObs"),
    @XmlEnumValue("NdfdMultiPointCoverage")
    NDFD_MULTI_POINT_COVERAGE("NdfdMultiPointCoverage"),
    @XmlEnumValue("Ndfd_KmlPoint")
    NDFD_KML_POINT("Ndfd_KmlPoint");
    private final String value;

    FeatureTypeType(String v) {
        value = v;
    }

    public String value() {
        return value;
    }

    public static FeatureTypeType fromValue(String v) {
        for (FeatureTypeType c: FeatureTypeType.values()) {
            if (c.value.equals(v)) {
                return c;
            }
        }
        throw new IllegalArgumentException(v);
    }

}
