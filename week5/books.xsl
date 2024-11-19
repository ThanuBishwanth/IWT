<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" encoding="UTF-8"/>
<xsl:template match="/">
<html>
<head>
<title>Bookstore</title>
<style>
body {
font-family: Arial, sans-serif; background-color: #f4f4f9; margin: 0;
padding: 20px;
}
table {
width: 100%;
border-collapse: collapse; margin-top: 20px;
box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}
th, td {
padding: 12px;
 
text-align: left;
}
th {
background-color: #4CAF50; color: white;
font-size: 1.1em; font-weight: bold;
}
td {
border: 1px solid #ddd;
}
td.title {
background-color: #e8f5e9; font-style: italic;
}
td.author {
background-color: #fff3e0; color: #d32f2f;
}
td.isbn {
background-color: #e3f2fd;
}
td.publisher {
background-color: #ffecb3; font-weight: bold;
}
td.edition {
background-color: #f1f8e9;
}
td.price {
background-color: #fffde7; font-weight: bold;
color: #388e3c;
}
tr:nth-child(even) { background-color: #f9f9f9;
}
tr:hover {
background-color: #f1f1f1;
}
caption {
font-size: 1.5em; margin-bottom: 10px; font-weight: bold;
}
</style>
</head>
<body>
<table>
<caption>Bookstore Inventory</caption>
 
<thead>
<tr>
<th>Title</th>
<th>Author</th>
<th>ISBN</th>
<th>Publisher</th>
<th>Edition</th>
<th>Price</th>
</tr>
</thead>
<tbody>
<xsl:for-each select="bookstore/book">
<tr>
<td class="title"><xsl:value-of select="title"/></td>
<td class="author"><xsl:value-of select="author"/></td>
<td class="isbn"><xsl:value-of select="isbn"/></td>
<td class="publisher"><xsl:value-of select="publisher"/></td>
<td class="edition"><xsl:value-of select="edition"/></td>
<td class="price"><xsl:value-of select="price"/></td>
</tr>
</xsl:for-each>
</tbody>
</table>
</body>
</html>
</xsl:template>
</xsl:stylesheet>
