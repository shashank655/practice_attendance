<?php
class GlobalNews extends MySQLCN {

    function AddNews($data) {
        $fetch = "UPDATE global_news set news='{$data['global_news']}' where id='1' ";
        $res = $this->updateData($fetch);
        if ($res) {
            return true;    
        } else {
            return false;
        }
    }

    function getGlobalNews() {
        $fetch = "SELECT * FROM `global_news`";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }    
}
?>