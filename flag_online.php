<?php

$semester = 'Fall 2016';
$problems = array();
$account = user_load('1342');

// Courses with section 2xx are online.
$query = db_select('node', 'n');
$query->leftJoin('field_data_field_course_section', 's', 's.entity_id=n.nid');
$query->leftJoin('field_data_field_semester', 'y', 'y.entity_id=n.nid');
$nids = $query->fields('n', array('nid'))
  ->condition('n.type', 'course_section')
  ->condition('s.field_course_section_value', '2%', 'LIKE')
  ->condition('y.field_semester_value', $semester)
  ->execute()
    ->fetchCol();

drush_print(count($nids));

foreach ($nids as $nid) {
  $success = flag('flag', 'course_online', $nid, $account);
  if (!$success) {
  	$problems[] = $nid;
  }
  drush_print($nid);
}

drush_print('problems:');
foreach ($problems as $problem) {
	drush_print($problem);
}
