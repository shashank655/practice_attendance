<?php
class Events extends MySQLCN {

    function eventsLoadData($data) {
        $fetch = "SELECT * FROM events ORDER BY id ";
        $fetch_data = $this->select($fetch);
        foreach($fetch_data as $row)
          {
           $output[] = array(
            'id'   => $row["id"],
            'title'   => $row["title"],
            'start'   => $row["start_event"],
            'end'   => $row["end_event"]
           );
          } 
        return $output;
    }

    function eventsLoadEventsHolidaysData($data) {
        $fetch = "SELECT * FROM events ORDER BY id ";
        $fetch_data = $this->select($fetch);
        $fetch_holiday = "SELECT * FROM holidays ORDER BY id ";
        $fetch_data_holiday = $this->select($fetch_holiday);

        echo "<pre>";print_r($fetch_data);die;
    }

    function eventsInsertData($data) {
        $qry = 'INSERT INTO `events` 
            (`title`,`start_event`,`end_event`) 
            VALUES ( "'. $data['title'] . '", "'. $data['start'] . '", "'. $data['end'] . '")';
        $res = $this->insert($qry);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function eventsInsertFormData($data) {
      $startDate = explode('/', $data['start']);
      $sdate  = date('Y-m-d H:i:s', strtotime(implode('-', array_reverse($startDate))));
      $edate = date('Y-m-d H:i:s', strtotime($sdate . ' +1 day'));
        $qry = 'INSERT INTO `events` 
            (`title`,`start_event`,`end_event`) 
            VALUES ( "'. $data['title'] . '", "'. $sdate . '", "'. $edate . '")';
        $res = $this->insert($qry);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function updateEvent($data) {
        $qry = "UPDATE `events` SET
              `title` = '{$data['title']}', 
              `start_event` = '{$data['start']}', 
              `end_event` = '{$data['end']}'
               WHERE id = '{$data['id']}'";
        $res = $this->updateData($qry);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function eventDelete($Id) {
        $qry = "DELETE FROM `events` WHERE id = '{$Id}'";
        $res = $this->deleteData($qry);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }    
}
?>