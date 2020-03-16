<?php

if (!defined('DEBUG')) define('DEBUG', false);

class Accounts
{
    protected $mysqli;

    public function __construct()
    {
        $this->mysqli = $this->connect();
    }

    protected function throwException(Throwable $th)
    {
        if (DEBUG) throw $th;
        $this->setAlert('danger', $th->getMessage());
    }

    public function alert()
    {
        if (!isset($_SESSION['alert'])) {
            return null;
        }
        $alert = $_SESSION['alert'];
        unset($_SESSION['alert']);
        return $alert;
    }

    public function setAlert($type, $message = null)
    {
        if (is_null($message)) {
            $message = $type;
            $type = 'success';
        }
        $_SESSION['alert'] = compact('type', 'message');
    }

    public function date($format, $string = null)
    {
        if (is_null($string)) {
            $string = $format;
            $format = 'Y-m-d';
        }
        return date($format, strtotime(str_replace('/', '-', $string)));
    }

    public function redirect($path)
    {
        die("<script type=\"text/javascript\">window.location.href = '{$path}'</script>");
    }

    protected function connect()
    {
        if ($this->mysqli instanceof mysqli) return $this->mysqli;

        $mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

        if ($mysqli->connect_errno) {
            throw new Exception("Failed to connect to MySQL: {$mysqli->connect_error}", 500);
        }

        return $mysqli;
    }

    protected function isAssociativeArray(array $array): bool
    {
        return array_keys($array) !== range(0, count($array) - 1);
    }

    protected function arrayOnly($array, $keys)
    {
        return array_intersect_key($array, array_flip((array) $keys));
    }

    protected function mapPlaceholderMark(array $array): array
    {
        return array_map(function ($key) {
            return "{$key} = ?";
        }, $array);
    }

    protected function getTypes(array $values): string
    {
        return implode(array_map(function ($value) {
            if ('integer' == gettype($value)) return 'i';
            if ('double' == gettype($value)) return 'd';
            if ('string' == gettype($value)) return 's';

            return 'b';
        }, $values));
    }

    protected function wrapIfNotArray($value): array
    {
        return is_array($value) ? $value : [$value];
    }

    protected function prepareExecute(string $query, array $values)
    {
        $return = new stdClass;

        if ($return->success = $stmt = $this->mysqli->prepare($query)) {
            if ($values) $stmt->bind_param($this->getTypes($values), ...$values);
            if ($return->success = $stmt->execute()) {

                if (strpos($query, 'SELECT') === 0) {
                    $result = $stmt->get_result();

                    $return->results = [];
                    $return->count = $result->num_rows;

                    while ($row = $result->fetch_object()) {
                        array_push($return->results, $row);
                    }
                }

                if (strpos($query, 'INSERT') === 0) {
                    $return->insert_id = $stmt->insert_id;
                }

                if (strpos($query, 'UPDATE') === 0) {
                    $return->affected_rows = $stmt->affected_rows;
                }
            } else {
                throw new Exception($stmt->error);
            }
        } else {
            throw new Exception($this->mysqli->error);
        }

        return $return;
    }

    protected function select(string $table, $columns = '*', array $where = [], array $extra = [])
    {
        $values = [];

        if (is_array($columns)) {
            if (0 == count($columns)) throw new InvalidArgumentException('The columns must have at least 1 items.');

            if ($this->isAssociativeArray($columns)) throw new InvalidArgumentException('The columns must be a sequential array.');

            $columns = implode(', ', $columns);
        }

        if (0 < count($where)) {
            if (!$this->isAssociativeArray($where)) throw new InvalidArgumentException('The where must be a associative array.');

            $values = array_merge($values, array_values($where));
            $where = implode(' AND ', $this->mapPlaceholderMark(array_keys($where)));
        }

        $limit = null;
        if (array_key_exists('limit', $extra)) {
            $limit = implode(', ', $this->wrapIfNotArray($extra['limit']));
        }

        $query = "SELECT {$columns} FROM {$table}";
        if ($where) $query .= " WHERE {$where}";
        if ($limit) $query .= " LIMIT {$limit}";

        return $this->prepareExecute($query, $values);
    }

    protected function insert(string $table, array $data = [])
    {
        if (!$this->isAssociativeArray($data)) throw new InvalidArgumentException('The data must be a associative array.');

        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));

        $query = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";
        return $this->prepareExecute($query, array_values($data));
    }

    protected function update(string $table, array $data = [], array $where)
    {
        if (!$this->isAssociativeArray($data)) throw new InvalidArgumentException('The data must be a associative array.');

        if (!$this->isAssociativeArray($where)) throw new InvalidArgumentException('The where must be a associative array.');

        $values = array_merge(array_values($data), array_values($where));

        $columns = implode(', ', $this->mapPlaceholderMark(array_keys($data)));
        $where = implode(' AND ', $this->mapPlaceholderMark(array_keys($where)));

        $query = "UPDATE {$table} SET {$columns} WHERE {$where}";
        return $this->prepareExecute($query, $values);
    }

    protected function delete(string $table, array $where = [])
    {
        $values = array_values($where);

        if (0 == count($where)) throw new InvalidArgumentException('The where must have at least 1 items.');
        if (!$this->isAssociativeArray($where)) throw new InvalidArgumentException('The where must be a associative array.');

        $where = implode(' AND ', $this->mapPlaceholderMark(array_keys($where)));

        $query = "DELETE FROM {$table} WHERE {$where}";
        return $this->prepareExecute($query, $values);
    }

    public function notFound($message = null)
    {
        if (!$message) $message = '<h1>Not Found</h1><p>The requested URL was not found on this server.</p>';

        if (DEBUG) throw new Exception($message, 404);

        die($message);
    }

    public function getFeeHeads()
    {
        return $this->select('fee_heads');
    }

    public function getFeeHead($id)
    {
        $fee_head = $this->select('fee_heads', '*', compact('id'));
        if (!$fee_head->success || !$fee_head->count) $this->notFound();

        $fee_head = $fee_head->results[0];
        $fee_head_sections = $this->select('fee_head_sections', '*', ['fee_head_id' => $id]);
        $fee_head->sections = $fee_head_sections->results;

        return $fee_head;
    }

    public function getFeeHeadFeesTypes($id)
    {
        $get_fees_type = $this->select('fees_head_fees_type', '*', ['fee_head_id' => $id]);
        // if (!$get_fees_type->success || !$get_fees_type->count) $this->notFound();
        return $get_fees_type;
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

    public function addEditFeeHead($request, $id = null)
    {
        try {
            $data = $this->arrayOnly($request, 'title');
            if (is_null($id)) {
                $result = $this->insert('fee_heads', $data);
                $this->setAlert('Fee Head added successfully.');
                $id = $result->insert_id;
            } else {
                $result = $this->update('fee_heads', $data, compact('id'));
                $this->setAlert('Fee Head updated successfully.');
            }

            $fee_head_id = $id;
            $this->delete('fee_head_sections', compact('fee_head_id'));

            if (isset($request['section_id']) && is_array($request['section_id'])) {
                foreach ($request['section_id'] as $class_id => $sections) {
                    foreach ($sections as $section_id => $value) {
                        $this->insert('fee_head_sections', compact('fee_head_id', 'class_id', 'section_id'));
                    }
                }
            }

            $this->delete('fees_head_fees_type', compact('fee_head_id'));

            if (isset($request['addFeesTypes']) && is_array($request['addFeesTypes'])) {
                foreach ($request['addFeesTypes'] as $key => $value) {
                    $fees_type = $request['addFeesTypes'][$key];
                    $amount = $request['addAmount'][$key];
                    $this->insert('fees_head_fees_type', compact('fee_head_id', 'fees_type', 'amount'));
                }
            }

            return $result;
        } catch (\Throwable $th) {
            return $this->throwException($th);
        }
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
            return $result;
        } catch (\Throwable $th) {
            return $this->throwException($th);
        }
    }

    public function getDiscounts()
    {
        return $this->select('discounts');
    }

    public function getDiscount($id)
    {
        $discount = $this->select('discounts', '*', compact('id'));
        if (!$discount->success || !$discount->count) $this->notFound();

        return $discount->results[0];
    }

    public function addEditDiscount($request, $id = null)
    {
        try {
            $data = $this->arrayOnly($request, ['fee_head_id', 'discount_type', 'discount_head']);
            if (is_null($id)) {
                $result = $this->insert('discounts', $data);
                $this->setAlert('Discount added successfully.');
            } else {
                $result = $this->update('discounts', $data, compact('id'));
                $this->setAlert('Discount updated successfully.');
            }

            return $result;
        } catch (\Throwable $th) {
            return $this->throwException($th);
        }
    }

    public function getMonthlyDiscounts()
    {
        return $this->select('monthly_discounts');
    }

    public function getMonthlyDiscount($id)
    {
        $discount = $this->select('monthly_discounts', '*', compact('id'));
        if (!$discount->success || !$discount->count) $this->notFound();

        return $discount->results[0];
    }

    public function addEditMonthlyDiscount($request, $id = null)
    {
        try {
            $data = $this->arrayOnly($request, ['fee_head_id', 'discount_type', 'discount_head']);
            if (is_null($id)) {
                $result = $this->insert('monthly_discounts', $data);
                $this->setAlert('Monthly Discount added successfully.');
            } else {
                $result = $this->update('monthly_discounts', $data, compact('id'));
                $this->setAlert('Monthly Discount updated successfully.');
            }

            return $result;
        } catch (\Throwable $th) {
            return $this->throwException($th);
        }
    }

    public function getStudentByAdmssionNo($admission_no)
    {
        $student = $this->select('students', '*', compact('admission_no'), ['limit' => 1]);

        if (!$student->success || !$student->count) {
            $this->setAlert('danger', 'Student not found.');
            return new Optional();
        }

        $student = $student->results[0];

        $class = $this->select('classes_name', '*', ['id' => $student->class_id], ['limit' => 1]);
        $section = $this->select('sections', '*', ['id' => $student->section_id], ['limit' => 1]);

        $student->class_name = $class->results[0]->class_name;
        $student->section_name = $section->results[0]->section_name;

        return $student;
    }

    public function getAdmissionByAdmssionNo($admission_no)
    {
        $admission = $this->select('admission_form_listing', '*', compact('admission_no'), ['limit' => 1]);

        if (!$admission->success || !$admission->count) {
            $this->setAlert('danger', 'Admission not found.');
            return new Optional();
        }

        $admission = $admission->results[0];

        $class = $this->select('classes_name', '*', ['id' => $admission->class_id], ['limit' => 1]);
        $section = $this->select('sections', '*', ['id' => $admission->section_id], ['limit' => 1]);

        $admission->class_name = $class->results[0]->class_name;
        $admission->section_name = $section->results[0]->section_name;

        return $admission;
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

    public function getAdmissionFees()
    {
        return $this->select('admission_fees');
    }

    public function getAdmissionFeeList()
    {
        $filters = [
            'class_id' => 'a.class_id = ?',
            'section_id' => 'a.section_id = ?',
            'admission_no' => 'af.admission_no = ?',
            'date_from' => 'af.due_date >= ?',
            'date_to' => 'af.due_date <= ?'
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
                    (SELECT SUM(afi.total) FROM admission_fee_items AS afi WHERE afi.admission_fee_id = af.id) AS total_fee_amount,
                    (SELECT SUM(afp.fee_paid) FROM admission_fee_payments AS afp WHERE afp.admission_fee_id = af.id) AS total_fee_payment
                    FROM admission_fees as af LEFT JOIN admission_form_listing as a ON af.admission_no = a.admission_no";

        if (count($where) > 0) {
            $query .= ' WHERE ' . implode(' AND ', $this->arrayOnly($filters, array_keys($where)));
        }
        return $this->prepareExecute($query, array_values($where));
    }

    public function getStudentAdmissionFeeList($student_id)
    {
        $query = "SELECT
                    af.id,
                    af.admission_no,
                    s.id as student_id,
                    CONCAT(s.first_name, ' ', s.last_name) AS student_name,
                    af.due_date,
                    (SELECT SUM(afi.total) FROM admission_fee_items AS afi WHERE afi.admission_fee_id = af.id) AS total_fee_amount,
                    (SELECT SUM(afp.fee_paid) FROM admission_fee_payments AS afp WHERE afp.admission_fee_id = af.id) AS total_fee_payment
                    FROM admission_fees as af LEFT JOIN students as s ON af.admission_no = s.admission_no
                    WHERE s.id = ?";

        return $this->prepareExecute($query, [$student_id]);
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
        $admission_fee_total = $this->select('admission_fee_payments', ['SUM(fee_paid) as total'], compact('admission_fee_id'));
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
                'student_roll_no' => $request['student_roll_no'],
                'date' => $this->date(urldecode($_GET['date'])),
                'fee_head_id' => urldecode($_GET['fee_head_id']),
                'admission_no' => urldecode($_GET['admission_no']),
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

            if (isset($request['fee_type']) && is_array($request['fee_type'])) {
                foreach ($request['fee_type'] as $key => $fee_type) {
                    $fee_amount = floatval($request['fee_amount'][$key]);
                    $discount_head_id = $request['discount_head'][$key] ?: null;
                    $discount_type = $request['discount_type'][$key] ?: null;
                    $discount_amount = floatval($request['discount_amount'][$key] ?: 0);
                    $total = floatval($fee_amount - $discount_amount);

                    $this->insert('admission_fee_items', compact(
                        'admission_fee_id',
                        'fee_type',
                        'fee_amount',
                        'discount_head_id',
                        'discount_type',
                        'discount_amount',
                        'total'
                    ));
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

            $data = $this->arrayOnly($request, ['fee_paid', 'payment_date', 'payment_method', 'comment', 'payment_information']);

            $data['admission_fee_id'] = $admission_fee->id;
            $data['payment_date'] = $this->date($request['payment_date']);
            $data['billing_address'] = serialize($request['billing']);

            $result = $this->insert('admission_fee_payments', $data);

            $admission_total_fee = $this->getAdmissionTotalFee($admission_fee_id);
            $admission_total_payment = $this->getAdmissionTotalPayment($admission_fee_id);

            $updated_due_date = null;
            if ($admission_total_fee > $admission_total_payment) {
                $updated_due_date = $this->date(
                    isset($request['fee_due_date']) ? $request['fee_due_date'] : '+15 days'
                );
            }

            $this->update('admission_fees', ['due_date' => $updated_due_date], ['id' => $admission_fee->id]);
            $this->setAlert('Admission Fee collected successfully.');

            return $result;
        } catch (\Throwable $th) {
            return $this->throwException($th);
        }
    }

    public function getMonthlyFees()
    {
        return $this->select('monthly_fees');
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
                    (SELECT SUM(mfi.total) FROM monthly_fee_items AS mfi WHERE mfi.monthly_fee_id = mf.id) AS total_fee_amount,
                    (SELECT SUM(mfp.fee_paid) FROM monthly_fee_payments AS mfp WHERE mfp.monthly_fee_id = mf.id) AS total_fee_payment
                    FROM monthly_fees as mf LEFT JOIN students as s ON mf.admission_no = s.admission_no";

        if (count($where) > 0) {
            $query .= ' WHERE ' . implode(' AND ', $this->arrayOnly($filters, array_keys($where)));
        }
        return $this->prepareExecute($query, array_values($where));
    }

    public function getStudentMonthlyFeeList($student_id)
    {
        $query = "SELECT
                    mf.id,
                    mf.admission_no,
                    s.id as student_id,
                    CONCAT(s.first_name, ' ', s.last_name) AS student_name,
                    mf.due_date,
                    (SELECT SUM(mfi.total) FROM monthly_fee_items AS mfi WHERE mfi.monthly_fee_id = mf.id) AS total_fee_amount,
                    (SELECT SUM(mfp.fee_paid) FROM monthly_fee_payments AS mfp WHERE mfp.monthly_fee_id = mf.id) AS total_fee_payment
                    FROM monthly_fees as mf LEFT JOIN students as s ON mf.admission_no = s.admission_no
                    WHERE s.id = ?";

        return $this->prepareExecute($query, [$student_id]);
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
        $monthly_fee_total = $this->select('monthly_fee_items', ['SUM(total) as total'], compact('monthly_fee_id'));
        return $monthly_fee_total->results[0]->total ?: 0;
    }

    public function getMonthlyTotalPayment($monthly_fee_id)
    {
        $monthly_fee_total = $this->select('monthly_fee_payments', ['SUM(fee_paid) as total'], compact('monthly_fee_id'));
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

    public function addEditMonthlyFee($request, $id = null)
    {
        try {
            $data = [
                'student_roll_no' => $request['student_roll_no'],
                'date' => $this->date(urldecode($_GET['date'])),
                'fee_head_id' => urldecode($_GET['fee_head_id']),
                'admission_no' => urldecode($_GET['admission_no']),
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

            if (isset($request['fee_type']) && is_array($request['fee_type'])) {
                foreach ($request['fee_type'] as $key => $fee_type) {
                    $fee_amount = floatval($request['fee_amount'][$key]);
                    $discount_head_id = $request['discount_head'][$key] ?: null;
                    $discount_type = $request['discount_type'][$key] ?: null;
                    $discount_amount = floatval($request['discount_amount'][$key] ?: 0);
                    $total = floatval($fee_amount - $discount_amount);

                    $this->insert('monthly_fee_items', compact(
                        'monthly_fee_id',
                        'fee_type',
                        'fee_amount',
                        'discount_head_id',
                        'discount_type',
                        'discount_amount',
                        'total'
                    ));
                }
            }

            return $result;
        } catch (\Throwable $th) {
            return $this->throwException($th);
        }
    }

    public function collectMonthlyFee($request, $monthly_fee_id)
    {
        try {
            $monthly_fee = $this->getMonthlyFee($monthly_fee_id);
            $student = $this->getStudentByAdmssionNo($monthly_fee->admission_no);

            $data = $this->arrayOnly($request, ['fee_paid', 'payment_date', 'payment_method', 'comment', 'payment_information']);

            $data['monthly_fee_id'] = $monthly_fee->id;
            $data['student_id'] = $student->id;
            $data['payment_date'] = $this->date($request['payment_date']);
            $data['billing_address'] = serialize($request['billing']);

            $result = $this->insert('monthly_fee_payments', $data);

            $monthly_total_fee = $this->getMonthlyTotalFee($monthly_fee_id);
            $monthly_total_payment = $this->getMonthlyTotalPayment($monthly_fee_id);

            $updated_due_date = null;
            if ($monthly_total_fee > $monthly_total_payment) {
                $updated_due_date = $this->date(
                    isset($request['fee_due_date']) ? $request['fee_due_date'] : '+15 days'
                );
            }

            $this->update('monthly_fees', ['due_date' => $updated_due_date], ['id' => $monthly_fee->id]);
            $this->setAlert('Monthly Fee collected successfully.');

            return $result;
        } catch (\Throwable $th) {
            return $this->throwException($th);
        }
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
                        $payment_information = "Order Id: {$response['order_id']}, Tracking Id: {$response['tracking_id']}, Bank Ref No: {$response['bank_ref_no']}, Payment Mode: {$response['payment_mode']}, Card Name: {$response['card_name']}, Trans Date: {$response['trans_date']}";
                        $data = [
                            'fee_paid' => $response['amount'],
                            'payment_date' => $this->date('now'),
                            'payment_method' => 'Online Payment',
                            'comment' => 'Online Payment',
                            'payment_information' => $payment_information
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

    public function getClasses()
    {
        return $this->select('classes_name');
    }

    public function getSections()
    {
        return $this->select('sections');
    }

    public function getStudentListByClassAndSection($request)
    {
        $where = $this->arrayOnly($request, ['class_id', 'section_id']);
        return $this->select('students', '*', $where);
    }
}
