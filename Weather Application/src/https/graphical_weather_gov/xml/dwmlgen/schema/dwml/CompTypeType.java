
package https.graphical_weather_gov.xml.dwmlgen.schema.dwml;

import javax.xml.bind.annotation.XmlEnum;
import javax.xml.bind.annotation.XmlEnumValue;
import javax.xml.bind.annotation.XmlType;


/**
 * <p>Java class for compTypeType.
 * 
 * <p>The following schema fragment specifies the expected content contained within this class.
 * <p>
 * <pre>
 * &lt;simpleType name="compTypeType">
 *   &lt;restriction base="{http://www.w3.org/2001/XMLSchema}string">
 *     &lt;enumeration value="IsEqual"/>
 *     &lt;enumeration value="Between"/>
 *     &lt;enumeration value="GreaterThan"/>
 *     &lt;enumeration value="GreaterThanEqualTo"/>
 *     &lt;enumeration value="LessThan"/>
 *     &lt;enumeration value="LessThanEqualTo"/>
 *   &lt;/restriction>
 * &lt;/simpleType>
 * </pre>
 * 
 */
@XmlType(name = "compTypeType")
@XmlEnum
public enum CompTypeType {

    @XmlEnumValue("IsEqual")
    IS_EQUAL("IsEqual"),
    @XmlEnumValue("Between")
    BETWEEN("Between"),
    @XmlEnumValue("GreaterThan")
    GREATER_THAN("GreaterThan"),
    @XmlEnumValue("GreaterThanEqualTo")
    GREATER_THAN_EQUAL_TO("GreaterThanEqualTo"),
    @XmlEnumValue("LessThan")
    LESS_THAN("LessThan"),
    @XmlEnumValue("LessThanEqualTo")
    LESS_THAN_EQUAL_TO("LessThanEqualTo");
    private final String value;

    CompTypeType(String v) {
        value = v;
    }

    public String value() {
        return value;
    }

    public static CompTypeType fromValue(String v) {
        for (CompTypeType c: CompTypeType.values()) {
            if (c.value.equals(v)) {
                return c;
            }
        }
        throw new IllegalArgumentException(v);
    }

}
