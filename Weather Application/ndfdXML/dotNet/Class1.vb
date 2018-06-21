Public Class MyContentHandler
    Implements MSXML2.IVBSAXContentHandler

    Public Sub characters(ByRef strChars As String) Implements MSXML2.IVBSAXContentHandler.characters

    End Sub

    Public WriteOnly Property documentLocator() As MSXML2.IVBSAXLocator Implements MSXML2.IVBSAXContentHandler.documentLocator
        Set(ByVal Value As MSXML2.IVBSAXLocator)

        End Set
    End Property

    Public Sub endDocument() Implements MSXML2.IVBSAXContentHandler.endDocument

    End Sub

    Public Sub endElement(ByRef strNamespaceURI As String, ByRef strLocalName As String, ByRef strQName As String) Implements MSXML2.IVBSAXContentHandler.endElement

    End Sub

    Public Sub endPrefixMapping(ByRef strPrefix As String) Implements MSXML2.IVBSAXContentHandler.endPrefixMapping

    End Sub

    Public Sub ignorableWhitespace(ByRef strChars As String) Implements MSXML2.IVBSAXContentHandler.ignorableWhitespace

    End Sub

    Public Sub processingInstruction(ByRef strTarget As String, ByRef strData As String) Implements MSXML2.IVBSAXContentHandler.processingInstruction

    End Sub

    Public Sub skippedEntity(ByRef strName As String) Implements MSXML2.IVBSAXContentHandler.skippedEntity

    End Sub

    Public Sub startDocument() Implements MSXML2.IVBSAXContentHandler.startDocument

    End Sub

    Public Sub startElement(ByRef strNamespaceURI As String, ByRef strLocalName As String, ByRef strQName As String, ByVal oAttributes As MSXML2.IVBSAXAttributes) Implements MSXML2.IVBSAXContentHandler.startElement

    End Sub

    Public Sub startPrefixMapping(ByRef strPrefix As String, ByRef strURI As String) Implements MSXML2.IVBSAXContentHandler.startPrefixMapping

    End Sub
End Class
