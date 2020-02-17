<?php

class Accounts
{
    protected $mysqli;

    public function __construct()
    {
        $this->mysqli = $this->connect();
    }

    protected function throwException(Throwable $th)
    {
        if (defined('DEBUG') && DEBUG) throw $th;
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

    protected function array_only($array, $keys)
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

        if (defined('DEBUG') && DEBUG) throw new Exception($message, 404);

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

    public function addEditFeeHead($request, $id = null)
    {
        try {
            $data = $this->array_only($request, 'title');

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
            $data = $this->array_only($request, ['fee_head_id', 'discount_type', 'discount_head']);
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
            $data = $this->array_only($request, ['fee_head_id', 'discount_type', 'discount_head']);
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

        $class = $this->select('classes_name', '*', ['id' => $student->class_id]);
        $section = $this->select('sections', '*', ['id' => $student->section_id]);

        $student->class_name = $class->results[0]->class_name;
        $student->section_name = $section->results[0]->section_name;

        return $student;
    }

    public function getAdmissionFees()
    {
        return $this->select('admission_fees');
    }

    public function getAdmissionFeeList()
    {
        $query = "SELECT
                    af.id,
                    af.admission_no,
                    CONCAT(s.first_name, ' ', s.last_name) AS student_name,
                    af.due_date,
                    (SELECT SUM(afi.total) FROM admission_fee_items AS afi WHERE afi.admission_fee_id = af.id) AS total_fee_amount,
                    (SELECT SUM(afp.fee_paid) FROM admission_fee_payments AS afp WHERE afp.admission_fee_id = af.id) AS total_fee_payment
                    FROM admission_fees as af LEFT JOIN students as s ON af.admission_no = s.admission_no";
        return $this->prepareExecute($query, []);
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
                'date' => date('Y-m-d', strtotime(urldecode($_GET['date']))),
                'fee_head_id' => urldecode($_GET['fee_head_id']),
                'admission_no' => urldecode($_GET['admission_no']),
                'due_date' => date('Y-m-d', strtotime('+15 days'))
            ];

            if (is_null($id)) {
                $result = $this->insert('admission_fees', $data);
                $this->setAlert('Admission Fee added successfully.');
                $id = $result->insert_id;
            } else {
                // $result = $this->insert('admission_fees', $data, compact('id'));
                // $this->setAlert('Admission Fee updated successfully.');
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
            $student = $this->getStudentByAdmssionNo($admission_fee->admission_no);

            $data = $this->array_only($request, ['fee_paid', 'payment_date', 'payment_method', 'comment', 'payment_information']);

            $data['admission_fee_id'] = $admission_fee->id;
            $data['student_id'] = $student->id;
            $data['payment_date'] = date('Y-m-d', strtotime(str_replace('/', '-', $request['payment_date'])));
            $data['billing_address'] = serialize($request['billing']);

            $result = $this->insert('admission_fee_payments', $data);

            $admission_total_fee = $this->getAdmissionTotalFee($admission_fee_id);
            $admission_total_payment = $this->getAdmissionTotalPayment($admission_fee_id);

            $updated_due_date = null;
            if ($admission_total_fee > $admission_total_payment) {
                $updated_due_date = date('Y-m-d', strtotime(
                    isset($request['fee_due_date']) ? str_replace('/', '-', $request['fee_due_date']) : '+15 days'
                ));
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
        $query = "SELECT
                    af.id,
                    af.admission_no,
                    CONCAT(s.first_name, ' ', s.last_name) AS student_name,
                    af.due_date,
                    (SELECT SUM(afi.total) FROM monthly_fee_items AS afi WHERE afi.monthly_fee_id = af.id) AS total_fee_amount,
                    (SELECT SUM(afp.fee_paid) FROM monthly_fee_payments AS afp WHERE afp.monthly_fee_id = af.id) AS total_fee_payment
                    FROM monthly_fees as af LEFT JOIN students as s ON af.admission_no = s.admission_no";
        return $this->prepareExecute($query, []);
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
                'date' => date('Y-m-d', strtotime(urldecode($_GET['date']))),
                'fee_head_id' => urldecode($_GET['fee_head_id']),
                'admission_no' => urldecode($_GET['admission_no']),
                'date_from' => date('Y-m-d', strtotime(str_replace('/', '-', $request['date_from']))),
                'date_to' => date('Y-m-d', strtotime(str_replace('/', '-', $request['date_to']))),
                'due_date' => date('Y-m-d', strtotime('+15 days'))
            ];

            if (is_null($id)) {
                $result = $this->insert('monthly_fees', $data);
                $this->setAlert('Monthly Fee added successfully.');
                $id = $result->insert_id;
            } else {
                // $result = $this->insert('monthly_fees', $data, compact('id'));
                // $this->setAlert('Monthly Fee updated successfully.');
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

            $data = $this->array_only($request, ['fee_paid', 'payment_date', 'payment_method', 'comment', 'payment_information']);

            $data['monthly_fee_id'] = $monthly_fee->id;
            $data['student_id'] = $student->id;
            $data['payment_date'] = date('Y-m-d', strtotime(str_replace('/', '-', $request['payment_date'])));
            $data['billing_address'] = serialize($request['billing']);

            $result = $this->insert('monthly_fee_payments', $data);

            $monthly_total_fee = $this->getMonthlyTotalFee($monthly_fee_id);
            $monthly_total_payment = $this->getMonthlyTotalPayment($monthly_fee_id);

            $updated_due_date = null;
            if ($monthly_total_fee > $monthly_total_payment) {
                $updated_due_date = date('Y-m-d', strtotime(
                    isset($request['fee_due_date']) ? str_replace('/', '-', $request['fee_due_date']) : '+15 days'
                ));
            }

            $this->update('monthly_fees', ['due_date' => $updated_due_date], ['id' => $monthly_fee->id]);
            $this->setAlert('Monthly Fee collected successfully.');

            return $result;
        } catch (\Throwable $th) {
            return $this->throwException($th);
        }
    }

    public function getUser($id)
    {
        $user = $this->select('users', '*', compact('id'));
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
}
