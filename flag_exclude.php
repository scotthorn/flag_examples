<?php
/* If this needs to be rerun, it needs the value changed for field_course_number_value to 3%, 4%, 5%, etc... */


$semester = 'Fall 2016';
$problems = array();
$account = user_load('1342');

// Exclude 6xx and 7xx from the search (undergrad classes only)
foreach(array('6', '7') as $num) {
  $query = db_select('node', 'n');
  $query->leftJoin('field_data_field_course_number', 'c', 'c.entity_id=n.nid');
  $query->leftJoin('field_data_field_semester', 'y', 'y.entity_id=n.nid');
  $nids = $query->fields('n', array('nid'))
    ->condition('n.type', 'course_section')
    ->condition('c.field_course_number_value', $num . '%', 'LIKE')
    ->condition('y.field_semester_value', $semester)
    ->execute()
    ->fetchCol();

  drush_print(count($nids));
  
  foreach ($nids as $nid) {
    $success = flag('unflag', 'courses_exclude', $nid, $account);
    if (!$success) {
    	$problems[] = $nid;
    }
    drush_print($nid);
  }
}

drush_print('problems:');
foreach ($problems as $problem) {
	drush_print($problem);
}
