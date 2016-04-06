<?php

$semester = 'Fall 2016';

/*  
 *  The list of course prefix+numbers that satisfy each
 *  UK Core requirement. Provided as 2-col excel from admin.
 */

$raw = "ACR,A-S 102
ACR,CME 455
ACR,A-S 103
ACR,A-S 200
ACR,A-S 380
ACR,EE 101
ACR,MNG 592
ACR,ME 411
ACR,A-S 130
ACR,A-S 280
ACR,TA 120
ACR,TAD 140
ACR,A-E 120
ACR,TA 110
ACR,UKC 300
ACR,UKC 100
ACR,UKC 101
ACR,A-S 245
ACR,TA 370
ACR,A-S 270
ACR,MUS 123
ACR,ENG 107
ACR,MUS 200
ACR,PLS 240
ACR,GEO 109
CC1,CIS 110
CC1,WRD 110
CC2,CIS 111
CC2,WRD 111
CC2,UKC 150
CCC,HIS 108
CCC,HIS 109
CCC,PHI 130
CCC,PS 101
CCC,PHI 335
CCC,HIS 261
CCC,APP 200
CCC,GEO 320
CCC,SOC 235
CCC,EPE 301
CCC,GEN 100
CCC,ANT 221
CCC,AAS 261
CCC,AAS 235
CCC,COM 315
CCC,SOC 360
CCC,CLD 360
CCC,GEO 220
CCC,GWS 301
CCC,A-H 360
CCC,UKC 180
CCC,UKC 380
CCC,GEO 221
CCC,ENG 191
CCC,UKC 181
CCC,COM 312
CCC,GRN 250
GDY,ANT 241
GDY,HIS 105
GDY,HIS 202
GDY,HIS 203
GDY,HIS 208
GDY,HIS 296
GDY,LAS 201
GDY,PS 210
GDY,GER 361
GDY,GEO 222
GDY,PHI 343
GDY,ANT 160
GDY,ANT 242
GDY,ANT 321
GDY,GEO 160
GDY,GEO 260
GDY,MUS 330
GDY,SOC 380
GDY,HIS 206
GDY,JPN 321
GDY,JPN 320
GDY,A-H 104
GDY,RUS 370
GDY,RUS 271
GDY,SAG 201
GDY,ANT 311
GDY,CLD 380
GDY,GEO 162
GDY,GEO 255
GDY,CHI 331
GDY,HIS 208
GDY,ANT 225
GDY,HIS 121
GDY,ANT 329
GDY,GWS 302
GDY,GER 342
GDY,GEO 164
GDY,RUS 125
GDY,ANT 222
GDY,GEO 163
GDY,GEO 261
GDY,PLS 103
GDY,SOC 180
GDY,A-H 311
GDY,ENG 181
GDY,EGR 240
GDY,HIS 122
HUM,CLA 229
HUM,CLA 230
HUM,ENG 264
HUM,ENG 281
HUM,HIS 104
HUM,HIS 105
HUM,HIS 202
HUM,HIS 203
HUM,HIS 229
HUM,HIS 230
HUM,PHI 100
HUM,A-H 105
HUM,A-H 106
HUM,MUS 100
HUM,A-H 334
HUM,AAS 264
HUM,CLA 135
HUM,GER 103
HUM,ARC 314
HUM,ENG 230
HUM,ENG 234
HUM,FR 103
HUM,RUS 270
HUM,SPA 371
HUM,SPA 372
HUM,GWS 201
HUM,TA 171
HUM,TA 271
HUM,TA 273
HUM,TA 274
HUM,CHI 330
HUM,CHI 331
HUM,HIS 121
HUM,GER 105
HUM,EGR 201
HUM,RUS 125
HUM,ID 161
HUM,ID 162
HUM,A-H 101
HUM,UKC 310
HUM,MCL 100
HUM,ENG 191
HUM,CLA 191
NPM,AST 191
NPM,BIO 102
NPM,BIO 103
NPM,CHE 101
NPM,PHY 211
NPM,PHY 231
NPM,PHY 241
NPM,CHE 105
NPM,ENT 110
NPM,GEO 130
NPM,PLS 104
NPM,EES 110
NPM,EES 120
NPM,ANT 230
NPM,EES 150
NPM,ARC 333
NPM,PHY 120
NPM,CHE 111
NPM,GEO 135
NPM,UKC 121
NPM,ABT 120
QFO,MA 113
QFO,MA 123
QFO,PHI 120
QFO,MA 111
QFO,MA 137
QFO,EES 151
QFO,EES 185
SIR,PSY 215
SIR,PSY 216
SIR,BAE 202
SIR,STA 210
SSC,COM 101
SSC,SOC 101
SSC,PSY 100
SSC,PS 235
SSC,ECO 101
SSC,GEO 172
SSC,ANT 101
SSC,CPH 201
SSC,CLD 102
SSC,GWS 200
SSC,ANT 102
SSC,UKC 130
SSC,UKC 131
SSC,COM 311
SSC,COM 313
SSC,COM 314 ";

$core = array(
  'ACR' => 'arts_creativity',
  'CC1' => 'composition_communications_i',
  'CC2' => 'composition_communication_ii',
  'CCC' => 'ccc',
  'GDY' => 'global_dynamics',
  'HUM' => 'courses_humanities',
  'NPM' => 'courses_natural_sciences',
  'QFO' => 'quantitative_foundations',
  'SIR' => 'statistical_inferential_reasonin',
  'SSC' => 'courses_social_sciences',

  );

$data = explode("\n", $raw);
unset($raw);
$problems = array();
$account = user_load('1342');

foreach ($data as $line) {
  drush_print($line);

  $parts = explode(',', $line);
  $flag = $core[$parts[0]];
  $course_parts = explode(' ', trim($parts[1]));
  $prefix = $course_parts[0];
  $course = $course_parts[1];

  $query = db_select('node', 'n');
  $query->leftJoin('field_data_field_course_prefix', 'p', 'p.entity_id=n.nid');
  $query->leftJoin('field_data_field_course_number', 'c', 'c.entity_id=n.nid');
  $query->leftJoin('field_data_field_semester', 'y', 'y.entity_id=n.nid');
  $nids = $query->fields('n', array('nid'))
    ->condition('n.type', 'course_section')
    ->condition('p.field_course_prefix_value', $prefix)
    ->condition('c.field_course_number_value', $course)
    ->condition('y.field_semester_value', $semester)
    ->execute()
    ->fetchCol();

 drush_print(implode(', ', $nids));

  foreach ($nids as $nid) {
    $success = flag('flag', $flag, $nid, $account);
    if (!$success) {
      $problems[] = $line . ' ::: ' . $nid;
    }
    drush_print(implode(' - ', array($prefix, $course, $nid)));
  }
}

foreach ($problems as $problem) {
  drush_print($problem);
}
