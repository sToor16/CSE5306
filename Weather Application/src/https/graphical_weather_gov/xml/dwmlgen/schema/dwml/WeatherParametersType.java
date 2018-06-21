
package https.graphical_weather_gov.xml.dwmlgen.schema.dwml;

import javax.xml.bind.annotation.XmlAccessType;
import javax.xml.bind.annotation.XmlAccessorType;
import javax.xml.bind.annotation.XmlElement;
import javax.xml.bind.annotation.XmlType;


/**
 * <p>Java class for weatherParametersType complex type.
 * 
 * <p>The following schema fragment specifies the expected content contained within this class.
 * 
 * <pre>
 * &lt;complexType name="weatherParametersType">
 *   &lt;complexContent>
 *     &lt;restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       &lt;all>
 *         &lt;element name="maxt" type="{http://www.w3.org/2001/XMLSchema}boolean"/>
 *         &lt;element name="mint" type="{http://www.w3.org/2001/XMLSchema}boolean"/>
 *         &lt;element name="temp" type="{http://www.w3.org/2001/XMLSchema}boolean"/>
 *         &lt;element name="dew" type="{http://www.w3.org/2001/XMLSchema}boolean"/>
 *         &lt;element name="pop12" type="{http://www.w3.org/2001/XMLSchema}boolean"/>
 *         &lt;element name="qpf" type="{http://www.w3.org/2001/XMLSchema}boolean"/>
 *         &lt;element name="sky" type="{http://www.w3.org/2001/XMLSchema}boolean"/>
 *         &lt;element name="snow" type="{http://www.w3.org/2001/XMLSchema}boolean"/>
 *         &lt;element name="wspd" type="{http://www.w3.org/2001/XMLSchema}boolean"/>
 *         &lt;element name="wdir" type="{http://www.w3.org/2001/XMLSchema}boolean"/>
 *         &lt;element name="wx" type="{http://www.w3.org/2001/XMLSchema}boolean"/>
 *         &lt;element name="waveh" type="{http://www.w3.org/2001/XMLSchema}boolean"/>
 *         &lt;element name="icons" type="{http://www.w3.org/2001/XMLSchema}boolean"/>
 *         &lt;element name="rh" type="{http://www.w3.org/2001/XMLSchema}boolean"/>
 *         &lt;element name="appt" type="{http://www.w3.org/2001/XMLSchema}boolean"/>
 *         &lt;element name="incw34" type="{http://www.w3.org/2001/XMLSchema}boolean"/>
 *         &lt;element name="incw50" type="{http://www.w3.org/2001/XMLSchema}boolean"/>
 *         &lt;element name="incw64" type="{http://www.w3.org/2001/XMLSchema}boolean"/>
 *         &lt;element name="cumw34" type="{http://www.w3.org/2001/XMLSchema}boolean"/>
 *         &lt;element name="cumw50" type="{http://www.w3.org/2001/XMLSchema}boolean"/>
 *         &lt;element name="cumw64" type="{http://www.w3.org/2001/XMLSchema}boolean"/>
 *         &lt;element name="critfireo" type="{http://www.w3.org/2001/XMLSchema}boolean"/>
 *         &lt;element name="dryfireo" type="{http://www.w3.org/2001/XMLSchema}boolean"/>
 *         &lt;element name="conhazo" type="{http://www.w3.org/2001/XMLSchema}boolean"/>
 *         &lt;element name="ptornado" type="{http://www.w3.org/2001/XMLSchema}boolean"/>
 *         &lt;element name="phail" type="{http://www.w3.org/2001/XMLSchema}boolean"/>
 *         &lt;element name="ptstmwinds" type="{http://www.w3.org/2001/XMLSchema}boolean"/>
 *         &lt;element name="pxtornado" type="{http://www.w3.org/2001/XMLSchema}boolean"/>
 *         &lt;element name="pxhail" type="{http://www.w3.org/2001/XMLSchema}boolean"/>
 *         &lt;element name="pxtstmwinds" type="{http://www.w3.org/2001/XMLSchema}boolean"/>
 *         &lt;element name="ptotsvrtstm" type="{http://www.w3.org/2001/XMLSchema}boolean"/>
 *         &lt;element name="pxtotsvrtstm" type="{http://www.w3.org/2001/XMLSchema}boolean"/>
 *         &lt;element name="tmpabv14d" type="{http://www.w3.org/2001/XMLSchema}boolean"/>
 *         &lt;element name="tmpblw14d" type="{http://www.w3.org/2001/XMLSchema}boolean"/>
 *         &lt;element name="tmpabv30d" type="{http://www.w3.org/2001/XMLSchema}boolean"/>
 *         &lt;element name="tmpblw30d" type="{http://www.w3.org/2001/XMLSchema}boolean"/>
 *         &lt;element name="tmpabv90d" type="{http://www.w3.org/2001/XMLSchema}boolean"/>
 *         &lt;element name="tmpblw90d" type="{http://www.w3.org/2001/XMLSchema}boolean"/>
 *         &lt;element name="prcpabv14d" type="{http://www.w3.org/2001/XMLSchema}boolean"/>
 *         &lt;element name="prcpblw14d" type="{http://www.w3.org/2001/XMLSchema}boolean"/>
 *         &lt;element name="prcpabv30d" type="{http://www.w3.org/2001/XMLSchema}boolean"/>
 *         &lt;element name="prcpblw30d" type="{http://www.w3.org/2001/XMLSchema}boolean"/>
 *         &lt;element name="prcpabv90d" type="{http://www.w3.org/2001/XMLSchema}boolean"/>
 *         &lt;element name="prcpblw90d" type="{http://www.w3.org/2001/XMLSchema}boolean"/>
 *         &lt;element name="precipa_r" type="{http://www.w3.org/2001/XMLSchema}boolean"/>
 *         &lt;element name="sky_r" type="{http://www.w3.org/2001/XMLSchema}boolean"/>
 *         &lt;element name="td_r" type="{http://www.w3.org/2001/XMLSchema}boolean"/>
 *         &lt;element name="temp_r" type="{http://www.w3.org/2001/XMLSchema}boolean"/>
 *         &lt;element name="wdir_r" type="{http://www.w3.org/2001/XMLSchema}boolean"/>
 *         &lt;element name="wspd_r" type="{http://www.w3.org/2001/XMLSchema}boolean"/>
 *         &lt;element name="wwa" type="{http://www.w3.org/2001/XMLSchema}boolean"/>
 *         &lt;element name="tstmprb" type="{http://www.w3.org/2001/XMLSchema}boolean"/>
 *         &lt;element name="tstmcat" type="{http://www.w3.org/2001/XMLSchema}boolean"/>
 *         &lt;element name="wgust" type="{http://www.w3.org/2001/XMLSchema}boolean"/>
 *         &lt;element name="iceaccum" type="{http://www.w3.org/2001/XMLSchema}boolean"/>
 *         &lt;element name="maxrh" type="{http://www.w3.org/2001/XMLSchema}boolean"/>
 *         &lt;element name="minrh" type="{http://www.w3.org/2001/XMLSchema}boolean"/>
 *       &lt;/all>
 *     &lt;/restriction>
 *   &lt;/complexContent>
 * &lt;/complexType>
 * </pre>
 * 
 * 
 */
@XmlAccessorType(XmlAccessType.FIELD)
@XmlType(name = "weatherParametersType", propOrder = {

})
public class WeatherParametersType {

    protected boolean maxt;
    protected boolean mint;
    protected boolean temp;
    protected boolean dew;
    protected boolean pop12;
    protected boolean qpf;
    protected boolean sky;
    protected boolean snow;
    protected boolean wspd;
    protected boolean wdir;
    protected boolean wx;
    protected boolean waveh;
    protected boolean icons;
    protected boolean rh;
    protected boolean appt;
    protected boolean incw34;
    protected boolean incw50;
    protected boolean incw64;
    protected boolean cumw34;
    protected boolean cumw50;
    protected boolean cumw64;
    protected boolean critfireo;
    protected boolean dryfireo;
    protected boolean conhazo;
    protected boolean ptornado;
    protected boolean phail;
    protected boolean ptstmwinds;
    protected boolean pxtornado;
    protected boolean pxhail;
    protected boolean pxtstmwinds;
    protected boolean ptotsvrtstm;
    protected boolean pxtotsvrtstm;
    @XmlElement(name = "tmpabv14d")
    protected boolean tmpabv14D;
    @XmlElement(name = "tmpblw14d")
    protected boolean tmpblw14D;
    @XmlElement(name = "tmpabv30d")
    protected boolean tmpabv30D;
    @XmlElement(name = "tmpblw30d")
    protected boolean tmpblw30D;
    @XmlElement(name = "tmpabv90d")
    protected boolean tmpabv90D;
    @XmlElement(name = "tmpblw90d")
    protected boolean tmpblw90D;
    @XmlElement(name = "prcpabv14d")
    protected boolean prcpabv14D;
    @XmlElement(name = "prcpblw14d")
    protected boolean prcpblw14D;
    @XmlElement(name = "prcpabv30d")
    protected boolean prcpabv30D;
    @XmlElement(name = "prcpblw30d")
    protected boolean prcpblw30D;
    @XmlElement(name = "prcpabv90d")
    protected boolean prcpabv90D;
    @XmlElement(name = "prcpblw90d")
    protected boolean prcpblw90D;
    @XmlElement(name = "precipa_r")
    protected boolean precipaR;
    @XmlElement(name = "sky_r")
    protected boolean skyR;
    @XmlElement(name = "td_r")
    protected boolean tdR;
    @XmlElement(name = "temp_r")
    protected boolean tempR;
    @XmlElement(name = "wdir_r")
    protected boolean wdirR;
    @XmlElement(name = "wspd_r")
    protected boolean wspdR;
    protected boolean wwa;
    protected boolean tstmprb;
    protected boolean tstmcat;
    protected boolean wgust;
    protected boolean iceaccum;
    protected boolean maxrh;
    protected boolean minrh;

    /**
     * Gets the value of the maxt property.
     * 
     */
    public boolean isMaxt() {
        return maxt;
    }

    /**
     * Sets the value of the maxt property.
     * 
     */
    public void setMaxt(boolean value) {
        this.maxt = value;
    }

    /**
     * Gets the value of the mint property.
     * 
     */
    public boolean isMint() {
        return mint;
    }

    /**
     * Sets the value of the mint property.
     * 
     */
    public void setMint(boolean value) {
        this.mint = value;
    }

    /**
     * Gets the value of the temp property.
     * 
     */
    public boolean isTemp() {
        return temp;
    }

    /**
     * Sets the value of the temp property.
     * 
     */
    public void setTemp(boolean value) {
        this.temp = value;
    }

    /**
     * Gets the value of the dew property.
     * 
     */
    public boolean isDew() {
        return dew;
    }

    /**
     * Sets the value of the dew property.
     * 
     */
    public void setDew(boolean value) {
        this.dew = value;
    }

    /**
     * Gets the value of the pop12 property.
     * 
     */
    public boolean isPop12() {
        return pop12;
    }

    /**
     * Sets the value of the pop12 property.
     * 
     */
    public void setPop12(boolean value) {
        this.pop12 = value;
    }

    /**
     * Gets the value of the qpf property.
     * 
     */
    public boolean isQpf() {
        return qpf;
    }

    /**
     * Sets the value of the qpf property.
     * 
     */
    public void setQpf(boolean value) {
        this.qpf = value;
    }

    /**
     * Gets the value of the sky property.
     * 
     */
    public boolean isSky() {
        return sky;
    }

    /**
     * Sets the value of the sky property.
     * 
     */
    public void setSky(boolean value) {
        this.sky = value;
    }

    /**
     * Gets the value of the snow property.
     * 
     */
    public boolean isSnow() {
        return snow;
    }

    /**
     * Sets the value of the snow property.
     * 
     */
    public void setSnow(boolean value) {
        this.snow = value;
    }

    /**
     * Gets the value of the wspd property.
     * 
     */
    public boolean isWspd() {
        return wspd;
    }

    /**
     * Sets the value of the wspd property.
     * 
     */
    public void setWspd(boolean value) {
        this.wspd = value;
    }

    /**
     * Gets the value of the wdir property.
     * 
     */
    public boolean isWdir() {
        return wdir;
    }

    /**
     * Sets the value of the wdir property.
     * 
     */
    public void setWdir(boolean value) {
        this.wdir = value;
    }

    /**
     * Gets the value of the wx property.
     * 
     */
    public boolean isWx() {
        return wx;
    }

    /**
     * Sets the value of the wx property.
     * 
     */
    public void setWx(boolean value) {
        this.wx = value;
    }

    /**
     * Gets the value of the waveh property.
     * 
     */
    public boolean isWaveh() {
        return waveh;
    }

    /**
     * Sets the value of the waveh property.
     * 
     */
    public void setWaveh(boolean value) {
        this.waveh = value;
    }

    /**
     * Gets the value of the icons property.
     * 
     */
    public boolean isIcons() {
        return icons;
    }

    /**
     * Sets the value of the icons property.
     * 
     */
    public void setIcons(boolean value) {
        this.icons = value;
    }

    /**
     * Gets the value of the rh property.
     * 
     */
    public boolean isRh() {
        return rh;
    }

    /**
     * Sets the value of the rh property.
     * 
     */
    public void setRh(boolean value) {
        this.rh = value;
    }

    /**
     * Gets the value of the appt property.
     * 
     */
    public boolean isAppt() {
        return appt;
    }

    /**
     * Sets the value of the appt property.
     * 
     */
    public void setAppt(boolean value) {
        this.appt = value;
    }

    /**
     * Gets the value of the incw34 property.
     * 
     */
    public boolean isIncw34() {
        return incw34;
    }

    /**
     * Sets the value of the incw34 property.
     * 
     */
    public void setIncw34(boolean value) {
        this.incw34 = value;
    }

    /**
     * Gets the value of the incw50 property.
     * 
     */
    public boolean isIncw50() {
        return incw50;
    }

    /**
     * Sets the value of the incw50 property.
     * 
     */
    public void setIncw50(boolean value) {
        this.incw50 = value;
    }

    /**
     * Gets the value of the incw64 property.
     * 
     */
    public boolean isIncw64() {
        return incw64;
    }

    /**
     * Sets the value of the incw64 property.
     * 
     */
    public void setIncw64(boolean value) {
        this.incw64 = value;
    }

    /**
     * Gets the value of the cumw34 property.
     * 
     */
    public boolean isCumw34() {
        return cumw34;
    }

    /**
     * Sets the value of the cumw34 property.
     * 
     */
    public void setCumw34(boolean value) {
        this.cumw34 = value;
    }

    /**
     * Gets the value of the cumw50 property.
     * 
     */
    public boolean isCumw50() {
        return cumw50;
    }

    /**
     * Sets the value of the cumw50 property.
     * 
     */
    public void setCumw50(boolean value) {
        this.cumw50 = value;
    }

    /**
     * Gets the value of the cumw64 property.
     * 
     */
    public boolean isCumw64() {
        return cumw64;
    }

    /**
     * Sets the value of the cumw64 property.
     * 
     */
    public void setCumw64(boolean value) {
        this.cumw64 = value;
    }

    /**
     * Gets the value of the critfireo property.
     * 
     */
    public boolean isCritfireo() {
        return critfireo;
    }

    /**
     * Sets the value of the critfireo property.
     * 
     */
    public void setCritfireo(boolean value) {
        this.critfireo = value;
    }

    /**
     * Gets the value of the dryfireo property.
     * 
     */
    public boolean isDryfireo() {
        return dryfireo;
    }

    /**
     * Sets the value of the dryfireo property.
     * 
     */
    public void setDryfireo(boolean value) {
        this.dryfireo = value;
    }

    /**
     * Gets the value of the conhazo property.
     * 
     */
    public boolean isConhazo() {
        return conhazo;
    }

    /**
     * Sets the value of the conhazo property.
     * 
     */
    public void setConhazo(boolean value) {
        this.conhazo = value;
    }

    /**
     * Gets the value of the ptornado property.
     * 
     */
    public boolean isPtornado() {
        return ptornado;
    }

    /**
     * Sets the value of the ptornado property.
     * 
     */
    public void setPtornado(boolean value) {
        this.ptornado = value;
    }

    /**
     * Gets the value of the phail property.
     * 
     */
    public boolean isPhail() {
        return phail;
    }

    /**
     * Sets the value of the phail property.
     * 
     */
    public void setPhail(boolean value) {
        this.phail = value;
    }

    /**
     * Gets the value of the ptstmwinds property.
     * 
     */
    public boolean isPtstmwinds() {
        return ptstmwinds;
    }

    /**
     * Sets the value of the ptstmwinds property.
     * 
     */
    public void setPtstmwinds(boolean value) {
        this.ptstmwinds = value;
    }

    /**
     * Gets the value of the pxtornado property.
     * 
     */
    public boolean isPxtornado() {
        return pxtornado;
    }

    /**
     * Sets the value of the pxtornado property.
     * 
     */
    public void setPxtornado(boolean value) {
        this.pxtornado = value;
    }

    /**
     * Gets the value of the pxhail property.
     * 
     */
    public boolean isPxhail() {
        return pxhail;
    }

    /**
     * Sets the value of the pxhail property.
     * 
     */
    public void setPxhail(boolean value) {
        this.pxhail = value;
    }

    /**
     * Gets the value of the pxtstmwinds property.
     * 
     */
    public boolean isPxtstmwinds() {
        return pxtstmwinds;
    }

    /**
     * Sets the value of the pxtstmwinds property.
     * 
     */
    public void setPxtstmwinds(boolean value) {
        this.pxtstmwinds = value;
    }

    /**
     * Gets the value of the ptotsvrtstm property.
     * 
     */
    public boolean isPtotsvrtstm() {
        return ptotsvrtstm;
    }

    /**
     * Sets the value of the ptotsvrtstm property.
     * 
     */
    public void setPtotsvrtstm(boolean value) {
        this.ptotsvrtstm = value;
    }

    /**
     * Gets the value of the pxtotsvrtstm property.
     * 
     */
    public boolean isPxtotsvrtstm() {
        return pxtotsvrtstm;
    }

    /**
     * Sets the value of the pxtotsvrtstm property.
     * 
     */
    public void setPxtotsvrtstm(boolean value) {
        this.pxtotsvrtstm = value;
    }

    /**
     * Gets the value of the tmpabv14D property.
     * 
     */
    public boolean isTmpabv14D() {
        return tmpabv14D;
    }

    /**
     * Sets the value of the tmpabv14D property.
     * 
     */
    public void setTmpabv14D(boolean value) {
        this.tmpabv14D = value;
    }

    /**
     * Gets the value of the tmpblw14D property.
     * 
     */
    public boolean isTmpblw14D() {
        return tmpblw14D;
    }

    /**
     * Sets the value of the tmpblw14D property.
     * 
     */
    public void setTmpblw14D(boolean value) {
        this.tmpblw14D = value;
    }

    /**
     * Gets the value of the tmpabv30D property.
     * 
     */
    public boolean isTmpabv30D() {
        return tmpabv30D;
    }

    /**
     * Sets the value of the tmpabv30D property.
     * 
     */
    public void setTmpabv30D(boolean value) {
        this.tmpabv30D = value;
    }

    /**
     * Gets the value of the tmpblw30D property.
     * 
     */
    public boolean isTmpblw30D() {
        return tmpblw30D;
    }

    /**
     * Sets the value of the tmpblw30D property.
     * 
     */
    public void setTmpblw30D(boolean value) {
        this.tmpblw30D = value;
    }

    /**
     * Gets the value of the tmpabv90D property.
     * 
     */
    public boolean isTmpabv90D() {
        return tmpabv90D;
    }

    /**
     * Sets the value of the tmpabv90D property.
     * 
     */
    public void setTmpabv90D(boolean value) {
        this.tmpabv90D = value;
    }

    /**
     * Gets the value of the tmpblw90D property.
     * 
     */
    public boolean isTmpblw90D() {
        return tmpblw90D;
    }

    /**
     * Sets the value of the tmpblw90D property.
     * 
     */
    public void setTmpblw90D(boolean value) {
        this.tmpblw90D = value;
    }

    /**
     * Gets the value of the prcpabv14D property.
     * 
     */
    public boolean isPrcpabv14D() {
        return prcpabv14D;
    }

    /**
     * Sets the value of the prcpabv14D property.
     * 
     */
    public void setPrcpabv14D(boolean value) {
        this.prcpabv14D = value;
    }

    /**
     * Gets the value of the prcpblw14D property.
     * 
     */
    public boolean isPrcpblw14D() {
        return prcpblw14D;
    }

    /**
     * Sets the value of the prcpblw14D property.
     * 
     */
    public void setPrcpblw14D(boolean value) {
        this.prcpblw14D = value;
    }

    /**
     * Gets the value of the prcpabv30D property.
     * 
     */
    public boolean isPrcpabv30D() {
        return prcpabv30D;
    }

    /**
     * Sets the value of the prcpabv30D property.
     * 
     */
    public void setPrcpabv30D(boolean value) {
        this.prcpabv30D = value;
    }

    /**
     * Gets the value of the prcpblw30D property.
     * 
     */
    public boolean isPrcpblw30D() {
        return prcpblw30D;
    }

    /**
     * Sets the value of the prcpblw30D property.
     * 
     */
    public void setPrcpblw30D(boolean value) {
        this.prcpblw30D = value;
    }

    /**
     * Gets the value of the prcpabv90D property.
     * 
     */
    public boolean isPrcpabv90D() {
        return prcpabv90D;
    }

    /**
     * Sets the value of the prcpabv90D property.
     * 
     */
    public void setPrcpabv90D(boolean value) {
        this.prcpabv90D = value;
    }

    /**
     * Gets the value of the prcpblw90D property.
     * 
     */
    public boolean isPrcpblw90D() {
        return prcpblw90D;
    }

    /**
     * Sets the value of the prcpblw90D property.
     * 
     */
    public void setPrcpblw90D(boolean value) {
        this.prcpblw90D = value;
    }

    /**
     * Gets the value of the precipaR property.
     * 
     */
    public boolean isPrecipaR() {
        return precipaR;
    }

    /**
     * Sets the value of the precipaR property.
     * 
     */
    public void setPrecipaR(boolean value) {
        this.precipaR = value;
    }

    /**
     * Gets the value of the skyR property.
     * 
     */
    public boolean isSkyR() {
        return skyR;
    }

    /**
     * Sets the value of the skyR property.
     * 
     */
    public void setSkyR(boolean value) {
        this.skyR = value;
    }

    /**
     * Gets the value of the tdR property.
     * 
     */
    public boolean isTdR() {
        return tdR;
    }

    /**
     * Sets the value of the tdR property.
     * 
     */
    public void setTdR(boolean value) {
        this.tdR = value;
    }

    /**
     * Gets the value of the tempR property.
     * 
     */
    public boolean isTempR() {
        return tempR;
    }

    /**
     * Sets the value of the tempR property.
     * 
     */
    public void setTempR(boolean value) {
        this.tempR = value;
    }

    /**
     * Gets the value of the wdirR property.
     * 
     */
    public boolean isWdirR() {
        return wdirR;
    }

    /**
     * Sets the value of the wdirR property.
     * 
     */
    public void setWdirR(boolean value) {
        this.wdirR = value;
    }

    /**
     * Gets the value of the wspdR property.
     * 
     */
    public boolean isWspdR() {
        return wspdR;
    }

    /**
     * Sets the value of the wspdR property.
     * 
     */
    public void setWspdR(boolean value) {
        this.wspdR = value;
    }

    /**
     * Gets the value of the wwa property.
     * 
     */
    public boolean isWwa() {
        return wwa;
    }

    /**
     * Sets the value of the wwa property.
     * 
     */
    public void setWwa(boolean value) {
        this.wwa = value;
    }

    /**
     * Gets the value of the tstmprb property.
     * 
     */
    public boolean isTstmprb() {
        return tstmprb;
    }

    /**
     * Sets the value of the tstmprb property.
     * 
     */
    public void setTstmprb(boolean value) {
        this.tstmprb = value;
    }

    /**
     * Gets the value of the tstmcat property.
     * 
     */
    public boolean isTstmcat() {
        return tstmcat;
    }

    /**
     * Sets the value of the tstmcat property.
     * 
     */
    public void setTstmcat(boolean value) {
        this.tstmcat = value;
    }

    /**
     * Gets the value of the wgust property.
     * 
     */
    public boolean isWgust() {
        return wgust;
    }

    /**
     * Sets the value of the wgust property.
     * 
     */
    public void setWgust(boolean value) {
        this.wgust = value;
    }

    /**
     * Gets the value of the iceaccum property.
     * 
     */
    public boolean isIceaccum() {
        return iceaccum;
    }

    /**
     * Sets the value of the iceaccum property.
     * 
     */
    public void setIceaccum(boolean value) {
        this.iceaccum = value;
    }

    /**
     * Gets the value of the maxrh property.
     * 
     */
    public boolean isMaxrh() {
        return maxrh;
    }

    /**
     * Sets the value of the maxrh property.
     * 
     */
    public void setMaxrh(boolean value) {
        this.maxrh = value;
    }

    /**
     * Gets the value of the minrh property.
     * 
     */
    public boolean isMinrh() {
        return minrh;
    }

    /**
     * Sets the value of the minrh property.
     * 
     */
    public void setMinrh(boolean value) {
        this.minrh = value;
    }

}
