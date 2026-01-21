<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0"
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

  <xsl:template match="/top_outfielders">
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
        <h2>Top Outfielders</h2>
        <table>
          <tr>
            <th>Nombre</th>
            <th>Equipo</th>
            <th>Posicion</th>
            <th>Max Exit Velocity</th>
            <th>Avg Exit Velocity</th>
            <th>Distance</th>
            <th>OAA</th>
            <th>Outfield Jump</th>
            <th>Arm Strength</th>
          </tr>

          <xsl:for-each select="jugador">
            <tr>
              <td><xsl:value-of select="nombre"/></td>
              <td><xsl:value-of select="equipo"/></td>
              <td><xsl:value-of select="@posicion"/></td>
              <td><xsl:value-of select="estadisticas_bateo/max_exit_velocity"/></td>
              <td><xsl:value-of select="estadisticas_bateo/avg_exit_velocity"/></td>
              <td><xsl:value-of select="estadisticas_bateo/distance"/></td>
              <td><xsl:value-of select="defensa/oaa"/></td>
              <td><xsl:value-of select="defensa/outfield_jump"/></td>
              <td><xsl:value-of select="defensa/arm_strength"/></td>
            </tr>
          </xsl:for-each>
        </table>
      </body>
    </html>
  </xsl:template>

</xsl:stylesheet>
