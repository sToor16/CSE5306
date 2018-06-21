'imports the webservice proxy namespace
Imports NDFD_WebService.ndfdSOAPserver

Public Class WebForm1
    Inherits System.Web.UI.Page

#Region " Web Form Designer Generated Code "

    'This call is required by the Web Form Designer.
    <System.Diagnostics.DebuggerStepThrough()> Private Sub InitializeComponent()

    End Sub
    Protected WithEvents Label2 As System.Web.UI.WebControls.Label
    Protected WithEvents Longitude As System.Web.UI.WebControls.TextBox
    Protected WithEvents Label3 As System.Web.UI.WebControls.Label
    Protected WithEvents StartDate As System.Web.UI.WebControls.TextBox
    Protected WithEvents Label4 As System.Web.UI.WebControls.Label
    Protected WithEvents NumberOfDays As System.Web.UI.WebControls.TextBox
    Protected WithEvents Label5 As System.Web.UI.WebControls.Label
    Protected WithEvents Label6 As System.Web.UI.WebControls.Label
    Protected WithEvents RetrieveNDFDxml As System.Web.UI.WebControls.Button
    Protected WithEvents Textbox1 As System.Web.UI.WebControls.TextBox
    Protected WithEvents dwmlOutByDay As System.Web.UI.WebControls.TextBox
    Protected WithEvents Label8 As System.Web.UI.WebControls.Label
    Protected WithEvents dwmlOut As System.Web.UI.WebControls.TextBox
    Protected WithEvents Textbox2 As System.Web.UI.WebControls.TextBox
    Protected WithEvents Label7 As System.Web.UI.WebControls.Label
    Protected WithEvents Label9 As System.Web.UI.WebControls.Label
    Protected WithEvents Latitude2 As System.Web.UI.WebControls.TextBox
    Protected WithEvents Longitude2 As System.Web.UI.WebControls.TextBox
    Protected WithEvents Label10 As System.Web.UI.WebControls.Label
    Protected WithEvents Label11 As System.Web.UI.WebControls.Label
    Protected WithEvents Label12 As System.Web.UI.WebControls.Label
    Protected WithEvents startDateTime As System.Web.UI.WebControls.TextBox
    Protected WithEvents endDateTime As System.Web.UI.WebControls.TextBox
    Protected WithEvents DWMLgenXML As System.Web.UI.WebControls.Button
    Protected WithEvents product As System.Web.UI.WebControls.DropDownList
    Protected WithEvents format As System.Web.UI.WebControls.DropDownList
    Protected WithEvents maxT As System.Web.UI.WebControls.CheckBox
    Protected WithEvents minT As System.Web.UI.WebControls.CheckBox
    Protected WithEvents hourlyT As System.Web.UI.WebControls.CheckBox
    Protected WithEvents icon As System.Web.UI.WebControls.CheckBox
    Protected WithEvents QPF As System.Web.UI.WebControls.CheckBox
    Protected WithEvents dewT As System.Web.UI.WebControls.CheckBox
    Protected WithEvents wave As System.Web.UI.WebControls.CheckBox
    Protected WithEvents pop12 As System.Web.UI.WebControls.CheckBox
    Protected WithEvents snow As System.Web.UI.WebControls.CheckBox
    Protected WithEvents sky As System.Web.UI.WebControls.CheckBox
    Protected WithEvents wspeed As System.Web.UI.WebControls.CheckBox
    Protected WithEvents wdir As System.Web.UI.WebControls.CheckBox
    Protected WithEvents weather As System.Web.UI.WebControls.CheckBox
    Protected WithEvents lable99 As System.Web.UI.WebControls.Label
    Protected WithEvents Label13 As System.Web.UI.WebControls.Label
    Protected WithEvents Latitude As System.Web.UI.WebControls.TextBox

    'NOTE: The following placeholder declaration is required by the Web Form Designer.
    'Do not delete or move it.
    Private designerPlaceholderDeclaration As System.Object

    Private Sub Page_Init(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles MyBase.Init
        'CODEGEN: This method call is required by the Web Form Designer
        'Do not modify it using the code editor.
        InitializeComponent()
    End Sub

#End Region

    Private Sub Page_Load(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles MyBase.Load
        'Put user code to initialize the page here
    End Sub

    Private Sub RetrieveNDFDxml_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles RetrieveNDFDxml.Click
        Dim x_NDFDdata As ndfdXML = New ndfdXML
        Dim soapLatitude As Decimal
        Dim soapLongitude As Decimal
        Dim soapStartDate As Date
        soapLatitude = Latitude.Text
        soapLongitude = Longitude.Text
        soapStartDate = StartDate.Text
        dwmlOutByDay.Text = x_NDFDdata.NDFDgenByDay(soapLatitude, soapLongitude, soapStartDate, NumberOfDays.Text, format.SelectedValue)
    End Sub

    Private Sub DropDownList1_SelectedIndexChanged(ByVal sender As System.Object, ByVal e As System.EventArgs)

    End Sub

    Private Sub DWMLgenXML_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles DWMLgenXML.Click
        Dim x_NDFDdata1 As ndfdXML = New ndfdXML
        Dim soapLatitude2 As Decimal
        Dim soapLongitude2 As Decimal
        Dim soapProduct As String
        Dim soapStartDateTime As Date
        Dim soapEndDateTime As Date
        Dim soapWeatherParameters As weatherParametersType = New weatherParametersType
        Dim counter As Integer
        soapLatitude2 = Latitude2.Text
        soapLongitude2 = Longitude2.Text
        soapStartDateTime = startDateTime.Text
        soapEndDateTime = endDateTime.Text
        If maxT.Checked Then
            soapWeatherParameters.maxt = True
        End If
        If minT.Checked Then
            soapWeatherParameters.mint = True
        End If
        If dewT.Checked Then
            soapWeatherParameters.dew = True
        End If
        If pop12.Checked Then
            soapWeatherParameters.pop12 = True
        End If
        If QPF.Checked Then
            soapWeatherParameters.qpf = True
        End If
        If sky.Checked Then
            soapWeatherParameters.sky = True
        End If
        If snow.Checked Then
            soapWeatherParameters.snow = True
        End If
        If hourlyT.Checked Then
            soapWeatherParameters.temp = True
        End If
        If wave.Checked Then
            soapWeatherParameters.waveh = False
        End If
        If wdir.Checked Then
            soapWeatherParameters.wdir = True
        End If
        If wspeed.Checked Then
            soapWeatherParameters.wspd = True
        End If
        If weather.Checked Then
            soapWeatherParameters.wx = True
        End If
        If icon.Checked Then
            soapWeatherParameters.icons = True
        End If
        dwmlOut.Text = x_NDFDdata1.NDFDgen(soapLatitude2, soapLongitude2, product.SelectedValue, soapStartDateTime, soapEndDateTime, soapWeatherParameters)
    End Sub

    Private Sub CheckBox23_CheckedChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles sky.CheckedChanged

    End Sub

    Private Sub Button1_Click(ByVal sender As System.Object, ByVal e As System.EventArgs)
        'dim xmldoc As New MSXML2.DOMDocument40
        Dim xmldoc As New System.Xml.XmlDataDocument
        Dim results As Boolean
        'xmldoc.async = False

        Dim x_NDFDdata1 As ndfdXML = New ndfdXML
        Dim soapLatitude2 As Decimal
        Dim soapLongitude2 As Decimal
        Dim soapProduct As String
        Dim soapStartDateTime As Date
        Dim soapEndDateTime As Date
        Dim soapWeatherParameters As weatherParametersType = New weatherParametersType
        Dim counter As Integer
        soapLatitude2 = Latitude2.Text
        soapLongitude2 = Longitude2.Text
        soapStartDateTime = startDateTime.Text
        soapEndDateTime = endDateTime.Text
        If maxT.Checked Then
            soapWeatherParameters.maxt = True
        End If
        If minT.Checked Then
            soapWeatherParameters.mint = True
        End If
        If dewT.Checked Then
            soapWeatherParameters.dew = True
        End If
        If pop12.Checked Then
            soapWeatherParameters.pop12 = True
        End If
        If QPF.Checked Then
            soapWeatherParameters.qpf = True
        End If
        If sky.Checked Then
            soapWeatherParameters.sky = True
        End If
        If snow.Checked Then
            soapWeatherParameters.snow = True
        End If
        If hourlyT.Checked Then
            soapWeatherParameters.temp = True
        End If
        If wave.Checked Then
            soapWeatherParameters.waveh = False
        End If
        If wdir.Checked Then
            soapWeatherParameters.wdir = True
        End If
        If wspeed.Checked Then
            soapWeatherParameters.wspd = True
        End If
        If weather.Checked Then
            soapWeatherParameters.wx = True
        End If
        If icon.Checked Then
            soapWeatherParameters.icons = True
        End If
        Dim serviceXML As String = x_NDFDdata1.NDFDgen(soapLatitude2, soapLongitude2, product.SelectedValue, soapStartDateTime, soapEndDateTime, soapWeatherParameters)
        xmldoc.LoadXml(serviceXML)
        Dim root As System.Xml.XmlElement
        root = xmldoc.DocumentElement
        Dim text As String
        text = "The name of the document root is "
        text = text & root.Name
        dwmlOutByDay.Text = text
    End Sub
End Class
