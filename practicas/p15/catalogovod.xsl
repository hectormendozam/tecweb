<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html" encoding="UTF-8" doctype-public="-//W3C//DTD XHTML 1.0 Strict//EN" doctype-system="http://www.w3.org/TR/xhtml1/DTD/strict.dtd"/>
    <xsl:template match="/">
        <html>
            <head>
                <title>Catálogo VOD</title>
                <style>
                    body {
                    font-family: Arial, sans-serif;
                    margin: 20px;
                    background-color: #f4f4f4;
                    color: #333;
                    }
                    h1 {
                    text-align: center;
                    color: #2c3e50;
                    }
                    .logo {
                    display: block;
                    margin: 0 auto 20px;
                    width: 150px;
                    }
                    table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-bottom: 20px;
                    }
                    th, td {
                    border: 1px solid #ddd;
                    padding: 8px;
                    text-align: left;
                    }
                    th {
                    background-color: #2c3e50;
                    color: white;
                    text-align: center;
                    }
                    .table-title {
                    background-color: #3498db;
                    color: white;
                    font-size: 1.2em;
                    text-align: center;
                    }
                </style>
            </head>
            <body>
                <!-- Logotipo -->
                <img class="logo" src="logo.png" alt="Logotipo VOD"/>
                
                <!-- Películas -->
                <h1>Catálogo de Películas</h1>
                <table>
                    <tr>
                        <th class="table-title" colspan="3">Películas</th>
                    </tr>
                    <tr>
                        <th>Título</th>
                        <th>Duración</th>
                        <th>Género</th>
                    </tr>
                    <xsl:for-each select="catalogovod/contenido/peliculas/genero">
                        <xsl:variable name="genero" select="@nombre"/>
                        <xsl:for-each select="titulo">
                            <tr>
                                <td><xsl:value-of select="."/></td>
                                <td><xsl:value-of select="@duracion"/></td>
                                <td><xsl:value-of select="$genero"/></td>
                            </tr>
                        </xsl:for-each>
                    </xsl:for-each>
                </table>
                
                <!-- Series -->
                <h1>Catálogo de Series</h1>
                <table>
                    <tr>
                        <th class="table-title" colspan="3">Series</th>
                    </tr>
                    <tr>
                        <th>Título</th>
                        <th>Duración</th>
                        <th>Género</th>
                    </tr>
                    <xsl:for-each select="catalogovod/contenido/series/genero">
                        <xsl:variable name="genero" select="@nombre"/>
                        <xsl:for-each select="titulo">
                            <tr>
                                <td><xsl:value-of select="."/></td>
                                <td><xsl:value-of select="@duracion"/></td>
                                <td><xsl:value-of select="$genero"/></td>
                            </tr>
                        </xsl:for-each>
                    </xsl:for-each>
                </table>
            </body>
        </html>
    </xsl:template>
</xsl:stylesheet>
