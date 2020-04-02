<?php

require_once __DIR__ . '/Database.php';

class Accounts extends Databse
{
    public function notFound($message = null)
    {
        if (!$message) $message = '<h1>Not Found</h1><p>The requested URL was not found on this server.</p>';

        if (DEBUG) throw new Exception($message, 404);

        die($message);
    }

    public function calculateDiscount($amount, $discount_type, $discount_value)
    {
        $discount = 0;
        if ($discount_type === 'fixed') {
            $discount = $discount_value;
        }

        if ($discount_type === 'percentage') {
            $discount = $amount * $discount_value / 100;
        }
        return ($discount < $amount) ? $discount : 0;
    }

    public function getClasses()
    {
        return $this->select('classes_name');
    }

    public function getSections()
    {
        return $this->select('sections');
    }

    public function getFeeHeadsWithClass()
    {
        return $this->select(
            'fee_heads as fh',
            [
                'fh.*',
                'c.class_name',
                '(SELECT SUM(amount) FROM fee_head_items as fhi WHERE fhi.fee_head_id = fh.id) as amount',
                '(SELECT SUM(discount) FROM fee_head_items as fhi WHERE fhi.fee_head_id = fh.id) as discount',
                '(SELECT SUM(total) FROM fee_head_items as fhi WHERE fhi.fee_head_id = fh.id) as total'
            ],
            [],
            [
                'join' => [
                    'table' => 'classes_name as c',
                    'type' => 'LEFT JOIN',
                    'on' => 'fh.class_id = c.id'
                ]
            ]
        );
    }

    public function getFeeHead($id)
    {
        $fee_head = $this->select('fee_heads', '*', compact('id'));
        if (!$fee_head->success || !$fee_head->count) $this->notFound();

        return $fee_head->results[0];
    }

    public function getFeeHeadByClassId($type, $class_id)
    {
        $fee_head = $this->select('fee_heads', '*', compact('type', 'class_id'));
        if (!$fee_head->success || !$fee_head->count) {
            return new Optional();
        };

        return $fee_head->results[0];
    }

    public function getFeeHeadItems($fee_head_id)
    {
        return $this->select('fee_head_items', '*', compact('fee_head_id'));
    }

    public function addEditFeeHead($request, $id)
    {
        try {
            $data = $this->arrayOnly($request, ['type', 'class_id', 'title']);
            if (is_null($id)) {
                $result = $this->insert('fee_heads', $data);
                $this->setAlert('Fee Head added successfully.');
                $id = $result->insert_id;
            } else {
                $result = $this->update('fee_heads', $data, compact('id'));
                $this->setAlert('Fee Head updated successfully.');
            }

            $fee_head_id = $id;
            $this->delete('fee_head_items', compact('fee_head_id'));

            if (isset($request['items']) && is_array($items = array_values($request['items']))) {
                for ($i = 0; $i < count($items); $i++) {
                    $title = $items[$i]['title'];
                    $amount = $items[$i]['amount'];
                    $discount_type = $items[$i]['discount_type'] ?? null;
                    $discount_value = $items[$i]['discount_value'] ?: 0;
                    $discount = $this->calculateDiscount($amount, $discount_type, $discount_value);
                    $total = $amount - $discount;
                    $this->insert(
                        'fee_head_items',
                        compact('fee_head_id', 'title', 'amount', 'discount_type', 'discount_value', 'discount', 'total')
                    );
                }
            }

            return $result;
        } catch (\Throwable $th) {
            return $this->throwException($th);
        }
    }

    public function getTransportationFees()
    {
        return $this->select('transportation_fees');
    }

    public function getTransportationFee($id)
    {
        $transportation_fee = $this->select('transportation_fees', '*', compact('id'));
        if (!$transportation_fee->success || !$transportation_fee->count) $this->notFound();

        return $transportation_fee->results[0];
    }

    public function getTransportationIfExists($id)
    {
        $transportation_fee = $this->select('transportation_fees', '*', compact('id'));
        if (!$transportation_fee->success || !$transportation_fee->count) return null;

        return $transportation_fee->results[0];
    }

    public function addTransportationFees($request)
    {
        try {
            $type = 'transportation';
            $this->delete('transportation_fees', compact('type'));

            if (isset($request['routeName']) && is_array($request['routeName'])) {
                foreach ($request['routeName'] as $key => $value) {
                    $routeName = $request['routeName'][$key];
                    $addAmount = $request['addAmount'][$key];
                    $this->insert('transportation_fees', compact('routeName', 'addAmount'));
                }
            }
            $this->setAlert('Transportation Fees added successfully.');
        } catch (\Throwable $th) {
            return $this->throwException($th);
        }
    }

    public function getAdmissionFeeList()
    {
        $filters = [
            'class_id' => 'a.class_id = ?',
            'section_id' => 'a.section_id = ?',
            'admission_no' => 'af.admission_no = ?',
            'date_from' => 'af.date >= ?',
            'date_to' => 'af.date <= ?'
        ];

        $where = $this->arrayOnly($_GET, array_keys($filters));

        if (isset($where['date_from'])) $where['date_from'] = $this->date($where['date_from']);
        if (isset($where['date_to'])) $where['date_to'] = $this->date($where['date_to']);

        $query = "SELECT
                    af.id,
                    af.admission_no,
                    a.id as admission_id,
                    CONCAT(a.first_name, ' ', a.last_name) AS student_name,
                    af.due_date,
                    (SELECT SUM(afi.total) FROM admission_fee_items AS afi WHERE afi.admission_fee_id = af.id) AS total,
                    (SELECT SUM(afp.amount) FROM admission_fee_payments AS afp WHERE afp.admission_fee_id = af.id) AS payment
                    FROM admission_fees as af LEFT JOIN admission_form_listing as a ON af.admission_no = a.admission_no";

        if (count($where) > 0) {
            $query .= ' WHERE ' . implode(' AND ', $this->arrayOnly($filters, array_keys($where)));
        }
        return $this->prepareExecute($query, array_values($where));
    }

    public function getAdmissionFee($id)
    {
        $admission_fee = $this->select('admission_fees', '*', compact('id'), ['limit' => 1]);

        if (!$admission_fee->success || !$admission_fee->count) {
            $this->notFound();
        }

        return $admission_fee->results[0];
    }

    public function getAdmissionTotalFee($admission_fee_id)
    {
        $admission_fee_total = $this->select('admission_fee_items', ['SUM(total) as total'], compact('admission_fee_id'));
        return $admission_fee_total->results[0]->total ?: 0;
    }

    public function getAdmissionTotalPayment($admission_fee_id)
    {
        $admission_fee_total = $this->select('admission_fee_payments', ['SUM(amount) as total'], compact('admission_fee_id'));
        return $admission_fee_total->results[0]->total ?: 0;
    }

    public function getAdmissionFeeItems($admission_fee_id)
    {
        return $this->select('admission_fee_items', '*', compact('admission_fee_id'));
    }

    public function getAdmissionFeePayments($admission_fee_id)
    {
        return $this->select('admission_fee_payments', '*', compact('admission_fee_id'));
    }

    public function addEditAdmissionFee($request, $id = null)
    {
        try {
            $data = [
                'admission_no' => urldecode($_GET['admission_no']),
                'date' => $this->date('now'),
                'due_date' => $this->date('+15 days')
            ];

            if (is_null($id)) {
                $result = $this->insert('admission_fees', $data);
                $this->setAlert('Admission Fee added successfully.');
                $id = $result->insert_id;
            } else {
                $result = $this->update('admission_fees', $data, compact('id'));
                $this->setAlert('Admission Fee updated successfully.');
            }

            $admission_fee_id = $id;
            $this->delete('admission_fee_items', compact('admission_fee_id'));

            if (isset($request['items']) && is_array($items = array_values($request['items']))) {
                for ($i = 0; $i < count($items); $i++) {
                    $title = $items[$i]['title'];
                    $amount = $items[$i]['amount'];
                    $discount_type = $items[$i]['discount_type'] ?? null;
                    $discount_value = $items[$i]['discount_value'] ?: 0;
                    $discount = $this->calculateDiscount($amount, $discount_type, $discount_value);
                    $total = $amount - $discount;
                    $this->insert(
                        'admission_fee_items',
                        compact('admission_fee_id', 'title', 'amount', 'discount_type', 'discount_value', 'discount', 'total')
                    );
                }
            }

            return $result;
        } catch (\Throwable $th) {
            return $this->throwException($th);
        }
    }

    public function collectAdmissionFee($request, $admission_fee_id)
    {
        try {
            $admission_fee = $this->getAdmissionFee($admission_fee_id);

            $data = $this->arrayOnly($request, ['amount', 'method', 'comment', 'description']);

            $data['admission_fee_id'] = $admission_fee->id;
            $data['date'] = $this->date('now');
            $data['billing_address'] = serialize($request['billing']);

            $result = $this->insert('admission_fee_payments', $data);

            $admission_total_fee = $this->getAdmissionTotalFee($admission_fee_id);
            $admission_total_payment = $this->getAdmissionTotalPayment($admission_fee_id);

            $updated_due_date = null;
            if ($admission_total_fee > $admission_total_payment) {
                $updated_due_date = $this->date(isset($request['due_date']) ? $request['due_date'] : '+15 days');
            }

            $this->update('admission_fees', ['due_date' => $updated_due_date], ['id' => $admission_fee->id]);
            $this->setAlert('Admission Fee collected successfully.');

            return $result;
        } catch (\Throwable $th) {
            return $this->throwException($th);
        }
    }

    public function getAdmissionByAdmssionNo($admission_no)
    {
        $admission = $this->select(
            'admission_form_listing as afl',
            '*',
            compact('admission_no'),
            [
                'join' => [
                    'table' => 'classes_name as c',
                    'type' => 'LEFT JOIN',
                    'on' => 'afl.class_id = c.id'
                ],
                'limit' => 1
            ]
        );

        if (!$admission->success || !$admission->count) {
            $this->setAlert('danger', 'Admission not found.');
            return new Optional();
        }

        return $admission->results[0];
    }

    public function getStudentsMobileNumberByIds($ids)
    {
        $where = implode(',', array_fill(0, count($ids), '?'));
        $query = 'SELECT parents_mobile_number FROM students WHERE id IN (' . $where . ')';
        $result = $this->prepareExecute($query, $ids);
        if ($result->success && $result->count) {
            return array_map(function ($item) {
                return $item->parents_mobile_number;
            }, $result->results);
        }
        return [];
    }

    public function getAdmissionsMobileNumberByIds($ids)
    {
        $where = implode(',', array_fill(0, count($ids), '?'));
        $query = 'SELECT parents_mobile_number FROM admission_form_listing WHERE id IN (' . $where . ')';
        $result = $this->prepareExecute($query, $ids);
        if ($result->success && $result->count) {
            return array_map(function ($item) {
                return $item->parents_mobile_number;
            }, $result->results);
        }
        return [];
    }

    protected function sendDueFeeReminder($mobilenumbers)
    {
        $message = 'Dear User,' . "\r\n" . 'We would like to inform you that you have fee due.' . "\r\n" . 'We request you to make the payment of the due amount before the due date.';

        try {
            $mobilenumbers = array_map(function ($number) {
                if (strlen($number) == 11 && substr($number, 0, 1) == '0') $number = substr($number, 1, 10);
                if (strlen($number) == 12 && substr($number, 0, 2) == '91') $number = substr($number, 2, 10);
                if (strlen($number) == 13 && substr($number, 0, 3) == '+91') $number = substr($number, 3, 10);
                return $number;
            }, $mobilenumbers);

            $response = MinavoVSMS::bulksms($mobilenumbers, $message);
            if ($response->status === 'success') {
                $this->setAlert('Fee reminder has been sent successfully.');
            } else {
                $this->setAlert('danger', 'Oops! Something went wrong.');
            }
        } catch (\Throwable $th) {
            return $this->throwException($th);
        }
    }

    public function sendMonthlyDueFeeReminder($student_ids)
    {
        return $this->sendDueFeeReminder(
            $this->getStudentsMobileNumberByIds($student_ids)
        );
    }

    public function sendAdmissionDueFeeReminder($admission_ids)
    {
        return $this->sendDueFeeReminder(
            $this->getAdmissionsMobileNumberByIds($admission_ids)
        );
    }

    public function getAdminUser()
    {
        $user = $this->select('users', '*', ['user_role' => 1], ['limit' => 1]);
        if (!$user->success || !$user->count) {
            $this->notFound();
        }

        return $user->results[0];
    }

    public function getMonthlyFeeList()
    {
        $filters = [
            'class_id' => 's.class_id = ?',
            'section_id' => 's.section_id = ?',
            'admission_no' => 'mf.admission_no = ?',
            'date_from' => 'mf.due_date >= ?',
            'date_to' => 'mf.due_date <= ?'
        ];

        $where = $this->arrayOnly($_GET, array_keys($filters));

        if (isset($where['date_from'])) $where['date_from'] = $this->date($where['date_from']);
        if (isset($where['date_to'])) $where['date_to'] = $this->date($where['date_to']);

        $query = "SELECT
                    mf.id,
                    mf.admission_no,
                    s.id as student_id,
                    CONCAT(s.first_name, ' ', s.last_name) AS student_name,
                    mf.due_date,
                    (SELECT SUM(mfi.total) FROM monthly_fee_items AS mfi WHERE mfi.monthly_fee_id = mf.id) AS total,
                    (SELECT SUM(mfp.amount) FROM monthly_fee_payments AS mfp WHERE mfp.monthly_fee_id = mf.id) AS payment
                    FROM monthly_fees as mf LEFT JOIN students as s ON mf.admission_no = s.admission_no";

        if (count($where) > 0) {
            $query .= ' WHERE ' . implode(' AND ', $this->arrayOnly($filters, array_keys($where)));
        }
        return $this->prepareExecute($query, array_values($where));
    }

    public function getStudentByAdmssionNo($admission_no)
    {
        $student = $this->select(
            'students as s',
            '*',
            compact('admission_no'),
            [
                'join' => [
                    'table' => 'classes_name as c',
                    'type' => 'LEFT JOIN',
                    'on' => 's.class_id = c.id'
                ],
                'limit' => 1
            ]
        );

        if (!$student->success || !$student->count) {
            $this->setAlert('danger', 'Student not found.');
            return new Optional();
        }

        return $student->results[0];
    }

    public function addEditMonthlyFee($request, $id)
    {
        try {
            $data = [
                'admission_no' => urldecode($_GET['admission_no']),
                'date' => $this->date('now'),
                'date_from' => $this->date($request['date_from']),
                'date_to' => $this->date($request['date_to']),
                'due_date' => $this->date('+15 days')
            ];

            if (is_null($id)) {
                $result = $this->insert('monthly_fees', $data);
                $this->setAlert('Monthly Fee added successfully.');
                $id = $result->insert_id;
            } else {
                $result = $this->update('monthly_fees', $data, compact('id'));
                $this->setAlert('Monthly Fee updated successfully.');
            }

            $monthly_fee_id = $id;
            $this->delete('monthly_fee_items', compact('monthly_fee_id'));

            if (isset($request['items']) && is_array($items = array_values($request['items']))) {
                for ($i = 0; $i < count($items); $i++) {
                    $title = $items[$i]['title'];
                    $amount = $items[$i]['amount'];
                    $discount_type = $items[$i]['discount_type'] ?? null;
                    $discount_value = $items[$i]['discount_value'] ?: 0;
                    $discount = $this->calculateDiscount($amount, $discount_type, $discount_value);
                    $total = $amount - $discount;
                    $this->insert(
                        'monthly_fee_items',
                        compact('monthly_fee_id', 'title', 'amount', 'discount_type', 'discount_value', 'discount', 'total')
                    );
                }
            }

            return $result;
        } catch (\Throwable $th) {
            return $this->throwException($th);
        }
    }

    public function getMonthlyFee($id)
    {
        $monthly_fee = $this->select('monthly_fees', '*', compact('id'), ['limit' => 1]);

        if (!$monthly_fee->success || !$monthly_fee->count) {
            $this->notFound();
        }

        return $monthly_fee->results[0];
    }


    public function getMonthlyTotalFee($monthly_fee_id)
    {
        $admission_fee_total = $this->select('monthly_fee_items', ['SUM(total) as total'], compact('monthly_fee_id'));
        return $admission_fee_total->results[0]->total ?: 0;
    }

    public function getMonthlyTotalPayment($monthly_fee_id)
    {
        $monthly_fee_total = $this->select('monthly_fee_payments', ['SUM(amount) as total'], compact('monthly_fee_id'));
        return $monthly_fee_total->results[0]->total ?: 0;
    }

    public function getMonthlyFeeItems($monthly_fee_id)
    {
        return $this->select('monthly_fee_items', '*', compact('monthly_fee_id'));
    }

    public function getMonthlyFeePayments($monthly_fee_id)
    {
        return $this->select('monthly_fee_payments', '*', compact('monthly_fee_id'));
    }

    public function collectMonthlyFee($request, $monthly_fee_id)
    {
        try {
            $monthly_fee = $this->getMonthlyFee($monthly_fee_id);

            $data = $this->arrayOnly($request, ['amount', 'method', 'comment', 'description']);

            $data['monthly_fee_id'] = $monthly_fee->id;
            $data['date'] = $this->date('now');
            $data['billing_address'] = serialize($request['billing']);

            $result = $this->insert('monthly_fee_payments', $data);

            $monthly_total_fee = $this->getMonthlyTotalFee($monthly_fee_id);
            $monthly_total_payment = $this->getMonthlyTotalPayment($monthly_fee_id);

            $updated_due_date = null;
            if ($monthly_total_fee > $monthly_total_payment) {
                $updated_due_date = $this->date(isset($request['due_date']) ? $request['due_date'] : '+15 days');
            }

            $this->update('monthly_fees', ['due_date' => $updated_due_date], ['id' => $monthly_fee->id]);
            $this->setAlert('Mmonthly Fee collected successfully.');

            return $result;
        } catch (\Throwable $th) {
            return $this->throwException($th);
        }
    }

    public function getCollectFeeStudentListing($request)
    {
        $where = [];
        $values = [];

        if (isset($request['class_id'])) {
            $where[] = 's.class_id = ?';
            $values[] = $request['class_id'];
        }

        if (isset($request['section_id'])) {
            $where[] = 's.section_id = ?';
            $values[] = $request['section_id'];
        }

        if (isset($request['admission_no'])) {
            $where[] = 's.admission_no = ?';
            $values[] = $request['admission_no'];
        }

        if (isset($request['student_name'])) {
            $where[] = "CONCAT(s.first_name,' ', s.first_name) LIKE ?";
            $values[] = "%{$request['student_name']}%";
        }

        $query = "SELECT
            s.*,
            c.class_name,
            sc.section_name,
            CONCAT(tf.routeName,'(', tf.addAmount, ')') as transportation,
            (SELECT SUM(total) FROM fee_head_items AS fhi LEFT JOIN fee_heads AS fh ON (fhi.fee_head_id = fh.id) WHERE fh.class_id = s.class_id) as total
            FROM students AS s
            LEFT JOIN classes_name as c ON (s.class_id = c.id)
            LEFT JOIN sections as sc ON (s.section_id = sc.id)
            LEFT JOIN transportation_fees as tf ON (tf.id = s.transportation_id)
            ";

        if (count($where)) {
            $query .= ' WHERE ' . implode(' AND ', $where);
        }

        return $this->prepareExecute($query, $values);
    }

    public function getStudentAdmissionFeeList($student_id)
    {
        return $this->select(
            'admission_fees as af',
            [
                'af.id',
                'af.admission_no',
                's.id as student_id',
                "CONCAT(s.first_name, ' ', s.last_name) AS student_name",
                'af.due_date',
                "(SELECT SUM(afi.total) FROM admission_fee_items AS afi WHERE afi.admission_fee_id = af.id) AS amount",
                "(SELECT SUM(afp.amount) FROM admission_fee_payments AS afp WHERE afp.admission_fee_id = af.id) AS payment"
            ],
            [
                's.id' => $student_id
            ],
            [
                'join' => [
                    'table' => 'students as s',
                    'type' => 'LEFT JOIN',
                    'on' => 'af.admission_no = s.admission_no'
                ]
            ]
        );
    }

    public function getStudentMonthlyFeeList($student_id)
    {
        return $this->select(
            'monthly_fees as af',
            [
                'af.id',
                'af.admission_no',
                's.id as student_id',
                "CONCAT(s.first_name, ' ', s.last_name) AS student_name",
                'af.due_date',
                "(SELECT SUM(afi.total) FROM monthly_fee_items AS afi WHERE afi.monthly_fee_id = af.id) AS amount",
                "(SELECT SUM(afp.amount) FROM monthly_fee_payments AS afp WHERE afp.monthly_fee_id = af.id) AS payment"
            ],
            [
                's.id' => $student_id
            ],
            [
                'join' => [
                    'table' => 'students as s',
                    'type' => 'LEFT JOIN',
                    'on' => 'af.admission_no = s.admission_no'
                ]
            ]
        );
    }

    public function collectFeeOnline($request, $type, $fee_id, $amount)
    {
        $_SESSION['orderNo'] = $order_id = rand() . '-' . $fee_id;

        return CCAvenue::redirect([
            'order_id' => $order_id,
            'amount' => $amount,
            'redirect_url' => BASE_ROOT . 'process-online-fee.php',
            'cancel_url' => BASE_ROOT . 'process-online-fee.php',
            'billing_name' => $request['billing']['first_name'] . ' ' . $request['billing']['last_name'],
            'billing_address' => $request['billing']['address_1'] . ' ' . $request['billing']['address_2'],
            'billing_city' => $request['billing']['city'],
            'billing_state' => $request['billing']['state'],
            'billing_zip' => $request['billing']['postal_code'],
            'billing_country' => $request['billing']['country'],
            'billing_tel' => $request['billing']['phone'],
            'billing_email' => $request['billing']['email'],
            'merchant_param1' => $type,
            'merchant_param2' => $fee_id
        ]);
    }

    public function processOnlinePayment($request)
    {
        try {
            if (!(isset($request['orderNo']) && isset($_SESSION['orderNo']) && $_SESSION['orderNo'] == $request['orderNo'])) {
                $this->setAlert('danger', 'Oops! Something went wrong.');
                return;
            }

            unset($_SESSION['orderNo']);

            if (isset($request['encResp'])) {
                $result = CCAvenue::response();
                if ($result->success === true && isset($result->response) && is_array($response = $result->response)) {
                    if ($response['order_status'] === 'Success') {
                        $description = "Order Id: {$response['order_id']}, Tracking Id: {$response['tracking_id']}, Bank Ref No: {$response['bank_ref_no']}, Payment Mode: {$response['payment_mode']}, Card Name: {$response['card_name']}, Trans Date: {$response['trans_date']}";
                        $data = [
                            'amount' => $response['amount'],
                            'date' => $this->date('now'),
                            'method' => 'Online Payment',
                            'comment' => 'Online Payment',
                            'description' => $description
                        ];

                        list($first_name, $last_name) = explode(' ', $response['billing_name'], 2);

                        $data['billing'] = [
                            'first_name' => $first_name,
                            'last_name' => $last_name,
                            'address_1' => $response['billing_address'],
                            'address_2' => '',
                            'city' => $response['billing_city'],
                            'state' => $response['billing_state'],
                            'postal_code' => $response['billing_zip'],
                            'country' => $response['billing_country'],
                            'phone' => $response['billing_tel'],
                            'email' => $response['billing_email'],
                        ];

                        switch ($result->response['merchant_param1']) {
                            case 'admission':
                                $this->collectAdmissionFee($data, $result->response['merchant_param2']);
                                break;

                            case 'monthly':
                                $this->collectMonthlyFee($data, $result->response['merchant_param2']);
                                break;

                            default:
                                # code...
                                break;
                        }

                        return $result->response['merchant_param1'];
                    }
                }
            }
        } catch (\Throwable $th) {
            return $this->throwException($th);
        }
    }
}

