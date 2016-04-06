<?php

$semester = 'Fall 2016';

// Prefixes and numbers in each that satisfy the language req.
$classes = array(
  'AIS' => array(101,102,201,202),
  'CHI' => array(101,102,201,202),
  'CLA' => array(101,102,151,152,201,202,251,252),
  'CSD' => array(220,320,420),
  'FR'  => array(101,102,106,201,202,204),
  'GER' => array(101,102,201,202),
  'HJS' => array(101,102,201,202),
  'ITA' => array(101,102,201,202),
  'JPN' => array(101,102,201,202),
  'RUS' => array(101,102,201,202),
  'SPA' => array(101,102,103,141,142,201,202,203,205,210,211,215,241,242),
  );

$problems = array();
$account = user_load('1342');

foreach ($classes as $prefix => $numbers) {
  $query = db_select('node', 'n');
  $query->leftJoin('field_data_field_course_prefix', 'p', 'p.entity_id=n.nid');
  $query->leftJoin('field_data_field_course_number', 'c', 'c.entity_id=n.nid');
  $query->leftJoin('field_data_field_semester', 'y', 'y.entity_id=n.nid');
  $nids = $query->fields('n', array('nid'))
  ->condition('n.type', 'course_section')
  ->condition('p.field_course_prefix_value', $prefix)
  ->condition('c.field_course_number_value', $numbers, 'IN')
  ->condition('y.field_semester_value', $semester)
  ->execute()
  ->fetchCol();

  drush_print(implode(', ', $nids));

  foreach ($nids as $nid) {
    $success = flag('flag', 'courses_language', $nid, $account);
    if (!$success) {
      $problems[] = $line . ' ::: ' . $nid;
    }
    drush_print(implode(' - ', array($prefix, $course, $nid)));
  }
}

foreach ($problems as $problem) {
  drush_print($problem);
}
