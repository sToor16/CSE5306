<%@ Page Language="vb" AutoEventWireup="false" Codebehind="WebForm1.aspx.vb" Inherits="NDFD_WebService.WebForm1"%>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
	<HEAD>
		<title>NDFD Web Service Demo</title>
		<meta content="Microsoft Visual Studio .NET 7.1" name="GENERATOR">
		<meta content="Visual Basic .NET 7.1" name="CODE_LANGUAGE">
		<meta content="JavaScript" name="vs_defaultClientScript">
		<meta content="http://schemas.microsoft.com/intellisense/ie5" name="vs_targetSchema">
	</HEAD>
	<body MS_POSITIONING="GridLayout">
		<form id="Form1" method="post" runat="server">
			<asp:checkbox id="weather" style="Z-INDEX: 139; LEFT: 360px; POSITION: absolute; TOP: 800px" runat="server"
				Text="Weather" Height="24px" Width="200px"></asp:checkbox><asp:checkbox id="wdir" style="Z-INDEX: 138; LEFT: 360px; POSITION: absolute; TOP: 776px" runat="server"
				Text="Wind Direction" Height="24px" Width="200px"></asp:checkbox><asp:checkbox id="wspeed" style="Z-INDEX: 137; LEFT: 360px; POSITION: absolute; TOP: 752px" runat="server"
				Text="Wind Speed" Height="24px" Width="200px"></asp:checkbox><asp:checkbox id="sky" style="Z-INDEX: 136; LEFT: 360px; POSITION: absolute; TOP: 728px" runat="server"
				Text="Sky Cover" Height="24px" Width="200px"></asp:checkbox><asp:checkbox id="snow" style="Z-INDEX: 135; LEFT: 360px; POSITION: absolute; TOP: 680px" runat="server"
				Text="Snow Amount" Height="24px" Width="200px"></asp:checkbox><asp:checkbox id="pop12" style="Z-INDEX: 134; LEFT: 360px; POSITION: absolute; TOP: 704px" runat="server"
				Text="12 Hour PoP" Height="24px" Width="200px"></asp:checkbox><asp:checkbox id="wave" style="Z-INDEX: 133; LEFT: 360px; POSITION: absolute; TOP: 848px" runat="server"
				Text="Wave Height" Height="24px" Width="200px"></asp:checkbox><asp:checkbox id="dewT" style="Z-INDEX: 132; LEFT: 360px; POSITION: absolute; TOP: 632px" runat="server"
				Text="Dewpoint Temperature" Height="24px" Width="200px"></asp:checkbox><asp:checkbox id="QPF" style="Z-INDEX: 131; LEFT: 360px; POSITION: absolute; TOP: 656px" runat="server"
				Text="QPF" Height="24px" Width="200px"></asp:checkbox><asp:checkbox id="icon" style="Z-INDEX: 130; LEFT: 360px; POSITION: absolute; TOP: 824px" runat="server"
				Text="Weather Icons" Height="24px" Width="200px"></asp:checkbox><asp:checkbox id="hourlyT" style="Z-INDEX: 128; LEFT: 360px; POSITION: absolute; TOP: 608px" runat="server"
				Text="Hourly Temperature" Height="24px" Width="200px"></asp:checkbox><asp:checkbox id="minT" style="Z-INDEX: 129; LEFT: 360px; POSITION: absolute; TOP: 584px" runat="server"
				Text="Minimum Temperature" Height="24px" Width="200px"></asp:checkbox><asp:textbox id="Longitude2" style="Z-INDEX: 118; LEFT: 120px; POSITION: absolute; TOP: 608px"
				runat="server" Width="96px">-77.00</asp:textbox><asp:textbox id="Latitude2" style="Z-INDEX: 117; LEFT: 120px; POSITION: absolute; TOP: 560px"
				runat="server" Width="96px">38.99</asp:textbox><asp:label id="Label9" style="Z-INDEX: 116; LEFT: 48px; POSITION: absolute; TOP: 608px" runat="server"
				Height="32px" Width="64px">longitude</asp:label><asp:label id="Label7" style="Z-INDEX: 115; LEFT: 48px; POSITION: absolute; TOP: 560px" runat="server"
				Height="24px" Width="64px">Latitude</asp:label><asp:textbox id="Textbox2" style="Z-INDEX: 102; LEFT: 136px; POSITION: absolute; TOP: 96px" runat="server"
				Width="96px">-77.00</asp:textbox><asp:label id="Label8" style="Z-INDEX: 113; LEFT: 48px; POSITION: absolute; TOP: 952px" runat="server"
				Height="24px" Width="144px">Returned DWML</asp:label><asp:textbox id="Textbox1" style="Z-INDEX: 110; LEFT: 40px; POSITION: absolute; TOP: 264px" runat="server"
				Height="256px" Width="549px" TextMode="MultiLine">Returned  DWML will appear here!</asp:textbox><asp:label id="Label2" style="Z-INDEX: 101; LEFT: 40px; POSITION: absolute; TOP: 104px" runat="server"
				Height="32px" Width="64px">longitude</asp:label><asp:textbox id="Longitude" style="Z-INDEX: 103; LEFT: 136px; POSITION: absolute; TOP: 96px"
				runat="server" Width="96px">-77.00</asp:textbox><asp:label id="Label3" style="Z-INDEX: 104; LEFT: 368px; POSITION: absolute; TOP: 64px" runat="server"
				Height="24px" Width="72px">Start Date</asp:label><asp:textbox id="StartDate" style="Z-INDEX: 105; LEFT: 464px; POSITION: absolute; TOP: 56px"
				runat="server" Height="32px" Width="97px">2004-12-02</asp:textbox><asp:label id="Label4" style="Z-INDEX: 106; LEFT: 336px; POSITION: absolute; TOP: 104px" runat="server"
				Height="24px" Width="113px">Number of Days</asp:label><asp:textbox id="NumberOfDays" style="Z-INDEX: 107; LEFT: 464px; POSITION: absolute; TOP: 96px"
				runat="server" Height="26px" Width="104px">7</asp:textbox><asp:label id="Label5" style="Z-INDEX: 108; LEFT: 40px; POSITION: absolute; TOP: 144px" runat="server"
				Height="32px" Width="72px">Format</asp:label><asp:label id="Label6" style="Z-INDEX: 109; LEFT: 40px; POSITION: absolute; TOP: 240px" runat="server"
				Height="24px" Width="176px">Returned DWML By Day</asp:label><asp:textbox id="dwmlOutByDay" style="Z-INDEX: 111; LEFT: 40px; POSITION: absolute; TOP: 264px"
				runat="server" Height="256px" Width="704px" TextMode="MultiLine">Returned DWML By Day will appear here!</asp:textbox><asp:button id="RetrieveNDFDxml" style="Z-INDEX: 112; LEFT: 248px; POSITION: absolute; TOP: 192px"
				runat="server" Text="Get NDFD By Day Data" Height="40px" Width="160px"></asp:button><asp:textbox id="dwmlOut" style="Z-INDEX: 114; LEFT: 48px; POSITION: absolute; TOP: 984px" runat="server"
				Height="272px" Width="704px" TextMode="MultiLine">Returned DWML will appear here!</asp:textbox><asp:label id="Label10" style="Z-INDEX: 119; LEFT: 48px; POSITION: absolute; TOP: 664px" runat="server"
				Height="32px" Width="64px">Product:</asp:label><asp:dropdownlist id="product" style="Z-INDEX: 120; LEFT: 120px; POSITION: absolute; TOP: 664px" runat="server"
				Height="48px" Width="128px">
				<asp:ListItem Value="time-series" Selected="True">Time Series</asp:ListItem>
				<asp:ListItem Value="glance">Weather At A Glance</asp:ListItem>
			</asp:dropdownlist><asp:label id="Label11" style="Z-INDEX: 121; LEFT: 48px; POSITION: absolute; TOP: 728px" runat="server"
				Height="32px" Width="104px">Start Date/Time:</asp:label><asp:label id="Label12" style="Z-INDEX: 122; LEFT: 48px; POSITION: absolute; TOP: 784px" runat="server"
				Height="32px" Width="96px">End Date/Time:</asp:label><asp:textbox id="startDateTime" style="Z-INDEX: 123; LEFT: 168px; POSITION: absolute; TOP: 728px"
				runat="server" Width="152px">2004-12-03T00:00:00</asp:textbox><asp:textbox id="endDateTime" style="Z-INDEX: 124; LEFT: 168px; POSITION: absolute; TOP: 784px"
				runat="server" Width="152px">2010-01-01T00:00:00</asp:textbox><asp:button id="DWMLgenXML" style="Z-INDEX: 125; LEFT: 224px; POSITION: absolute; TOP: 896px"
				runat="server" Text="Get NDFD Data" Height="46px" Width="144px"></asp:button><asp:dropdownlist id="format" style="Z-INDEX: 126; LEFT: 136px; POSITION: absolute; TOP: 144px" runat="server"
				Height="32px" Width="136px">
				<asp:ListItem Value="24 hourly" Selected="True">24 Hourly Periods</asp:ListItem>
				<asp:ListItem Value="12 hourly">12 Hourly Periods</asp:ListItem>
			</asp:dropdownlist><asp:checkbox id="maxT" style="Z-INDEX: 127; LEFT: 360px; POSITION: absolute; TOP: 560px" runat="server"
				Text="Maximum Temperature" Height="24px" Width="200px" Checked="True"></asp:checkbox><asp:label id="lable99" style="Z-INDEX: 140; LEFT: 40px; POSITION: absolute; TOP: 64px" runat="server"
				Height="16px" Width="80px">Latitude:</asp:label><asp:label id="Label13" style="Z-INDEX: 141; LEFT: 40px; POSITION: absolute; TOP: -408px" runat="server"
				Height="32px" Width="64px">Label</asp:label><asp:textbox id="Latitude" style="Z-INDEX: 142; LEFT: 136px; POSITION: absolute; TOP: 64px" runat="server"
				Width="136px">38.99</asp:textbox></form>
	</body>
</HTML>
