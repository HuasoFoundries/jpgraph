<?php

/**
 * JPGraph - Community Edition
 */

namespace Amenadiel\JpGraph\Util;

/*
 * File:        JPGRAPH_ERRHANDLER.PHP
 * // Description: Error handler class together with handling of localized
 * //              error messages. All localized error messages are stored
 * //              in a separate file under the "lang/" subdirectory.
 * // Created:     2006-09-24
 * // Ver:         $Id: jpgraph_errhandler.inc.php 1920 2009-12-08 10:02:26Z ljp $
 * //
 * // Copyright 2006 (c) Aditus Consulting. All rights reserved.
 */

class ExceptionFactory
{
    const Error10 = "HTTP headers have already been sent.Caused by output from file %s at line %d.Explanation:HTTP headers have already been sent back to the browser indicating the data as text before the library got a chance to send it's image HTTP header to this browser. This makes it impossible for the library to send back image data to the browser (since that would be interpretated as text by the browser and show up as junk text).Most likely you have some text in your script before the call to Graph::Stroke(). If this texts gets sent back to the browser the browser will assume that all data is plain text. Look for any text, even spaces and newlines, that might have been sent back to the browser. For example it is a common mistake to leave a blank line before the opening php tag";
    const Error21001 = 'Data values for Stock charts must contain an even multiple of %d data points.';
    const Error22001 = 'Total percentage for all windrose legs in a windrose plot can not exceed 100%% !\n(Current max is: %d)';
    const Error22002 = 'Graph is too small to have a scale. Please make the graph larger.';
    const Error22004 = 'Label specification for windrose directions must have 16 values (one for each compass direction).';
    const Error22005 = 'Line style for radial lines must be on of ("solid","dotted","dashed","longdashed") ';
    const Error22006 = 'Illegal windrose type specified.';
    const Error22007 = 'To few values for the range legend.';
    const Error22008 = 'Internal error: Trying to plot free Windrose even though type is not a free windrose';
    const Error22009 = 'You have specified the same direction twice, once with an angle and once with a compass direction (%f degrees)';
    const Error22010 = 'Direction must either be a numeric value or one of the 16 compass directions';
    const Error22011 = 'Windrose index must be numeric or direction label. You have specified index=%d';
    const Error22012 = 'Windrose radial axis specification contains a direction which is not enabled.';
    const Error22013 = 'You have specified the look&feel for the same compass direction twice, once with text and once with index (Index=%d)';
    const Error22014 = 'Index for compass direction must be between 0 and 15.';
    const Error22015 = 'You have specified an undefined Windrose plot type.';
    const Error22016 = 'Windrose leg index must be numeric or direction label.';
    const Error22017 = 'Windrose data contains a direction which is not enabled. Please adjust what labels are displayed.';
    const Error22018 = 'You have specified data for the same compass direction twice, once with text and once with index (Index=%d)';
    const Error22019 = 'Index for direction must be between 0 and 15. You can\'t specify angles for a Regular Windplot, only index and compass directions.';
    const Error22020 = 'Windrose plot is too large to fit the specified Graph size. Please use WindrosePlot::SetSize() to make the plot smaller or increase the size of the Graph in the initial WindroseGraph() call.';
    const Error22021 = 'It is only possible to add Text, IconPlot or WindrosePlot to a Windrose Graph';
    const Error23001 = 'This marker "%s" does not exist in color with index: %d';
    const Error23002 = 'Mark color index too large for marker "%s"';
    const Error23003 = 'A filename must be specified if you set the mark type to MARK_IMG.';
    const Error24001 = 'FuncGenerator : No function specified. ';
    const Error24002 = 'FuncGenerator : Syntax error in function specification ';
    const Error24003 = 'DateScaleUtils: Unknown tick type specified in call to GetTicks()';
    const Error24004 = 'ReadCSV2: Column count mismatch in %s line %d';
    const Error25001 = 'This PHP installation is not configured with the GD library. Please recompile PHP with GD support to run JpGraph. (Neither function imagetypes() nor imagecreatefromstring() does exist)';
    const Error25002 = 'Your PHP installation does not seem to have the required GD library. Please see the PHP documentation on how to install and enable the GD library.';
    const Error25003 = 'General PHP error : At %s:%d : %s';
    const Error25004 = 'General PHP error : %s ';
    const Error25005 = 'Can\'t access PHP_SELF, PHP global variable. You can\'t run PHP from command line if you want to use the \'auto\' naming of cache or image files.';

    const Error25007 = 'You are trying to use the locale (%s) which your PHP installation does not support. Hint: Use \'\' to indicate the default locale for this geographic region.';
    const Error25008 = 'Image width/height argument in Graph::Graph() must be numeric';
    const Error25009 = 'You must specify what scale to use with a call to Graph::SetScale()';
    const Error25010 = 'Graph::Add() You tried to add a null plot to the graph.';
    const Error25011 = 'Graph::AddY2() You tried to add a null plot to the graph.';
    const Error25012 = 'Graph::AddYN() You tried to add a null plot to the graph.';
    const Error25013 = 'You can only add standard plots to multiple Y-axis';
    const Error25014 = 'Graph::AddText() You tried to add a null text to the graph.';
    const Error25015 = 'Graph::AddLine() You tried to add a null line to the graph.';
    const Error25016 = 'Graph::AddBand() You tried to add a null band to the graph.';
    const Error25017 = 'You are using GD 2.x and are trying to use a background images on a non truecolor image. To use background images with GD 2.x it is necessary to enable truecolor by setting the USE_TRUECOLOR constant to TRUE. Due to a bug in GD 2.0.1 using any truetype fonts with truecolor images will result in very poor quality fonts.';
    const Error25018 = 'Incorrect file name for Graph::SetBackgroundImage() : "%s" Must have a valid image extension (jpg,gif,png) when using auto detection of image type';
    const Error25019 = 'Unknown file extension (%s) in Graph::SetBackgroundImage() for filename: "%s"';
    const Error25020 = 'Graph::SetScale(): Specified Max value must be larger than the specified Min value.';
    const Error25021 = 'Unknown scale specification for Y-scale. (%s)';
    const Error25022 = 'Unknown scale specification for X-scale. (%s)';
    const Error25023 = 'Unsupported Y2 axis type: "%s" Must be one of (lin,log,int)';
    const Error25024 = 'Unsupported Y axis type:  "%s" Must be one of (lin,log,int)';
    const Error25025 = 'Unsupported Tick density: %d';
    const Error25026 = 'Can\'t draw unspecified Y-scale. You have either: 1. Specified an Y axis for auto scaling but have not supplied any plots. 2. Specified a scale manually but have forgot to specify the tick steps';
    const Error25027 = 'Can\'t open cached CSIM "%s" for reading.';
    const Error25028 = 'Apache/PHP does not have permission to write to the CSIM cache directory (%s). Check permissions.';
    const Error25029 = 'Can\'t write CSIM "%s" for writing. Check free space and permissions.';
    const Error25030 = 'Missing script name in call to StrokeCSIM(). You must specify the name of the actual image script as the first parameter to StrokeCSIM().';
    const Error25031 = 'You must specify what scale to use with a call to Graph::SetScale().';
    const Error25032 = 'No plots for Y-axis nbr:%d';
    const Error25033 = '';
    const Error25034 = 'Can\'t draw unspecified X-scale. No plots specified.';
    const Error25035 = 'You have enabled clipping. Clipping is only supported for graphs at 0 or 90 degrees rotation. Please adjust you current angle (=%d degrees) or disable clipping.';
    const Error25036 = 'Unknown AxisStyle() : %s';
    const Error25037 = 'The image format of your background image (%s) is not supported in your system configuration. ';
    const Error25038 = 'Background image seems to be of different type (has different file extension) than specified imagetype. Specified: %s File: %s';
    const Error25039 = 'Can\'t read background image: "%s"';
    const Error25040 = 'It is not possible to specify both a background image and a background country flag.';
    const Error25041 = 'In order to use Country flags as backgrounds you must include the "jpgraph_flags.php" file.';
    const Error25042 = 'Unknown background image layout';
    const Error25043 = 'Unknown title background style.';
    const Error25044 = 'Cannot use auto scaling since it is impossible to determine a valid min/max value of the Y-axis (only null values).';
    const Error25045 = 'Font families Configs::FF_HANDWRT and Configs::FF_BOOK are no longer available due to copyright problem with these fonts. Fonts can no longer be distributed with JpGraph. Please download fonts from http://corefonts.sourceforge.net/';
    const Error25046 = 'Specified TTF font family (id=%d) is unknown or does not exist. Please note that TTF fonts are not distributed with JpGraph for copyright reasons. You can find the MS TTF WEB-fonts (arial, courier etc) for download at http://corefonts.sourceforge.net/';
    const Error25047 = 'Style %s is not available for font family %s';
    const Error25048 = 'Unknown font style specification [%s].';
    const Error25049 = 'Font file "%s" is not readable or does not exist.';
    const Error25050 = 'First argument to Text::Text() must be a string.';
    const Error25051 = 'Invalid direction specified for text.';
    const Error25052 = 'PANIC: Internal error in SuperScript::Stroke(). Unknown vertical alignment for text';
    const Error25053 = 'PANIC: Internal error in SuperScript::Stroke(). Unknown horizontal alignment for text';
    const Error25054 = 'Internal error: Unknown grid axis %s';
    const Error25055 = 'Axis::SetTickDirection() is deprecated. Use Axis::SetTickSide() instead';
    const Error25056 = 'SetTickLabelMargin() is deprecated. Use Axis::SetLabelMargin() instead.';
    const Error25057 = 'SetTextTicks() is deprecated. Use SetTextTickInterval() instead.';
    const Error25058 = 'Text label interval must be specified >= 1.';
    const Error25059 = 'SetLabelPos() is deprecated. Use Axis::SetLabelSide() instead.';
    const Error25060 = 'Unknown alignment specified for X-axis title. (%s)';
    const Error25061 = 'Unknown alignment specified for Y-axis title. (%s)';
    const Error25062 = 'Labels at an angle are not supported on Y-axis';
    const Error25063 = 'Ticks::SetPrecision() is deprecated. Use Ticks::SetLabelFormat() (or Ticks::SetFormatCallback()) instead';
    const Error25064 = 'Minor or major step size is 0. Check that you haven\'t got an accidental SetTextTicks(0) in your code. If this is not the case you might have stumbled upon a bug in JpGraph. Please report this and if possible include the data that caused the problem';
    const Error25065 = 'Tick positions must be specified as an array()';
    const Error25066 = 'When manually specifying tick positions and labels the number of labels must be the same as the number of specified ticks.';
    const Error25067 = 'Your manually specified scale and ticks is not correct. The scale seems to be too small to hold any of the specified tick marks.';
    const Error25068 = 'A plot has an illegal scale. This could for example be that you are trying to use text auto scaling to draw a line plot with only one point or that the plot area is too small. It could also be that no input data value is numeric (perhaps only \'-\' or \'x\')';
    const Error25069 = 'Grace must be larger then 0';
    const Error25070 = 'Either X or Y data arrays contains non-numeric values. Check that the data is really specified as numeric data and not as strings. It is an error to specify data for example as \'-2345.2\' (using quotes).';
    const Error25071 = 'You have specified a min value with SetAutoMin() which is larger than the maximum value used for the scale. This is not possible.';
    const Error25072 = 'You have specified a max value with SetAutoMax() which is smaller than the minimum value used for the scale. This is not possible.';
    const Error25073 = 'Internal error. Integer scale algorithm comparison out of bound (r=%f)';
    const Error25074 = 'Internal error. The scale range is negative (%f) [for %s scale] This problem could potentially be caused by trying to use \"illegal\" values in the input data arrays (like trying to send in strings or only NULL values) which causes the auto scaling to fail.';
    const Error25075 = 'Can\'t automatically determine ticks since min==max.';
    const Error25077 = 'Adjustment factor for color must be > 0';
    const Error25078 = 'Unknown color: %s';
    const Error25079 = 'Unknown color specification: %s, size=%d';
    const Error25080 = 'Alpha parameter for color must be between 0.0 and 1.0';
    const Error25081 = 'Selected graphic format is either not supported or unknown [%s]';
    const Error25082 = 'Illegal sizes specified for width or height when creating an image, (width=%d, height=%d)';
    const Error25083 = 'Illegal image size when copying image. Size for copied to image is 1 pixel or less.';
    const Error25084 = 'Failed to create temporary GD canvas. Possible Out of memory problem.';
    const Error25085 = 'An image can not be created from the supplied string. It is either in a format not supported or the string is representing an corrupt image.';
    const Error25086 = 'You only seem to have GD 1.x installed. To enable Alphablending requires GD 2.x or higher. Please install GD or make sure the constant USE_GD2 is specified correctly to reflect your installation. By default it tries to auto detect what version of GD you have installed. On some very rare occasions it may falsely detect GD2 where only GD1 is installed. You must then set USE_GD2 to false.';
    const Error25087 = 'This PHP build has not been configured with TTF support. You need to recompile your PHP installation with FreeType support.';
    const Error25088 = 'You have a misconfigured GD font support. The call to imagefontwidth() fails.';
    const Error25089 = 'You have a misconfigured GD font support. The call to imagefontheight() fails.';
    const Error25090 = 'Unknown direction specified in call to StrokeBoxedText() [%s]';
    const Error25091 = 'Internal font does not support drawing text at arbitrary angle. Use TTF fonts instead.';
    const Error25092 = 'There is either a configuration problem with TrueType or a problem reading font file "%s" Make sure file exists and is in a readable place for the HTTP process. (If \'basedir\' restriction is enabled in PHP then the font file must be located in the document root.). It might also be a wrongly installed FreeType library. Try upgrading to at least FreeType 2.1.13 and recompile GD with the correct setup so it can find the new FT library.';
    const Error25093 = 'Can not read font file "%s" in call to Image::GetBBoxTTF. Please make sure that you have set a font before calling this method and that the font is installed in the TTF directory.';
    const Error25094 = 'Direction for text most be given as an angle between 0 and 90.';
    const Error25095 = 'Unknown font font family specification. ';
    const Error25096 = 'Can\'t allocate any more colors in palette image. Image has already allocated maximum of %d colors and the palette  is now full. Change to a truecolor image instead';
    const Error25097 = 'Color specified as empty string in PushColor().';
    const Error25098 = 'Negative Color stack index. Unmatched call to PopColor()';
    const Error25099 = 'Parameters for brightness and Contrast out of range [-1,1]';
    const Error25100 = 'Problem with color palette and your GD setup. Please disable anti-aliasing or use GD2 with true-color. If you have GD2 library installed please make sure that you have set the USE_GD2 constant to true and truecolor is enabled.';
    const Error25101 = 'Illegal numeric argument to SetLineStyle(): (%d)';
    const Error25102 = 'Illegal string argument to SetLineStyle(): %s';
    const Error25103 = 'Illegal argument to SetLineStyle %s';
    const Error25104 = 'Unknown line style: %s';
    const Error25105 = 'NULL data specified for a filled polygon. Check that your data is not NULL.';
    const Error25106 = 'Image::FillToBorder : Can not allocate more colors';
    const Error25107 = 'Can\'t write to file "%s". Check that the process running PHP has enough permission.';
    const Error25108 = 'Can\'t stream image. This is most likely due to a faulty PHP/GD setup. Try to recompile PHP and use the built-in GD library that comes with PHP.';
    const Error25109 = 'Your PHP (and GD-lib) installation does not appear to support any known graphic formats. You need to first make sure GD is compiled as a module to PHP. If you also want to use JPEG images you must get the JPEG library. Please see the PHP docs for details.';
    const Error25110 = 'Your PHP installation does not support the chosen graphic format: %s';
    const Error25111 = 'Can\'t delete cached image %s. Permission problem?';
    const Error25112 = 'Cached imagefile (%s) has file date in the future.';
    const Error25113 = 'Can\'t delete cached image "%s". Permission problem?';
    const Error25114 = 'PHP has not enough permissions to write to the cache file "%s". Please make sure that the user running PHP has write permission for this file if you wan to use the cache system with JpGraph.';
    const Error25115 = 'Can\'t set permission for cached image "%s". Permission problem?';
    const Error25116 = 'Cant open file from cache "%s"';
    const Error25117 = 'Can\'t open cached image "%s" for reading.';
    const Error25118 = 'Can\'t create directory "%s". Make sure PHP has write permission to this directory.';
    const Error25119 = 'Can\'t set permissions for "%s". Permission problems?';
    const Error25120 = 'Position for legend must be given as percentage in range 0-1';
    const Error25121 = 'Empty input data array specified for plot. Must have at least one data point.';
    const Error25122 = 'Stroke() must be implemented by concrete subclass to class Plot';
    const Error25123 = 'You can\'t use a text X-scale with specified X-coords. Use a "int" or "lin" scale instead.';
    const Error25124 = 'The input data array must have consecutive values from position 0 and forward. The given y-array starts with empty values (NULL)';
    const Error25125 = 'Illegal direction for static line';
    const Error25126 = 'Can\'t create truecolor image. Check that the GD2 library is properly setup with PHP.';
    const Error25127 = 'The library has been configured for automatic encoding conversion of Japanese fonts. This requires that PHP has the mb_convert_encoding() function. Your PHP installation lacks this function (PHP needs the "--enable-mbstring" when compiled).';
    const Error25128 = 'The function imageantialias() is not available in your PHP installation. Use the GD version that comes with PHP and not the standalone version.';
    const Error25129 = 'Anti-alias can not be used with dashed lines. Please disable anti-alias or use solid lines.';
    const Error25130 = 'Too small plot area. (%d x %d). With the given image size and margins there is to little space left for the plot. Increase the plot size or reduce the margins.';
    const Error25131 = 'StrokeBoxedText2() only supports TTF fonts and not built-in bitmap fonts.';
    const Error25132 = 'Undefined property %s.';
    const Error25133 = 'Use Graph::SetTheme() after Graph::SetScale().';
    const Error25500 = 'Multibyte strings must be enabled in the PHP installation in order to run the LED module so that the function mb_strlen() is available. See PHP documentation for more information.';
    const Error26000 = 'PDF417: The PDF417 module requires that the PHP installation must support the function bcmod(). This is normally enabled at compile time. See documentation for more information.';
    const Error26001 = 'PDF417: Number of Columns must be >= 1 and <= 30';
    const Error26002 = 'PDF417: Error level must be between 0 and 8';
    const Error26003 = 'PDF417: Invalid format for input data to encode with PDF417';
    const Error26004 = 'PDF417: Can\'t encode given data with error level %d and %d columns since it results in too many symbols or more than 90 rows.';
    const Error26005 = 'PDF417: Can\'t open file "%s" for writing';
    const Error26006 = 'PDF417: Internal error. Data files for PDF417 cluster %d is corrupted.';
    const Error26007 = 'PDF417: Internal error. GetPattern: Illegal Code Value = %d (row=%d)';
    const Error26008 = 'PDF417: Internal error. Mode not found in mode list!! mode=%d';
    const Error26009 = 'PDF417: Encode error: Illegal character. Can\'t encode character with ASCII code=%d';
    const Error26010 = 'PDF417: Internal error: No input data in decode.';
    const Error26011 = 'PDF417: Encoding error. Can\'t use numeric encoding on non-numeric data.';
    const Error26012 = 'PDF417: Internal error. No input data to decode for Binary compressor.';
    const Error26013 = 'PDF417: Internal error. Checksum error. Coefficient tables corrupted.';
    const Error26014 = 'PDF417: Internal error. No data to calculate codewords on.';
    const Error26015 = 'PDF417: Internal error. State transition table entry 0 is NULL. Entry 1 = (%s)';
    const Error26016 = 'PDF417: Internal error: Unrecognized state transition mode in decode.';
    const Error27001 = 'GTextTable: Invalid argument to Set(). Array argument must be 2 dimensional';
    const Error27002 = 'GTextTable: Invalid argument to Set()';
    const Error27003 = 'GTextTable: Wrong number of arguments to GTextTable::SetColor()';
    const Error27004 = 'GTextTable: Specified cell range to be merged is not valid.';
    const Error27005 = 'GTextTable: Cannot merge already merged cells in the range: (%d,%d) to (%d,%d)';
    const Error27006 = 'GTextTable: Column argument = %d is outside specified table size.';
    const Error27007 = 'GTextTable: Row argument = %d is outside specified table size.';
    const Error27008 = 'GTextTable: Column and row size arrays must match the dimensions of the table';
    const Error27009 = 'GTextTable: Number of table columns or rows are 0. Make sure Init() or Set() is called.';
    const Error27010 = 'GTextTable: No alignment specified in call to SetAlign()';
    const Error27011 = 'GTextTable: Unknown alignment specified in SetAlign(). Horizontal=%s, Vertical=%s';
    const Error27012 = 'GTextTable: Internal error. Invalid alignment specified =%s';
    const Error27013 = 'GTextTable: Argument to FormatNumber() must be a string.';
    const Error27014 = 'GTextTable: Table is not initilaized with either a call to Set() or Init()';
    const Error27015 = 'GTextTable: Cell image constrain type must be TIMG_WIDTH or TIMG_HEIGHT';
    const Error28001 = 'Third argument to Contour must be an array of colors.';
    const Error28002 = 'Number of colors must equal the number of isobar lines specified';
    const Error28003 = 'ContourPlot Internal Error: isobarHCrossing: Coloumn index too large (%d)';
    const Error28004 = 'ContourPlot Internal Error: isobarHCrossing: Row index too large (%d)';
    const Error28005 = 'ContourPlot Internal Error: isobarVCrossing: Row index too large (%d)';
    const Error28006 = 'ContourPlot Internal Error: isobarVCrossing: Col index too large (%d)';
    const Error28007 = 'ContourPlot interpolation factor is too large (>5)';
    const Error29201 = 'Min range value must be less or equal to max range value for colormaps';
    const Error29202 = 'The distance between min and max value is too small for numerical precision';
    const Error29203 = 'Number of color quantification level must be at least %d';
    const Error29204 = 'Number of colors (%d) is invalid for this colormap. It must be a number that can be written as: %d + k*%d';
    const Error29205 = 'Colormap specification out of range. Must be an integer in range [0,%d]';
    const Error29206 = 'Invalid object added to MatrixGraph';
    const Error29207 = 'Empty input data specified for MatrixPlot';
    const Error29208 = 'Unknown side specifiction for matrix labels "%s"';
    const Error29209 = 'CSIM Target matrix must be the same size as the data matrix (csim=%d x %d, data=%d x %d)';
    const Error29210 = 'CSIM Target for matrix labels does not match the number of labels (csim=%d, labels=%d)';
    const Error5001 = 'Unknown flag size (%d).';
    const Error5002 = 'Flag index %s does not exist.';
    const Error5003 = 'Invalid ordinal number (%d) specified for flag index.';
    const Error5004 = 'The (partial) country name %s does not have a corresponding flag image. The flag may still exist but under another name, e.g. instead of "usa" try "united states".';
    const Error6001 = 'Internal error. Height for ActivityTitles is < 0';
    const Error6002 = 'You can\'t specify negative sizes for Gantt graph dimensions. Use 0 to indicate that you want the library to automatically determine a dimension.';
    const Error6003 = 'Invalid format for Constrain parameter at index=%d in CreateSimple(). Parameter must start with index 0 and contain arrays of (Row,Constrain-To,Constrain-Type)';
    const Error6004 = 'Invalid format for Progress parameter at index=%d in CreateSimple(). Parameter must start with index 0 and contain arrays of (Row,Progress)';
    const Error6005 = 'SetScale() is not meaningful with Gantt charts.';
    const Error6006 = 'Cannot autoscale Gantt chart. No dated activities exist. [GetBarMinMax() start >= n]';
    const Error6007 = 'Sanity check for automatic Gantt chart size failed. Either the width (=%d) or height (=%d) is larger than MAX_GANTTIMG_SIZE. This could potentially be caused by a wrong date in one of the activities.';
    const Error6008 = 'You have specified a constrain from row=%d to row=%d which does not have any activity';
    const Error6009 = 'Unknown constrain type specified from row=%d to row=%d';
    const Error6010 = 'Illegal icon index for Gantt builtin icon [%d]';
    const Error6011 = 'Argument to IconImage must be string or integer';
    const Error6012 = 'Unknown type in Gantt object title specification';
    const Error6015 = 'Illegal vertical position %d';
    const Error6016 = 'Date string (%s) specified for Gantt activity can not be interpretated. Please make sure it is a valid time string, e.g. 2005-04-23 13:30';
    const Error6017 = 'Unknown date format in GanttScale (%s).';
    const Error6018 = 'Interval for minutes must divide the hour evenly, e.g. 1,5,10,12,15,20,30 etc You have specified an interval of %d minutes.';
    const Error6019 = 'The available width (%d) for minutes are to small for this scale to be displayed. Please use auto-sizing or increase the width of the graph.';
    const Error6020 = 'Interval for hours must divide the day evenly, e.g. 0:30, 1:00, 1:30, 4:00 etc. You have specified an interval of %d';
    const Error6021 = 'Unknown formatting style for week.';
    const Error6022 = 'Gantt scale has not been specified.';
    const Error6023 = 'If you display both hour and minutes the hour interval must be 1 (Otherwise it doesn\'t make sense to display minutes).';
    const Error6024 = 'CSIM Target must be specified as a string. Start of target is: %d';
    const Error6025 = 'CSIM Alt text must be specified as a string. Start of alt text is: %d';
    const Error6027 = 'Progress value must in range [0, 1]';
    const Error6028 = 'Specified height (%d) for gantt bar is out of range.';
    const Error6029 = 'Offset for vertical line must be in range [0,1]';
    const Error6030 = 'Unknown arrow direction for link.';
    const Error6031 = 'Unknown arrow type for link.';
    const Error6032 = 'Internal error: Unknown path type (=%d) specified for link.';
    const Error6033 = 'Array of fonts must contain arrays with 3 elements, i.e. (Family, Style, Size)';

    /**
     * @param mixed $errnbr
     * @param mixed $args
     *
     * @return string
     */
    public static function Get($errnbr, ...$args)
    {
        if (is_string($errnbr)) {
            $errorMessageStr = [$errnbr];
        } else if (!$errorMessageStr = Helper::getErrorMessage($errnbr)) {
            return \sprintf(
                'Internal error: The specified error message (%s) does not exist in the chosen locale (%s)',
                $errnbr,
                Helper::getErrLocale()
            );
        }

        try {
            return \vsprintf($errorMessageStr[0], $args);
        } catch (\Exception $e) {
            return $errorMessageStr[0];
        }
    }

    /**
     * @param mixed $errnbr
     * @param mixed $args
     */
    public static function create($errnbr, ...$args): JpGraphException
    {
        return new JpGraphException(self::Get($errnbr, ...$args));
    }
}
