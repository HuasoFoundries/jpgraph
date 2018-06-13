<?php

/**
 * JPGraph v3.1.20
 */

// The single error message for all errors
define('DEFAULT_ERROR_MESSAGE', 'We are sorry but the system could not generate the requested image. Please contact site support to resolve this problem. Problem no: #');

// Note: Format of each error message is array(<error message>,<number of arguments>)
$_jpg_messages = [
/*
 ** Headers already sent error. This is formatted as HTML different since this will be sent back directly as text
 */
    10 => ['<table border=1><tr><td><font color=darkred size=4><b>JpGraph Error:</b>
HTTP headers have already been sent.<br>Caused by output from file <b>%s</b> at line <b>%d</b>.</font></td></tr><tr><td><b>Explanation:</b><br>HTTP headers have already been sent back to the browser indicating the data as text before the library got a chance to send it\'s image HTTP header to this browser. This makes it impossible for the library to send back image data to the browser (since that would be interpretated as text by the browser and show up as junk text).<p>Most likely you have some text in your script before the call to <i>Graph::Stroke()</i>. If this texts gets sent back to the browser the browser will assume that all data is plain text. Look for any text, even spaces and newlines, that might have been sent back to the browser. <p>For example it is a common mistake to leave a blank line before the opening "<b>&lt;?php</b>".</td></tr></table>', 2],

    11    => [DEFAULT_ERROR_MESSAGE . '11', 0],
    12    => [DEFAULT_ERROR_MESSAGE . '12', 0],
    13    => [DEFAULT_ERROR_MESSAGE . '13', 0],
    2001  => [DEFAULT_ERROR_MESSAGE . '2001', 0],
    2002  => [DEFAULT_ERROR_MESSAGE . '2002', 0],
    2003  => [DEFAULT_ERROR_MESSAGE . '2003', 0],
    2004  => [DEFAULT_ERROR_MESSAGE . '2004', 0],
    2005  => [DEFAULT_ERROR_MESSAGE . '2005', 0],
    2006  => [DEFAULT_ERROR_MESSAGE . '2006', 0],
    2007  => [DEFAULT_ERROR_MESSAGE . '2007', 0],
    2008  => [DEFAULT_ERROR_MESSAGE . '2008', 0],
    2009  => [DEFAULT_ERROR_MESSAGE . '2009', 0],
    2010  => [DEFAULT_ERROR_MESSAGE . '2010', 0],
    2011  => [DEFAULT_ERROR_MESSAGE . '2011', 0],
    2012  => [DEFAULT_ERROR_MESSAGE . '2012', 0],
    2013  => [DEFAULT_ERROR_MESSAGE . '2013', 0],
    2014  => [DEFAULT_ERROR_MESSAGE . '2014', 0],
    3001  => [DEFAULT_ERROR_MESSAGE . '3001', 0],
    4002  => [DEFAULT_ERROR_MESSAGE . '4002', 0],
    5001  => [DEFAULT_ERROR_MESSAGE . '5001', 0],
    5002  => [DEFAULT_ERROR_MESSAGE . '5002', 0],
    5003  => [DEFAULT_ERROR_MESSAGE . '5003', 0],
    5004  => [DEFAULT_ERROR_MESSAGE . '5004', 0],
    6001  => [DEFAULT_ERROR_MESSAGE . '6001', 0],
    6002  => [DEFAULT_ERROR_MESSAGE . '6002', 0],
    6003  => [DEFAULT_ERROR_MESSAGE . '6003', 0],
    6004  => [DEFAULT_ERROR_MESSAGE . '6004', 0],
    6005  => [DEFAULT_ERROR_MESSAGE . '6005', 0],
    6006  => [DEFAULT_ERROR_MESSAGE . '6006', 0],
    6007  => [DEFAULT_ERROR_MESSAGE . '6007', 0],
    6008  => [DEFAULT_ERROR_MESSAGE . '6008', 0],
    6009  => [DEFAULT_ERROR_MESSAGE . '6009', 0],
    6010  => [DEFAULT_ERROR_MESSAGE . '6010', 0],
    6011  => [DEFAULT_ERROR_MESSAGE . '6011', 0],
    6012  => [DEFAULT_ERROR_MESSAGE . '6012', 0],
    6015  => [DEFAULT_ERROR_MESSAGE . '6015', 0],
    6016  => [DEFAULT_ERROR_MESSAGE . '6016', 0],
    6017  => [DEFAULT_ERROR_MESSAGE . '6017', 0],
    6018  => [DEFAULT_ERROR_MESSAGE . '6018', 0],
    6019  => [DEFAULT_ERROR_MESSAGE . '6019', 0],
    6020  => [DEFAULT_ERROR_MESSAGE . '6020', 0],
    6021  => [DEFAULT_ERROR_MESSAGE . '6021', 0],
    6022  => [DEFAULT_ERROR_MESSAGE . '6022', 0],
    6023  => [DEFAULT_ERROR_MESSAGE . '6023', 0],
    6024  => [DEFAULT_ERROR_MESSAGE . '6024', 0],
    6025  => [DEFAULT_ERROR_MESSAGE . '6025', 0],
    6027  => [DEFAULT_ERROR_MESSAGE . '6027', 0],
    6028  => [DEFAULT_ERROR_MESSAGE . '6028', 0],
    6029  => [DEFAULT_ERROR_MESSAGE . '6029', 0],
    6030  => [DEFAULT_ERROR_MESSAGE . '6030', 0],
    6031  => [DEFAULT_ERROR_MESSAGE . '6031', 0],
    6032  => [DEFAULT_ERROR_MESSAGE . '6032', 0],
    6033  => [DEFAULT_ERROR_MESSAGE . '6033', 0],
    7001  => [DEFAULT_ERROR_MESSAGE . '7001', 0],
    8001  => [DEFAULT_ERROR_MESSAGE . '8001', 0],
    8002  => [DEFAULT_ERROR_MESSAGE . '8002', 0],
    8003  => [DEFAULT_ERROR_MESSAGE . '8003', 0],
    8004  => [DEFAULT_ERROR_MESSAGE . '8004', 0],
    9001  => [DEFAULT_ERROR_MESSAGE . '9001', 0],
    10001 => [DEFAULT_ERROR_MESSAGE . '10001', 0],
    10002 => [DEFAULT_ERROR_MESSAGE . '10002', 0],
    10003 => [DEFAULT_ERROR_MESSAGE . '10003', 0],
    11001 => [DEFAULT_ERROR_MESSAGE . '11001', 0],
    11002 => [DEFAULT_ERROR_MESSAGE . '11002', 0],
    11003 => [DEFAULT_ERROR_MESSAGE . '11003', 0],
    11004 => [DEFAULT_ERROR_MESSAGE . '11004', 0],
    11005 => [DEFAULT_ERROR_MESSAGE . '11005', 0],
    12001 => [DEFAULT_ERROR_MESSAGE . '12001', 0],
    12002 => [DEFAULT_ERROR_MESSAGE . '12002', 0],
    12003 => [DEFAULT_ERROR_MESSAGE . '12003', 0],
    12004 => [DEFAULT_ERROR_MESSAGE . '12004', 0],
    12005 => [DEFAULT_ERROR_MESSAGE . '12005', 0],
    12006 => [DEFAULT_ERROR_MESSAGE . '12006', 0],
    12007 => [DEFAULT_ERROR_MESSAGE . '12007', 0],
    12008 => [DEFAULT_ERROR_MESSAGE . '12008', 0],
    12009 => [DEFAULT_ERROR_MESSAGE . '12009', 0],
    12010 => [DEFAULT_ERROR_MESSAGE . '12010', 0],
    12011 => [DEFAULT_ERROR_MESSAGE . '12011', 0],
    12012 => [DEFAULT_ERROR_MESSAGE . '12012', 0],
    14001 => [DEFAULT_ERROR_MESSAGE . '14001', 0],
    14002 => [DEFAULT_ERROR_MESSAGE . '14002', 0],
    14003 => [DEFAULT_ERROR_MESSAGE . '14003', 0],
    14004 => [DEFAULT_ERROR_MESSAGE . '14004', 0],
    14005 => [DEFAULT_ERROR_MESSAGE . '14005', 0],
    14006 => [DEFAULT_ERROR_MESSAGE . '14006', 0],
    14007 => [DEFAULT_ERROR_MESSAGE . '14007', 0],
    15001 => [DEFAULT_ERROR_MESSAGE . '15001', 0],
    15002 => [DEFAULT_ERROR_MESSAGE . '15002', 0],
    15003 => [DEFAULT_ERROR_MESSAGE . '15003', 0],
    15004 => [DEFAULT_ERROR_MESSAGE . '15004', 0],
    15005 => [DEFAULT_ERROR_MESSAGE . '15005', 0],
    15006 => [DEFAULT_ERROR_MESSAGE . '15006', 0],
    15007 => [DEFAULT_ERROR_MESSAGE . '15007', 0],
    15008 => [DEFAULT_ERROR_MESSAGE . '15008', 0],
    15009 => [DEFAULT_ERROR_MESSAGE . '15009', 0],
    15010 => [DEFAULT_ERROR_MESSAGE . '15010', 0],
    15011 => [DEFAULT_ERROR_MESSAGE . '15011', 0],
    15012 => [DEFAULT_ERROR_MESSAGE . '15012', 0],
    16001 => [DEFAULT_ERROR_MESSAGE . '16001', 0],
    16002 => [DEFAULT_ERROR_MESSAGE . '16002', 0],
    16003 => [DEFAULT_ERROR_MESSAGE . '16003', 0],
    16004 => [DEFAULT_ERROR_MESSAGE . '16004', 0],
    17001 => [DEFAULT_ERROR_MESSAGE . '17001', 0],
    17002 => [DEFAULT_ERROR_MESSAGE . '17002', 0],
    17004 => [DEFAULT_ERROR_MESSAGE . '17004', 0],
    18001 => [DEFAULT_ERROR_MESSAGE . '18001', 0],
    18002 => [DEFAULT_ERROR_MESSAGE . '18002', 0],
    18003 => [DEFAULT_ERROR_MESSAGE . '18003', 0],
    18004 => [DEFAULT_ERROR_MESSAGE . '18004', 0],
    18005 => [DEFAULT_ERROR_MESSAGE . '18005', 0],
    18006 => [DEFAULT_ERROR_MESSAGE . '18006', 0],
    18007 => [DEFAULT_ERROR_MESSAGE . '18007', 0],
    18008 => [DEFAULT_ERROR_MESSAGE . '18008', 0],
    19001 => [DEFAULT_ERROR_MESSAGE . '19001', 0],
    19002 => [DEFAULT_ERROR_MESSAGE . '19002', 0],
    19003 => [DEFAULT_ERROR_MESSAGE . '19003', 0],
    20001 => [DEFAULT_ERROR_MESSAGE . '20001', 0],
    20002 => [DEFAULT_ERROR_MESSAGE . '20002', 0],
    20003 => [DEFAULT_ERROR_MESSAGE . '20003', 0],
    21001 => [DEFAULT_ERROR_MESSAGE . '21001', 0],
    23001 => [DEFAULT_ERROR_MESSAGE . '23001', 0],
    23002 => [DEFAULT_ERROR_MESSAGE . '23002', 0],
    23003 => [DEFAULT_ERROR_MESSAGE . '23003', 0],
    24001 => [DEFAULT_ERROR_MESSAGE . '24001', 0],
    24002 => [DEFAULT_ERROR_MESSAGE . '24002', 0],
    24003 => [DEFAULT_ERROR_MESSAGE . '24003', 0],
    24004 => [DEFAULT_ERROR_MESSAGE . '24004', 0],
    25001 => [DEFAULT_ERROR_MESSAGE . '25001', 0],
    25002 => [DEFAULT_ERROR_MESSAGE . '25002', 0],
    25003 => [DEFAULT_ERROR_MESSAGE . '25003', 0],
    25004 => [DEFAULT_ERROR_MESSAGE . '25004', 0],
    25005 => [DEFAULT_ERROR_MESSAGE . '25005', 0],
    25006 => [DEFAULT_ERROR_MESSAGE . '25006', 0],
    25007 => [DEFAULT_ERROR_MESSAGE . '25007', 0],
    25008 => [DEFAULT_ERROR_MESSAGE . '25008', 0],
    25009 => [DEFAULT_ERROR_MESSAGE . '25009', 0],
    25010 => [DEFAULT_ERROR_MESSAGE . '25010', 0],
    25011 => [DEFAULT_ERROR_MESSAGE . '25011', 0],
    25012 => [DEFAULT_ERROR_MESSAGE . '25012', 0],
    25013 => [DEFAULT_ERROR_MESSAGE . '25013', 0],
    25014 => [DEFAULT_ERROR_MESSAGE . '25014', 0],
    25015 => [DEFAULT_ERROR_MESSAGE . '25015', 0],
    25016 => [DEFAULT_ERROR_MESSAGE . '25016', 0],
    25017 => [DEFAULT_ERROR_MESSAGE . '25017', 0],
    25018 => [DEFAULT_ERROR_MESSAGE . '25018', 0],
    25019 => [DEFAULT_ERROR_MESSAGE . '25019', 0],
    25020 => [DEFAULT_ERROR_MESSAGE . '25020', 0],
    25021 => [DEFAULT_ERROR_MESSAGE . '25021', 0],
    25022 => [DEFAULT_ERROR_MESSAGE . '25022', 0],
    25023 => [DEFAULT_ERROR_MESSAGE . '25023', 0],
    25024 => [DEFAULT_ERROR_MESSAGE . '25024', 0],
    25025 => [DEFAULT_ERROR_MESSAGE . '25025', 0],
    25026 => [DEFAULT_ERROR_MESSAGE . '25026', 0],
    25027 => [DEFAULT_ERROR_MESSAGE . '25027', 0],
    25028 => [DEFAULT_ERROR_MESSAGE . '25028', 0],
    25029 => [DEFAULT_ERROR_MESSAGE . '25029', 0],
    25030 => [DEFAULT_ERROR_MESSAGE . '25030', 0],
    25031 => [DEFAULT_ERROR_MESSAGE . '25031', 0],
    25032 => [DEFAULT_ERROR_MESSAGE . '25032', 0],
    25033 => [DEFAULT_ERROR_MESSAGE . '25033', 0],
    25034 => [DEFAULT_ERROR_MESSAGE . '25034', 0],
    25035 => [DEFAULT_ERROR_MESSAGE . '25035', 0],
    25036 => [DEFAULT_ERROR_MESSAGE . '25036', 0],
    25037 => [DEFAULT_ERROR_MESSAGE . '25037', 0],
    25038 => [DEFAULT_ERROR_MESSAGE . '25038', 0],
    25039 => [DEFAULT_ERROR_MESSAGE . '25039', 0],
    25040 => [DEFAULT_ERROR_MESSAGE . '25040', 0],
    25041 => [DEFAULT_ERROR_MESSAGE . '25041', 0],
    25042 => [DEFAULT_ERROR_MESSAGE . '25042', 0],
    25043 => [DEFAULT_ERROR_MESSAGE . '25043', 0],
    25044 => [DEFAULT_ERROR_MESSAGE . '25044', 0],
    25045 => [DEFAULT_ERROR_MESSAGE . '25045', 0],
    25046 => [DEFAULT_ERROR_MESSAGE . '25046', 0],
    25047 => [DEFAULT_ERROR_MESSAGE . '25047', 0],
    25048 => [DEFAULT_ERROR_MESSAGE . '25048', 0],
    25049 => [DEFAULT_ERROR_MESSAGE . '25049', 0],
    25050 => [DEFAULT_ERROR_MESSAGE . '25050', 0],
    25051 => [DEFAULT_ERROR_MESSAGE . '25051', 0],
    25052 => [DEFAULT_ERROR_MESSAGE . '25052', 0],
    25053 => [DEFAULT_ERROR_MESSAGE . '25053', 0],
    25054 => [DEFAULT_ERROR_MESSAGE . '25054', 0],
    25055 => [DEFAULT_ERROR_MESSAGE . '25055', 0],
    25056 => [DEFAULT_ERROR_MESSAGE . '25056', 0],
    25057 => [DEFAULT_ERROR_MESSAGE . '25057', 0],
    25058 => [DEFAULT_ERROR_MESSAGE . '25058', 0],
    25059 => [DEFAULT_ERROR_MESSAGE . '25059', 0],
    25060 => [DEFAULT_ERROR_MESSAGE . '25060', 0],
    25061 => [DEFAULT_ERROR_MESSAGE . '25061', 0],
    25062 => [DEFAULT_ERROR_MESSAGE . '25062', 0],
    25063 => [DEFAULT_ERROR_MESSAGE . '25063', 0],
    25064 => [DEFAULT_ERROR_MESSAGE . '25064', 0],
    25065 => [DEFAULT_ERROR_MESSAGE . '25065', 0],
    25066 => [DEFAULT_ERROR_MESSAGE . '25066', 0],
    25067 => [DEFAULT_ERROR_MESSAGE . '25067', 0],
    25068 => [DEFAULT_ERROR_MESSAGE . '25068', 0],
    25069 => [DEFAULT_ERROR_MESSAGE . '25069', 0],
    25070 => [DEFAULT_ERROR_MESSAGE . '25070', 0],
    25071 => [DEFAULT_ERROR_MESSAGE . '25071', 0],
    25072 => [DEFAULT_ERROR_MESSAGE . '25072', 0],
    25073 => [DEFAULT_ERROR_MESSAGE . '25073', 0],
    25074 => [DEFAULT_ERROR_MESSAGE . '25074', 0],
    25075 => [DEFAULT_ERROR_MESSAGE . '25075', 0],
    25077 => [DEFAULT_ERROR_MESSAGE . '25077', 0],
    25078 => [DEFAULT_ERROR_MESSAGE . '25078', 0],
    25079 => [DEFAULT_ERROR_MESSAGE . '25079', 0],
    25080 => [DEFAULT_ERROR_MESSAGE . '25080', 0],
    25081 => [DEFAULT_ERROR_MESSAGE . '25081', 0],
    25082 => [DEFAULT_ERROR_MESSAGE . '25082', 0],
    25083 => [DEFAULT_ERROR_MESSAGE . '25083', 0],
    25084 => [DEFAULT_ERROR_MESSAGE . '25084', 0],
    25085 => [DEFAULT_ERROR_MESSAGE . '25085', 0],
    25086 => [DEFAULT_ERROR_MESSAGE . '25086', 0],
    25087 => [DEFAULT_ERROR_MESSAGE . '25087', 0],
    25088 => [DEFAULT_ERROR_MESSAGE . '25088', 0],
    25089 => [DEFAULT_ERROR_MESSAGE . '25089', 0],
    25090 => [DEFAULT_ERROR_MESSAGE . '25090', 0],
    25091 => [DEFAULT_ERROR_MESSAGE . '25091', 0],
    25092 => [DEFAULT_ERROR_MESSAGE . '25092', 0],
    25093 => [DEFAULT_ERROR_MESSAGE . '25093', 0],
    25094 => [DEFAULT_ERROR_MESSAGE . '25094', 0],
    25095 => [DEFAULT_ERROR_MESSAGE . '25095', 0],
    25096 => [DEFAULT_ERROR_MESSAGE . '25096', 0],
    25097 => [DEFAULT_ERROR_MESSAGE . '25097', 0],
    25098 => [DEFAULT_ERROR_MESSAGE . '25098', 0],
    25099 => [DEFAULT_ERROR_MESSAGE . '25099', 0],
    25100 => [DEFAULT_ERROR_MESSAGE . '25100', 0],
    25101 => [DEFAULT_ERROR_MESSAGE . '25101', 0],
    25102 => [DEFAULT_ERROR_MESSAGE . '25102', 0],
    25103 => [DEFAULT_ERROR_MESSAGE . '25103', 0],
    25104 => [DEFAULT_ERROR_MESSAGE . '25104', 0],
    25105 => [DEFAULT_ERROR_MESSAGE . '25105', 0],
    25106 => [DEFAULT_ERROR_MESSAGE . '25106', 0],
    25107 => [DEFAULT_ERROR_MESSAGE . '25107', 0],
    25108 => [DEFAULT_ERROR_MESSAGE . '25108', 0],
    25109 => [DEFAULT_ERROR_MESSAGE . '25109', 0],
    25110 => [DEFAULT_ERROR_MESSAGE . '25110', 0],
    25111 => [DEFAULT_ERROR_MESSAGE . '25111', 0],
    25112 => [DEFAULT_ERROR_MESSAGE . '25112', 0],
    25113 => [DEFAULT_ERROR_MESSAGE . '25113', 0],
    25114 => [DEFAULT_ERROR_MESSAGE . '25114', 0],
    25115 => [DEFAULT_ERROR_MESSAGE . '25115', 0],
    25116 => [DEFAULT_ERROR_MESSAGE . '25116', 0],
    25117 => [DEFAULT_ERROR_MESSAGE . '25117', 0],
    25118 => [DEFAULT_ERROR_MESSAGE . '25118', 0],
    25119 => [DEFAULT_ERROR_MESSAGE . '25119', 0],
    25120 => [DEFAULT_ERROR_MESSAGE . '25120', 0],
    25121 => [DEFAULT_ERROR_MESSAGE . '25121', 0],
    25122 => [DEFAULT_ERROR_MESSAGE . '25122', 0],
    25123 => [DEFAULT_ERROR_MESSAGE . '25123', 0],
    25124 => [DEFAULT_ERROR_MESSAGE . '25124', 0],
    25125 => [DEFAULT_ERROR_MESSAGE . '25125', 0],
    25126 => [DEFAULT_ERROR_MESSAGE . '25126', 0],
    25127 => [DEFAULT_ERROR_MESSAGE . '25127', 0],
    25128 => [DEFAULT_ERROR_MESSAGE . '25128', 0],
    25129 => [DEFAULT_ERROR_MESSAGE . '25129', 0],
    25130 => [DEFAULT_ERROR_MESSAGE . '25130', 0],
    25131 => [DEFAULT_ERROR_MESSAGE . '25131', 0],
    25132 => [DEFAULT_ERROR_MESSAGE . '25132', 0],
    25133 => [DEFAULT_ERROR_MESSAGE . '25133', 0],
    25500 => [DEFAULT_ERROR_MESSAGE . '25500', 0],
    24003 => [DEFAULT_ERROR_MESSAGE . '24003', 0],
    24004 => [DEFAULT_ERROR_MESSAGE . '24004', 0],
    24005 => [DEFAULT_ERROR_MESSAGE . '24005', 0],
    24006 => [DEFAULT_ERROR_MESSAGE . '24006', 0],
    24007 => [DEFAULT_ERROR_MESSAGE . '24007', 0],
    24008 => [DEFAULT_ERROR_MESSAGE . '24008', 0],
    24009 => [DEFAULT_ERROR_MESSAGE . '24009', 0],
    24010 => [DEFAULT_ERROR_MESSAGE . '24010', 0],
    24011 => [DEFAULT_ERROR_MESSAGE . '24011', 0],
    24012 => [DEFAULT_ERROR_MESSAGE . '24012', 0],
    24013 => [DEFAULT_ERROR_MESSAGE . '24013', 0],
    24014 => [DEFAULT_ERROR_MESSAGE . '24014', 0],
    24015 => [DEFAULT_ERROR_MESSAGE . '24015', 0],
    22001 => [DEFAULT_ERROR_MESSAGE . '22001', 0],
    22002 => [DEFAULT_ERROR_MESSAGE . '22002', 0],
    22004 => [DEFAULT_ERROR_MESSAGE . '22004', 0],
    22005 => [DEFAULT_ERROR_MESSAGE . '22005', 0],
    22006 => [DEFAULT_ERROR_MESSAGE . '22006', 0],
    22007 => [DEFAULT_ERROR_MESSAGE . '22007', 0],
    22008 => [DEFAULT_ERROR_MESSAGE . '22008', 0],
    22009 => [DEFAULT_ERROR_MESSAGE . '22009', 0],
    22010 => [DEFAULT_ERROR_MESSAGE . '22010', 0],
    22011 => [DEFAULT_ERROR_MESSAGE . '22011', 0],
    22012 => [DEFAULT_ERROR_MESSAGE . '22012', 0],
    22013 => [DEFAULT_ERROR_MESSAGE . '22013', 0],
    22014 => [DEFAULT_ERROR_MESSAGE . '22014', 0],
    22015 => [DEFAULT_ERROR_MESSAGE . '22015', 0],
    22016 => [DEFAULT_ERROR_MESSAGE . '22016', 0],
    22017 => [DEFAULT_ERROR_MESSAGE . '22017', 0],
    22018 => [DEFAULT_ERROR_MESSAGE . '22018', 0],
    22019 => [DEFAULT_ERROR_MESSAGE . '22019', 0],
    22020 => [DEFAULT_ERROR_MESSAGE . '22020', 0],
    13001 => [DEFAULT_ERROR_MESSAGE . '13001', 0],
    13002 => [DEFAULT_ERROR_MESSAGE . '13002', 0],
    1001  => [DEFAULT_ERROR_MESSAGE . '1001', 0],
    1002  => [DEFAULT_ERROR_MESSAGE . '1002', 0],
    1003  => [DEFAULT_ERROR_MESSAGE . '1003', 0],
    1004  => [DEFAULT_ERROR_MESSAGE . '1004', 0],
    1005  => [DEFAULT_ERROR_MESSAGE . '1005', 0],
    1006  => [DEFAULT_ERROR_MESSAGE . '1006', 0],
    1007  => [DEFAULT_ERROR_MESSAGE . '1007', 0],
    1008  => [DEFAULT_ERROR_MESSAGE . '1008', 0],
    1009  => [DEFAULT_ERROR_MESSAGE . '1009', 0],
    1010  => [DEFAULT_ERROR_MESSAGE . '1010', 0],
    1011  => [DEFAULT_ERROR_MESSAGE . '1011', 0],
    26000 => [DEFAULT_ERROR_MESSAGE . '26000', 0],
    26001 => [DEFAULT_ERROR_MESSAGE . '26001', 0],
    26002 => [DEFAULT_ERROR_MESSAGE . '26002', 0],
    26003 => [DEFAULT_ERROR_MESSAGE . '26003', 0],
    26004 => [DEFAULT_ERROR_MESSAGE . '26004', 0],
    26005 => [DEFAULT_ERROR_MESSAGE . '26005', 0],
    26006 => [DEFAULT_ERROR_MESSAGE . '26006', 0],
    26007 => [DEFAULT_ERROR_MESSAGE . '26007', 0],
    26008 => [DEFAULT_ERROR_MESSAGE . '26008', 0],
    26009 => [DEFAULT_ERROR_MESSAGE . '26009', 0],
    26010 => [DEFAULT_ERROR_MESSAGE . '26010', 0],
    26011 => [DEFAULT_ERROR_MESSAGE . '26011', 0],
    26012 => [DEFAULT_ERROR_MESSAGE . '26012', 0],
    26013 => [DEFAULT_ERROR_MESSAGE . '26013', 0],
    26014 => [DEFAULT_ERROR_MESSAGE . '26014', 0],
    26015 => [DEFAULT_ERROR_MESSAGE . '26015', 0],
    26016 => [DEFAULT_ERROR_MESSAGE . '26016', 0],

    27001 => [DEFAULT_ERROR_MESSAGE . '27001', 0],
    27002 => [DEFAULT_ERROR_MESSAGE . '27002', 0],
    27003 => [DEFAULT_ERROR_MESSAGE . '27003', 0],
    27004 => [DEFAULT_ERROR_MESSAGE . '27004', 0],
    27005 => [DEFAULT_ERROR_MESSAGE . '27005', 0],
    27006 => [DEFAULT_ERROR_MESSAGE . '27006', 0],
    27007 => [DEFAULT_ERROR_MESSAGE . '27007', 0],
    27008 => [DEFAULT_ERROR_MESSAGE . '27008', 0],
    27009 => [DEFAULT_ERROR_MESSAGE . '27009', 0],
    27010 => [DEFAULT_ERROR_MESSAGE . '27010', 0],
    27011 => [DEFAULT_ERROR_MESSAGE . '27011', 0],
    27012 => [DEFAULT_ERROR_MESSAGE . '27012', 0],
    27013 => [DEFAULT_ERROR_MESSAGE . '27013', 0],
    27014 => [DEFAULT_ERROR_MESSAGE . '27014', 0],
    27015 => [DEFAULT_ERROR_MESSAGE . '27015', 0],

    28001 => [DEFAULT_ERROR_MESSAGE . '28001', 0],
    28002 => [DEFAULT_ERROR_MESSAGE . '28002', 0],
    28003 => [DEFAULT_ERROR_MESSAGE . '28003', 0],
    28004 => [DEFAULT_ERROR_MESSAGE . '28004', 0],
    28005 => [DEFAULT_ERROR_MESSAGE . '28005', 0],
    28006 => [DEFAULT_ERROR_MESSAGE . '28006', 0],
    28007 => [DEFAULT_ERROR_MESSAGE . '28007', 0],

    29201 => [DEFAULT_ERROR_MESSAGE . '28001', 0],
    29202 => [DEFAULT_ERROR_MESSAGE . '28002', 0],
    29203 => [DEFAULT_ERROR_MESSAGE . '28003', 0],
    29204 => [DEFAULT_ERROR_MESSAGE . '28004', 0],
    29205 => [DEFAULT_ERROR_MESSAGE . '28005', 0],
    29206 => [DEFAULT_ERROR_MESSAGE . '28006', 0],
    29207 => [DEFAULT_ERROR_MESSAGE . '28007', 0],
    29208 => [DEFAULT_ERROR_MESSAGE . '28008', 0],
    29209 => [DEFAULT_ERROR_MESSAGE . '28009', 0],
    29210 => [DEFAULT_ERROR_MESSAGE . '28010', 0],
];
