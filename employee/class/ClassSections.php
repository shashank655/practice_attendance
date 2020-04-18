<?php
class ClassSections extends MySQLCN {

    function addClasses($data) {
        $result = $this->checkClassIfExists($data);
        if($result) {
            return false;
        }

        $qry = 'INSERT INTO `classes_name`
            (`class_name`)
            VALUES ( "'. $data['className'] . '")';
        $res = $this->insert($qry);
        if ($res) {
            if(!empty($data['addSection'])){
                foreach ($data['addSection'] as $key => $value) {
                    $qry2 = 'INSERT INTO `sections`
                        (`class_id`,`section_name`)
                    VALUES ("'. $res . '", "'. $value . '")';
                    $res2 = $this->insert($qry2);

                        if(!empty($data['subjects_id'])) {
                            $subjectsId = implode(',', $data['subjects_id']);
                            $qry3 = 'INSERT INTO `class_sections_subjects`
                                (`class_id`,`section_id`,`subjects_id`)
                                VALUES ("'. $res . '","'. $res2 . '", "'. $subjectsId . '")';
                            $res3 = $this->insert($qry3);
                        }
                }
            }
            return true;
        } else {
            return false;
        }
    }

    function getClassesLists() {
        $fetch = "SELECT * FROM `classes_name` ";
        $fetch_data = $this->select($fetch);
        $class_data = array();
        $section_string = array();
            foreach ($fetch_data as $key => $value) {
                $class_data[$key]['id'] = $value['id'];
                $class_data[$key]['class_name'] = $value['class_name'];
                $fetch2 = "SELECT * FROM `sections` where class_id = '{$value['id']}'";
                $fetch_data_section = $this->select($fetch2);
                    foreach ($fetch_data_section as $key2 => $value2) {
                        $section_string[]= $value2['section_name'];
                    }
                $class_data[$key]['sections'] = implode(',', $section_string);
                unset($section_string);
            }
        return $class_data;
    }

    function getClassesWithSectionsLists() {
        $fetch = "SELECT * FROM `classes_name` ";
        $fetch_data = $this->select($fetch);
        $class_data = array();
            foreach ($fetch_data as $key => $value) {
                $class_data[$key]['id'] = $value['id'];
                $class_data[$key]['class_name'] = $value['class_name'];
                $fetch2 = "SELECT * FROM `sections` where class_id = '{$value['id']}'";
                $fetch_data_section = $this->select($fetch2);
                $class_data[$key]['sections'] = $fetch_data_section;
            }
        return $class_data;
    }

    function deleteClasses($cId) {
        $qry = "DELETE FROM `classes_name` WHERE id = '{$cId}'";
        $res = $this->deleteData($qry);
        if ($res) {
            $qry2 = "DELETE FROM `sections` WHERE class_id = '{$cId}'";
            $res2 = $this->deleteData($qry2);
            return true;
        } else {
            return false;
        }
    }

    function getClassInfo($id){
        $fetch = "SELECT classes_name.*, sections.*, sections.id as secId FROM `classes_name` left join sections on classes_name.id=sections.class_id where classes_name.id='{$id}' ";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }

    function classInfoUpdate($data){
        $qry = "UPDATE `classes_name` SET
              `class_name` = '{$data['className']}'
               WHERE id = '{$data['classId']}'";
        $res = $this->updateData($qry);
        if ($res) {
            if(!empty($data['addSection'])){

                $qryDel = "DELETE FROM `sections` WHERE class_id = '{$data['classId'] }'";
                $resDel = $this->deleteData($qryDel);

                $qryDel2 = "DELETE FROM `class_sections_subjects` WHERE class_id = '{$data['classId'] }'";
                $resDel2 = $this->deleteData($qryDel2);

                foreach ($data['addSection'] as $key => $value) {
                    if(!empty($data['sectionsIds'][$key])) {
                        $qry2 = 'INSERT INTO `sections`
                            (`id`,`class_id`,`section_name`)
                        VALUES ("'. $data['sectionsIds'][$key] . '","'. $data['classId'] . '", "'. $value . '")';
                        $res2 = $this->insert($qry2);

                        if(!empty($data['subjects_id'])) {
                            $subjectsId = implode(',', $data['subjects_id']);
                            $qry3 = 'INSERT INTO `class_sections_subjects`
                                (`class_id`,`section_id`,`subjects_id`)
                                VALUES ("'. $data['classId'] . '","'. $data['sectionsIds'][$key] . '", "'. $subjectsId . '")';
                            $res3 = $this->insert($qry3);
                        }
                    } else {
                        $qry4 = 'INSERT INTO `sections`
                            (`class_id`,`section_name`)
                        VALUES ("'. $data['classId'] . '", "'. $value . '")';
                        $res4 = $this->insert($qry4);

                        $qry5 = 'INSERT INTO `class_sections_subjects`
                                (`class_id`,`section_id`,`subjects_id`)
                                VALUES ("'. $data['classId'] . '","'. $res4 . '", "'. $subjectsId . '")';
                        $res5 = $this->insert($qry5);
                    }
                }
            }
            return true;
        } else {
            return false;
        }
    }

    function get_subject_ids($secId){
        $fetch = "SELECT * FROM `class_sections_subjects` where section_id='{$secId}' ";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }

    function checkClassIfExists($data) {
        $fetch = "SELECT id FROM `classes_name` where class_name='{$data['className']}' ";
        $fetch_data = $this->select($fetch);
        if ($fetch_data != NULL) {
            return true;
        } else {
            return false;
        }
    }
        function getClassSections($class_id) {
            $query = "SELECT * FROM sections WHERE class_id = '$class_id'";

            if (empty( $result = $this->select($query) )) {
                return [];
            }

            return array_map(function ($row) {
                return [
                    'id'      => $row['id'],
                    'section' => $row['section_name'],
                ];
            }, $result);
        }
}
?>
