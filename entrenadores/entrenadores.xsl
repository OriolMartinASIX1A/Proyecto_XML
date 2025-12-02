<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0"
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

  <xsl:template match="/top_entrenadores">
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
        <h2>Top Entrenadores</h2>
        <table>
          <tr>
            <th>Nombre</th>
            <th>Equipo</th>
            <th>Activo</th>
            <th>Experiencia</th>
            <th>Victorias</th>
            <th>Derrotas</th>
          </tr>

          <xsl:for-each select="entrenador">
            <tr>
              <td><xsl:value-of select="nombre"/></td>
              <td><xsl:value-of select="equipo"/></td>
              <td><xsl:value-of select="equipo/@activo"/></td>
              <td><xsl:value-of select="experiencia"/></td>
              <td><xsl:value-of select="victorias"/></td>
              <td><xsl:value-of select="derrotas"/></td>
            </tr>
          </xsl:for-each>
        </table>
      </body>
    </html>
  </xsl:template>

</xsl:stylesheet>
