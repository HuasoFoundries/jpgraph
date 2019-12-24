<?php
// Deafult graphic format set to 'auto' which will automatically
// choose the best available format in the order png,gif,jpeg
// (The supported format depends on what your PHP installation supports)
define('DEFAULT_GFORMAT', 'auto');
// The builtin GD function imagettfbbox() fuction which calculates the bounding box for
// text using TTF fonts is buggy. By setting this define to true the library
// uses its own compensation for this bug. However this will give a
// slightly different visual apparance than not using this compensation.
// Enabling this compensation will in general give text a bit more space to more
// truly reflect the actual bounding box which is a bit larger than what the
// GD function thinks.
define('USE_LIBRARY_IMAGETTFBBOX', true);

// Constants for types of static bands in plot area
define('BAND_RDIAG', 1); // Right diagonal lines
define('BAND_LDIAG', 2); // Left diagonal lines
define('BAND_SOLID', 3); // Solid one color
define('BAND_VLINE', 4); // Vertical lines
define('BAND_HLINE', 5); // Horizontal lines
define('BAND_3DPLANE', 6); // "3D" Plane
define('BAND_HVCROSS', 7); // Vertical/Hor crosses
define('BAND_DIAGCROSS', 8); // Diagonal crosses

// Maximum size for Automatic Gantt chart
define('MAX_GANTTIMG_SIZE_W', 8000);
define('MAX_GANTTIMG_SIZE_H', 5000);

// Scale Header types
define('GANTT_HDAY', 1);
define('GANTT_HWEEK', 2);
define('GANTT_HMONTH', 4);
define('GANTT_HYEAR', 8);
define('GANTT_HHOUR', 16);
define('GANTT_HMIN', 32);

// Bar patterns
define('GANTT_RDIAG', BAND_RDIAG); // Right diagonal lines
define('GANTT_LDIAG', BAND_LDIAG); // Left diagonal lines
define('GANTT_SOLID', BAND_SOLID); // Solid one color
define('GANTT_VLINE', BAND_VLINE); // Vertical lines
define('GANTT_HLINE', BAND_HLINE); // Horizontal lines
define('GANTT_3DPLANE', BAND_3DPLANE); // "3D" Plane
define('GANTT_HVCROSS', BAND_HVCROSS); // Vertical/Hor crosses
define('GANTT_DIAGCROSS', BAND_DIAGCROSS); // Diagonal crosses

// Conversion constant
define('HOURADJ_1', 0 + 30);
define('HOURADJ_2', 1 + 30);
define('HOURADJ_3', 2 + 30);
define('HOURADJ_4', 3 + 30);
define('HOURADJ_6', 4 + 30);
define('HOURADJ_12', 5 + 30);

define('MINADJ_1', 0 + 20);
define('MINADJ_5', 1 + 20);
define('MINADJ_10', 2 + 20);
define('MINADJ_15', 3 + 20);
define('MINADJ_30', 4 + 20);

define('SECADJ_1', 0);
define('SECADJ_5', 1);
define('SECADJ_10', 2);
define('SECADJ_15', 3);
define('SECADJ_30', 4);

define('YEARADJ_1', 0 + 30);
define('YEARADJ_2', 1 + 30);
define('YEARADJ_5', 2 + 30);

define('MONTHADJ_1', 0 + 20);
define('MONTHADJ_6', 1 + 20);

define('DAYADJ_1', 0);
define('DAYADJ_WEEK', 1);
define('DAYADJ_7', 1);

define('SECPERYEAR', 31536000);
define('SECPERDAY', 86400);
define('SECPERHOUR', 3600);
define('SECPERMIN', 60);

// Layout of bars
define('GANTT_EVEN', 1);
define('GANTT_FROMTOP', 2);

// Style for minute header
define('MINUTESTYLE_MM', 0); // 15
define('MINUTESTYLE_CUSTOM', 2); // Custom format

// Style for hour header
define('HOURSTYLE_HM24', 0); // 13:10
define('HOURSTYLE_HMAMPM', 1); // 1:10pm
define('HOURSTYLE_H24', 2); // 13
define('HOURSTYLE_HAMPM', 3); // 1pm
define('HOURSTYLE_CUSTOM', 4); // User defined

// Style for day header
define('DAYSTYLE_ONELETTER', 0); // "M"
define('DAYSTYLE_LONG', 1); // "Monday"
define('DAYSTYLE_LONGDAYDATE1', 2); // "Monday 23 Jun"
define('DAYSTYLE_LONGDAYDATE2', 3); // "Monday 23 Jun 2003"
define('DAYSTYLE_SHORT', 4); // "Mon"
define('DAYSTYLE_SHORTDAYDATE1', 5); // "Mon 23/6"
define('DAYSTYLE_SHORTDAYDATE2', 6); // "Mon 23 Jun"
define('DAYSTYLE_SHORTDAYDATE3', 7); // "Mon 23"
define('DAYSTYLE_SHORTDATE1', 8); // "23/6"
define('DAYSTYLE_SHORTDATE2', 9); // "23 Jun"
define('DAYSTYLE_SHORTDATE3', 10); // "Mon 23"
define('DAYSTYLE_SHORTDATE4', 11); // "23"
define('DAYSTYLE_CUSTOM', 12); // "M"

// Styles for week header
define('WEEKSTYLE_WNBR', 0);
define('WEEKSTYLE_FIRSTDAY', 1);
define('WEEKSTYLE_FIRSTDAY2', 2);
define('WEEKSTYLE_FIRSTDAYWNBR', 3);
define('WEEKSTYLE_FIRSTDAY2WNBR', 4);

// Styles for month header
define('MONTHSTYLE_SHORTNAME', 0);
define('MONTHSTYLE_LONGNAME', 1);
define('MONTHSTYLE_LONGNAMEYEAR2', 2);
define('MONTHSTYLE_SHORTNAMEYEAR2', 3);
define('MONTHSTYLE_LONGNAMEYEAR4', 4);
define('MONTHSTYLE_SHORTNAMEYEAR4', 5);
define('MONTHSTYLE_FIRSTLETTER', 6);

// Types of constrain links
define('CONSTRAIN_STARTSTART', 0);
define('CONSTRAIN_STARTEND', 1);
define('CONSTRAIN_ENDSTART', 2);
define('CONSTRAIN_ENDEND', 3);

// Arrow direction for constrain links
define('ARROW_DOWN', 0);
define('ARROW_UP', 1);
define('ARROW_LEFT', 2);
define('ARROW_RIGHT', 3);

// Arrow type for constrain type
define('ARROWT_SOLID', 0);
define('ARROWT_OPEN', 1);

// Arrow size for constrain lines
define('ARROW_S1', 0);
define('ARROW_S2', 1);
define('ARROW_S3', 2);
define('ARROW_S4', 3);
define('ARROW_S5', 4);

// Activity types for use with utility method CreateSimple()
define('ACTYPE_NORMAL', 0);
define('ACTYPE_GROUP', 1);
define('ACTYPE_MILESTONE', 2);

define('ACTINFO_3D', 1);
define('ACTINFO_2D', 0);

define('GICON_WARNINGRED', 0);
define('GICON_TEXT', 1);
define('GICON_ENDCONS', 2);
define('GICON_MAIL', 3);
define('GICON_STARTCONS', 4);
define('GICON_CALC', 5);
define('GICON_MAGNIFIER', 6);
define('GICON_LOCK', 7);
define('GICON_STOP', 8);
define('GICON_WARNINGYELLOW', 9);
define('GICON_FOLDEROPEN', 10);
define('GICON_FOLDER', 11);
define('GICON_TEXTIMPORTANT', 12);
