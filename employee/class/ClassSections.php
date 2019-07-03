<?php
class ClassSections extends MySQLCN {

    function addClasses($data) {
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
        $fetch = "SELECT * FROM `classes_name` left join sections on classes_name.id=sections.class_id where classes_name.id='{$id}' ";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }

    function classInfoUpdate($data){
        $qry = "UPDATE `classes_name` SET
              `class_name` = '{$data['className']}'
               WHERE id = '{$data['classId']}'";
        $res = $this->updateData($qry);
        if ($res) {
            $qry2 = "DELETE FROM `sections` WHERE class_id = '{$data['classId']}'";
            $res2 = $this->deleteData($qry2);
            if(!empty($data['addSection'])){
                foreach ($data['addSection'] as $key => $value) {
                    $qry3 = 'INSERT INTO `sections` 
                        (`class_id`,`section_name`) 
                    VALUES ("'. $data['classId'] . '", "'. $value . '")';
                    $res3 = $this->insert($qry3);
                }
            }
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
