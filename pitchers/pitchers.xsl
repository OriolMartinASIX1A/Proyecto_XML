<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0"
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

  <xsl:template match="/top_lanzadores">
    <html>
    <head>
    <style>
          body {
            font-family: Arial, sans-serif;
            background-color: #0c1a2b; 
            color: #ffffff;
            padding: 20px;
          }
          h2 {
            color: #c8102e; 
          }
          table {
            border-collapse: collapse;
            width: 100%;
          }
          th {
            border: 2px solid #c8102e;
            padding: 6px;
          }
          td {   
            border: 1px solid #c8102e;
            padding: 6px;
            text-align: center;
          }
        </style>
    </head>
      <body>
        <h2>Top Lanzadores</h2>
        <table>
          <tr >
            <th>Nombre</th>
            <th>Equipo</th>
            <th>Rol</th>
            <th>ERA</th>
            <th>Strikeouts</th>
            <th>Bases por bolas</th>
          </tr>

          <xsl:for-each select="lanzador">
            <tr>
              <td><xsl:value-of select="nombre"/></td>
              <td><xsl:value-of select="equipo"/></td>
              <td><xsl:value-of select="@rol"/></td>
              <td><xsl:value-of select="era"/></td>
              <td><xsl:value-of select="estadisticas_tiro/strikeouts"/></td>
              <td><xsl:value-of select="estadisticas_tiro/base_por_bolas"/></td>
            </tr>
          </xsl:for-each>
        </table>
      </body>
    </html>
  </xsl:template>

</xsl:stylesheet>
