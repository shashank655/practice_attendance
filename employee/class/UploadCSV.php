<?php
class UploadCSV extends MySQLCN {

    function UploadStudentRecordCSV($data) {
        if($_FILES['CsvData']['name']){
            $arrFileName = explode('.',$_FILES['CsvData']['name']);
            // if($arrFileName[1] != 'csv'){
            //     $_SESSION['Msg'] = "Please upload only CSV extentions files. ";
            //     header('Location: ' . BASE_ROOT.'upload-student-csv.php');
            // }
            /* File Upload */
            $csv_file = $_FILES['CsvData'];
                if(!empty($csv_file['name'])){
                    $imagename=$csv_file['name'];
                    $filename=UPLOAD_CSV_PATH."".time().$imagename;
                    move_uploaded_file($csv_file['tmp_name'],$filename);    
                    }
            echo "done";die;
                /* File Upload */
                    $handle = fopen(UPLOAD_CSV_ROOT."/".$imagename, "r");
                        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                            $item = array();
                                if($data[0] == 'Product Name' || $data[1] == 'Quantity'){
                                    continue;
                                }

                                /* Checking Shopkeeper's name */

                                    $shop_name = $data[2];

                                $shop_out = $this->Shopkeeper->find('first',array('conditions'=>array('Shopkeeper.name'=>$shop_name)));
                                //echo "<pre>";print_r($shop_out);die;

                                if(!empty($shop_out))
                                $shop_id = $shop_out['Shopkeeper']['id'];
                        
                                if(empty($shop_out)){
                                                        
                                    $shop_data['Shopkeeper']['name'] = $shop_name; 
                                        //echo "<pre>";print_r($shop_data);die; 
                                    $this->Shopkeeper->saveAll($shop_data);

                                    $shop_id = $this->Shopkeeper->getLastInsertID();
                                }   

                                /* Checking Shopkeeper's name */

                            /* Checking already filled product */

                                $data_drug_temp = $this->Drug->find('first',array('conditions'=>array('Drug.product_name'=>$data[0],'Drug.quantity'=>$data[1],'Drug.pharmacy_name'=>$data[2],'Drug.amount'=>$data[3])));    
                            
                            //pr($data_drug_temp);die;

                            if(!empty($data_drug_temp)){

                                continue;
                            }   


                            /* Checking already filled product */   

                            $item['shopkeeper_id'] = $shop_id;
                            $item['product_name'] = $data[0];
                            $item['quantity'] = $data[1];
                            $item['pharmacy_name'] = $data[2];
                            $item['amount'] = $data[3];
                            $item['csvfile_status'] = '1';
                            $this->Drug->saveAll($item);
                            
                        }
                        fclose($handle);
                }
        }
    }
?>