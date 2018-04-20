<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.1" xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns:fo="http://www.w3.org/1999/XSL/Format" exclude-result-prefixes="fo"
                xmlns:fox="http://xmlgraphics.apache.org/fop/extensions">
    <xsl:template match="response">
        <fo:root xmlns:fo="http://www.w3.org/1999/XSL/Format"
                 xmlns:fox="http://xmlgraphics.apache.org/fop/extensions">

            <fo:layout-master-set>
                <fo:simple-page-master master-name="A4-landscape"
                                       margin-right="0.5cm"
                                       margin-left="0.5cm"
                                       margin-bottom="0.25cm"
                                       margin-top="0.25cm"
                                       page-height="21cm"
                                       page-width="29.7cm">
                    <fo:region-body margin-top="0cm"/>
                    <fo:region-before extent="1cm"/>
                    <fo:region-after extent="1.5cm"/>
                </fo:simple-page-master>
            </fo:layout-master-set>

            <fo:page-sequence master-reference="A4-landscape">
                <fo:flow flow-name="xsl-region-body" font-family="Segoe-UI-Normal">

                    <fo:block color="#333" font-size="1.1cm" space-after.optimum="0.5cm">
                        <fo:inline font-family="Segoe-UI-Bold" font-weight="bold">Chore</fo:inline>
                        Schedule
                    </fo:block>


                    <fo:table border-collapse="collapse" table-layout="fixed" width="100%" border="0 solid white">
                        <fo:table-column column-width="5cm" border-top="0 solid black" border-bottom="0 solid black"
                                         border-left="0 solid white" border-right="0 solid white"/>
                        <fo:table-column column-width="3.4cm" border-top="0 solid black" border-bottom="0 solid black"
                                         border-left="0 solid white" border-right="0 solid white"/>
                        <fo:table-column column-width="3.4cm" border-top="0 solid black" border-bottom="0 solid black"
                                         border-left="0 solid white" border-right="0 solid white"/>
                        <fo:table-column column-width="3.4cm" border-top="0 solid black" border-bottom="0 solid black"
                                         border-left="0 solid white" border-right="0 solid white"/>
                        <fo:table-column column-width="3.4cm" border-top="0 solid black" border-bottom="0 solid black"
                                         border-left="0 solid white" border-right="0 solid white"/>
                        <fo:table-column column-width="3.4cm" border-top="0 solid black" border-bottom="0 solid black"
                                         border-left="0 solid white" border-right="0 solid white"/>
                        <fo:table-column column-width="3.4cm" border-top="0 solid black" border-bottom="0 solid black"
                                         border-left="0 solid white" border-right="0 solid white"/>
                        <fo:table-column column-width="3.4cm" border-top="0 solid black" border-bottom="0 solid black"
                                         border-left="0 solid white" border-right="0 solid white"/>

                        <fo:table-header font-weight="regular" border="0pt solid black">
                            <fo:table-row border="0pt solid black" height="2.5cm"
                                          border-top="2pt solid #3F51B5" border-bottom="2pt solid #3F51B5">
                                <fo:table-cell padding="0.1cm" background-color="#fff" color="#3F51B5"
                                               display-align="center"
                                               border-left="0.5pt solid #3F51B5">
                                    <fo:block text-align="center" font-size="0.4cm" padding-bottom="0.3cm">
                                        FOR THE WEEK OF:
                                    </fo:block>
                                    <fo:block text-align="center" font-size="0.7cm" background-color="#3F51B5"
                                              color="#fff" padding="0.1cm">
                                        <xsl:value-of select="date"/>
                                    </fo:block>
                                </fo:table-cell>
                                <fo:table-cell padding="0.2cm" background-color="#1A237E" color="#fff"
                                               border-left="0.5pt solid #283593">
                                    <fo:block text-align="left" font-size="1.0cm">
                                        <xsl:value-of select="days/day[1]/weekday"/>
                                    </fo:block>
                                    <fo:block text-align="left" font-size="0.5cm" padding-top="2mm">
                                        <xsl:value-of select="days/day[1]/day"/>
                                    </fo:block>
                                </fo:table-cell>
                                <fo:table-cell padding="0.2cm" background-color="#283593" color="#fff"
                                               border-left="0.5pt solid #303F9F">
                                    <fo:block text-align="left" font-size="1.0cm">
                                        <xsl:value-of select="days/day[2]/weekday"/>
                                    </fo:block>
                                    <fo:block text-align="left" font-size="0.5cm" padding-top="2mm">
                                        <xsl:value-of select="days/day[2]/day"/>
                                    </fo:block>
                                </fo:table-cell>
                                <fo:table-cell padding="0.2cm" background-color="#303F9F" color="#fff">
                                    <fo:block text-align="left" font-size="1.0cm">
                                        <xsl:value-of select="days/day[3]/weekday"/>
                                    </fo:block>
                                    <fo:block text-align="left" font-size="0.5cm" padding-top="2mm">
                                        <xsl:value-of select="days/day[3]/day"/>
                                    </fo:block>
                                </fo:table-cell>
                                <fo:table-cell padding="0.2cm" background-color="#3949AB" color="#fff">
                                    <fo:block text-align="left" font-size="1.0cm">
                                        <xsl:value-of select="days/day[4]/weekday"/>
                                    </fo:block>
                                    <fo:block text-align="left" font-size="0.5cm" padding-top="2mm">
                                        <xsl:value-of select="days/day[4]/day"/>
                                    </fo:block>
                                </fo:table-cell>
                                <fo:table-cell padding="0.2cm" background-color="#3F51B5" color="#fff">
                                    <fo:block text-align="left" font-size="1.0cm">
                                        <xsl:value-of select="days/day[5]/weekday"/>
                                    </fo:block>
                                    <fo:block text-align="left" font-size="0.5cm" padding-top="2mm">
                                        <xsl:value-of select="days/day[5]/day"/>
                                    </fo:block>
                                </fo:table-cell>
                                <fo:table-cell padding="0.2cm" background-color="#5C6BC0" color="#fff">
                                    <fo:block text-align="left" font-size="1.0cm">
                                        <xsl:value-of select="days/day[6]/weekday"/>
                                    </fo:block>
                                    <fo:block text-align="left" font-size="0.5cm" padding-top="2mm">
                                        <xsl:value-of select="days/day[6]/day"/>
                                    </fo:block>
                                </fo:table-cell>
                                <fo:table-cell padding="0.2cm" background-color="#7986CB" color="#fff">
                                    <fo:block text-align="left" font-size="1.0cm">
                                        <xsl:value-of select="days/day[7]/weekday"/>
                                    </fo:block>
                                    <fo:block text-align="left" font-size="0.5cm" padding-top="2mm">
                                        <xsl:value-of select="days/day[7]/day"/>
                                    </fo:block>
                                </fo:table-cell>
                            </fo:table-row>
                        </fo:table-header>

                        <fo:table-body>
                            <xsl:for-each select="chores/chore">
                                <fo:table-row border-top="2pt solid #3F51B5">
                                    <fo:table-cell display-align="center" padding="1mm">
                                        <fo:block text-align="left" page-break-inside="avoid">
                                            <xsl:value-of select="task/name"/>
                                        </fo:block>
                                    </fo:table-cell>
                                    <xsl:for-each select="days/day">
                                        <fo:table-cell display-align="center" padding="1mm">
                                            <xsl:variable name="name" select="name"/>
                                            <xsl:choose>
                                                <xsl:when test="$name">
                                                    <fo:table table-layout="fixed">
                                                        <fo:table-column column-width="2.5cm"/>
                                                        <fo:table-column column-width="0.5cm"/>
                                                        <fo:table-body>
                                                            <fo:table-row>
                                                                <fo:table-cell display-align="center" padding="1mm">
                                                                    <fo:block text-align="center">
                                                                        <xsl:value-of select="name"/>
                                                                    </fo:block>
                                                                </fo:table-cell>
                                                                <fo:table-cell display-align="center" padding="1mm">
                                                                    <fo:block text-align="center" height="20">
                                                                        <fo:instream-foreign-object xmlns:svg="http://www.w3.org/2000/svg"
                                                                                                    padding-top="-4mm" padding-left="2mm">
                                                                            <svg:svg xmlns:svg="http://www.w3.org/2000/svg"
                                                                                     width="20"
                                                                                     height="20"
                                                                                     viewBox="0 -5 25 10">
                                                                                <svg:g style="fill:white; stroke:#3F51B5">
                                                                                    <svg:rect x="5" y="0" width="15" height="15"/>
                                                                                </svg:g>
                                                                            </svg:svg>
                                                                        </fo:instream-foreign-object>
                                                                    </fo:block>
                                                                </fo:table-cell>
                                                            </fo:table-row>
                                                        </fo:table-body>
                                                    </fo:table>
                                                </xsl:when>
                                                <xsl:otherwise>
                                                    <fo:block text-align="center">

                                                    </fo:block>
                                                </xsl:otherwise>
                                            </xsl:choose>

                                        </fo:table-cell>
                                    </xsl:for-each>
                                    <!--
                                    <fo:table-cell display-align="center" padding="1mm">
                                        <fo:block text-align="center" height="20">
                                            Andres
                                            <fo:instream-foreign-object xmlns:svg="http://www.w3.org/2000/svg"
                                                                        padding-top="-4mm" padding-left="2mm">
                                                <svg:svg xmlns:svg="http://www.w3.org/2000/svg"
                                                         width="20"
                                                         height="20"
                                                         viewBox="0 -5 25 10">
                                                    <svg:g style="fill:white; stroke:#3F51B5">
                                                        <svg:rect x="5" y="0" width="15" height="15"/>
                                                    </svg:g>
                                                </svg:svg>
                                            </fo:instream-foreign-object>
                                        </fo:block>
                                    </fo:table-cell>
                                    <fo:table-cell display-align="center" padding="1mm">
                                        <fo:block text-align="center" height="20">
                                            Andres
                                            <fo:instream-foreign-object xmlns:svg="http://www.w3.org/2000/svg"
                                                                        padding-top="-4mm" padding-left="2mm">
                                                <svg:svg xmlns:svg="http://www.w3.org/2000/svg"
                                                         width="20"
                                                         height="20"
                                                         viewBox="0 -5 25 10">
                                                    <svg:g style="fill:white; stroke:#3F51B5">
                                                        <svg:rect x="5" y="0" width="15" height="15"/>
                                                    </svg:g>
                                                </svg:svg>
                                            </fo:instream-foreign-object>
                                        </fo:block>
                                    </fo:table-cell>
                                    <fo:table-cell display-align="center" padding="1mm">
                                        <fo:block text-align="center" height="20">
                                            Andres
                                            <fo:instream-foreign-object xmlns:svg="http://www.w3.org/2000/svg"
                                                                        padding-top="-4mm" padding-left="2mm">
                                                <svg:svg xmlns:svg="http://www.w3.org/2000/svg"
                                                         width="20"
                                                         height="20"
                                                         viewBox="0 -5 25 10">
                                                    <svg:g style="fill:white; stroke:#3F51B5">
                                                        <svg:rect x="5" y="0" width="15" height="15"/>
                                                    </svg:g>
                                                </svg:svg>
                                            </fo:instream-foreign-object>
                                        </fo:block>
                                    </fo:table-cell>
                                    <fo:table-cell display-align="center" padding="1mm">
                                        <fo:block text-align="center" height="20">
                                            Andres
                                            <fo:instream-foreign-object xmlns:svg="http://www.w3.org/2000/svg"
                                                                        padding-top="-4mm" padding-left="2mm">
                                                <svg:svg xmlns:svg="http://www.w3.org/2000/svg"
                                                         width="20"
                                                         height="20"
                                                         viewBox="0 -5 25 10">
                                                    <svg:g style="fill:white; stroke:#3F51B5">
                                                        <svg:rect x="5" y="0" width="15" height="15"/>
                                                    </svg:g>
                                                </svg:svg>
                                            </fo:instream-foreign-object>
                                        </fo:block>
                                    </fo:table-cell>
                                    <fo:table-cell display-align="center" padding="1mm">
                                        <fo:block text-align="center" height="20">
                                            Andres
                                            <fo:instream-foreign-object xmlns:svg="http://www.w3.org/2000/svg"
                                                                        padding-top="-4mm" padding-left="2mm">
                                                <svg:svg xmlns:svg="http://www.w3.org/2000/svg"
                                                         width="20"
                                                         height="20"
                                                         viewBox="0 -5 25 10">
                                                    <svg:g style="fill:white; stroke:#3F51B5">
                                                        <svg:rect x="5" y="0" width="15" height="15"/>
                                                    </svg:g>
                                                </svg:svg>
                                            </fo:instream-foreign-object>
                                        </fo:block>
                                    </fo:table-cell>
                                    <fo:table-cell display-align="center" padding="1mm">
                                        <fo:block text-align="center" height="20">
                                            Andres
                                            <fo:instream-foreign-object xmlns:svg="http://www.w3.org/2000/svg"
                                                                        padding-top="-4mm" padding-left="2mm">
                                                <svg:svg xmlns:svg="http://www.w3.org/2000/svg"
                                                         width="20"
                                                         height="20"
                                                         viewBox="0 -5 25 10">
                                                    <svg:g style="fill:white; stroke:#3F51B5">
                                                        <svg:rect x="5" y="0" width="15" height="15"/>
                                                    </svg:g>
                                                </svg:svg>
                                            </fo:instream-foreign-object>
                                        </fo:block>
                                    </fo:table-cell>
                                    -->
                                </fo:table-row>
                            </xsl:for-each>

                        </fo:table-body>
                    </fo:table>
                </fo:flow>
            </fo:page-sequence>
        </fo:root>
    </xsl:template>
</xsl:stylesheet>
